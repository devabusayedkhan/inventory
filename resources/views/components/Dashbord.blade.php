@include("layout.MenuToggle")

<!-- Main layout -->
<div class="flex flex-col md:flex-row h-screen">
  <!-- Left Sidebar -->
  @include("layout.Sidebar")

  <!-- Right Content -->
  <div class="w-full bg-gray-50 p-6 overflow-auto">
    <h1 class="text-2xl font-bold mb-4">Main Content</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
      <!-- Product -->
      <div class="bg-white rounded-xl p-4 shadow flex items-center justify-between">
        <div>
          <div class="text-2xl font-bold text-gray-800" id="dashbordProduct"></div>
          <div class="text-gray-500">product</div>
        </div>
        <div class="text-4xl text-white bg-gradient-to-br from-pink-500 to-purple-500 p-3 rounded-lg shadow">
          <i class="fa-solid fa-gift"></i>
        </div>
      </div>
      <!-- Category-->
      <div class="bg-white rounded-xl p-4 shadow flex items-center justify-between">
        <div>
          <div class="text-2xl font-bold text-gray-800" id="dashbordCategory"></div>
          <div class="text-gray-500">Category</div>
        </div>
        <div class="text-4xl text-white bg-gradient-to-br from-pink-500 to-purple-500 p-3 rounded-lg shadow">
          <i class="fa-solid fa-layer-group"></i>
        </div>
      </div>
      {{-- Customer --}}
      <div class="bg-white rounded-xl p-4 shadow flex items-center justify-between">
        <div>
          <div class="text-2xl font-bold text-gray-800" id="dashbordCustomer"></div>
          <div class="text-gray-500">Customer</div>
        </div>
        <div class="text-4xl text-white bg-gradient-to-br from-pink-500 to-purple-500 p-3 rounded-lg shadow">
          <i class="fa-solid fa-users-viewfinder"></i>
        </div>
      </div>
      {{-- Invoice --}}
      <div class="bg-white rounded-xl p-4 shadow flex items-center justify-between">
        <div>
          <div class="text-2xl font-bold text-gray-800" id="dashbordInvoice"></div>
          <div class="text-gray-500">Invoice</div>
        </div>
        <div class="text-4xl text-white bg-gradient-to-br from-pink-500 to-purple-500 p-3 rounded-lg shadow">
          <i class="fa-solid fa-receipt"></i>
        </div>
      </div>

      {{-- Total Sale --}}
      <div class="bg-white rounded-xl p-4 shadow flex items-center justify-between">
        <div>
          <i class="fa-solid fa-bangladeshi-taka-sign text-2xl me-2"></i>
          <b class="text-2xl font-bold text-gray-800" id="dashbordTotalSale"></b>
          <div class="text-gray-500">Total Sale</div>
        </div>
        <div class="text-4xl text-white bg-gradient-to-br from-pink-500 to-purple-500 p-3 rounded-lg shadow">
          <i class="fa-solid fa-cart-shopping"></i>
        </div>
      </div>

      {{-- Vat Callection --}}
      <div class="bg-white rounded-xl p-4 shadow flex items-center justify-between">
        <div>
          <i class="fa-solid fa-bangladeshi-taka-sign text-2xl me-2"></i>
          <b class="text-2xl font-bold text-gray-800" id="dashbordVatCallection"></b>
          <div class="text-gray-500">Vat Callection</div>
        </div>
        <div class="text-4xl text-white bg-gradient-to-br from-pink-500 to-purple-500 p-3 rounded-lg shadow">
          <i class="fa-solid fa-hand-holding-dollar"></i>
        </div>
      </div>

      {{-- Total Callection --}}
      <div class="bg-white rounded-xl p-4 shadow flex items-center justify-between">
        <div>
          <i class="fa-solid fa-bangladeshi-taka-sign text-2xl me-2"></i>
          <b class="text-2xl font-bold text-gray-800" id="dashbordTotalCallection"></b>
          <div class="text-gray-500">Total Callection</div>
        </div>
        <div class="text-4xl text-white bg-gradient-to-br from-pink-500 to-purple-500 p-3 rounded-lg shadow">
          <i class="fa-solid fa-sack-dollar"></i>
        </div>
      </div>

    </div>
  </div>
</div>


<script>
  const DashbordSummery = async () => {
    showLoader();
    const res = await axios.get('/api/summery');
    hideLoader();

    document.getElementById('dashbordProduct').innerHTML = res.data.product;
    document.getElementById('dashbordCategory').innerHTML = res.data.category;
    document.getElementById('dashbordCustomer').innerHTML = res.data.customer;
    document.getElementById('dashbordInvoice').innerHTML = res.data.invoice;
    document.getElementById('dashbordTotalSale').innerHTML = res.data.total.toFixed(2);
    document.getElementById('dashbordVatCallection').innerHTML = res.data.vat.toFixed(2);
    document.getElementById('dashbordTotalCallection').innerHTML = res.data.payable.toFixed(2);
  }

  DashbordSummery();

</script>