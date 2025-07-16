@include("layout.MenuToggle")

<!-- Main layout -->
<div class="flex flex-col md:flex-row h-screen">
    <!-- Left Sidebar -->
    @include("layout.Sidebar")
    <!-- Right Content -->
    <div class="w-full bg-gray-50 p-6 overflow-auto">
        <div class="category-container bg-white rounded-2xl p-5 w-[70%] m-auto">
            <div class="category-header flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold">Category</h1>
                <button onclick="document.getElementById('modal').style.display='flex'" class="px-6 py-2 rounded-lg text-white font-bold bg-gradient-to-r from-pink-600 to-purple-600 hover:from-pink-700 hover:to-purple-700 transition">
                    CREATE
                </button>
            </div>

            <hr class="text-gray-300">

            <!-- table -->
            <table class="min-w-full divide-y divide-gray-200 mt-4" id="categoryTable">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">No</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Category</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200" id="categoryData">

                </tbody>
            </table>

        </div>
    </div>

</div>


<script>
    const getcategory = async () => {
        showLoader();
        const res = await axios.get('/api/getcategory');
        hideLoader();

        const tableList = $("#categoryData");
        const tableData = $("#categoryTable");

        tableData.DataTable().destroy();
        tableList.empty();

        res.data.forEach((item, index) => {

            let row = `
                        <tr>
                            <td class="px-4 py-2 text-sm text-gray-700 font-bold">${index+1}</td>
                            <td class="px-4 py-2 text-sm text-gray-700 font-bold">${item['name']}</td>
                            <td class="px-4 py-2 flex gap-2">
                            <button onclick="openCategoryUpdateModal(${item.id}, '${item.name}')" class="px-3 py-1 rounded border border-green-500 text-green-500 hover:bg-green-500 hover:text-white text-sm"><i class="fa-solid fa-pen-to-square"></i></button>
                            <button onclick="deleteCategory(${item.id})" class="px-3 py-1 rounded border border-red-500 text-red-500 hover:bg-red-500 hover:text-white text-sm"><i class="fa-solid fa-trash-can"></i></button>
                            </td>
                        </tr>`

            tableList.append(row);
        });


        tableData.DataTable({
            order: [
                [0, 'asc']
            ],
            lengthMenu: [5, 10, 15, 20]
        });
    }

    const deleteCategory = async (id) => {
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
            try {
                const res = await axios.post("/api/deletecategory", {
                    id: id
                });

                Swal.fire({
                    title: "Deleted!",
                    text: "Your Category has been deleted.",
                    icon: "success"
                });
                getcategory();
            } catch (error) {
                Swal.fire({
                    title: "Error!",
                    text: "Failed to delete the category.",
                    icon: "error"
                });
            }
        }
    };


    getcategory()
</script>