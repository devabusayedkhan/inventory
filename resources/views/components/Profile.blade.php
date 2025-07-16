@include("layout.MenuToggle")

<div class="flex flex-col md:flex-row h-screen">
    @include("layout.Sidebar")
    <div class="w-full bg-gray-50 p-6 overflow-auto">
        <div class="flex items-center justify-center">
            <div class="bg-white shadow-md rounded-2xl p-8 w-full max-w-5xl">
                <h2 class="text-3xl font-semibold text-gray-800 mb-6 border-b pb-4">User Profile</h2>
                <div id="userProfileNotFound"></div>
                <form class="space-y-6" onsubmit="userDataUpdate(event)">
                    <!-- Profile Picture -->
                    <div class="">
                        <label class="block text-sm font-semibold text-gray-700 mb-1 relative w-[150px] profilePhoto">
                            <i class="fa-solid fa-pen-to-square absolute text-5xl text-white rounded-full"></i>
                            <img src="" id="profilePic" alt="" class="w-[150px] h-[150px] object-cover object-top rounded-full">

                            <input oninput="profilePic.src=window.URL.createObjectURL(this.files[0])" type="file" id="updateUserPhoto" accept="image/*" class="hidden" />
                        </label>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Email Address</label>
                            <input id="updateUserEmail" type="email" placeholder="User Email" class="w-full border rounded-lg px-4 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-purple-500" readonly />
                        </div>

                        <!-- First Name -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">First Name</label>
                            <input id="updateUserFirstName" type="text" placeholder="First Name" class="w-full border rounded-lg px-4 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-purple-500" />
                        </div>

                        <!-- Last Name -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Last Name</label>
                            <input id="updateUserLastName" type="text" placeholder="Last Name" class="w-full border rounded-lg px-4 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-purple-500" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Mobile -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Mobile Number</label>
                            <input id="updateUserMobile" type="tel" placeholder="Mobile" class="w-full border rounded-lg px-4 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-purple-500" />
                        </div>

                        <!-- password -->
                        <div class="field" style="position: relative;">
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                            <input type="password" id="updateUserPassword" placeholder="User Password" class="w-full border rounded-lg px-4 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-purple-500">
                            <span onclick="togglePassword()" style="position: absolute; right: 10px; bottom: -5%; transform: translateY(-50%); cursor: pointer;">
                                <i id="updateProfileeyeIcon" class="fa fa-eye"></i>
                            </span>
                        </div>
                    </div>

                    <!-- Button -->
                    <div>
                        <button type="submit" class="bg-fuchsia-600 hover:bg-fuchsia-700 text-white font-semibold rounded-lg px-6 py-2 mt-4 shadow-md transition-all w-full md:w-auto">
                            Update profile
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<script>
    const getUserData = async () => {
        showLoader();
        const response = await axios.get('/api/getuserdata');
        hideLoader();

        // 
        if (response.status === 200 && response.data['status'] === 'success') {
            const profilePic = document.getElementById('profilePic');
            profilePic.src = response.data.data.profilePhoto? response.data.data.profilePhoto : `storage/photos/user.png`;

            const userEmail = document.getElementById('updateUserEmail');
            userEmail.value = response.data.data.email

            const updateUserFirstName = document.getElementById('updateUserFirstName');
            updateUserFirstName.value = response.data.data.first_name

            const updateUserLastName = document.getElementById('updateUserLastName');
            updateUserLastName.value = response.data.data.last_name

            const updateUserMobile = document.getElementById('updateUserMobile');
            updateUserMobile.value = response.data.data.mobile

            const updateUserPassword = document.getElementById('updateUserPassword');
            updateUserPassword.value = response.data.data.password
        } else {
            document.getElementById('userProfileNotFound').innerHTML = "Profile data not found";
        }
    }
    getUserData();

    const userDataUpdate = async (e) => {
        e.preventDefault();
        const profilePhoto = document.getElementById('updateUserPhoto').files[0];
        const firstName = document.getElementById('updateUserFirstName').value;
        const lastName = document.getElementById('updateUserLastName').value;
        const mobile = document.getElementById('updateUserMobile').value;
        const password = document.getElementById('updateUserPassword').value;
        
        if (firstName.length === 0) {
            Swal.fire({
                icon: "error",
                title: "First Name is required",
            });
        } else if (lastName.length === 0) {
            Swal.fire({
                icon: "error",
                title: "Last Name is required",
            });
        } else if (mobile.length === 0) {
            Swal.fire({
                icon: "error",
                title: "Mobile number is required",
            });
        } else if (password.length < 8) {
            Swal.fire({
                icon: "error",
                title: "password must be at least 8 characters",
            });
        } else {
            showLoader();
            const response = await axios.post('/api/updateuserdata', {
                firstName,
                lastName,
                mobile,
                password,
                profilePhoto
            }, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            });
            hideLoader();

            if (response.data.status === "success") {
                Swal.fire({
                    position: "center-center",
                    icon: "success",
                    title: "Your profile has been updated",
                    showConfirmButton: false,
                    timer: 1500
                });
                getUserData();
                profileOrLoginLoader();
            }

        }
    }



    // password input field script
    function togglePassword() {
        const passwordInput = document.getElementById("updateUserPassword");
        const eyeIcon = document.getElementById("updateProfileeyeIcon");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            eyeIcon.classList.remove("fa-eye");
            eyeIcon.classList.add("fa-eye-slash");
        } else {
            passwordInput.type = "password";
            eyeIcon.classList.remove("fa-eye-slash");
            eyeIcon.classList.add("fa-eye");
        }
    }
</script>