<?php

namespace App\Providers;

use Aws\Credentials\Credentials;
use Aws\Signature\SignatureV4;
use Elasticsearch\ClientBuilder;
use Illuminate\Support\ServiceProvider;
use Wizacha\Middleware\AwsSignatureMiddleware;

class ElasticSearchServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('ESClient', function () {
            $builder = ClientBuilder::create();

            if (config('elasticsearch.connection') === 'aws')
            {
                $key = config('aws.credentials.key');
                $secret = config('aws.credentials.secret');
                $region = config('aws.region');
                $credentials = new Credentials($key, $secret);
                $signature = new SignatureV4('es', $region);
                $middleware = new AwsSignatureMiddleware($credentials, $signature);
                $awsHandler = $middleware(ClientBuilder::defaultHandler());
                $builder->setHandler($awsHandler);
            }

            $builder->setHosts(config('elasticsearch.hosts'));
            return $builder->build();
        }, true);

        $this->app->bind('ResultProcessor', function () {
           return new \App\Processors\ElasticSearch\Processor();
        });
    }
}
