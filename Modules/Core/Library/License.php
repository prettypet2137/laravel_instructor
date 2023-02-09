<?php
namespace Modules\Core\Library;

use GuzzleHttp\Client;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class License
{

    /**
     * @var string
     */
    protected $productId;

    /**
     * @var string
     */
    protected $apiUrl;

    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @var string
     */
    protected $verifyType;

    /**
     * @var int
     */
    protected $verificationPeriod;

    /**
     * @var string
     */
    protected $currentVersion;

    /**
     * @var string
     */
    protected $sessionKey = '44622179e10cab6xyz';

    /**
     * Core constructor.
     */
    public function __construct($productId ='', $verifyType = 'non_envato', $currentVersion='1.0.0')
    {
        $this->apiUrl = 'https://license.techfago.com/';
        $this->apiKey = '3FFA21049727823F0866';
        $this->verificationPeriod = 1;

        $this->productId = $productId;
        $this->verifyType = $verifyType;
        $this->currentVersion = $currentVersion;

    }

    /**
     * @param string $license
     * @param string $client
     * @param bool $createLicense
     * @return array
     */
    public function activateLicense($license, $client, $createLicense = true)
    {
        $data = [
            'product_id'   => $this->productId,
            'license_code' => $license,
            'client_name'  => $client,
            'verify_type'  => $this->verifyType,
        ];

        $response = $this->callApi($this->apiUrl . 'api/activate_license', $data);

        return $response;
    }
    /**
     * @param bool $license
     * @param bool $client
     * @return array
     */
    public function deactivateLicense($license = false, $client = false)
    {
        $data = [];

        $data = [
            'product_id'   => $this->productId,
            'license_code' => $license,
            'client_name'  => $client,
        ];

        $response = $this->callApi($this->apiUrl . 'api/deactivate_license', $data);

        return $response;
    }

    public function checkUpdate(){

        $data = [
            'product_id'   => $this->productId,
            'current_version' => $this->currentVersion
        ];
        $response = $this->callApi($this->apiUrl . 'api/check_update', $data);

        return $response;
    }
    
    public function getLatestVersion(){

        $data = [
            'product_id'   => $this->productId,
        ];
        $response = $this->callApi($this->apiUrl . 'api/latest_version', $data);

        return $response;
    }
    

    public function getListProducts($pd_category = ''){

        $data = [
            'pd_category'   => $pd_category,
        ];
        $response = $this->callApi($this->apiUrl . 'api/get_products_category', $data);

        return $response;
    }
    public function getProductWithID($product_id){

        if (empty($product_id)) {
            
            return [
                    'status'  => false,
                    'message' => 'Product ID required..',
            ];
        }
        $data = [
            'product_id'   => $product_id,
        ];
        $response = $this->callApi($this->apiUrl . 'api/get_product', $data);
        
        
        return $response;
    }

    

    public function downloadUgrade($license = false, $client = false, $path_main = '' , $latest_version = false ,$db_for_import = false) 
    {
        // check new update
        
        $checkUpdate = $this->checkUpdate();

        if (!$checkUpdate || !$checkUpdate['status'] ) {
            # code...
            return $checkUpdate;
        }
        // install latest_version
        if ($latest_version) {

            $response = $this->getLatestVersion();

            if ($response['status']) {
                $checkUpdate['version'] = $response['latest_version'];
                $checkUpdate['update_id'] = $response['update_id'];
            }
        }
        $data =  array();

        // download file
        if(!empty($license)&&!empty($client)){
            $data =  array(
                "license_file" => null,
                "license_code" => $license,
                "client_name" => $client
            );
        }

        $responseMainFile = $this->downloadMainFile($checkUpdate['update_id'],$checkUpdate['version'], $data, $path_main);
        
        if ($responseMainFile['status'] == true) {
            // change version
            
            // migrate DB module or update
            Artisan::call('optimize:clear');
            Artisan::call('migrate', ["--force" => true]);

            return [
                'status'  => true,
                'version_new' => $checkUpdate['version'],
                'message' => "App updated successfully",
            ];
            
        }
        else{

            return [
                    'status'  => false,
                    'message' => $responseMainFile['message'],
            ];
        }

        

    }
    

    private function downloadMainFile($update_id, $version, $data, $path_main)
    {
        // Download main file
        $source_download = $this->apiUrl."api/download_update/main/".$update_id; 
        $archive   = storage_path('upgrade/release-' . $version . '.zip');
        $extractTo = storage_path('upgrade/release-' . $version);
        
        $path_main_file = base_path($path_main);
        

        if(!File::exists($path_main_file)) {
            // path does not exist
            return [
                'status'  => false,
                'message' => 'Not found path main file.',
            ];

        }

        File::makeDirectory($extractTo, 0777, true, true);

        $client   = new Client(['verify' => false]);

        $response = $client->request('POST', $source_download, [
            'http_errors' => false,
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept'       => 'application/json',
                'LB-API-KEY'   => $this->apiKey,
                'LB-URL'       => rtrim(url('/'), '/'),
                'LB-IP'        => request()->ip(),
                'LB-LANG'      => 'english',
            ],
            'sink'           => $archive,
            'json'    => $data,
        ]);

        if ($response->getStatusCode() == 200) {

            $zip = new \ZipArchive();

            if ($zip->open($archive) === true) {

                if (File::isWritable($extractTo . '/')) {

                    try {
                     
                        if ($zip->extractTo($extractTo)) {

                            $zip->close();
                            
                            File::copyDirectory($extractTo, $path_main_file);
                            File::cleanDirectory(storage_path('upgrade'), true);

                            return [
                                'status'  => true,
                                'message' => 'Download Done.',
                            ];

                        } else {
                            return [
                                'status'  => false,
                                'message' => 'Unable to extract archive.',
                            ];
                        }    
                         
                    } catch (\Exception $e) {

                        return [
                            'status'  => false,
                            'message' => "Can't extract file download:" . $e->getMessage(),
                        ];
                    }


                } else {

                    return [
                            'status'  => false,
                            'message' => 'Directory is not writable '.$extractTo,
                    ];
                }
            } else {
                return [
                    'status'  => false,
                    'message' => 'Unable to open archive.',
                    ];
            }

        }else{
            return [
                'status'  => false,
                'message' => $response->getStatusCode(). " - ". $response->getReasonPhrase(),
            ];
        }
    }

    private function downloadSQLFile($update_id, $version, $data = [])
    {
        // Download and excute Sql file
        $source_download = $this->apiUrl."api/download_update/sql/".$update_id;
        $archive   = storage_path('upgrade/release-sql-' . $version . '.sql');

        $client   = new Client(['verify' => false]);

        $response = $client->request('POST', $source_download, [
            'http_errors' => false,
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept'       => 'application/json',
                'LB-API-KEY'   => $this->apiKey,
                'LB-URL'       => rtrim(url('/'), '/'),
                'LB-IP'        => request()->ip(),
                'LB-LANG'      => 'english',
            ],
            'sink'           => $archive,
            'json'    => $data,
        ]);

        if ($response->getStatusCode() == 200) {

            if(File::exists($archive)) {
                try {
                     
                     $sql = file_get_contents($archive);
                     if (!empty($sql)) {
                         \DB::unprepared($sql);
                     }

                     File::cleanDirectory(storage_path('upgrade'), true);

                     return [
                        'status'  => true,
                        'message' => "Upgrade SQL successfully",
                    ];
                     
                } catch (\Exception $e) {

                    return [
                        'status'  => false,
                        'message' => "Can't add default templates and blocks SQL" . $e->getMessage(),
                    ];
                }
            }
            else {
                return [
                    'status'  => false,
                    'message' => "Download SQL fail. Don't exits file.",
                    ];
            }

        }else{
            return [
                'status'  => false,
                'message' => $response->getStatusCode(). " - ". $response->getReasonPhrase(),
            ];
        }
    }
    /**
     * @param string $url
     * @param string $data
     * @return array
     */
    protected function callApi($url, $data = [])
    {
        $client = new Client(['verify' => false]);

        $result = $client->post($url, [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept'       => 'application/json',
                'LB-API-KEY'   => $this->apiKey,
                'LB-URL'       => rtrim(url('/'), '/'),
                'LB-IP'        => request()->ip(),
                'LB-LANG'      => 'english',
            ],
            'json'    => $data,
        ]);

        if (!$result && config('app.debug')) {
            return [
                'status'  => false,
                'message' => 'Server is unavailable at the moment, please try again.',
            ];
        }

        $result = json_decode($result->getBody(), true);

        if (!$result['status']) {
            return $result;
        }

        return $result;
    }



    /**
     * @param bool $timeBasedCheck
     * @param bool $license
     * @param bool $client
     * @return array
     */
    public function verifyLicense($license = false, $client = false, $timeBasedCheck = false)
    {
        $data = [
            'product_id'   => $this->productId,
            'license_file' => null,
            'license_code' => null,
            'client_name'  => null,
        ];


        if (!empty($license) && !empty($client)) {
            $data = [
                'product_id'   => $this->productId,
                'license_code' => $license,
                'client_name'  => $client,
            ];
        }

        $response = [
            'status'  => true,
            'message' => 'Verified! Thanks for purchasing our product.',
        ];

        if ($timeBasedCheck && $this->verificationPeriod > 0) {
            $type = (int)$this->verificationPeriod;
            $today = date('d-m-Y');
            if (!session($this->sessionKey)) {
                session([$this->sessionKey => '00-00-0000']);
            }
            $typeText = $type . ' days';

            if ($type == 1) {
                $typeText = '1 day';
            } elseif ($type == 3) {
                $typeText = '3 days';
            } elseif ($type == 7) {
                $typeText = '1 week';
            }

            if (strtotime($today) >= strtotime(session($this->sessionKey))) {
                $response = $this->callApi($this->apiUrl . 'api/verify_license', $data);
                if ($response['status'] == true) {
                    $tomorrow = date('d-m-Y', strtotime($today . ' + ' . $typeText));
                    session([$this->sessionKey => $tomorrow]);
                }
            }

            return $response;
        }

        return $this->callApi($this->apiUrl . 'api/verify_license', $data);
    }

   

    
}
