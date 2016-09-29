<?php namespace App\Processors\ElasticSearch\ResultProcessor;

class GetResponse extends AbstractResponse
{
    protected $method = 'get';

    protected function getDocuments ()
    {
        return [$this->response];
    }
}