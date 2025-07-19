<script>
  let login = false;

  const logout = async () => {
    const response = await axios.get('/api/logout');
    if (response.status == 200) {
      window.location.href = '/loginRegister';
      login = false;
    }
  }
  
</script>


<div class="loader hidden absolute top-0 left-0 w-[100%]" id="loader">
  <div class="MuiLinearProgress-root " role="progressbar">
    <div class="MuiLinearProgress-bar MuiLinearProgress-bar1Indeterminate"></div>
    <div class="MuiLinearProgress-bar MuiLinearProgress-bar2Indeterminate"></div>
  </div>
</div>


<!-- Navbar -->
<nav class="flex items-center justify-between bg-white px-6 py-3 shadow">

  <a href="/" class="flex items-center gap-3 h-[80px]" id="headerLogo">
    {{-- <span class="text-2xl font-bold text-indigo-900">dask<span class="text-orange-500">Z</span>one --}}
    </span>
  </a>

  <div id="rightHeader">

  </div>

</nav>



<script>
  // login check

  const rightHeader = document.getElementById('rightHeader');
  
  const profileOrLoginLoader = async () => {
    showLoader();
    const response = await axios.get('/api/getuserdata');
    hideLoader();
    login = !!response.data.data;
    
    if (login) {
      // logo
      if (response.data.data.profilePhoto) {
        document.getElementById('headerLogo').innerHTML = `<img src="${response.data.data.profilePhoto}" class="max-w-[200px] max-h-[80px]"/>`
      }
      
      rightHeader.innerHTML = `
      <div class="relative">
        <button id="userButton" class="rounded-full border-1 border-gray-300">
          ${response.data.data.profilePhoto? `<img src="${response.data.data.profilePhoto}" class="w-15 h-15 rounded-full object-cover object-top" alt="User" />` : `<img src="storage/photos/user.png" class="w-10 h-10">`}
        </button>
        <!-- Dropdown -->
        <div id="dropdownMenu" class="absolute right-0 mt-2 w-48 bg-white rounded shadow hidden z-50">
          <div class="flex items-center px-4 py-3 border-b">
            ${response.data.data.profilePhoto? `<img src="${response.data.data.profilePhoto}" class="w-10 h-10 rounded-full object-cover object-top" alt="User" />` : `<img src="storage/photos/user.png" class="w-10 h-10">`}
            <div class="ml-3 font-bold text-gray-700">${response.data.data.first_name}</div>
          </div>
          <a href="/dashboard" class=" font-bold block px-4 py-2 hover:bg-gray-100 text-gray-700">Dashbord</a>
          <a href="{{ url('/userprofile') }}" class=" font-bold block px-4 py-2 hover:bg-pink-100 border-l-4 border-transparent hover:border-pink-500 text-gray-700">Profile</a>
          <a class=" font-bold block px-4 py-2 hover:bg-gray-100 text-gray-700 cursor-pointer" onclick="logout()"
           >Logout</a>
        </div>
      </div>
      `;

      // Toggle user dropdown
      document.getElementById('userButton').addEventListener('click', () => {
        const dropdown = document.getElementById('dropdownMenu');
        dropdown.classList.toggle('hidden');
      });

      // Hide dropdown when clicking outside
      window.addEventListener('click', (e) => {
        const dropdown = document.getElementById('dropdownMenu');
        const button = document.getElementById('userButton');
        if (!button.contains(e.target) && !dropdown.contains(e.target)) {
          dropdown.classList.add('hidden');
        }
      });

    } else {
      rightHeader.innerHTML = `
      <a href="/loginRegister" class="font-bold m-0 px-4 py-2 rounded-xl text-white bg-red-500 hover:bg-red-600 transition">Login/Register
      </a>`;
    }
  }

  profileOrLoginLoader();
</script>