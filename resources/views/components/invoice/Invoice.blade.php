@include("layout.MenuToggle")

<!-- Main layout -->
<div class="flex flex-col md:flex-row h-screen">
    <!-- Left Sidebar -->
    @include("layout.Sidebar")
    <!-- Right Content -->
    <div class="w-full bg-gray-50 p-6 overflow-auto">
        <div class="invoice-container bg-white rounded-2xl p-5 w-[80%] m-auto">
            <div class="invoice-header flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold">Invoice</h1>
            </div>

            <hr class="text-gray-300">

            <!-- table -->
            <table class="min-w-full divide-y divide-gray-200 mt-4" id="invoiceTable">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Date</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Customer Name</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Phone</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Total</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Vat</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Discount</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Payable</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200" id="invoiceData">

                </tbody>
            </table>

        </div>
    </div>

</div>


<script>
    const getinvoice = async () => {
        showLoader();
        const res = await axios.get('/api/invoiceselect');
        hideLoader();

        const tableList = $("#invoiceData");
        const tableData = $("#invoiceTable");

        tableData.DataTable().destroy();
        tableList.empty();

        res.data.reverse().forEach((item, index) => {

            let payable = Number(item.payable || 0);
            let discount = Number(item.discount || 0);
            let vat = Number(item.vat || 0);
            let total = Number(item.total || 0);
            let row = `
                    <tr>
                        <td class="px-4 py-2 text-sm text-gray-700 font-bold">${DMY(item.created_at)}</td>
                        <td class="px-4 py-2 text-sm text-gray-700 font-bold">${item['customer']['name']}</td>
                        <td class="px-4 py-2 text-sm text-gray-700 font-bold">${item['customer']['mobile']}</td>
                        <td class="px-4 py-2 text-sm text-gray-700 font-bold"><b>৳ </b>${total.toFixed(2)}</td>
                        <td class="px-4 py-2 text-sm text-gray-700 font-bold"><b>৳ </b>${vat.toFixed(2)}</td>
                        <td class="px-4 py-2 text-sm text-gray-700 font-bold"><b>৳ </b>${discount.toFixed(2)}</td>
                        <td class="px-4 py-2 text-sm text-gray-700 font-bold"><b>৳ </b>${payable.toFixed(2)}</td>

                        <td class="px-4 py-2 flex gap-2">
                            <button onclick="viewInvoice(${item.id}, ${item.customer.id})" class="px-3 py-1 rounded border border-cyan-500 text-cyan-500 hover:bg-cyan-500 hover:text-white text-sm">
                                <i class="fa-solid fa-eye"></i>
                            </button>

                            <button onclick="deleteInvoice(${item.id})" class="px-3 py-1 rounded border border-red-500 text-red-500 hover:bg-red-500 hover:text-white text-sm"><i class="fa-solid fa-trash-can"></i></button>
                        </td>
                    </tr>`

            tableList.append(row);
        });


        tableData.DataTable({
            order: [
                [0, 'dsc']
            ],
            lengthMenu: [20, 50, 100, 200]
        });
    }

    const deleteInvoice = async (id) => {
        const result = await Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        });

        if (result.isConfirmed) {
            const res = await axios.post("/api/invoicedelete", {
                "invoice_id": id
            });

            if (res.data == 1) {
                Swal.fire({
                    title: "Deleted!",
                    text: "Your invoice has been deleted.",
                    icon: "success"
                });
                getinvoice();
            } else {
                Swal.fire({
                    title: "Error!",
                    text: "Failed to delete the invoice.",
                    icon: "error"
                });
            }

        }
    };


    getinvoice();
</script>