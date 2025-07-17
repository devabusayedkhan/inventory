@include("layout.MenuToggle")

<!-- Main layout -->
<div class="flex flex-col md:flex-row">
    <!-- Left Sidebar -->
    @include("layout.Sidebar")
    <!-- Right Content -->
    <div class="w-full md:flex bg-gray-50 p-6 overflow-auto gap-3">

        <!-- Left Panel (Product Picker) -->
        <div class="bg-white rounded-xl shadow p-6 w-full">
            <table class="w-full text-sm" id="saleProductTable">
                <thead class="text-gray-500 border-b">
                    <tr>
                        <th class="text-left w-[70%]">Product</th>
                        <th class="text-left w-[20%]">Price</th>
                        <th class="text-left w-[10%]">Pick</th>
                    </tr>
                </thead>
                <tbody id="saleProductTableData">

                </tbody>
            </table>
        </div>

        <!-- Middle Panel (Customer Picker) -->
        <div class="bg-white rounded-xl shadow p-6 w-full">
            <table class="w-full text-sm" id="saleCustomerTable">
                <thead class="text-gray-500 border-b">
                    <tr>
                        <th class="text-left">Customer</th>
                        <th class="text-left">Mobile</th>
                        <th class="text-left">Pick</th>
                    </tr>
                </thead>
                <tbody id="saleCustomerTableData">

                </tbody>
            </table>
        </div>

        <!-- Right Panel (Invoice) -->
        <div class="bg-white rounded-xl shadow p-6 w-full">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <p class="font-bold">BILLED TO</p>
                    <p>Name: <strong id="billToName"></strong></p>
                    <p>Email: <strong id="billToEmail"></strong></p>
                    <p>User Phone: <strong id="billToMobile"></strong></p>
                    <input type="hidden" value="" id="billToId">
                </div>
                <div class="text-right">
                    <span class="text-2xl font-bold text-indigo-900">dask<span class="text-orange-500">Z</span>one
                    </span>
                    <p class="font-bold text-xl text-emerald-600">Invoice</p>
                    <p class="text-cyan-600 font-bold">Date: <span>{{date('d-F-Y')}}</span></p>
                </div>
            </div>

            <table class="w-full text-sm mb-4">
                <thead class="text-gray-500 border-b">
                    <tr>
                        <th class="text-left w-[65%]">Name</th>
                        <th class="text-left w-[10%]">Qty</th>
                        <th class="text-left w-[15%]">Total</th>
                        <th class="text-left w-[10%]">Remove</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700" id="billToProductData">
                    <!-- Product rows go here -->
                </tbody>
            </table>

            <div class="text-sm text-gray-700 space-y-2">
                <p class="font-bold">TOTAL:
                    <strong class="d-inline">৳</strong> <span id="totalAmount">0.00</span>
                </p>
                <p class="font-bold text-lg text-cyan-600">PAYABLE:
                    <strong class="d-inline">৳</strong> <span id="payable">0.00</span>
                </p>
                <p class="font-bold">VAT(5%):
                    <strong class="d-inline">৳</strong> <span id="vat">0.00</span>
                </p>
                <p class="font-bold">Discount:
                    <strong class="d-inline">৳</strong> <span id="discount">0.00</span>
                </p>

                <label class="block text-gray-600 mt-4 mb-0">Discount(%):</label>
                <b class="block text-red-700 m-0" id="maxiumDiscountmsg"></b>
                <input type="number" value="0" min="0" max="100" id="discountInput"
                    class="w-20 px-2 py-1 border rounded" onkeyup="total()" />
            </div>

            <button onclick="invoiceSet()"
                class="mt-4 w-full py-2 rounded text-white font-bold bg-gradient-to-r from-pink-500 to-purple-600 hover:opacity-90">
                CONFIRM
            </button>
        </div>
    </div>

</div>


<script>
    // Customer load
    const getCustomer = async () => {
        showLoader();
        const res = await axios.get('/api/getcustomer');
        hideLoader();

        const tableData = $("#saleCustomerTableData");
        const table = $("#saleCustomerTable");

        table.DataTable().destroy();
        tableData.empty();

        res.data.forEach((item) => {

            let row = `
                    <tr class="border-b">
                        <td class="py-2"><i class="fa-solid fa-user-tie me-1"></i> ${item.name}</td>
                        <td class="py-2">${item.mobile}</td>
                        <td><button class="px-3 py-1 border rounded hover:bg-gray-100" onclick="customerBillTo('${item.name}', '${item.email}', '${item.mobile}', ${item.id})">ADD</button></td>
                    </tr>`

            tableData.append(row);
        });

        table.DataTable({
            order: [[0, 'asc']],
            scrollCollapse: false,
            info: false,
            lengthChange: false
        });
    }
    // Customer information show on Bill to
    const customerBillTo = (name, email, mobile, id) => {
        const billToName = document.getElementById('billToName');
        const billToEmail = document.getElementById('billToEmail');
        const billToMobile = document.getElementById('billToMobile');
        const billToId = document.getElementById('billToId');
        if (name) {
            billToName.innerHTML = name;
            billToEmail.innerHTML = email || "";
            billToMobile.innerHTML = mobile;
            billToId.value = id;
        }
    }
    // Product load
    const getProduct = async () => {
        showLoader();
        const res = await axios.get('/api/getproduct');
        hideLoader();

        const tableData = $("#saleProductTableData");
        const table = $("#saleProductTable");

        table.DataTable().destroy();
        tableData.empty();

        res.data.forEach((item) => {

            let row = `
                    <tr class="border-b">
                        <td class="py-2"><img src="${item.img}" class="w-[30px] h-[30px] object-cover inline"> ${item.name}</td>
                        <td class="py-2 me-1">
                            <strong class="d-inline text-2xl">৳</strong> ${item.price}
                            <hr class="my-1 text-gray-200">
                            <div class="flex items-center space-x-2">
                                <button type="button" onclick='decQty(this)' class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300 select-none">-</button>

                                    <input 
                                    type="number" 
                                    value="1" 
                                    min="1" max="10" 
                                    name='qty'
                                    class="qtyInput w-12 text-center border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    readonly
                                    />

                                <button type="button" onclick='incQty(this)' class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300 select-none">+</button>
                            </div>
                        </td>
                        
                        <td><button class="px-3 py-1 border rounded hover:bg-gray-100" onclick='addProductBillTo(${item.id}, this)'>ADD</button></td>
                    </tr>`

            tableData.append(row);
        });

        table.DataTable({
            order: [[0, 'asc']],
            scrollCollapse: false,
            info: false,
            lengthChange: false
        });
    }

    let allBillToProduct = [];
    let invoiceDetails = {};
    // Product information show
    const addProductBillTo = async (id, qtyBTN) => {
        // qty
        const row = qtyBTN.closest('tr');
        const qtyInput = row.querySelector('input[name="qty"]');
        const qty = parseInt(qtyInput.value);

        showLoader();
        const res = await axios.post('/api/productfiend', { "id": id });
        hideLoader();

        const prevProduct = allBillToProduct.find(item => item.id == id);


        if (prevProduct) {
            const prevQty = prevProduct.qty;
            const prevProducts = allBillToProduct.filter(product => product.id != id);

            const price = (res.data.price * (qty + prevQty)).toFixed(2);
            allBillToProduct = [...prevProducts, { ...res.data, price: price, qty: (qty + prevQty) }]
        } else {
            const price = (res.data.price * qty).toFixed(2);
            allBillToProduct.push({ ...res.data, qty: qty, price: price });
        }

        showProductBillTo();
        total();
    }

    const productBillToRemove = (id) => {
        const filterData = allBillToProduct.filter(item => item.id != id);
        allBillToProduct = filterData;
        showProductBillTo();
        total();
    }

    // show invoice
    const showProductBillTo = () => {

        const billToProductData = document.getElementById('billToProductData');
        let row = ``;
        allBillToProduct.map((item) => {

            row += `
                    <tr class="border-b">
                        <td class="py-2"> ${item.name}</td>
                        <td class="py-2"> ${item.qty}</td>
                        <td class="py-2 me-1"> <strong class="d-inline text-2xl">৳</strong> ${item.price}</td>
                        <td><button class="px-3 py-1 border rounded hover:bg-gray-100" onclick="productBillToRemove(${item.id})">Remove</button></td>
                    </tr>`
        });
        billToProductData.innerHTML = row;
    }

    // total
    const total = () => {
        const discountInput = document.getElementById('discountInput').value;
        // set vat
        const setVat = 5; //This value is in %

        let totalAmount = 0.00;
        let discount = 0;
        let vat = 0;
        let payable = 0

        allBillToProduct.map((item) => {
            let price = parseFloat(item.price);
            totalAmount = (totalAmount + price);
        })

        // discount
        if (discountInput > 0 && discountInput <= 50) {
            discount = (totalAmount * discountInput) / 100;
            totalAmount -= discount;
        }

        vat = (totalAmount * setVat) / 100;
        payable = totalAmount + vat;

        // show all amount
        document.getElementById('totalAmount').innerHTML = totalAmount.toFixed(2);
        document.getElementById('discount').innerHTML = discount.toFixed(2);
        document.getElementById('payable').innerHTML = payable.toFixed(2);
        document.getElementById('vat').innerHTML = vat.toFixed(2);

        // set invoice details
        invoiceDetails = {
            setVat,
            totalAmount,
            discount,
            vat,
            payable,
            allBillToProduct
        }
    }


    const invoiceSet = async () => {

        let customer_id = document.getElementById('billToId');


        if (!customer_id.value) {
            showLoader();
            let res = await axios.get('/api/findguestcustomer');

            if (!res.data.id) {
                // Add a guest Customer
                await axios.post('/api/addcustomer', {
                    name: "Guest Customer",
                    email: "guestcustomer@gmail.com",
                    mobile: "01666666666"
                });
                res = await axios.get('/api/findguestcustomer');
            }

            hideLoader();
            await Swal.fire({
                title: "Are you sure?",
                text: "কোন কাস্টমার সিলেক্ট করা হয়নি। আপনি কি Guest Customer-এর কাছে পণ্য বিক্রি করতে চান?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes"
            }).then((result) => {
                if (result.isConfirmed) {
                    customer_id.value = res.data.id;
                }
            });
        }


        showLoader();
        const res = await axios.post('/api/invoicecreate', {
            "total": invoiceDetails.totalAmount,
            "discount": invoiceDetails.discount,
            "vat": invoiceDetails.vat,
            "payable": invoiceDetails.payable,
            "customer_id": customer_id.value,
            "products": invoiceDetails.allBillToProduct,
        });
        hideLoader();

        if (res.data > 0) {
            await Swal.fire({
                position: "center-center",
                icon: "success",
                title: "Success",
                showConfirmButton: false,
                timer: 1500
            });
            document.querySelectorAll('.qtyInput').forEach(el => {
                el.value = 1;
            });

            // show invoice details
            const customerId = document.getElementById('billToId').value;
            viewInvoice(res.data, customerId);

            // reset bill to 
            allBillToProduct = [];
            invoiceDetails = {};
            document.getElementById('billToName').innerHTML = "";
            document.getElementById('billToEmail').innerHTML = "";
            document.getElementById('billToMobile').innerHTML = "";
            document.getElementById('billToProductData').innerHTML = "";
            document.getElementById('totalAmount').innerHTML = "0.00";
            document.getElementById('payable').innerHTML = "0.00";
            document.getElementById('vat').innerHTML = "0.00";
            document.getElementById('discount').innerHTML = "0.00";
            document.getElementById('discountInput').value = "0";
            document.getElementById('billToId').value = "";
        } else {
            Swal.fire({
                icon: "error",
                title: "At least one product is required. Please add one."
            });
        }


    }


    (async () => {
        showLoader();
        await getProduct();
        await getCustomer()
        hideLoader();
    })()



    // qty design

    function decQty(button) {
        // button থেকে parent div খুঁজে input পাবে
        const input = button.parentElement.querySelector('.qtyInput');
        let current = parseInt(input.value);
        if (current > 1) {
            input.value = current - 1;
        }
    }

    function incQty(button) {
        const input = button.parentElement.querySelector('.qtyInput');
        let current = parseInt(input.value);
        if (current < 10) {
            input.value = current + 1;
        }
    }


    const input = document.getElementById('discountInput');
    input.addEventListener('input', () => {
        let value = parseFloat(input.value);
        if (value > 50) {
            input.value = 50;
            document.getElementById('maxiumDiscountmsg').innerHTML = "max possible discount 50%";
        } else if (value < 0) {
            input.value = 0
        } else {
            document.getElementById('maxiumDiscountmsg').innerHTML = "";
        }
    });

</script>