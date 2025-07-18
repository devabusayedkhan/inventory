<script>
    const createInputChange = () => {
        document.getElementById('customerCreateErrorms').innerHTML = "";
    }
</script>
<!-- Modal Background -->
<div class="fixed inset-0 items-center justify-center bg-black/50 z-50 hidden" id="customerModal">
    <!-- Modal Box -->
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm p-6">
        <h2 class="text-xl font-semibold mb-4">Add Customer</h2>

        <!-- Input Field -->
        <div>
            <label for="customerName" class="block text-sm font-medium text-gray-700">Customer Name</label>
            <input type="text" id="customerName" name="customerName"
                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Enter customer name" onkeyup="createInputChange()">
        </div>

        <div>
            <label for="customerEmail" class="block text-sm font-medium text-gray-700">Customer Email</label>
            <input type="text" id="customerEmail" name="customerEmail"
                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Enter customer email" onkeyup="createInputChange()">
        </div>

        <div>
            <label for="customerMobile" class="block text-sm font-medium text-gray-700">Customer Mobile</label>
            <input type="text" id="customerMobile" name="customerMobile"
                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Enter customer mobile" onkeyup="createInputChange()">
        </div>

        <p class="text-red-500 font-bold" id="customerCreateErrorms"></p>

        <!-- Buttons -->
        <div class="flex justify-end space-x-2 mt-4">
            <!-- Close Button -->
            <button onclick="document.getElementById('customerModal').style.display='none'"
                class="px-4 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300">
                Close
            </button>

            <!-- Save Button -->
            <button onclick="createCustomer()" type="button"
                class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">
                Save
            </button>
        </div>
    </div>
</div>

<script>
    const createCustomer = async () => {
        let customerName = document.getElementById('customerName');
        let customerEmail = document.getElementById('customerEmail');
        let customerMobile = document.getElementById('customerMobile');
        if (!customerName.value) {
            document.getElementById('customerCreateErrorms').innerHTML = "Customer Name is required";
        } else if (!customerMobile.value) {
            document.getElementById('customerCreateErrorms').innerHTML = "Customer Mobile numver is required";
        } else {

            showLoader();
            const getCustomerData = await axios.get('/api/getcustomer');
            hideLoader();

            let customerNameChecker = "";
            getCustomerData.data.map((item) => {
                if (item.email.toLowerCase() == customerEmail.value.toLowerCase() || item.mobile.toLowerCase() == customerMobile.value.toLowerCase()) {
                    customerNameChecker = true;
                }
            });

            if (customerNameChecker !== true) {
                showLoader();
                const res = await axios.post('/api/addcustomer', {
                    name: customerName.value,
                    email: customerEmail.value,
                    mobile: customerMobile.value
                });
                hideLoader();

                if (res.data.status === "success") {
                    Swal.fire({
                        position: "center-center",
                        icon: "success",
                        title: "Customer created success",
                        showConfirmButton: false,
                        timer: 1500
                    });
                    customerName.value = "";
                    customerEmail.value = "";
                    customerMobile.value = "";
                    document.getElementById('customerModal').style.display = 'none';
                    getcustomer();
                } else {
                    document.getElementById('customerCreateErrorms').innerHTML = res.data;
                }
            } else {
                document.getElementById('customerCreateErrorms').innerHTML = "This customer already exists.";
            }
        }
    }
</script>