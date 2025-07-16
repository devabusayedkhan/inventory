<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function ReportPage(Request $request)
    {
        return view("pages.dashbord.report-page");
    }

    public function SalesReport(Request $request)
    {
        $user_id = $request->header("id");

        $fromDate = date('Y-m-d', strtotime($request->fromdate));
        $toDate = date('Y-m-d', strtotime($request->todate));

        $total = Invoice::where('user_id', $user_id)
            ->whereDate('created_at', '>=', $fromDate)
            ->whereDate('created_at', '<=', $toDate)->sum('total');
        $vat = Invoice::where('user_id', $user_id)
            ->whereDate('created_at', '>=', $fromDate)
            ->whereDate('created_at', '<=', $toDate)->sum('vat');
        $payable = Invoice::where('user_id', $user_id)
            ->whereDate('created_at', '>=', $fromDate)
            ->whereDate('created_at', '<=', $toDate)->sum('payable');
        $discount = Invoice::where('user_id', $user_id)
            ->whereDate('created_at', '>=', $fromDate)
            ->whereDate('created_at', '<=', $toDate)->sum('discount');
        $list = Invoice::where('user_id', $user_id)
            ->whereDate('created_at', '>=', $fromDate)
            ->whereDate('created_at', '<=', $toDate)
            ->with('customer')->get();

        $data = [
            'total' => $total,
            'vat' => $vat,
            'payable' => $payable,
            'discount' => $discount,
            'list' => $list,
            'formDate' => $fromDate,
            'toDate' => $toDate
        ];

        if ($total > 0) {
            $pdf = Pdf::loadView('report.SalesReport', $data);
            return $pdf->download('invoice.pdf');
        }else{
            return 0;
        }
    }
}
