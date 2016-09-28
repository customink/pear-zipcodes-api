<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ImportZipInfoFromCsv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:demographic';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Demographic Information from Zipcodes.com csv file';

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
        $file = new \SplFileObject(config('elasticsearch.demographic_file'));
        $count = 0;
        $headers = [];
        $bar = $this->output->createProgressBar(33500);

        $params = ['body' => []];

        while (! $file->eof()) {
            $count++;
            $line = utf8_encode($file->fgets());
            if ($count == 1) {
                $headers = str_getcsv($line);
                continue;
            }


            $values = str_getcsv($file);
            if (count($values) === count($headers) and $values[1] === "P") {  //Check to see if it's a Primary Record
                $values = array_map(function ($value) {
                    return utf8_encode($value);
                }, $values);

                $processedArray = array_combine($headers, $values);

                $params['body'][] = [
                    'update' => [
                        '_index' => config('elasticsearch.index'),
                        '_type' => 'zipcodes',
                        '_id' => $processedArray['ZipCode'],
                    ]
                ];
                $params['body'][] = [
                    'doc' => (object) ['properties' => (object) $processedArray],
                    'doc_as_upsert' => true,
                ];
                if ($count % 50 == 0) {
                    try {
                        \ES::bulk($params);
                    } catch (\Exception $e) {
                        dd($params);
                    }

                    // erase the old bulk request
                    $params = ['body' => []];

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
