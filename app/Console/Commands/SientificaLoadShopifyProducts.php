<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Sientifica\Helpers\Misc\MaxihealthXlsFileContentNormalizer;
use Sientifica\Helpers\Misc\MaxihealthXlsFileContentHandler;
use Sientifica\Helpers\CustomLogger;
use Sientifica\Helpers\ShopifyAPI\Shopify;
use Sientifica\Helpers\ShopifyAPI\ShopifyProductPublisher;

class SientificaLoadShopifyProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Sientifica:LoadShopifyProducts {filepath : Path to xls file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command reads from a local xls file, then it syncs all product definitions in xls file to a shopify store.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $logger = new CustomLogger('shopify');
        $filepath = $this->argument('filepath');
        if (file_exists($this->argument('filepath'))){
            $fileNormalizer = new MaxihealthXlsFileContentNormalizer();
            $fileHandler = new MaxihealthXlsFileContentHandler();
            $shopifyApiHandler = new Shopify(env('SHPFY_BASEURL'),env('SHPFY_ACCESSTOKEN'));

            $normalizedFileContent = $fileNormalizer->normalizeFileContent($filepath);
            $fileHandler->processFile($normalizedFileContent);
            for ($i=1;$i<$fileHandler->count();$i++){
                $shopifyProductPublisher = new ShopifyProductPublisher($fileHandler->get($i),$shopifyApiHandler);
                $response = $shopifyProductPublisher->publish(true);
                $logger->writeToLog("response from shopify.com: ".json_encode($response),'INFO');
            }

        }
        else{
            $logger->writeToLog("File ".$this->argument('filepath')."doesn't exists",'WARNING');
            echo "File ".$this->argument('filepath')."doesn't exists\n";
        }
    }
}
