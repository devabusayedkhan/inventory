@include("layout.MenuToggle")

<!-- Main layout -->
<div class="flex flex-col md:flex-row">
    <!-- Left Sidebar -->
    @include("layout.Sidebar")
    <!-- Right Content -->
    <div class="w-full bg-gray-50 p-6 ">
        <div class="product-container bg-white rounded-2xl p-5 w-[80%] m-auto ">
            <div class="product-header flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold">Product</h1>
                <button onclick="document.getElementById('productModal').style.display='flex'"
                    class="px-6 py-2 rounded-lg text-white font-bold bg-gradient-to-r from-pink-600 to-purple-600 hover:from-pink-700 hover:to-purple-700 transition">
                    CREATE
                </button>
            </div>

            <hr class="text-gray-300">

            <!-- table -->
            <table class="min-w-full divide-y divide-gray-200 mt-4" id="productTable">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">No</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Product img</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Product Name</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">unit</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Price</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200" id="productData">
                </tbody>
            </table>

        </div>
    </div>

</div>


<script>
    const getproduct = async () => {

        showLoader();
        const res = await axios.get('/api/getproduct');
        hideLoader();

        const tableList = $("#productData");
        const tableData = $("#productTable");

        tableData.DataTable().destroy();
        tableList.empty();

        res.data.reverse().forEach((item, index) => {
            
            let row = `
                        <tr>
                            <td class="px-4 py-2 text-sm text-gray-700 font-bold">${index + 1}</td>
                            <td class="px-4 py-2 text-sm text-gray-700 font-bold">
                            <img class="w-[50px] h-[50px] object-cover rounded" src="${item.img}"  onerror="this.src='productimg/photo_icon.png'"  alt="">
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-700 font-bold">${item['name']}</td>
                            <td class="px-4 py-2 text-sm text-gray-700 font-bold">${item['unit']}</td>
                            <td class="px-4 py-2 text-sm text-yellow-600 font-bold"><b class="me-1">৳</b>${item['price']}</td>
                            <td class="px-4 py-2 flex gap-2">
                                
                            <button onclick="openProductUpdateModal(${item.id})" 
                            class="product-update-btn px-3 py-1 rounded border border-green-500 text-green-500 hover:bg-green-500 hover:text-white text-sm"><i class="fa-solid fa-pen-to-square"></i></button>

                            <button onclick="deleteProduct(${item.id},'${item.img}')" class="px-3 py-1 rounded border border-red-500 text-red-500 hover:bg-red-500 hover:text-white text-sm"><i class="fa-solid fa-trash-can"></i></button>
                            </td>
                        </tr>`

            tableList.append(row);
        });


        tableData.DataTable();
    }

    const deleteProduct = async (id, oldImg) => {
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
                const res = await axios.post("/api/deleteproduct", {
                    id: id,
                    old_img: oldImg
                });


                Swal.fire({
                    title: "Deleted!",
                    text: "Your Product has been deleted.",
                    icon: "success"
                });
                getproduct();
            } catch (error) {
                Swal.fire({
                    title: "Error!",
                    text: "Failed to delete the product.",
                    icon: "error"
                });
            }
        }
    };


    getproduct()
</script>