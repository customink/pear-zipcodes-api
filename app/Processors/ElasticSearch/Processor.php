<?php namespace App\Processors\ElasticSearch;

class Processor {
    protected $responseMethods = [
        'get' => ResultProcessor\GetResponse::class,
        'mget' => ResultProcessor\MGetResponse::class,
        'search' => ResultProcessor\SearchResponse::class,
    ];

    function __call($name, $arguments)
    {
        if (isset($this->responseMethods[$name])) {
            /**
             * @var $processor \App\Processors\ElasticSearch\ResultProcessor\AbstractResponse
             */
            $resultProcessorClass = $this->responseMethods[$name];
            $processor = new $resultProcessorClass($arguments[0]);

            return $processor->process();
        }

        $className = static::class;

        throw new \BadMethodCallException("Call to undefined method {$className}::{$name}()");
    }
}