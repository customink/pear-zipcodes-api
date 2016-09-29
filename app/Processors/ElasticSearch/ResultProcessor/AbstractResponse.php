<?php namespace App\Processors\ElasticSearch\ResultProcessor;

use App\Processors\ElasticSearch\DocumentArrayProcessor;

abstract class AbstractResponse
{
    protected $response;
    protected $method;

    function __construct(array $response)
    {
        $this->response = $response;
    }

    /**
     * @return \App\Processors\ElasticSearch\DocumentArrayProcessor
     */
    public function process() {
        return new DocumentArrayProcessor($this->getDocuments(), $this->method);
    }

    abstract protected function getDocuments();
}