<?php namespace App\Processors\ElasticSearch\OutputProcessor;

abstract class AbstractOutputProcessor
{
    protected $documents;
    protected $options;

    function __construct($documents, $options = []) {
        $this->options = $options;
        $this->documents = $documents;
    }

    abstract public function getArray();
}