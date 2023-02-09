<?php

namespace Modules\Install\Http\Controllers;

use Modules\Core\Library\License;
use Modules\User\Entities\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Modules\ModulesManager\Entities\PurchaseManager;


class InstallController extends Controller
{
    private $minPhpVersion = '7.3';
    

    private $permissions = [
        'storage'           => '0775',
        'storage/app'       => '0775',
        'storage/framework' => '0775',
        'storage/logs'      => '0775',
        'bootstrap/cache'   => '0775',
    ];

    private $extensions    = [
        'openssl',
        'pdo',
        'mbstring',
        'xml',
        'ctype',
        'gd',
        'tokenizer',
        'JSON',
        'bcmath',
        'cURL',
        'fileinfo',
        'zip',
    ];

    public function installCheck(Request $request)
    {
        // public all module assets
        Artisan::call('module:publish');
        // Clear cache, routes, views
        Artisan::call('optimize:clear');

        $passed = true;

        // Permissions checker
        $results['permissions'] = [];
        foreach ($this->permissions as $folder => $permission) {
            $results['permissions'][] = [
                'folder'     => $folder,
                'permission' => substr(sprintf('%o', fileperms(base_path($folder))), -4),
                'required'   => $permission,
                'success'    => substr(sprintf('%o', fileperms(base_path($folder))), -4) >= $permission ? true : false,
            ];
        }

        // Extension checker
        $results['extensions'] = [];
        foreach ($this->extensions as $extension) {
            $results['extensions'][] = [
                'extension' => $extension,
                'success'   => extension_loaded($extension),
            ];
        }

        // PHP version
        $results['php'] = [
            'installed' => PHP_VERSION,
            'required'  => $this->minPhpVersion,
            'success'   => version_compare(PHP_VERSION, $this->minPhpVersion) >= 0 ? true : false,
        ];

        // Pass check
        foreach ($results['permissions'] as $permission) {
            if ($permission['success'] == false) {
                $passed = false;
                break;
            }
        }

        foreach ($results['extensions'] as $extension) {
            if ($extension['success'] == false) {
                $passed = false;
                break;
            }
        }

        if ($results['php']['success'] == false) {
            $passed = false;
        }
        return view('install::install.requirements', compact(
            'results',
            'passed'
        ));

    }

    public function installDB($passed,Request $request){

        if($passed){
            $SERVER_IP = $request->server('SERVER_ADDR');
            return view('install::install.database', compact(
                'passed','SERVER_IP'
            ));
        }
        abort(404);
    }

    public function installDBPost(Request $request)
    {
        $request->validate([
            'APP_URL'     => 'required|url',
            'DB_HOST'     => 'required|string|max:50',
            'DB_PORT'     => 'required|numeric',
            'DB_DATABASE' => 'required|string|max:50',
            'DB_USERNAME' => 'required|string|max:50',
            'DB_PASSWORD' => 'nullable|string|max:50',
            'SERVER_IP' => 'required|ip|string',
        ]);

        // Check DB connection
        try {

            $pdo = new \PDO(
                'mysql:host=' . $request->DB_HOST . ';port=' . $request->DB_PORT . ';dbname=' . $request->DB_DATABASE,
                $request->DB_USERNAME,
                $request->DB_PASSWORD, [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                ]
            );

        } catch (\PDOException $e) {

            return redirect()->back()
                    ->withInput($request->input())
                    ->with('error', 'Database connection failed: ' . $e->getMessage());

        }

       
        try {

            setEnv([
                'APP_URL'     => strtolower(rtrim($request->APP_URL, '/')),
                'APP_ENV'     => 'production',
                'APP_DEBUG'   => 'false',
                'DB_HOST'     => '"' . $request->DB_HOST . '"',
                'DB_PORT'     => '"' . $request->DB_PORT . '"',
                'DB_DATABASE' => '"' . $request->DB_DATABASE . '"',
                'DB_USERNAME' => '"' . $request->DB_USERNAME . '"',
                'DB_PASSWORD' => '"' . $request->DB_PASSWORD . '"',
                'SERVER_IP' => $request->SERVER_IP
            ]);

            return redirect()->route('install.active');

        } catch (\Exception $e) {

            return redirect()->back()
                    ->withInput($request->input())
                    ->with('error', 'Can\'t save changes to .env file: ' . $e->getMessage());
        }
        
        

    }

    public function installActive(Request $request){

        return view('install::install.active');
    }

    public function installActivePost(Request $request){


        $request->validate([
           'PURCHASE_CODE' =>'required|string',
           'USER_NAME_OR_EMAIL' =>'required|string',
        ]);

        $core = get_file_data(storage_path('core.json'));

        $PRODUCT_ID = Arr::get($core, 'PRODUCT_ID');
        $PRODUCT_NAME = Arr::get($core, 'PRODUCT_NAME');
        $VERIFY_TYPE = Arr::get($core, 'VERIFY_TYPE');
        $VERSION = Arr::get($core, 'VERSION');
        

        $license = new License($PRODUCT_ID,$VERIFY_TYPE,$VERSION);

        $res = $license->getLatestVersion();

        if (!$res['status']) {

            return redirect()->back()
                    ->withInput($request->input())
                    ->with('error', $res['message']);
        }

        if ($res['latest_version'] != $VERSION) {

            return redirect()->back()
                    ->withInput($request->input())
                    ->with('error', $res['message']. ' You need download latest version for install');
        }


        $response = $license->activateLicense($request->PURCHASE_CODE, $request->USER_NAME_OR_EMAIL);

        if (!$response['status']) {

            return redirect()->back()
                    ->withInput($request->input())
                    ->with('error', $response['message']);
        }


        // Migrate DB
        try {
            
            Artisan::call('migrate', ["--force" => true]);
            // crete purchase row
            $item = PurchaseManager::create([
                "product_id" => $PRODUCT_ID,
                "product_name" => $PRODUCT_NAME,
                "purchase_code" => $request->PURCHASE_CODE,
                "verify_type" => $VERIFY_TYPE,
                "email_username_purchase" => $request->USER_NAME_OR_EMAIL,
                "version" => $VERSION
            ]);

            // Create admin account
            $user = User::create([
                'role'        => 'admin',
                'name'            => 'admin',
                'email'           => 'admin@admin.com',
                'password'        => Hash::make('admin@admin.com'),
            ]);

            // publish all language modules
            publishLangModule();

            // Save installation
            touch(storage_path('installed'));


        } catch (\Exception $e) {
            // revert deactive license
            $response = $license->deactivateLicense($request->PURCHASE_CODE, $request->USER_NAME_OR_EMAIL);

            return redirect()->back()
                ->withInput($request->input())
                ->with('error', 'Can\'t migrate database: ' . $e->getMessage());

        }
        
        // Clear cache, routes, views
        Artisan::call('optimize:clear');

        $notify_success = 'Install successfully. You can login admin with: email: admin@admin.com - pass: admin@admin.com.';
        return redirect()->route('login')
                ->with('success', $notify_success );

    }

   
            


    
}
