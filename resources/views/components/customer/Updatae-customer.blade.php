<script>
    const updateCustomerInputChange = () => {
        document.getElementById('updateCustomerDuplicateMsg').innerHTML = "";
    }
</script>
<!-- Modal Background -->
<div class="fixed inset-0 hidden items-center justify-center bg-black/50 z-50" id="updateCustomerModal">
    <!-- Modal Box -->
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm p-6">
        <h2 class="text-xl font-semibold mb-4">Update Customer</h2>

        <input type="hidden" id="updateCustomerID">

        <!-- Input Field -->
        <!-- name -->
        <div class="mb-2">
            <label for="updateCustomerName" class="block text-sm font-medium text-gray-700">Customer Name</label>
            <input type="text" id="updateCustomerName" name="updateCustomerName"
                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Enter new customer name" onkeyup="updateCustomerInputChange()">
        </div>
        <!-- email -->
        <div class="mb-2">
            <label for="updateCustomerEmail" class="block text-sm font-medium text-gray-700">Customer Email</label>
            <input type="text" id="updateCustomerEmail" name="updateCustomerEmail"
                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Enter new customer email" onkeyup="updateCustomerInputChange()">
        </div>
        <!-- mobile -->
        <div class="mb-2">
            <label for="updateCustomerMobile" class="block text-sm font-medium text-gray-700">Customer Mobile</label>
            <input type="text" id="updateCustomerMobile" name="updateCustomerMobile"
                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Enter new customer mobile" onkeyup="updateCustomerInputChange()">
        </div>

        <!-- Duplicate Message -->
        <p class="text-red-500 font-bold" id="updateCustomerDuplicateMsg"></p>

        <!-- Buttons -->
        <div class="flex justify-end space-x-2 mt-4">
            <!-- Close Button -->
            <button onclick="document.getElementById('updateCustomerModal').style.display='none'"
                class="px-4 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300">
                Close
            </button>

            <!-- Update Button -->
            <button onclick="updateCustomer()"
                class="px-4 py-2 rounded-lg bg-green-600 text-white hover:bg-green-700">
                Update
            </button>
        </div>
    </div>
</div>

<script>
    const updateCustomerInputName = document.getElementById('updateCustomerName');
    const updateCustomerInputEmail = document.getElementById('updateCustomerEmail');
    const updateCustomerInputMobile = document.getElementById('updateCustomerMobile');
    const updateCustomerInputid = document.getElementById('updateCustomerID');

    // modal css
    const openCustomerUpdateModal = (id, customerName, customerEmail, customermobile) => {
        document.getElementById('updateCustomerModal').style.display = 'flex';
        updateCustomerInputName.value = customerName;
        updateCustomerInputEmail.value = customerEmail;
        updateCustomerInputMobile.value = customermobile;
        updateCustomerInputid.value = id;
    }

    const updateCustomer = async () => {
        showLoader();
        const getCustomerData = await axios.get('/api/getcustomer');
        hideLoader();

        let customerNameChecker = "";
        getCustomerData.data.map((item) => {
            if (
                (item.email.toLowerCase() == updateCustomerInputEmail.value.toLowerCase() && item.id != updateCustomerInputid.value) ||
                (item.mobile.toLowerCase() == updateCustomerInputMobile.value.toLowerCase() && item.id != updateCustomerInputid.value)) {
                customerNameChecker = true;
            }
        });

        if (customerNameChecker !== true) {
            showLoader();
            const res = await axios.post('/api/updatecustomer', {
                id: updateCustomerInputid.value,
                name: updateCustomerInputName.value,
                email: updateCustomerInputEmail.value,
                mobile: updateCustomerInputMobile.value
            });
            hideLoader();


            if (res.data.status === "success") {
                Swal.fire({
                    position: "center-center",
                    icon: "success",
                    title: "Customer Update success",
                    showConfirmButton: false,
                    timer: 1500
                });
                document.getElementById('updateCustomerModal').style.display = 'none';
                getcustomer();
            } else {
                document.getElementById('updateCustomerDuplicateMsg').innerHTML = res.data;
            }
        } else {
            document.getElementById('updateCustomerDuplicateMsg').innerHTML = "This customer already exists.";
        }
    }
</script>