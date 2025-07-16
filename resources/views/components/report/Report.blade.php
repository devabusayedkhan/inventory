@include("layout.MenuToggle")

<!-- Main layout -->
<div class="flex flex-col md:flex-row">
    <!-- Left Sidebar -->
    @include("layout.Sidebar")
    <!-- Right Content -->
    <div class="w-full bg-gray-50 h-[80vh] pt-10">
        <div class="p-10 shadow-2xl rounded-2xl bg-white w-[40%] mx-auto">
            <h1 class="text-3xl mb-4 text-emerald-600 font-bold">Sales Report</h1>
            <div class="fromDate mb-2">
                <label>
                    <h4 class="mb-2 text-emerald-700 font-bold">Date From</h4>
                    <input id="fromDate" type="date" class="w-[100%] p-2 border-2 border-gray-300 rounded">
                </label>
            </div>
            <div class="toDate mb-4">
                <label>
                    <h4 class="mb-2 text-emerald-700 font-bold">Date To</h4>
                    <input id="toDate" type="date" class="w-[100%] p-2 border-2 border-gray-300 rounded">
                </label>
            </div>
            <div class="text-right">
                <button onclick="salesReport()"
                    class="px-6 py-2 rounded-lg text-white font-bold bg-gradient-to-r from-pink-600 to-purple-600 hover:from-pink-700 hover:to-purple-700 transition">
                    DOWNLOAD
                </button>
            </div>
        </div>
    </div>

</div>

<script>
    const salesReport = async () => {
        const fromDate = document.getElementById('fromDate').value;
        const toDate = document.getElementById('toDate').value;

        if (fromDate.length === 0 || toDate.length === 0) {
            Swal.fire({
                icon: "error",
                title: "Date Range Required !",
            });
        } else {
            showLoader();
            const res = await axios.get(`/api/sales-report/${fromDate}/${toDate}`);
            hideLoader();

            if (res.data == 0) {
                Swal.fire({
                    icon: "error",
                    title: "Data not found"
                });
            } else {
                window.open(`/api/sales-report/${fromDate}/${toDate}`);
            }
        }
    }
</script>