<script>
    const email = sessionStorage.getItem('email');
    if (!email) {
        window.location.href = '/loginRegister';
    }
</script>

@extends('App')
@section('content')
<!-- Step 2: OTP Modal -->
<div class="flex items-center justify-center h-[70vh]">
    <div class="bg-white w-full max-w-sm p-6 rounded-lg shadow-lg relative">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4 text-center">Enter OTP</h2>
        <p class="text-center mb-4 text-gray-600">Please enter the 4-digit code sent to your email</p>


        <div class="flex justify-center">
            <input id="verifyInputValue" type="text" maxlength="4" class="otp-input w-48 h-12 text-center border rounded text-xl tracking-widest" required placeholder="____" />
        </div>

        <button
            onclick="verifyOtp()"
            class="mt-6 w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg">
            Verify OTP
        </button>


    </div>
</div>

@endsection

<script>
    const resendOTP = async () => {
        const email = sessionStorage.getItem('email');
        const response = await axios.post('/api/sendotp', {
            email: email
        })
    }

    const verifyOtp = async () => {
        showLoader();
        const otp = document.getElementById('verifyInputValue').value;
        const email = sessionStorage.getItem('email');

        if (otp.length === 4) {
            const response = await axios.post('/api/verifyotp', {
                email: email,
                otp: otp,
            });

            if (response.status === 200 && response.data['status'] === 'success') {
                sessionStorage.removeItem('email');
                Swal.fire({
                    position: "center-center",
                    icon: "success",
                    title: response.data['message'],
                    showConfirmButton: false,
                    timer: 1500
                });

                setTimeout(() => {
                    window.location.href = '/updatepasswordgform';
                }, 1000);
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Invalid OTP",
                });
            }
        } else {
            Swal.fire({
                icon: "error",
                title: "4-digit otp required",
            });
        }

        hideLoader();
    }
</script>