<?php


namespace App\Http\services\Invoice;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InvoiceImportService
{
    public function import($importData, $format): void {
        Log::channel('slack')->debug('Start Invoice import');

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

        $sf_number = 0;
        foreach($parsedData as $invoice) {
            $sf_number++;
            $invoiceArr = [
                'user_id' => $invoice['user_id'],
                'sf_code' => $invoice['sf_code'],
                'sf_number' => (isset($invoice['sf_number'])) ? $invoice['sf_number'] : $sf_number,
                'company_name' => $invoice['company_name'],
                'company_code' => $invoice['company_code'],
                'company_address' => (isset($invoice['company_address'])) ? $invoice['company_address'] : '',
                'company_vat' => (isset($invoice['company_vat'])) ? $invoice['company_vat'] : null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $invoice_id = DB::table('invoices')->insertGetId($invoiceArr);


            DB::table('items')->insert([
                'name' => (isset($invoice['name'])) ? $invoice['name'] : '',
                'unit' => (isset($invoice['unit'])) ? $invoice['unit'] : '',
                'price' => $invoice['price'],
                'quantity' => 1,
                'itemable_id' => $invoice_id,
                'itemable_type' => 'App\Models\Invoice',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
}
