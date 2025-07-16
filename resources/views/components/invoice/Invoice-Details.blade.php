<!-- Modal Background -->
<div class="fixed inset-0 hidden items-center justify-center bg-black/50 z-50" id="viewInvoiceModal">
    <!-- Modal Box -->
    <div class="bg-white rounded-2xl shadow-xl w-[95%] md:w-[70%] lg:w-[60%] xl:w-[50%] p-6">
        <h2 class="text-xl font-bold mb-4">Invoice</h2>

        <hr class="text-gray-300">

        <div class="p-8" id="invoicePrint">
            <!-- Header -->
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-gray-800 font-bold text-lg">BILLED TO</h2>
                    <p class="text-gray-700 mt-1">Name: <span class="font-bold" id="invoiceCustomerName"></span></p>
                    <p class="text-gray-700">Email: <span class="font-bold" id="invoiceCustomerEmail"></span></p>
                    <p class="text-gray-700">Mobile: <span class="font-bold" id="invoiceCustomerMobile"></span></p>
                </div>
                <div class="text-right">
                    <span class="text-2xl font-bold text-indigo-900">dask<span class="text-orange-500">Z</span>one
                    </span>
                    <p class="text-gray-600 font-semibold mt-1">Invoice</p>
                    <p class="text-gray-500 text-sm">Date: <span id="invoiceDate"></span></p>
                </div>
            </div>
            <hr class="text-gray-300 mt-4">
            <!-- Table -->
            <div class="mt-6">
                <table class="w-full">
                    <thead class="text-left font-bold border-b border-gray-400">
                        <tr class="bg-gray-200 p-2">
                            <th class="p-2 w-[70%]">Name</th>
                            <th class="py-2">Qty</th>
                            <th class="py-2">Total</th>
                        </tr>
                    </thead>
                    <tbody id="invoice-Details-data">
                        {{-- invoice Data --}}
                    </tbody>
                </table>
            </div>
            <!-- Totals -->
            <div class="mt-6 text-gray-800 text-sm space-y-1">
                <p class="m-0"><strong class="text-md">TOTAL: </strong>
                    <b class="text-2xl font-bold"> ৳</b>
                    <span class="text-md" id="invoice-details-total"></span>
                </p>
                <p class="m-0"><strong class="text-md">PAYABLE: </strong>
                    <b class="text-2xl font-bold"> ৳</b>
                    <span class="text-md" id="invoice-details-payable"></span>
                </p>
                <p class="m-0"><strong class="text-md">VAT(5%): </strong>
                    <b class="text-2xl font-bold"> ৳</b>
                    <span class="text-md" id="invoice-details-vat"></span>
                </p>
                <p class="m-0"><strong class="text-md">Discount: </strong>
                    <b class="text-2xl font-bold"> ৳</b>
                    <span class="text-md" id="invoice-details-discount"></span>
                </p>
            </div>

            <hr class="text-gray-300 mt-2">
        </div>

        <!-- Buttons -->
        <div class="flex justify-end space-x-2 mt-4">
            <!-- Close Button -->
            <button onclick="document.getElementById('viewInvoiceModal').style.display='none'"
                class="px-4 py-2 rounded-lg bg-gradient-to-r from-pink-600 to-purple-600 hover:from-pink-700 hover:to-purple-700 transition text-white font-bold">
                Close
            </button>

            <!-- Update Button -->
            <button onclick="invoicePrintPage()" class="px-4 py-2 rounded-lg bg-green-600 text-white hover:bg-green-700 font-bold">
                Print
            </button>
        </div>
    </div>
</div>

<script>

    // modal css
    const viewInvoice = async (invoice_id, customer_id) => {

        showLoader();
        const res = await axios.post('/api/invoicedetails', { invoice_id, customer_id });
        hideLoader();

        if (res.status == 200) {
            let allInvoiceData = ``;

            res.data.invoice_product.map((item) => {
                allInvoiceData += `
                <tr class="text-gray-700 border-b border-gray-300 bg-gray-100">
                    <td class="p-2">${item.product}</td>
                    <td class="py-2">${item.qty}</td>
                    <td class="py-2">${item.sale_price}</td>
                </tr>`;
            });

            document.getElementById('invoiceCustomerName').innerHTML = res.data.customer.name;
            document.getElementById('invoiceCustomerEmail').innerHTML = res.data.customer.email;
            document.getElementById('invoiceCustomerMobile').innerHTML = res.data.customer.mobile;
            document.getElementById('invoiceDate').innerHTML = DMY(res.data.invoice.created_at);
            document.getElementById('invoice-Details-data').innerHTML = allInvoiceData;
            document.getElementById('invoice-details-total').innerHTML = Number(res.data.invoice.total).toFixed(2);
            document.getElementById('invoice-details-payable').innerHTML = Number(res.data.invoice.payable).toFixed(2);
            document.getElementById('invoice-details-vat').innerHTML = Number(res.data.invoice.vat).toFixed(2);
            document.getElementById('invoice-details-discount').innerHTML = Number(res.data.invoice.discount).toFixed(2);
        }

        // modal css
        document.getElementById('viewInvoiceModal').style.display = 'flex';
    }

    const invoicePrintPage = ()=>{
        let invoicePrintContent = document.getElementById('invoicePrint').innerHTML;
        let orginalContents = document.body.innerHTML;
        document.body.innerHTML = invoicePrintContent;
        window.print();
        document.body.innerHTML = orginalContents;
        document.getElementById('viewInvoiceModal').style.display = 'none';
    }
</script>