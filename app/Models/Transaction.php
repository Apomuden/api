<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Model;

use App\Http\Helpers\DateHelper;
use ReflectionClass;

class Transaction
{
    public function buildTransactionDetails($patient_id): array
    {
        $total_deposit_amount = $this->deposit($patient_id);
        $total_discount_amount = $this->discount($patient_id);
        $abscond_amount = $this->abscond($patient_id);
        $services = $this->service_order($patient_id);
        $reflect = new ReflectionClass($services[0] ?? $services);
        $reflect = $reflect->getShortName();
        //dd($services);
        $items = [];
        $total_bill = 0;

        foreach ($services as $service) {
            //dd($service);
            $total_bill += ((double)(($service->insured && $service->prepaid) ? 0 : $service->service_total_amt));
            $items[] = [
                'description' => $service->service->description ?? null,
                'service_type' => $service->hospital_service->name ?? null,
                'unit_fee' => number_format($service->service_fee ?? 0, 2),
                'total_quantity' => $service->service_quantity ?? null,
                'insured' => boolval($service->insured) ? 'YES' : 'NO',
                'prepaid' => boolval($service->prepaid) ? 'YES' : 'NO',
                'total_amount' => number_format($service->service_total_amt ?? 0, 2),
                'total_amount_due' => ($service->insured && !$service->prepaid) ? 0 : $service->service_total_amt,
                'service_date' => DateHelper::toDisplayDateTime($service->service_date),
                'transaction_update_id' => $reflect . '::' . $service->id
            ];
        }
        $refund_amount = $total_deposit_amount - $total_bill;
        $total_bill_due = $total_bill - $total_deposit_amount - $total_discount_amount;
        return [
            'services' => $items,
            'outstanding_bill' => number_format($abscond_amount, 2),
            'total_bill' => number_format($total_bill, 2),
            'total_deposit_amount' => number_format($total_deposit_amount, 2),
            'total_discount_amount' => number_format($total_discount_amount, 2),
            'total_bill_due' => number_format(($refund_amount > 0) ? 0.00 : $total_bill_due, 2),
            'refund_amount' => number_format(($refund_amount <= 0) ? 0.00 : $refund_amount, 2)
        ];
    }

    public function service_order($patient_id, $status = 'PENDING')
    {
        return ServiceOrder::query()->where(['patient_id' => $patient_id,'status' => $status])->get();
    }

    public function deposit($patient_id, $status = 'ACTIVE')
    {
        return Deposit::query()->where(['patient_id' => $patient_id,'status' => $status])->sum('deposit_amount');
    }

    public function abscond($patient_id, $status = 'ACTIVE')
    {
        return Abscond::query()->where(['patient_id' => $patient_id,'status' => $status])->sum('abscond_amount');
    }

    public function discount($patient_id)
    {
        return Discount::query()->where(['patient_id' => $patient_id])->sum('balance');
    }

    public function consultation($patient_id)
    {
        return ServiceOrder::query()->where('patient_id', $patient_id)->get();
    }
}
