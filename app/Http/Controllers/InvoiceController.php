<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function salePageLoad()
    {
        return view('pages.dashbord.sale');
    }

    public function invoicePageLoad(Request $request)
    {
        return view('pages.dashbord.invoice-page');
    }

    public function invoiceCreate(Request $request)
    {
        DB::beginTransaction();
        try {
            $customer_id = $request->input('customer_id');
            $product = $request->input('products');

            if ($product && $customer_id) {
                $user_id = $request->header('id');
                $total = $request->input('total');
                $discount = $request->input('discount');
                $vat = $request->input('vat');
                $payable = $request->input('payable');
                $invoice = Invoice::create([
                    'total' => $total,
                    'discount' => $discount,
                    'vat' => $vat,
                    'payable' => $payable,
                    'user_id' => $user_id,
                    'customer_id' => $customer_id,
                ]);

                $invoice_id = $invoice->id;

                foreach ($product as $item) {
                    InvoiceProduct::create([
                        'invoice_id' => $invoice_id,
                        'product' => $item['name'],
                        'product_id' => $item['id'],
                        'user_id' => $user_id,
                        'qty' => $item['qty'],
                        'sale_price' => $item['price']
                    ]);
                }

                DB::commit();
                return $invoice->id;
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return 0;
        }
    }

    public function invoiceSelect(Request $request)
    {
        $user_id = $request->header('id');
        return Invoice::where('user_id', $user_id)->with('customer')->get();
    }

    public function invoiceDetails(Request $request)
    {
        try {
            $user_id = $request->header('id');

            // get inpput value
            $customer_id = $request->input('customer_id');
            $invoice_id = $request->input('invoice_id');

            $customer = Customer::where('user_id', $user_id)
                ->where('id', $customer_id)->first();

            $invoice = Invoice::where('user_id', $user_id)
                ->where('id', $invoice_id)->first();

            $invoice_product = InvoiceProduct::where('user_id', $user_id)
                ->where('invoice_id', $invoice_id)->get();

            return [
                'customer' => $customer,
                'invoice' => $invoice,
                'invoice_product' => $invoice_product,
            ];
        } catch (\Throwable $th) {
            return "Invoice not found";
        }
    }

    public function invoiceDelete(Request $request)
    {
        DB::beginTransaction();
        try {
            $user_id = $request->header('id');
            $invoice_id = $request->input('invoice_id');

            // delete invoice product
            InvoiceProduct::where('user_id', $user_id)
                ->where('invoice_id', $invoice_id)
                ->delete();

            // delete invoice
            Invoice::where('user_id', $user_id)
                ->where('id', $invoice_id)
                ->delete();

            DB::commit();
            return 1;
        } catch (Exception $e) {
            DB::rollBack();
            return 0;
        }
    }
}
