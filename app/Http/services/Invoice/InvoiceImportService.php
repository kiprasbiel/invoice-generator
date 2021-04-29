<?php


namespace App\Http\services\Invoice;

use Illuminate\Support\Facades\DB;

class InvoiceImportService
{
    public function import($importData, $format): void {
        // TODO: refactorint i parent klase
        $userId = $importData->user_id;

        $data = array_map(
            function($file) {
                return str_getcsv($file, ";");
            },
            file($importData->csv_filename)
        );
        ksort($format['fields']);

        $parsedData = array_map(function($row) use ($format, $userId) {
            $combinedArr = array_combine($format['fields'], $row);
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
                'is_payed' => true,
                'created_at' => (isset($invoice['created_at'])) ? $invoice['created_at'] : date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $invoice_id = DB::table('invoices')->insertGetId($invoiceArr);

            DB::table('items')->insert([
                'name' => (isset($invoice['name'])) ? $invoice['name'] : '',
                'unit' => (isset($invoice['unit'])) ? $invoice['unit'] : '',
                'price' => $invoice['price'],
                'quantity' => (isset($invoice['quantity'])) ? $invoice['quantity'] : 1,
                'itemable_id' => $invoice_id,
                'itemable_type' => 'App\Models\Invoice',
                'created_at' => (isset($invoice['created_at'])) ? $invoice['created_at'] : date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
}
