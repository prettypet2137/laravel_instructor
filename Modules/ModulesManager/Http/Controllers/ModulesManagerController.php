<?php

namespace Modules\ModulesManager\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use GuzzleHttp\Client as GuzzleClient;
use Modules\Core\Library\License;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Modules\ModulesManager\Entities\PurchaseManager;

class ModulesManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request, License $license)
    {
        $products_purchased = PurchaseManager::all();
        $data = $license->getListProducts('goevent');
        return view('modulesmanager::index', compact('data','products_purchased'));
    }

    public function migrateModule(Request $request, $type = "update")
    {
        // Migrate DB
        $message = __('Update module successfully');
        
        if ($type == "install") {
            $message = __('Install module succeszsfully');
        }
        
        try {

            Artisan::call('migrate', ["--force" => true]);
            Artisan::call('translation:sync-missing-translation-keys');
            Artisan::call('optimize:clear');


        } catch (\Exception $e) {

            return redirect()->back()
                ->with('error', 'Error: ' . $e->getMessage());
        }

        return redirect()->back()
                    ->with('success', $message);
       
    }

    public function install(Request $request)
    {
        $request->validate([
            'license'     => 'required|string',
            'product_id'  => 'required|string',
            'email_username_purchase'  => 'required|string',
            'product_name'  => 'required|string',
            'verify_type'  => 'required|string|in:envato,non_envato',
        ]);

        $license_code = trim($request->input('license'));
        $product_id = trim($request->input('product_id'));
        $email_username_purchase = trim($request->input('email_username_purchase'));
        $path_main = trim($request->input('path_main'));
        $verify_type = trim($request->input('verify_type'));
        $product_name = trim($request->input('product_name'));

        $item = PurchaseManager::where('product_id', $product_id)->first();
        // check exits purchase code
        if ($item) {
            return redirect()->back()
                    ->with('error', __('This modules or themes is already installed'));
        }

        $license = new License($product_id,$verify_type);

        // active license
        $response = $license->activateLicense($license_code, $email_username_purchase);
        if (!$response['status']) {

            return redirect()->back()
                    ->with('error', $response['message']);
        }


        $response = $license->downloadUgrade($license_code, $email_username_purchase, $path_main,true);
        if (!$response['status']) {
            // roll back
            $license->deactivateLicense($license_code, $email_username_purchase);
            return redirect()->back()
                    ->with('error', $response['message']);
        }
        // Active success add new record
        $item = PurchaseManager::create([
            "product_id" => $product_id,
            "product_name" => $product_name,
            "purchase_code" => $license_code,
            "verify_type" => $verify_type,
            "email_username_purchase" => $email_username_purchase,
            "path_main" => $path_main,
            "version" => '1.0.0'
        ]);

        try {
            
            Artisan::call('module:publish');
            // publish all language modules
            publishLangModule();

            $item->version = $response['version_new'];
            $item->save();

            return redirect()->route('settings.modulesmanager.migreatemodule', array('type' => 'install'));

        } catch (\Exception $e) {

            // revert deactive license
            $response = $license->deactivateLicense($item->purchase_code, $item->email_username_purchase);
            return redirect()->back()
                ->with('error', 'Error install: ' . $e->getMessage());

        }
        
    }

    public function update(Request $request, $product_id)
    {
        $item = PurchaseManager::where('product_id', $product_id)->first();
        if ($item) {
            // check exits purchase code
            $license = new License($item->product_id, $item->verify_type, $item->version);

            // verify license
            $response = $license->verifyLicense($item->purchase_code, $item->email_username_purchase);
            if (!$response['status']) {

                return redirect()->back()
                        ->with('error', $response['message']);
            }

            $response = $license->downloadUgrade($item->purchase_code, $item->email_username_purchase,$item->path_main,false);
            
            if (!$response['status']) {
                // roll back
                return redirect()->back()
                        ->with('error', $response['message']);
            }

            try {

                // Clear cache, routes, views
                Artisan::call('optimize:clear');
                Artisan::call('module:publish');
                
                // publish all language modules
                publishLangModule();

                $item->version = $response['version_new'];
                $item->save();

                return redirect()->route('settings.modulesmanager.migreatemodule', array('type' => 'update'));

            } catch (\Exception $e) {
                // revert deactive license
                $response = $license->deactivateLicense($item->purchase_code, $item->email_username_purchase);
                return redirect()->back()
                    ->with('error', 'Error install: ' . $e->getMessage());

            }

        }
        

        abort(404);
        
    }

}
