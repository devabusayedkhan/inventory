<script>
    const updateProductInputChange = () => {
        let dmsg = document.getElementById('updateProductDuplicateMsg')
        if (dmsg) {
            dmsg.innerHTML = "";
        }
    }
</script>
<!-- Modal Background -->
<div class="fixed inset-0 hidden items-center justify-center bg-black/50 z-50" id="updateProductModal">
    <!-- Modal Box -->
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm p-6">
        <h2 class="text-xl font-semibold mb-4">Update Product</h2>

        <input type="hidden" id="updateProductID">

        <!-- Input Field -->
        <!-- name -->
        <div class="mb-2">
            <label for="updateProductName" class="block text-sm font-medium text-gray-700">Product Name</label>
            <input type="text" id="updateProductName" name="updateProductName"
                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Enter new product name" onkeyup="updateProductInputChange()">
        </div>
        <!-- Unit -->
        <div class="mb-2">
            <label for="updateProductUnit" class="block text-sm font-medium text-gray-700">Product Unit</label>
            <input type="text" id="updateProductUnit" name="updateProductUnit"
                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Enter new Product Unit" onkeyup="updateProductInputChange()">
        </div>
        <!-- Price -->
        <div class="mb-2">
            <label for="updateProductPrice" class="block text-sm font-medium text-gray-700">Product Price</label>
            <input type="number" step="0.01" min="0" id="updateProductPrice" name="updateProductPrice"
                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Enter new Product Price" onkeyup="updateProductInputChange()">
        </div>

        <!-- category -->
        <div class="mt-4">
            <label for="updateProductCategory" class="block text-sm font-medium text-gray-700">Product Category</label>
            <select id="updateProductCategory" name="updateProductCategory"
                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </select>
        </div>

        <!-- Product Image Upload -->
        <div class="mt-2">
            <label class="block text-sm font-semibold text-gray-700 mb-1 relative w-[150px] profilePhoto">
                <i class="fa-solid fa-pen-to-square absolute text-5xl text-white"></i>
                <img src="" id="updateProductInputImg" alt="" class="w-[150px] h-[150px] object-cover object-top">

                <input oninput="updateProductInputImg.src=window.URL.createObjectURL(this.files[0])" type="file"
                    id="updateProductImg" accept="image/*" class="hidden" />
            </label>
        </div>

        <input type="hidden" id="oldProductImg">

        <!-- Buttons -->
        <div class="flex justify-end space-x-2 mt-4">
            <!-- Close Button -->
            <button onclick="document.getElementById('updateProductModal').style.display='none'"
                class="px-4 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300">
                Close
            </button>

            <!-- Update Button -->
            <button onclick="updateProduct()" class="px-4 py-2 rounded-lg bg-green-600 text-white hover:bg-green-700">
                Update
            </button>
        </div>
    </div>
</div>

<script>
    const updateProductInputName = document.getElementById('updateProductName');
    const updateProductInputUnit = document.getElementById('updateProductUnit');
    const updateProductInputPrice = document.getElementById('updateProductPrice');
    const updateProductInputCategory = document.getElementById('updateProductCategory');
    const updateProductInputid = document.getElementById('updateProductID');
    const oldProductImg = document.getElementById('oldProductImg');
    const updateProductInputImg = document.getElementById('updateProductInputImg');

    // modal css

    const openProductUpdateModal = async (id) => {
        
        showLoader();
        const res = await axios.post('/api/productfiend', { "id": id });
        hideLoader();

        const product = textValidation(res.data);

        const productName = product.name;
        const productUnit = product.unit;
        const productPrice = product.price;
        const productID = product.id;
        const oldImg = product.img;
        const productCategory = product.category_id;
        

        document.getElementById('updateProductModal').style.display = 'flex';
        updateProductInputName.value = productName;
        updateProductInputUnit.value = productUnit;
        updateProductInputPrice.value = productPrice;
        updateProductInputid.value = productID;
        oldProductImg.value = oldImg;

        updateProductInputImg.src = oldImg || `productimg/photo_icon.png`;

        // category 
        showLoader();
        const getCategoryData = await axios.get('/api/getcategory');
        hideLoader();
                
        let optionData = `<option value="">Select a category</option>`;
        getCategoryData.data.map((item) => {
            optionData += `<option ${item.id == productCategory ?
                'selected' : ''} value="${item.id}">${item.name}</option>`;
        });
        updateProductInputCategory.innerHTML = optionData;

    }

    const updateProduct = async () => {
        const updateProductImg = document.getElementById('updateProductImg').files[0];

        showLoader();
        const formData = {
            id: updateProductInputid.value,
            category_id: updateProductInputCategory.value,
            name: updateProductInputName.value,
            unit: updateProductInputUnit.value,
            price: updateProductInputPrice.value,
            img: updateProductImg,
            old_img: oldProductImg.value
        }
        const config = {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        }

        const res = await axios.post('/api/updateproduct', formData, config);
        hideLoader();


        if (res.data.status === "success") {
            Swal.fire({
                position: "center-center",
                icon: "success",
                title: "Product Update success",
                showConfirmButton: false,
                timer: 1500
            });
            document.getElementById('updateProductModal').style.display = 'none';
            document.getElementById('updateProductImg').value = "";
            getproduct();
        } else {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Product not update",
            });
        }

    }
</script>