<?php


namespace App\Http\services\Clients;


use App\Models\Client;
use App\Models\ImportData;
use Illuminate\Support\Facades\Log;

class ClientImportService
{
    public function import($id, $format): void {
        Log::channel('slack')->debug('Start import');

        $importData = ImportData::find($id);
        $userId = $importData->user_id;

        $data = array_map(
            function($file) {
                return str_getcsv($file, ";");
            },
            file($importData->csv_filename)
        );

        $parsedData = array_map(function($row) use ($format, $userId) {
            $tempArr = array_intersect_key($row, $format['fields']);
            $combinedArr = array_combine($format['fields'], $tempArr);
            $combinedArr['user_id'] = $userId;
            return $combinedArr;
        }, $data);

        $response = Client::insert($parsedData);
        Log::channel('sisngle')->debug($response);
    }
}
