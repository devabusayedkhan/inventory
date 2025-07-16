  <div class="w-full md:w-1/8 bg-white py-4 shadow transition-all duration-500 ease-in-out transform" id="dashbordLeftItem">
    <ul class="space-y-2 w-100 md:block hidden" id="sidebar">

      <a href="{{url('/customer')}}" class="text-indigo-900 font-bold p-2 block overflow-hidden hover:bg-emerald-400">
        <i class="fa-solid fa-users"></i>
        Customer
      </a>

      <a href="{{url('/category')}}" class="text-indigo-900 font-bold p-2 block overflow-hidden hover:bg-emerald-400">
        <i class="fa-solid fa-layer-group"></i>
        Category
      </a>

      <a href="{{url("/product")}}" class="text-indigo-900 font-bold p-2 block overflow-hidden hover:bg-emerald-400">
        <i class="fa-solid fa-gift"></i>
        Product
      </a>

      <a href="{{url("/sale")}}" class="text-indigo-900 font-bold p-2 block overflow-hidden hover:bg-emerald-400">
        <i class="fa-solid fa-cart-shopping"></i>
        Sale
      </a>

      <a href="{{url("/invoice")}}" class="text-indigo-900 font-bold p-2 block overflow-hidden hover:bg-emerald-400">
        <i class="fa-solid fa-file-invoice"></i>
        Invoice
      </a>

      <a href="{{url("/report")}}" class="text-indigo-900 font-bold p-2 block overflow-hidden hover:bg-emerald-400">
        <i class="fa-solid fa-receipt"></i>
        Report
      </a>

    </ul>
  </div>

  <!-- mobile JS for toggle -->
  <script>
    const toggleBtn = document.getElementById('menuToggle');
    const sidebar = document.getElementById('sidebar');
    const menuToggleBtn = document.querySelector('.menueTogglebtn');

    menuToggleBtn.innerHTML = `<i class="fa-solid fa-caret-down"></i>`;

    toggleBtn.addEventListener('click', () => {
      const btnHidden = sidebar.classList.toggle('hidden');

      if (btnHidden) {
        menuToggleBtn.innerHTML = `<i class="fa-solid fa-caret-down"></i>`;
      } else {
        menuToggleBtn.innerHTML = `<i class="fa-solid fa-caret-up"></i>`;
      }
    });
  </script>


  <!-- left menu arya design -->
  <script>
    const dashbordLeftContent = () => {
      const dashbordLeftItem = document.getElementById('dashbordLeftItem');

      if (dashbordLeftItem.classList.contains('md:w-0/8')) {
        dashbordLeftItem.classList.remove('md:w-0/8');
        dashbordLeftItem.classList.add('md:w-1/8');
      } else {
        dashbordLeftItem.classList.remove('md:w-1/8');
        dashbordLeftItem.classList.add('md:w-0/8');
      }
    };
  </script>