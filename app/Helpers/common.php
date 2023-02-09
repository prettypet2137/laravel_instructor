<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\File;
use Nwidart\Modules\Facades\Module;
use Illuminate\Support\Facades\DB;
use Modules\Core\Library\License;
use Modules\LandingPage\Entities\LandingPage;
use Modules\Events\Entities\EventCategory;

if (!function_exists('getConfigFileEventTemplate')) {
    function getConfigFileEventTemplate($name)
    {
        $module = Module::find('events');
        $path = $module->getExtraPath('Resources/views/event_templates/').$name."/config.php";
        $config = [];
        if(file_exists($path)){
            $config = include $path;
        }
        return $config;
    }
}

if (!function_exists('getListEventTemplates')) {
    function getListEventTemplates()
    {
        $module = Module::find('events');
        $path = $module->getExtraPath('Resources/views/event_templates');
        $event_templates = getDirectories($path);

        return $event_templates;
    }
}
if (!function_exists('getImagePreviewEventTemplate')) {
    function getImagePreviewEventTemplate($template_name)
    {
        $image_path = Module::asset('events:event_templates/'.$template_name.'/preview.png');
        return $image_path;
    }
}

if (!function_exists('getEventCategories')) {
    function getEventCategories()
    {
        $user_id = \Auth::user()->id;
        $categories = EventCategory::where("user_id", $user_id)->get();
        return $categories;
    }
}


if (!function_exists('getDirectories')) {
    function getDirectories(string $path) : array
    {
        $directories = [];
        $items = scandir($path);
        foreach ($items as $item) {
            if($item == '..' || $item == '.')
                continue;
            if(is_dir($path.'/'.$item))
                $directories[] = $item;
        }
        return $directories;
    }
}



if (!function_exists('getDomainFromURL')) {
    function getDomainFromURL($url) {
        $parse = parse_url($url);
        return $parse['host']; 
    }
}

if (!function_exists('is_slug')) {
    function is_slug($str) {
        return preg_match('/^[a-z0-9]+(-?[a-z0-9]+)*$/i', $str);
    }

}

if (!function_exists('getEstablishedIn')) {
    function getEstablishedIn()
    {
        $array = array();
        for ($counter = date('Y'); $counter > 1917; $counter--) {
            $array[$counter] = $counter;
        }
        return $array;
    }
}

if (!function_exists('getNumOffices')) {
    function getNumOffices()
    {
        $array = ['1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10', '11' => '11', '12' => '12', '13' => '13', '14' => '14', '15' => '15', '16' => '16', '17' => '17', '18' => '18', '19' => '19', '20' => '20'];
        return $array;
    }
}


if (!function_exists('getCurencies')) {
    function getCurencies()
    {
        $array = ['AED' => 'AED', 'AF' => 'AF', 'ALL' => 'ALL', 'ANG' => 'ANG', 'ARS' => 'ARS', 'AUD' => 'AUD', 'AWG' => 'AWG', 'AZ' => 'AZ', 'BAM' => 'BAM', 'BBD' => 'BBD', 'BG' => 'BG', 'BMD' => 'BMD', 'BOB' => 'BOB', 'BRL' => 'BRL', 'BWP' => 'BWP', 'BYR' => 'BYR', 'CAD' => 'CAD', 'CHF' => 'CHF', 'CLP' => 'CLP', 'CNY' => 'CNY', 'COP' => 'COP', 'CRC' => 'CRC', 'CUP' => 'CUP', 'CZK' => 'CZK', 'DKK' => 'DKK', 'DOP' => 'DOP', 'EGP' => 'EGP', 'EUR' => 'EUR', 'FKP' => 'FKP', 'GBP' => 'GBP', 'GHC' => 'GHC', 'GIP' => 'GIP', 'GTQ' => 'GTQ', 'GYD' => 'GYD', 'HNL' => 'HNL', 'HUF' => 'HUF', 'IDR' => 'IDR', 'ILS' => 'ILS', 'INR' => 'INR', 'IRR' => 'IRR', 'ISK' => 'ISK', 'JEP' => 'JEP', 'JMD' => 'JMD', 'JPY' => 'JPY', 'KGS' => 'KGS', 'KHR' => 'KHR', 'KYD' => 'KYD', 'KZT' => 'KZT', 'LAK' => 'LAK', 'LBP' => 'LBP', 'LKR' => 'LKR', 'LRD' => 'LRD', 'LTL' => 'LTL', 'LVL' => 'LVL', 'MKD' => 'MKD', 'MNT' => 'MNT', 'MUR' => 'MUR', 'MX' => 'MX', 'MYR' => 'MYR', 'MZ' => 'MZ', 'NAD' => 'NAD', 'NG' => 'NG', 'NIO' => 'NIO', 'NOK' => 'NOK', 'NPR' => 'NPR', 'NZD' => 'NZD', 'OMR' => 'OMR', 'PAB' => 'PAB', 'PE' => 'PE', 'PHP' => 'PHP', 'PKR' => 'PKR', 'PL' => 'PL', 'PYG' => 'PYG', 'QAR' => 'QAR', 'RO' => 'RO', 'RSD' => 'RSD', 'RUB' => 'RUB', 'SAR' => 'SAR', 'SBD' => 'SBD', 'SCR' => 'SCR', 'SEK' => 'SEK', 'SGD' => 'SGD', 'SHP' => 'SHP', 'SOS' => 'SOS', 'SRD' => 'SRD', 'SVC' => 'SVC', 'SYP' => 'SYP', 'THB' => 'THB', 'TRY' => 'TRY', 'TTD' => 'TTD', 'TVD' => 'TVD', 'TWD' => 'TWD', 'UAH' => 'UAH', 'USD' => 'USD', 'UYU' => 'UYU', 'UZS' => 'UZS', 'VEF' => 'VEF', 'VND' => 'VND', 'YER' => 'YER', 'ZAR' => 'ZAR', 'ZWD' => 'ZWD',];
        return $array;
    }
}

if (!function_exists('getNumEmployees')) {
    function getNumEmployees()
    {
        $array = ['1-10' => '1-10', '11-50' => '11-50', '51-100' => '51-100', '101-200' => '101-200', '201-300' => '201-300', '301-600' => '301-600', '601-1000' => '601-1000', '1001-1500' => '1001-1500', '1501-2000' => '1501-2000', '2001-2500' => '2001-2500', '2501-3000' => '2501-3000', '3001-3500' => '3001-3500', '3501-4000' => '3501-4000', '4001-4500' => '4001-4500', '4501-5000' => '4501-5000', '5000+' => '5000+'];
        return $array;
    }
}

if (!function_exists('routeName')) {
    function routeName() {
       return \Request::route()->getName();
    }
}
if (!function_exists('ruleMailChimpForAddContact')) {

    function ruleMailChimpForAddContact($landing_page,$form_data) {

        if (isset($landing_page->settings['intergration'])) {

            $intergration = $landing_page->settings['intergration'];
            
            if (isset($intergration['type']) && $intergration['type'] != "none") {
                // Check field email exits and valid.
                $field_values = $form_data->field_values;
                if (isset($field_values['email']) && !empty($field_values['email'])) {
                    if (filter_var($field_values['email'], FILTER_VALIDATE_EMAIL)) {
                        return true;
                    }
                }
            }
        }

        return false;
    }
}

if (!function_exists('getColorStatus')) {

    function getColorStatus($status = '') {

        switch ($status) {
            case 'OPEN':
                # code...
                return "primary";

                break;
            
            case 'COMPLETED':
                # code..
                return "success";

                break;
            
            case 'CANCELED':
                # code...
                return "danger";

                break;

            default:
                # code...
                return $status;
                break;
        }
    }
}
if (!function_exists('getValueIfKeyIsset')) {

    function getValueIfKeyIsset($array, $key) {

        if (isset($array[$key])) {
            
            if (is_numeric($array[$key])) {
                return intval($array[$key]);
            }
            return $array[$key];
        }
        return null;
    }
}

if (!function_exists('checkIssetAndNotEmptyKeys')) {

    function checkIssetAndNotEmptyKeys($array = [], $array_keys = []) {

        foreach ($array_keys as $key) {
            if (!isset($array[$key]) || empty($array[$key])) {
                 return false;
            }
        }
        return true;
    }
}

if (!function_exists('getLandingPageCurrentURL')) {

    function getLandingPageCurrentURL(LandingPage $page) {
        
        $url = "http://";
        
        if ($page) {
            if ($page->domain_type == 0) {
                $url .= $page->sub_domain;
            }else{
                $url .= $page->custom_domain;
            }
        }
        return $url;
    }
}

if (!function_exists('QueryJsonPage')) {

    function QueryJsonPage($json = '', $type='') {

        $q = new Jsonq($json);
        $res = $q->where('type', '=', $type)->get()->result();

        return $res;
    }
}
if (!function_exists('getAppDomain')) {

    function getAppDomain() {
        $app_url = config('app.url');
        $parse = parse_url($app_url);
        $domain_main =  $parse['host'];
        return $domain_main;
    }
}

if (!function_exists('publishLangModule')) {

    function publishLangModule($name_module = "") {

        if(!empty($name_module)) {
            
            $module = Module::find($name_module);
            
            if (!$module) {

                return false;
            }

            $path_lang_module = $module->getPath().'/Resources'.'/lang/en';

            if(File::exists($path_lang_module)) {
                
                File::copyDirectory($path_lang_module, resource_path('lang/en'));

            }
            return true;
            // call
        }else{

            // publish lang all module
            $all_modules = Module::all();
            foreach ($all_modules as $item) {

                $path_lang_module = $item->getPath().'/Resources'.'/lang/en';
                
                if(File::exists($path_lang_module)) {
                    
                    File::copyDirectory($path_lang_module, resource_path('lang/en'));

                }
            }
        }
        return true;

    }
}
if (!function_exists('getAllJSModules')) {

    function getAllAssetsModulesForApp($type = '') {
        
        // publish lang all module
        $html = "";
        $types_arr = array("css", "js");
        if (!in_array($type, $types_arr)) {
            return $html;
        }

        $all_modules = Module::all();
        foreach ($all_modules as $module) {

            $path_assets = $module->getPath().'/Resources'.'/assets/app/'.$type;
            
            if(File::exists($path_assets)) {

                $files = File::allfiles($path_assets);

                foreach ($files as $item) {

                    if (!empty($item->getContents())) {

                        if ($type == "css") {
                            $html .= "<link rel='stylesheet' href=".Module::asset($module->getLowerName().':app/css/'.$item->getFilename()).">\n";
                        }
                        elseif($type == "js"){
                            $html .= "<script src=".Module::asset($module->getLowerName().':app/js/'.$item->getFilename())." ></script>\n";
                        }
                        
                    }
                }
            }
        }
        return $html;

    }
}


if(!function_exists("check_product_purchase")){

    function check_product_purchase($product_id){
        $item = DB::table('purchase_managers')->where('product_id', $product_id)->first();
        if(empty($item)){
            return false;
        }
        return $item;
    }
}

if(!function_exists("get_latest_version_product_id")){

    function get_latest_version_product_id($product_id){
        $license = new License($product_id);
        $response = $license->getLatestVersion();
        if ($response['status'] == true) {
            return $response;
        }
        
        return false;
    }
}

if(!function_exists("get_percentage")){

    function get_percentage($total, $number)
    {
      if ( $total > 0 ) {
       return number_format(($number / $total) * 100);

      } else {
        return 0;
      }
    }
}
if(!function_exists("random_color")){

    function random_color()
    {
        $items = array("primary", "success", "info", "warning", "danger" , "secondary", "dark");
        return $items[array_rand($items)];
    }
}

if(!function_exists("get_color_chart_count")){

    function get_color_chart_count($count = 0)
    {
        
        $items = ["#4353FF", "#1cc88a", "#36b9cc", "#f6c23e", "#e74a3b","#5a5c69", "#3366cc","#dc3912","#ff9900","#109618","#990099","#0099c6","#dd4477","#66aa00","#b82e2e","#316395","#3366cc","#994499","#22aa99","#aaaa11","#6633cc","#e67300","#8b0707","#651067","#329262","#5574a6","#3b3eac","#b77322","#16d620","#b91383","#f4359e","#9c5935","#a9c413","#2a778d","#668d1c","#bea413","#0c5922","#743411"];
        
        $output = array_slice($items, 0, $count);

        return $output;
        // return $items[array_rand($items)];
    }
}



if(!function_exists("getDeviceTracking")){

    function getDeviceTracking($tracking){
        
        if($tracking->isMobile()){

            return "Mobile";
        }
        elseif($tracking->isTablet()){

            return "Tablet";
        }
        elseif($tracking->isDesktop()){
            
            return "Desktop";
        }
        else{
            return "Unknown";
        }
    }
}


/*Settings*/

if(!function_exists("get_option")){

    function get_option($key, $value = ""){

        if (File::exists(storage_path('installed'))){

            $option = DB::table('settings')->where('key', $key)->first();
            if(empty($option)){
                DB::table('settings')->insert(
                    ['key' => $key, 'value' => $value]
                );
                return $value;
            }else{
                return $option->value;
            }

        }
        return $value;
        
    }
}

if(!function_exists("update_option")){

    function update_option($key, $value){

        $option = DB::table('settings')->where('key', $key)->first();
        if(empty($option)){
            DB::table('settings')->insert(
                ['key' => $key, 'value' => $value]
            );
        }else{
            DB::table('settings')
            ->where('key', $key)
            ->update(['value' => $value]);
        }
    }
}
if (!function_exists('getPaymentsvailable')) {

    function getPaymentsvailable() {
        $modules = Module::all();
        $payments = [];
        if ($modules) {

            foreach ($modules as $module) {
                $name_module = $module->getLowerName();
                $config = config($name_module.'.payment');
                if(!empty($config)){

                    if (count($config) > 0) {
                       foreach ($config as $item) {
                           $payments[] = $item;

                       }
                    }

                }
                
            }
           
        }
        return $payments;
    }
}



if (!function_exists('accountSettingPayments')) {

    function accountSettingPayments($data = []) {
        $modules = Module::all();
        $html = "";
        $config_module = [];
        $modules_sort = [];
        if ($modules) {
            foreach ($modules as $module) {
                $name_module = $module->getLowerName();
                $menu_config = config($name_module.'.menu');
                
                if(view()->exists($name_module.'::moduletemplates.module-account-payment') && !empty($menu_config['account_payment_position'])){
                    $tmp['name'] = $name_module;
                    $tmp['account_payment_position'] = $menu_config['account_payment_position'];
                    $modules_sort[] =  $tmp;
                }
                
            }
            // sort
            usort($modules_sort, function ($item1, $item2) {
                return $item1['account_payment_position'] <=> $item2['account_payment_position'];
            });

            // get view Template
            foreach ($modules_sort as $item) {
                $html .= view($item['name'].'::moduletemplates.module-account-payment',compact('data'))->render(); 
            }
                
        }
        return $html;
    }
}

if (!function_exists('settingPayments')) {

    function settingPayments($data = []) {
        $modules = Module::all();
        $html = "";
        $config_module = [];
        $modules_sort = [];
        if ($modules) {
            foreach ($modules as $module) {
                $name_module = $module->getLowerName();
                $menu_config = config($name_module.'.menu');
                
                if(view()->exists($name_module.'::moduletemplates.module-setting-payment') && !empty($menu_config['setting_payment_position'])){
                    $tmp['name'] = $name_module;
                    $tmp['setting_payment_position'] = $menu_config['setting_payment_position'];
                    $modules_sort[] =  $tmp;
                }
                
            }
            // sort
            usort($modules_sort, function ($item1, $item2) {
                return $item1['setting_payment_position'] <=> $item2['setting_payment_position'];
            });

            // get view Template
            foreach ($modules_sort as $item) {
                $html .= view($item['name'].'::moduletemplates.module-setting-payment')->render(); 
            }
                
        }
        return $html;
    }
}
if (!function_exists('paymentSkins')) {

    function paymentSkins($data = []) {
        $modules = Module::all();
        $html = "";
        $config_module = [];
        $modules_sort = [];
        if ($modules) {
            foreach ($modules as $module) {
                $name_module = $module->getLowerName();
                $menu_config = config($name_module.'.menu');
                
                if(view()->exists($name_module.'::moduletemplates.module-payment-skins') && !empty($menu_config['payment_skins_position'])){
                    $tmp['name'] = $name_module;
                    $tmp['payment_skins_position'] = $menu_config['payment_skins_position'];
                    $modules_sort[] =  $tmp;
                }
                
            }
            // sort
            usort($modules_sort, function ($item1, $item2) {
                return $item1['payment_skins_position'] <=> $item2['payment_skins_position'];
            });

            // get view Template
            foreach ($modules_sort as $item) {
                $html .= view($item['name'].'::moduletemplates.module-payment-skins',compact('data'))->render(); 
            }
                
        }
        return $html;
    }
}
if (!function_exists('menuHeaderSkins')) {

    function menuHeaderSkins($data = []) {
        $modules = Module::all();
        $html = "";
        $config_module = [];
        $modules_sort = [];
        if ($modules) {
            foreach ($modules as $module) {
                $name_module = $module->getLowerName();
                $menu_config = config($name_module.'.menu');
                
                if(view()->exists($name_module.'::moduletemplates.module-header-skins') && !empty($menu_config['header_skins_position'])){
                    $tmp['name'] = $name_module;
                    $tmp['header_skins_position'] = $menu_config['header_skins_position'];
                    $modules_sort[] =  $tmp;
                }
                
            }
            // sort
            usort($modules_sort, function ($item1, $item2) {
                return $item1['header_skins_position'] <=> $item2['header_skins_position'];
            });

            // get view Template
            foreach ($modules_sort as $item) {
                $html .= view($item['name'].'::moduletemplates.module-header-skins')->render(); 
            }
                
        }
        return $html;
    }
}

if (!function_exists('menuBottomSkins')) {

    function menuBottomSkins($data = []) {

        $modules = Module::all();
        $html = "";
        $config_module = [];
        $modules_sort = [];
        if ($modules) {
            foreach ($modules as $module) {
                $name_module = $module->getLowerName();
                $menu_config = config($name_module.'.menu');
                
                if(view()->exists($name_module.'::moduletemplates.module-bottom-skins') && !empty($menu_config['bottom_skins_position'])){
                    $tmp['name'] = $name_module;
                    $tmp['bottom_skins_position'] = $menu_config['bottom_skins_position'];
                    $modules_sort[] =  $tmp;
                }

            }
            // sort
            usort($modules_sort, function ($item1, $item2) {
                return $item1['bottom_skins_position'] <=> $item2['bottom_skins_position'];
            });

            // get view Template
            foreach ($modules_sort as $item) {
                $html .= view($item['name'].'::moduletemplates.module-bottom-skins',compact('data'))->render(); 
            }
                
        }
        return $html;
    }
}


if (!function_exists('menuSiderbar')) {

    function menuSiderbar($data = []) {
        $modules = Module::all();
        $html = "";
        $config_module = [];
        $modules_sort = [];
        if ($modules) {
            
            foreach ($modules as $module) {
                $name_module = $module->getLowerName();
                $menu_config = config($name_module.'.menu');
                
                if(view()->exists($name_module.'::moduletemplates.module-sidebar') && !empty($menu_config['siderbar_position'])){
                    $tmp['name'] = $name_module;
                    $tmp['siderbar_position'] = $menu_config['siderbar_position'];
                    $modules_sort[] =  $tmp;
                }
                
            }
            // sort
            usort($modules_sort, function ($item1, $item2) {
                return $item1['siderbar_position'] <=> $item2['siderbar_position'];
            });

            // get view Template
            foreach ($modules_sort as $item) {
                $html .= view($item['name'].'::moduletemplates.module-sidebar')->render(); 
            }
                
        }
        return $html;
    }
}

if (!function_exists('menuAdminSettingSiderbar')) {

    function menuAdminSettingSiderbar($data = []) {
        $modules = Module::all();
        $html = "";
        $config_module = [];
        $modules_sort = [];
        if ($modules) {
            // sort module with siderbar position
            foreach ($modules as $module) {
                $name_module = $module->getLowerName();
                $menu_config = config($name_module.'.menu');
                
                if(view()->exists($name_module.'::moduletemplates.module-sidebar-admin') && !empty($menu_config['siderbar_admin_position'])){
                    $tmp['name'] = $name_module;
                    $tmp['siderbar_admin_position'] = $menu_config['siderbar_admin_position'];
                    $modules_sort[] =  $tmp;
                }
                
            }
            // sort
            usort($modules_sort, function ($item1, $item2) {
                return $item1['siderbar_admin_position'] <=> $item2['siderbar_admin_position'];
            });

            // get view template
            foreach ($modules_sort as $item) {
                $html .= view($item['name'].'::moduletemplates.module-sidebar-admin')->render(); 
            }
                
        }
        return $html;
    }
}
if (!function_exists('menuHeaderTopLeft')) {

    function menuHeaderTopLeft($data = []) {
        $modules = Module::all();
        $html = "";
        $config_module = [];
        $modules_sort = [];
        if ($modules) {
            // sort module with siderbar position
            foreach ($modules as $module) {
                $name_module = $module->getLowerName();
                $menu_config = config($name_module.'.menu');
                
                if(view()->exists($name_module.'::moduletemplates.module-header-top-left') && !empty($menu_config['header_top_left'])){
                    $tmp['name'] = $name_module;
                    $tmp['header_top_left'] = $menu_config['header_top_left'];
                    $modules_sort[] =  $tmp;
                }
                
            }
            // sort
            usort($modules_sort, function ($item1, $item2) {
                return $item1['header_top_left'] <=> $item2['header_top_left'];
            });

            // get view template
            foreach ($modules_sort as $item) {
                $html .= view($item['name'].'::moduletemplates.module-header-top-left')->render(); 
            }
                
        }
        return $html;
    }
}
if (!function_exists('menuHeaderTop')) {

    function menuHeaderTop($data = []) {
        $modules = Module::all();
        $html = "";
        $config_module = [];
        $modules_sort = [];
        if ($modules) {
            // sort module with siderbar position
            foreach ($modules as $module) {
                $name_module = $module->getLowerName();
                $menu_config = config($name_module.'.menu');
                
                if(view()->exists($name_module.'::moduletemplates.module-header-top') && !empty($menu_config['header_top'])){
                    $tmp['name'] = $name_module;
                    $tmp['header_top'] = $menu_config['header_top'];
                    $modules_sort[] =  $tmp;
                }
                
            }
            // sort
            usort($modules_sort, function ($item1, $item2) {
                return $item1['header_top'] <=> $item2['header_top'];
            });

            // get view template
            foreach ($modules_sort as $item) {
                $html .= view($item['name'].'::moduletemplates.module-header-top')->render(); 
            }
                
        }
        return $html;
    }
}

if (!function_exists('generateRandomString')) {

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

if (!function_exists('getAllImagesContentMedia')) {

    function getAllImagesContentMedia(){
        $path = public_path('storage/content_media');
        if(!File::exists($path)) {
            File::makeDirectory($path, $mode = 0755, true, true);
        }
        $images_url = [];
        $files = File::files($path);
        foreach ($files as $item) {
            # code...
            $images_url[] = URL::to('/storage/content_media')."/".$item->getFilename();
        }
        return $images_url;
        
    }
}

if (!function_exists('getAllImagesUser')) {

    function getAllImagesUser($user_id){
        $path = public_path('storage/user_storage/'.$user_id);
        if(!File::exists($path)) {
            File::makeDirectory($path, $mode = 0755, true, true);
        }
        $images_url = [];
        $files = File::files($path);
        foreach ($files as $item) {
            # code...
            $images_url[] = URL::to('/storage/user_storage/'.$user_id)."/".$item->getFilename();
        }
        return $images_url;
        
    }
}
if (!function_exists('getAllContentTemplate')) {

    function getAllContentTemplate(){
        $path = public_path('storage/content_media');
        $images_url = [];
        $files = File::files($path);
        foreach ($files as $item) {
            # code...
            $images_url[] = URL::to('/storage/content_media')."/".$item->getFilename();
        }
        return $images_url;
        
    }
}
if (!function_exists('replaceVarContentStyle')) {

    function replaceVarContentStyle($item=""){
        // Image URL: ##image_url##
        $results = array();
        $image_url = URL::to('/storage/content_media')."/";

        $temp = $item;
        if (is_object($item)) {
            if (isset($item->content)) {
                $temp->content = str_replace('##image_url##', $image_url, $item->content);
            }
            if (isset($item->style)) {
                $temp->style = str_replace('##image_url##', $image_url, $item->style);
            }
            if (isset($item->thank_you_page)) {
                $temp->thank_you_page = str_replace('##image_url##', $image_url, $item->thank_you_page);
            }
            if (isset($item->thank_you_style)) {
                $temp->thank_you_style = str_replace('##image_url##', $image_url, $item->thank_you_style);
            }
            
            
        }
        else{
            if (isset($item)) {
                $temp = str_replace('##image_url##', $image_url, $item);
            }
        }
        return $temp;
    }
}
if (!function_exists('saveImgBase64')) {

     function saveImgBase64($param, $folder)
    {
        list($extension, $content) = explode(';', $param);
        $tmpExtension = explode('/', $extension);
        preg_match('/.([0-9]+) /', microtime(), $m);
        $fileName = sprintf('img%s%s.%s', date('YmdHis'), $m[1], $tmpExtension[1]);
        $content = explode(',', $content)[1];
        $storage = Storage::disk('public');

        $checkDirectory = $storage->exists($folder);

        if (!$checkDirectory) {
            $storage->makeDirectory($folder);
        }

        $storage->put($folder . '/' . $fileName, base64_decode($content), 'public');

        return $fileName;
    }
}

if (!function_exists('cleanImages')) {

    function cleanImages(){

        $path = public_path('storage/thumb_templates');
        $images_url = [];
        $files = File::files($path);
        foreach ($files as $item) {
            # code...
            //$block = Template::where('thumb',$item->getFilename())->first();
            if (!$block) {
                $path_delete = $path."/".$item->getFilename();

                if(File::exists($path_delete)) {
                    File::delete($path_delete);
                }
            }
        }
        die("done");
    }
}
if (!function_exists('deleteImageWithPath')) {
    
    function deleteImageWithPath($path_delete){

        if(File::exists($path_delete)) {
            File::delete($path_delete);
        }
    }
}
if (!function_exists('setEnv')) {
    
    function setEnv($data)
    {
        if (empty($data) || !is_array($data) || !is_file(base_path('.env'))) {
            return false;
        }

        $env = file_get_contents(base_path('.env'));

        $env = explode("\n", $env);

        foreach ($data as $data_key => $data_value) {

            $updated = false;

            foreach ($env as $env_key => $env_value) {

                $entry = explode('=', $env_value, 2);

                // Check if new or old key
                if ($entry[0] == $data_key) {
                    $env[$env_key] = $data_key . '=' . $data_value;
                    $updated       = true;
                } else {
                    $env[$env_key] = $env_value;
                }
            }

            // Lets create if not available
            if (!$updated) {
                $env[] = $data_key . '=' . $data_value;
            }
        }

        $env = implode("\n", $env);

        file_put_contents(base_path('.env'), $env);

        return true;
    }
}

if (!function_exists('format_time')) {
    /**
     * @param Carbon $timestamp
     * @param string $format
     * @return string
     */
    function format_time(Carbon $timestamp, $format = 'j M Y H:i')
    {
        $first = Carbon::create(0000, 0, 0, 00, 00, 00);
        if ($timestamp->lte($first)) {
            return '';
        }

        return $timestamp->format($format);
    }
}

if (!function_exists('date_from_database')) {
    /**
     * @param string $time
     * @param string $format
     * @return string
     */
    function date_from_database($time, $format = 'Y-m-d')
    {
        if (empty($time)) {
            return $time;
        }

        return format_time(Carbon::parse($time), $format);
    }
}

if (!function_exists('human_file_size')) {
    /**
     * @param int $bytes
     * @param int $precision
     * @return string
     */
    function human_file_size($bytes, $precision = 2): string
    {
        $units = ['B', 'kB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);

        return number_format($bytes, $precision, ',', '.') . ' ' . $units[$pow];
    }
}

if (!function_exists('get_file_data')) {
    /**
     * @param string $file
     * @param bool $toArray
     * @return bool|mixed
     */
    function get_file_data($file, $toArray = true)
    {
        $file = File::get($file);
        if (!empty($file)) {
            if ($toArray) {
                return json_decode($file, true);
            }
            return $file;
        }
        if (!$toArray) {
            return null;
        }
        return [];
    }
}

if (!function_exists('change_file_json')) {
    /**
     * @param string $file
     * @param bool $toArray
     * @return bool|mixed
     */
    function change_file_json($file, $key_change, $value_change)
    {
        $jsonString = file_get_contents($file);
        
        $data = json_decode($jsonString, true);
        $data[$key_change] = $value_change;
        
        $newJsonString = json_encode($data);

        file_put_contents($file, $newJsonString);
    }
}

if (!function_exists('json_encode_prettify')) {
    /**
     * @param array $data
     * @return string
     */
    function json_encode_prettify($data)
    {
        return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }
}

if (!function_exists('save_file_data')) {
    /**
     * @param string $path
     * @param array|string $data
     * @param bool $json
     * @return bool|mixed
     */
    function save_file_data($path, $data, $json = true)
    {
        try {
            if ($json) {
                $data = json_encode_prettify($data);
            }
            if (!File::isDirectory(File::dirname($path))) {
                File::makeDirectory(File::dirname($path), 493, true);
            }
            File::put($path, $data);

            return true;
        } catch (Exception $exception) {
            info($exception->getMessage());
            return false;
        }
    }
}

if (!function_exists('scan_folder')) {
    /**
     * @param string $path
     * @param array $ignoreFiles
     * @return array
     */
    function scan_folder($path, $ignoreFiles = [])
    {
        try {
            if (File::isDirectory($path)) {
                $data = array_diff(scandir($path), array_merge(['.', '..', '.DS_Store'], $ignoreFiles));
                natsort($data);
                return $data;
            }
            return [];
        } catch (Exception $exception) {
            return [];
        }
    }
}

if (!function_exists('get_device_type')) {
    function get_device_type($user_agent) {
        $mobile_regex = '/(?:phone|windows\s+phone|ipod|blackberry|(?:android|bb\d+|meego|silk|googlebot) .+? mobile|palm|windows\s+ce|opera mini|avantgo|mobilesafari|docomo)/i';
        $tablet_regex = '/(?:ipad|playbook|(?:android|bb\d+|meego|silk)(?! .+? mobile))/i';

        if(preg_match_all($mobile_regex, $user_agent)) {
            return 'mobile';
        } else {

            if(preg_match_all($tablet_regex, $user_agent)) {
                return 'tablet';
            } else {
                return 'desktop';
            }

        }
    }
}

if (!function_exists('get_country_from_country_code')) {
    function get_country_from_country_code($code) {
        $code = mb_strtoupper($code);

        $country_list = get_countries_array();

        if(!isset($country_list[$code])) {
            return __('Unknown');
        } else {
            return $country_list[$code];
        }
    }
}

if (!function_exists('get_countries_array')) {
    function get_countries_array() {
        return [
            'AF' => 'Afghanistan',
            'AX' => 'Aland Islands',
            'AL' => 'Albania',
            'DZ' => 'Algeria',
            'AS' => 'American Samoa',
            'AD' => 'Andorra',
            'AO' => 'Angola',
            'AI' => 'Anguilla',
            'AQ' => 'Antarctica',
            'AG' => 'Antigua and Barbuda',
            'AR' => 'Argentina',
            'AM' => 'Armenia',
            'AW' => 'Aruba',
            'AU' => 'Australia',
            'AT' => 'Austria',
            'AZ' => 'Azerbaijan',
            'BS' => 'Bahamas',
            'BH' => 'Bahrain',
            'BD' => 'Bangladesh',
            'BB' => 'Barbados',
            'BY' => 'Belarus',
            'BE' => 'Belgium',
            'BZ' => 'Belize',
            'BJ' => 'Benin',
            'BM' => 'Bermuda',
            'BT' => 'Bhutan',
            'BO' => 'Bolivia',
            'BQ' => 'Bonaire, Saint Eustatius and Saba',
            'BA' => 'Bosnia and Herzegovina',
            'BW' => 'Botswana',
            'BV' => 'Bouvet Island',
            'BR' => 'Brazil',
            'IO' => 'British Indian Ocean Territory',
            'VG' => 'British Virgin Islands',
            'BN' => 'Brunei',
            'BG' => 'Bulgaria',
            'BF' => 'Burkina Faso',
            'BI' => 'Burundi',
            'KH' => 'Cambodia',
            'CM' => 'Cameroon',
            'CA' => 'Canada',
            'CV' => 'Cape Verde',
            'KY' => 'Cayman Islands',
            'CF' => 'Central African Republic',
            'TD' => 'Chad',
            'CL' => 'Chile',
            'CN' => 'China',
            'CX' => 'Christmas Island',
            'CC' => 'Cocos Islands',
            'CO' => 'Colombia',
            'KM' => 'Comoros',
            'CK' => 'Cook Islands',
            'CR' => 'Costa Rica',
            'HR' => 'Croatia',
            'CU' => 'Cuba',
            'CW' => 'Curacao',
            'CY' => 'Cyprus',
            'CZ' => 'Czech Republic',
            'CD' => 'Democratic Republic of the Congo',
            'DK' => 'Denmark',
            'DJ' => 'Djibouti',
            'DM' => 'Dominica',
            'DO' => 'Dominican Republic',
            'TL' => 'East Timor',
            'EC' => 'Ecuador',
            'EG' => 'Egypt',
            'SV' => 'El Salvador',
            'GQ' => 'Equatorial Guinea',
            'ER' => 'Eritrea',
            'EE' => 'Estonia',
            'ET' => 'Ethiopia',
            'FK' => 'Falkland Islands',
            'FO' => 'Faroe Islands',
            'FJ' => 'Fiji',
            'FI' => 'Finland',
            'FR' => 'France',
            'GF' => 'French Guiana',
            'PF' => 'French Polynesia',
            'TF' => 'French Southern Territories',
            'GA' => 'Gabon',
            'GM' => 'Gambia',
            'GE' => 'Georgia',
            'DE' => 'Germany',
            'GH' => 'Ghana',
            'GI' => 'Gibraltar',
            'GR' => 'Greece',
            'GL' => 'Greenland',
            'GD' => 'Grenada',
            'GP' => 'Guadeloupe',
            'GU' => 'Guam',
            'GT' => 'Guatemala',
            'GG' => 'Guernsey',
            'GN' => 'Guinea',
            'GW' => 'Guinea-Bissau',
            'GY' => 'Guyana',
            'HT' => 'Haiti',
            'HM' => 'Heard Island and McDonald Islands',
            'HN' => 'Honduras',
            'HK' => 'Hong Kong',
            'HU' => 'Hungary',
            'IS' => 'Iceland',
            'IN' => 'India',
            'ID' => 'Indonesia',
            'IR' => 'Iran',
            'IQ' => 'Iraq',
            'IE' => 'Ireland',
            'IM' => 'Isle of Man',
            'IL' => 'Israel',
            'IT' => 'Italy',
            'CI' => 'Ivory Coast',
            'JM' => 'Jamaica',
            'JP' => 'Japan',
            'JE' => 'Jersey',
            'JO' => 'Jordan',
            'KZ' => 'Kazakhstan',
            'KE' => 'Kenya',
            'KI' => 'Kiribati',
            'XK' => 'Kosovo',
            'KW' => 'Kuwait',
            'KG' => 'Kyrgyzstan',
            'LA' => 'Laos',
            'LV' => 'Latvia',
            'LB' => 'Lebanon',
            'LS' => 'Lesotho',
            'LR' => 'Liberia',
            'LY' => 'Libya',
            'LI' => 'Liechtenstein',
            'LT' => 'Lithuania',
            'LU' => 'Luxembourg',
            'MO' => 'Macao',
            'MK' => 'Macedonia',
            'MG' => 'Madagascar',
            'MW' => 'Malawi',
            'MY' => 'Malaysia',
            'MV' => 'Maldives',
            'ML' => 'Mali',
            'MT' => 'Malta',
            'MH' => 'Marshall Islands',
            'MQ' => 'Martinique',
            'MR' => 'Mauritania',
            'MU' => 'Mauritius',
            'YT' => 'Mayotte',
            'MX' => 'Mexico',
            'FM' => 'Micronesia',
            'MD' => 'Moldova',
            'MC' => 'Monaco',
            'MN' => 'Mongolia',
            'ME' => 'Montenegro',
            'MS' => 'Montserrat',
            'MA' => 'Morocco',
            'MZ' => 'Mozambique',
            'MM' => 'Myanmar',
            'NA' => 'Namibia',
            'NR' => 'Nauru',
            'NP' => 'Nepal',
            'NL' => 'Netherlands',
            'NC' => 'New Caledonia',
            'NZ' => 'New Zealand',
            'NI' => 'Nicaragua',
            'NE' => 'Niger',
            'NG' => 'Nigeria',
            'NU' => 'Niue',
            'NF' => 'Norfolk Island',
            'KP' => 'North Korea',
            'MP' => 'Northern Mariana Islands',
            'NO' => 'Norway',
            'OM' => 'Oman',
            'PK' => 'Pakistan',
            'PW' => 'Palau',
            'PS' => 'Palestinian Territory',
            'PA' => 'Panama',
            'PG' => 'Papua New Guinea',
            'PY' => 'Paraguay',
            'PE' => 'Peru',
            'PH' => 'Philippines',
            'PN' => 'Pitcairn',
            'PL' => 'Poland',
            'PT' => 'Portugal',
            'PR' => 'Puerto Rico',
            'QA' => 'Qatar',
            'CG' => 'Republic of the Congo',
            'RE' => 'Reunion',
            'RO' => 'Romania',
            'RU' => 'Russia',
            'RW' => 'Rwanda',
            'BL' => 'Saint Barthelemy',
            'SH' => 'Saint Helena',
            'KN' => 'Saint Kitts and Nevis',
            'LC' => 'Saint Lucia',
            'MF' => 'Saint Martin',
            'PM' => 'Saint Pierre and Miquelon',
            'VC' => 'Saint Vincent and the Grenadines',
            'WS' => 'Samoa',
            'SM' => 'San Marino',
            'ST' => 'Sao Tome and Principe',
            'SA' => 'Saudi Arabia',
            'SN' => 'Senegal',
            'RS' => 'Serbia',
            'SC' => 'Seychelles',
            'SL' => 'Sierra Leone',
            'SG' => 'Singapore',
            'SX' => 'Sint Maarten',
            'SK' => 'Slovakia',
            'SI' => 'Slovenia',
            'SB' => 'Solomon Islands',
            'SO' => 'Somalia',
            'ZA' => 'South Africa',
            'GS' => 'South Georgia and the South Sandwich Islands',
            'KR' => 'South Korea',
            'SS' => 'South Sudan',
            'ES' => 'Spain',
            'LK' => 'Sri Lanka',
            'SD' => 'Sudan',
            'SR' => 'Suriname',
            'SJ' => 'Svalbard and Jan Mayen',
            'SZ' => 'Swaziland',
            'SE' => 'Sweden',
            'CH' => 'Switzerland',
            'SY' => 'Syria',
            'TW' => 'Taiwan',
            'TJ' => 'Tajikistan',
            'TZ' => 'Tanzania',
            'TH' => 'Thailand',
            'TG' => 'Togo',
            'TK' => 'Tokelau',
            'TO' => 'Tonga',
            'TT' => 'Trinidad and Tobago',
            'TN' => 'Tunisia',
            'TR' => 'Turkey',
            'TM' => 'Turkmenistan',
            'TC' => 'Turks and Caicos Islands',
            'TV' => 'Tuvalu',
            'VI' => 'U.S. Virgin Islands',
            'UG' => 'Uganda',
            'UA' => 'Ukraine',
            'AE' => 'United Arab Emirates',
            'GB' => 'United Kingdom',
            'US' => 'United States',
            'UM' => 'United States Minor Outlying Islands',
            'UY' => 'Uruguay',
            'UZ' => 'Uzbekistan',
            'VU' => 'Vanuatu',
            'VA' => 'Vatican',
            'VE' => 'Venezuela',
            'VN' => 'Vietnam',
            'WF' => 'Wallis and Futuna',
            'EH' => 'Western Sahara',
            'YE' => 'Yemen',
            'ZM' => 'Zambia',
            'ZW' => 'Zimbabwe',
        ];
    }
}

if (!function_exists('nr')) {
    function nr($number, $decimals = 0, $extra = false) {

        if($extra) {
            $formatted_number = $number;
            $touched = false;

            if(!$touched && (!is_array($extra) || (is_array($extra) && in_array('B', $extra)))) {

                if($number > 999999999) {
                    $formatted_number = number_format($number / 1000000000, $decimals, '.', ',') . 'B';

                    $touched = true;
                }

            }

            if(!$touched && (!is_array($extra) || (is_array($extra) && in_array('M', $extra)))) {

                if($number > 999999) {
                    $formatted_number = number_format($number / 1000000, $decimals, '.', ',') . 'M';

                    $touched = true;
                }

            }

            if(!$touched && (!is_array($extra) || (is_array($extra) && in_array('K', $extra)))) {

                if($number > 999) {
                    $formatted_number = number_format($number / 1000, $decimals, '.', ',') . 'K';

                    $touched = true;
                }

            }

            if($decimals > 0) {
                $dotzero = '.' . str_repeat('0', $decimals);
                $formatted_number = str_replace($dotzero, '', $formatted_number);
            }

            return $formatted_number;
        }

        if($number == 0) {
            return 0;
        }

        return number_format($number, $decimals, '.', ',');
    }
}

if (!function_exists('get_language_from_locale')) {
    function get_language_from_locale($locale) {
        $languages = get_locale_languages_array();

        if(!isset($languages[$locale])) {
            return __('Unknown');
        } else {
            return $languages[$locale];
        }
    }
}

if (!function_exists('get_locale_languages_array')) {
    function get_locale_languages_array() {
        return [
            'ab' => 'Abkhazian',
            'aa' => 'Afar',
            'af' => 'Afrikaans',
            'ak' => 'Akan',
            'sq' => 'Albanian',
            'am' => 'Amharic',
            'ar' => 'Arabic',
            'an' => 'Aragonese',
            'hy' => 'Armenian',
            'as' => 'Assamese',
            'av' => 'Avaric',
            'ae' => 'Avestan',
            'ay' => 'Aymara',
            'az' => 'Azerbaijani',
            'bm' => 'Bambara',
            'ba' => 'Bashkir',
            'eu' => 'Basque',
            'be' => 'Belarusian',
            'bn' => 'Bengali',
            'bh' => 'Bihari languages',
            'bi' => 'Bislama',
            'bs' => 'Bosnian',
            'br' => 'Breton',
            'bg' => 'Bulgarian',
            'my' => 'Burmese',
            'ca' => 'Catalan, Valencian',
            'km' => 'Central Khmer',
            'ch' => 'Chamorro',
            'ce' => 'Chechen',
            'ny' => 'Chichewa, Chewa, Nyanja',
            'zh' => 'Chinese',
            'cu' => 'Church Slavonic, Old Bulgarian, Old Church Slavonic',
            'cv' => 'Chuvash',
            'kw' => 'Cornish',
            'co' => 'Corsican',
            'cr' => 'Cree',
            'hr' => 'Croatian',
            'cs' => 'Czech',
            'da' => 'Danish',
            'dv' => 'Divehi, Dhivehi, Maldivian',
            'nl' => 'Dutch, Flemish',
            'dz' => 'Dzongkha',
            'en' => 'English',
            'eo' => 'Esperanto',
            'et' => 'Estonian',
            'ee' => 'Ewe',
            'fo' => 'Faroese',
            'fj' => 'Fijian',
            'fi' => 'Finnish',
            'fr' => 'French',
            'ff' => 'Fulah',
            'gd' => 'Gaelic, Scottish Gaelic',
            'gl' => 'Galician',
            'lg' => 'Ganda',
            'ka' => 'Georgian',
            'de' => 'German',
            'ki' => 'Gikuyu, Kikuyu',
            'el' => 'Greek (Modern)',
            'kl' => 'Greenlandic, Kalaallisut',
            'gn' => 'Guarani',
            'gu' => 'Gujarati',
            'ht' => 'Haitian, Haitian Creole',
            'ha' => 'Hausa',
            'he' => 'Hebrew',
            'hz' => 'Herero',
            'hi' => 'Hindi',
            'ho' => 'Hiri Motu',
            'hu' => 'Hungarian',
            'is' => 'Icelandic',
            'io' => 'Ido',
            'ig' => 'Igbo',
            'id' => 'Indonesian',
            'ia' => 'Interlingua (International Auxiliary Language Association)',
            'ie' => 'Interlingue',
            'iu' => 'Inuktitut',
            'ik' => 'Inupiaq',
            'ga' => 'Irish',
            'it' => 'Italian',
            'ja' => 'Japanese',
            'jv' => 'Javanese',
            'kn' => 'Kannada',
            'kr' => 'Kanuri',
            'ks' => 'Kashmiri',
            'kk' => 'Kazakh',
            'rw' => 'Kinyarwanda',
            'kv' => 'Komi',
            'kg' => 'Kongo',
            'ko' => 'Korean',
            'kj' => 'Kwanyama, Kuanyama',
            'ku' => 'Kurdish',
            'ky' => 'Kyrgyz',
            'lo' => 'Lao',
            'la' => 'Latin',
            'lv' => 'Latvian',
            'lb' => 'Letzeburgesch, Luxembourgish',
            'li' => 'Limburgish, Limburgan, Limburger',
            'ln' => 'Lingala',
            'lt' => 'Lithuanian',
            'lu' => 'Luba-Katanga',
            'mk' => 'Macedonian',
            'mg' => 'Malagasy',
            'ms' => 'Malay',
            'ml' => 'Malayalam',
            'mt' => 'Maltese',
            'gv' => 'Manx',
            'mi' => 'Maori',
            'mr' => 'Marathi',
            'mh' => 'Marshallese',
            'ro' => 'Moldovan, Moldavian, Romanian',
            'mn' => 'Mongolian',
            'na' => 'Nauru',
            'nv' => 'Navajo, Navaho',
            'nd' => 'Northern Ndebele',
            'ng' => 'Ndonga',
            'ne' => 'Nepali',
            'se' => 'Northern Sami',
            'no' => 'Norwegian',
            'nb' => 'Norwegian Bokmål',
            'nn' => 'Norwegian Nynorsk',
            'ii' => 'Nuosu, Sichuan Yi',
            'oc' => 'Occitan (post 1500)',
            'oj' => 'Ojibwa',
            'or' => 'Oriya',
            'om' => 'Oromo',
            'os' => 'Ossetian, Ossetic',
            'pi' => 'Pali',
            'pa' => 'Panjabi, Punjabi',
            'ps' => 'Pashto, Pushto',
            'fa' => 'Persian',
            'pl' => 'Polish',
            'pt' => 'Portuguese',
            'qu' => 'Quechua',
            'rm' => 'Romansh',
            'rn' => 'Rundi',
            'ru' => 'Russian',
            'sm' => 'Samoan',
            'sg' => 'Sango',
            'sa' => 'Sanskrit',
            'sc' => 'Sardinian',
            'sr' => 'Serbian',
            'sn' => 'Shona',
            'sd' => 'Sindhi',
            'si' => 'Sinhala, Sinhalese',
            'sk' => 'Slovak',
            'sl' => 'Slovenian',
            'so' => 'Somali',
            'st' => 'Sotho, Southern',
            'nr' => 'South Ndebele',
            'es' => 'Spanish, Castilian',
            'su' => 'Sundanese',
            'sw' => 'Swahili',
            'ss' => 'Swati',
            'sv' => 'Swedish',
            'tl' => 'Tagalog',
            'ty' => 'Tahitian',
            'tg' => 'Tajik',
            'ta' => 'Tamil',
            'tt' => 'Tatar',
            'te' => 'Telugu',
            'th' => 'Thai',
            'bo' => 'Tibetan',
            'ti' => 'Tigrinya',
            'to' => 'Tonga (Tonga Islands)',
            'ts' => 'Tsonga',
            'tn' => 'Tswana',
            'tr' => 'Turkish',
            'tk' => 'Turkmen',
            'tw' => 'Twi',
            'ug' => 'Uighur, Uyghur',
            'uk' => 'Ukrainian',
            'ur' => 'Urdu',
            'uz' => 'Uzbek',
            've' => 'Venda',
            'vi' => 'Vietnamese',
            'vo' => 'Volap_k',
            'wa' => 'Walloon',
            'cy' => 'Welsh',
            'fy' => 'Western Frisian',
            'wo' => 'Wolof',
            'xh' => 'Xhosa',
            'yi' => 'Yiddish',
            'yo' => 'Yoruba',
            'za' => 'Zhuang, Chuang',
            'zu' => 'Zulu'
        ];
    }
}

if (!function_exists('get_chart_data')) {
    function get_chart_data(Array $main_array) {

        $results = [];

        foreach($main_array as $date_label => $data) {

            foreach($data as $label_key => $label_value) {

                if(!isset($results[$label_key])) {
                    $results[$label_key] = [];
                }

                $results[$label_key][] = $label_value;

            }

        }

        foreach($results as $key => $value) {
            $results[$key] = '["' . implode('", "', $value) . '"]';
        }

        $results['labels'] = '["' . implode('", "', array_keys($main_array)) . '"]';

        return $results;
    }
}


if (!function_exists('getSlugName')) {
    function getSlugName(String $name) {

        return \Illuminate\Support\Str::slug($name);
    }
}

function getEnvData($key) {
    return env($key, null);
}