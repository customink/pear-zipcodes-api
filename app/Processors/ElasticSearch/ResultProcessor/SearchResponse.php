<?php namespace App\Processors\ElasticSearch\ResultProcessor;

class SearchResponse extends AbstractResponse
{
    protected $method = 'search';

    protected function getDocuments() {
        return $this->response['hits']['hits'];
    }
}