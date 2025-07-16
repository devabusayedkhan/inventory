<script>
    const updateInputChange = ()=>{
        document.getElementById('updateDuplicateMsg').innerHTML = "";
    }
</script>
<!-- Modal Background -->
<div class="fixed inset-0 hidden items-center justify-center bg-black/50 z-50" id="updateModal">
    <!-- Modal Box -->
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm p-6">
        <h2 class="text-xl font-semibold mb-4">Update Category</h2>

        <input type="hidden" id="updateCategoryID">

        <!-- Input Field -->
        <div class="mb-2">
            <label for="updateCategoryName" class="block text-sm font-medium text-gray-700">Category Name</label>
            <input type="text" id="updateCategoryName" name="updateCategoryName"
                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Enter new category name" onkeyup="updateInputChange()">
        </div>

        <!-- Duplicate Message -->
        <p class="text-red-500 font-bold" id="updateDuplicateMsg"></p>

        <!-- Buttons -->
        <div class="flex justify-end space-x-2 mt-4">
            <!-- Close Button -->
            <button onclick="document.getElementById('updateModal').style.display='none'"
                class="px-4 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300">
                Close
            </button>

            <!-- Update Button -->
            <button onclick="updateCategory()"
                class="px-4 py-2 rounded-lg bg-green-600 text-white hover:bg-green-700">
                Update
            </button>
        </div>
    </div>
</div>

<script>
    const updateCategoryInputName = document.getElementById('updateCategoryName');
    const updateCategoryInputid = document.getElementById('updateCategoryID');

    // modal css
    const openCategoryUpdateModal = (id, categoryNme) => {
        document.getElementById('updateModal').style.display = 'flex';
        updateCategoryInputName.value = categoryNme;
        updateCategoryInputid.value = id;
    }

    const updateCategory = async () => {
        showLoader();
        const getCategoryData = await axios.get('/api/getcategory');
        hideLoader();
        
        let categoryNameChecker = "";
        getCategoryData.data.map((item) => {
            if (item.name.toLowerCase() == updateCategoryInputName.value.toLowerCase() && item.id != updateCategoryInputid.value) {
                categoryNameChecker = true;
            }
        });
        
        if (categoryNameChecker !== true) {
            showLoader();
            const res = await axios.post('/api/updatecategory', {
                id: updateCategoryInputid.value,
                name: updateCategoryInputName.value
            });
            hideLoader();


            if (res.data.status === "success") {
                Swal.fire({
                    position: "center-center",
                    icon: "success",
                    title: "Category Update success",
                    showConfirmButton: false,
                    timer: 1500
                });
                document.getElementById('updateModal').style.display = 'none';
                getcategory();
            } else {
                document.getElementById('updateDuplicateMsg').innerHTML = res.data;
            }
        } else {
            document.getElementById('updateDuplicateMsg').innerHTML = "This category name already exists.";
        }
    }
</script>