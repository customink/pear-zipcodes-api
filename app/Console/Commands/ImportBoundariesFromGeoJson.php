<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ImportBoundariesFromGeoJson extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:boundaries';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Boundaries From GeoJSON';

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
        $countfile = new \SplFileObject(config('elasticsearch.boundary_file'));
        $countfile->seek($countfile->getSize());
        $bar = $this->output->createProgressBar($countfile->key());
        $countfile = null;

        $file = new \SplFileObject(config('elasticsearch.boundary_file'));
        $count = 0;

        $params = ['body' => []];

        while (! $file->eof()) {
            $rawJson = rtrim(trim($file->fgets()), ',');

            if (substr($rawJson, -1) === '}' and $rawJson[0] === '{') { // poor man's way to check if it's valid JSON
                $count++;

                $data = json_decode($rawJson);
                $params['body'][] = [
                    'update' => [
                        '_index' => config('elasticsearch.index'),
                        '_type' => 'zipcodes',
                        '_id' => $data->properties->GEOID10,
                    ]
                ];
                $params['body'][] = ['doc' => $data, 'doc_as_upsert' => true];
                if ($count % 50 == 0) {
                    $responses = \ES::bulk($params);

                    // erase the old bulk request
                    $params = ['body' => []];

                    // unset the bulk response when you are done to save memory
                    unset($responses);
                }

                $bar->advance();
            }
        }

        if (!empty($params['body'])) {
            \ES::bulk($params);
        }

        $bar->finish();
        $file = null;
    }
}
