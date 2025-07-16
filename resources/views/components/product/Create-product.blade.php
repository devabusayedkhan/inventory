<script>
    const createInputChange = () => {
        document.getElementById('productCreateErrorms').innerHTML = "";
    }
</script>
<!-- Modal Background -->
<div class="fixed inset-0 items-center justify-center bg-black/50 z-50 hidden" id="productModal">
    <!-- Modal Box -->
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm p-6">
        <h2 class="text-xl font-semibold mb-4">Add Product</h2>

        <!-- Input Field -->
        <div>
            <label for="productName" class="block text-sm font-medium text-gray-700">Product Name</label>
            <input type="text" id="productName" name="productName"
                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Enter product name" onkeyup="createInputChange()">
        </div>

        <div>
            <label for="productUnit" class="block text-sm font-medium text-gray-700">Product Unit</label>
            <input type="text" id="productUnit" name="productUnit"
                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Enter product unit" onkeyup="createInputChange()">
        </div>

        <div>
            <label for="productPrice" class="block text-sm font-medium text-gray-700">Product Price</label>
            <input type="number" id="productPrice" name="productPrice" step="0.01" min="0"
                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Enter product price" onkeyup="createInputChange()">
        </div>

        <!-- category -->
        <div class="mt-4">
            <label for="productCategory" class="block text-sm font-medium text-gray-700">Product Category</label>
            <select id="productCategory" name="productCategory"
                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </select>
        </div>



        <!-- Product Image Upload -->
        <div class="mt-4">
            <label for="productImg" class="block text-sm font-medium text-gray-700">Product Image</label>
            <input type="file" id="productImg" name="productImg"
                accept="image/*"
                class="mt-1 block w-full text-sm text-gray-700 border border-gray-300 rounded-lg cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>



        <p class="text-red-500 font-bold" id="productCreateErrorms"></p>

        <!-- Buttons -->
        <div class="flex justify-end space-x-2 mt-4">
            <!-- Close Button -->
            <button onclick="document.getElementById('productModal').style.display='none'"
                class="px-4 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300">
                Close
            </button>

            <!-- Save Button -->
            <button onclick="createProduct()" type="button" class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">
                Save
            </button>
        </div>
    </div>
</div>

<script>
    let productCategory = document.getElementById('productCategory');
    // category input field
    const categoryLoadForFieldFrom = async () => {
        // category 
        showLoader();
        const getCategoryData = await axios.get('/api/getcategory');
        hideLoader();

        let optionData = `<option value="">Select a category</option>`;
        getCategoryData.data.map((item) => {
            optionData += `<option value="${item.id}">${item.name}</option>`;
        });

        productCategory.innerHTML = optionData;
    }
    categoryLoadForFieldFrom();


    const createProduct = async () => {
        let productName = document.getElementById('productName');
        let productUnit = document.getElementById('productUnit');
        let productPrice = document.getElementById('productPrice');
        let productImg = document.getElementById('productImg').files[0];

        showLoader();
        const res = await axios.post('/api/addproduct', {
            category_id: productCategory.value,
            name: productName.value,
            price: productPrice.value,
            unit: productUnit.value,
            img: productImg
        }, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });
        hideLoader();

        if (res.data.status === "success") {
            Swal.fire({
                position: "center-center",
                icon: "success",
                title: "Product created success",
                showConfirmButton: false,
                timer: 1500
            });
            productName.value = "";
            productUnit.value = "";
            productPrice.value = "";

            document.getElementById('productModal').style.display = 'none';
            getproduct();
        } else {
            document.getElementById('productCreateErrorms').innerHTML = res.data.message;
        }

    }
</script>