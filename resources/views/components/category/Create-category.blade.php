<script>
    const createInputChange = ()=>{
        document.getElementById('categoryCreateErrorms').innerHTML = "";
    }
</script>
<!-- Modal Background -->
<div class="fixed inset-0 items-center justify-center bg-black/50 z-50 hidden" id="modal">
    <!-- Modal Box -->
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm p-6">
        <h2 class="text-xl font-semibold mb-4">Add Category</h2>

        <!-- Input Field -->
        <div>
            <label for="categoryName" class="block text-sm font-medium text-gray-700">Category Name</label>
            <input type="text" id="categoryName" name="categoryName"
                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Enter category name" onkeyup="createInputChange()">
        </div>

        <p class="text-red-500 font-bold" id="categoryCreateErrorms"></p>

        <!-- Buttons -->
        <div class="flex justify-end space-x-2 mt-4">
            <!-- Close Button -->
            <button onclick="document.getElementById('modal').style.display='none'"
                class="px-4 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300">
                Close
            </button>

            <!-- Save Button -->
            <button onclick="createCategory()" type="button" class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">
                Save
            </button>
        </div>
    </div>
</div>

<script>
    const createCategory = async () => {
        let categoryName = document.getElementById('categoryName');

        showLoader();
        const getCategoryData = await axios.get('/api/getcategory');
        hideLoader();

        let categoryNameChecker = "";
        getCategoryData.data.map((item) => {
            if (item.name.toLowerCase() == categoryName.value.toLowerCase()) {
                categoryNameChecker = true;
            }
        });

        if (categoryNameChecker !== true) {
            showLoader();
            const res = await axios.post('/api/addcategory', {
                name: categoryName.value
            });
            hideLoader();

            if (res.data.status === "success") {
                Swal.fire({
                    position: "center-center",
                    icon: "success",
                    title: "Category created success",
                    showConfirmButton: false,
                    timer: 1500
                });
                categoryName.value = "";
                document.getElementById('modal').style.display = 'none';
                getcategory();
            } else {
                document.getElementById('categoryCreateErrorms').innerHTML = res.data;
            }
        }else{
            document.getElementById('categoryCreateErrorms').innerHTML = "This category name already exists.";
        }
    }
</script>