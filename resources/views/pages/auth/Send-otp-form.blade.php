@extends('App')
@section('content')
<div class=" flex items-center justify-center h-[70vh]">
    <div class="bg-white w-full max-w-md p-6 rounded-lg shadow-lg relative">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4 text-center">Forgot Password</h2>


        <label for="email" class="block text-sm text-gray-600 mb-1">Email address</label>
        <input
            type="email"
            id="emailInput"
            name="email"
            required
            placeholder="Enter your email"
            class="w-full px-4 py-2 border rounded-lg mb-4 focus:outline-none focus:ring-2 focus:ring-blue-400" />

        <button
            type="submit"
            class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg"
            onclick="sendOtp()">
            Next
        </button>
    </div>
</div>
@endsection


<script>
    const sendOtp = async () => {
        showLoader();
        const email = document.getElementById('emailInput').value;
        const response = await axios.post('/api/sendotp', {
            email: email
        })

        if (response.status === 200 && response.data['status'] === 'success') {
            Swal.fire({
                position: "center-center",
                icon: "success",
                title: "4 Digit OTP has been send",
                showConfirmButton: false,
                timer: 1500
            });
            sessionStorage.setItem('email', response.data['email']);
            setTimeout(function (){
                window.location.href = 'verifyotpform';
            }, 1000)
        } else {
            Swal.fire({
                icon: "error",
                title: "Please enter a valid email address",
            });
        }

        hideLoader();
    }
</script>