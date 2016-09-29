<?php namespace App\Processors\ElasticSearch\ResultProcessor;

class MGetResponse extends AbstractResponse
{
    protected $method = 'mget';

    protected function getDocuments() {
        return $this->response['docs'];
    }
}