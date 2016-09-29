<?php namespace App\Processors\ElasticSearch\DocumentFormatter;

abstract class AbstractDocumentFormatter
{
    protected $document;

    public function __construct($document)
    {
        $this->document = $document;
    }

    /**
     * @return array
     */
    abstract function format($options = []);
}