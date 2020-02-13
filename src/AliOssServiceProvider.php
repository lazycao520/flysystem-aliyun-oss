<?php
/**
 * Created by PhpStorm.
 * User: lazycao
 * Date: 2020-02-12
 * Time: 15:05
 */

namespace LyCao\AliyunOss;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Filesystem;
use OSS\OssClient;

class AliOssServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //发布配置文件
        /*
        if (function_exists('config_path')) {
            $this->publishes([
                __DIR__ . '/config/config.php' => config_path('alioss.php'),
            ], 'config');
        }
        */

        Storage::extend('oss', function($app, $config)
        {
            $accessId  = $config['access_id'];
            $accessKey = $config['access_key'];

            $cdnDomain = empty($config['cdnDomain']) ? '' : $config['cdnDomain'];
            $bucket    = $config['bucket'];
            $isCname   = empty($config['isCName']) ? false : $config['isCName'];

            $endPoint  = $config['endpoint']; // 默认作为外部节点
            $epInternal= $isCname?$cdnDomain:(empty($config['endpoint_internal']) ? $endPoint : $config['endpoint_internal']); // 内部节点
            $prefix = empty($config['prefix']) ? '' : $config['prefix'];
            $client  = new OssClient($accessId, $accessKey, $epInternal, $isCname);
            $adapter = new AliOssAdapter($client, $bucket, $endPoint, $isCname, $cdnDomain,$prefix);

            $filesystem =  new Filesystem($adapter);

            return $filesystem;
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    }

}