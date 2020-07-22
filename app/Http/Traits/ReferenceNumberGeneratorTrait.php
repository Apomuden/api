<?php

namespace App\Http\Traits;

use Illuminate\Database\Eloquent\Model;

trait ReferenceNumberGeneratorTrait
{
    public static function getLastReferenceNumber(Model $model, string $column = 'reference_number')
    {
        return $model::all($column)->last()->{$column} ?? null;
    }

    public static function generate(Model $model, string $column = 'reference_number', $separator = '/'): string
    {
        $prefix = strtoupper(date('M')) . ' ';
        $midNumber = '00001';
        $postfix = strtoupper(date('y'));
        $receiptNumber = $prefix . $separator . $midNumber . $separator . $postfix;
        $previousReceiptNumber = self::getLastReferenceNumber($model, $column) ?? null;
        $previousReceiptNumberArray = $previousReceiptNumber ? explode($separator, $previousReceiptNumber) : null;
        if ($previousReceiptNumber) {
            if ($previousReceiptNumberArray[0] == $prefix && $previousReceiptNumberArray[2] == $postfix) {
                $previousReceiptNumberArray[1] = ((int)$previousReceiptNumberArray[1]) + 1;
                if (strlen($previousReceiptNumberArray[1]) < 5) {
                    $previousReceiptNumberArray[1] = str_pad($previousReceiptNumberArray[1], 5, '0', STR_PAD_LEFT);
                }
                $receiptNumber = implode($separator, $previousReceiptNumberArray);
            }
        }
        return $receiptNumber;
    }
}
