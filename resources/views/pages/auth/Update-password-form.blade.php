  @extends('App')
  @section('content')
  <div class="flex items-center justify-center h-[70vh]">
      <div class="bg-white p-6 rounded-2xl shadow-md w-full max-w-sm space-y-4">
          <h2 class="text-2xl font-semibold text-gray-800 text-center">Set Your Password</h2>

          <!-- Password -->
          <div>
              <label for="password" class="block text-gray-700 font-medium mb-1">Password</label>
              <input
                  type="password"
                  id="newUpdatePasswordFild"
                  name="password"
                  class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                  required />
          </div>

          <!-- Confirm Password -->
          <div>
              <label for="confirm_password" class="block text-gray-700 font-medium mb-1">Confirm Password</label>
              <input
                  type="password"
                  id="confirmUpdatePasswordFild"
                  name="confirm_password"
                  class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                  required />
          </div>

          <!-- Submit Button -->
          <button
              onclick="updatePassword()"
              type="submit"
              class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition duration-300">
              Submit
          </button>
      </div>
  </div>
  @endsection


  <script>
      const updatePassword = async () => {
          showLoader();
          const password = document.getElementById('newUpdatePasswordFild').value;
          const confPassword = document.getElementById('confirmUpdatePasswordFild').value;

          if (!password || password.trim() === "") {
              Swal.fire({
                  icon: "error",
                  title: "Password is required",
              });
          } else if (password.length < 6) {
              Swal.fire({
                  icon: "error",
                  title: "Password must be at least 6 characters",
              });
          } else if (password !== confPassword) {
              Swal.fire({
                  icon: "error",
                  title: "password and confirm password does not match",
              });
          } else {
              const response = await axios.post('/api/updatepassword', {
                  password: password
              });
              if (response.status === 200 && response.data['status'] === 'success') {
                  Swal.fire({
                      position: "center-center",
                      icon: "success",
                      title: response.data['message'],
                      showConfirmButton: false,
                      timer: 1500
                  });
                  setTimeout(() => {
                      window.location.href = '/loginRegister';
                  }, 1000);
              } else {
                  Swal.fire({
                      icon: "error",
                      title: response.data['message'],
                  });
                  setTimeout(() => {
                      window.location.href = '/loginRegister';
                  }, 1000);
              }
          }
          hideLoader();
      }
  </script>