<?php


namespace App\Http\services\Invoice;


class InvoiceService
{
    public static function calculateCosts($serviceList){
        $totalCost = 0;
        foreach ($serviceList as &$service){
            $price = $service['product_price'] * $service['product_pcs'];
            $totalCost += $price;
            $service['total_price'] =  $price;
        }

        $serviceList['total_invoice_price'] = $totalCost;
        return $serviceList;
    }
}
