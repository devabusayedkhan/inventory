<script>
  // register script
  const handleSubmit = async (e) => {
    e.preventDefault();
    const loginBtn = document.querySelector('#loginBtn');
    const formData = new FormData(e.target);
    const {
      firstName,
      lastName,
      email,
      mobile,
      password
    } = Object.fromEntries(formData);

    // form validation
    if (!firstName || firstName.trim() === "") {
      Swal.fire({
        icon: "error",
        title: "First name is required",
      });
    } else if (!lastName || lastName.trim() === "") {
      Swal.fire({
        icon: "error",
        title: "Last name is required",
      });
    } else if (!email || email.trim() === "") {
      Swal.fire({
        icon: "error",
        title: "Email is required",
      });
    } else if (!/^\S+@\S+\.\S+$/.test(email)) {
      Swal.fire({
        icon: "error",
        title: "Invalid email format",
      });
    } else if (!mobile || mobile.trim() === "") {
      Swal.fire({
        icon: "error",
        title: "Mobile number is required",
      });
    } else if (!/^\d{10,15}$/.test(mobile)) {
      Swal.fire({
        icon: "error",
        title: "Mobile must be 10-15 digits",
      });
    } else if (!password || password.trim() === "") {
      Swal.fire({
        icon: "error",
        title: "Password is required",
      });
    } else if (password.length < 6) {
      Swal.fire({
        icon: "error",
        title: "Password must be at least 6 characters",
      });
    } else {
      try {
        showLoader();
        const response = await axios.post('/api/register', {
          first_name: firstName,
          last_name: lastName,
          email: email,
          mobile: mobile,
          password: password,
        });
        hideLoader();
        Swal.fire({
          position: "center-center",
          icon: "success",
          title: "Registration completed successfully",
          showConfirmButton: false,
          timer: 1500
        }).then(() => {
          loginBtn.click();
          e.target.reset();
        });

      } catch (error) {
        Swal.fire({
          icon: "warning",
          title: "This email already registered",
        });
        hideLoader();
      }
    }
  }

  // login
  const handleLoginSubmit = async (e) => {
    e.preventDefault();
    showLoader();
    $formData = new FormData(e.target);
    const {
      email,
      password
    } = Object.fromEntries($formData);

    const response = await axios.post('/api/userLogin', {
      email: email,
      password: password
    });

    if (response.data.status == 'success' && response.status === 200) {
      login = true;
      Swal.fire({
        position: "center-center",
        icon: "success",
        title: "Login success",
        showConfirmButton: false,
        timer: 1500
      });
      e.target.reset();
      setTimeout(() => {
        window.location.href = "/dashboard";
      }, 1000);
    } else {
      Swal.fire({
        icon: "error",
        title: "Wrong email or password",
      });
    }
    hideLoader();
  }
</script>

<!-- Tailwind-based Login/Register Form -->
<div class="wrapper mx-auto my-6">
  <div class="title-text">
    <div class="title login">Login Form</div>
    <div class="title signup">Register Form</div>
  </div>
  <div class="form-container">
    <div class="slide-controls">
      <input type="radio" name="slide" id="login">
      <input type="radio" name="slide" id="signup">
      <label for="login" class="slide login" id="loginBtn">Login</label>
      <label for="signup" class="slide signup">Register</label>
      <div class="slider-tab"></div>
    </div>
    <div class="form-inner">
      <!-- Login Form -->
      <form class="login" onsubmit="handleLoginSubmit(event)">
        <div class="field">
          <input type="email" name="email" placeholder="Email Address" required>
        </div>

        <!-- password -->
        <div class="field" style="position: relative;">
          <input type="password" id="password" name="password" placeholder="Password" required>
          <span onclick="togglePassword()" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;">
            <i id="eyeIcon" class="fa fa-eye"></i>
          </span>
        </div>

        <div class="pass-link">
          <a href="/sendotpform">Forgot password?</a>
        </div>

        <div class="field btn">
          <div class="btn-layer"></div>
          <input type="submit" value="Login">
        </div>
        <div class="signup-link">
          Not a member? <a href="#">Register now</a>
        </div>
      </form>

      <!-- Signup Form -->
      <form class="signup" onsubmit="handleSubmit(event)">
        <div class="field">
          <input type="text" name="firstName" placeholder="First Name" required>
        </div>
        <div class="field">
          <input type="text" name="lastName" placeholder="Last Name" required>
        </div>
        <div class="field">
          <input type="email" name="email" placeholder="Email Address" required>
        </div>
        <div class="field">
          <input type="text" name="mobile" placeholder="Mobile Number" required>
        </div>
        <div class="field">
          <input type="password" name="password" placeholder="Password" required>
        </div>
        <div class="field btn">
          <div class="btn-layer"></div>
          <input type="submit" value="Register">
        </div>
      </form>
    </div>
  </div>
</div>

<!-- JavaScript  -->
<script>
  const loginText = document.querySelector(".title-text .login");
  const loginForm = document.querySelector("form.login");
  const loginBtn = document.querySelector("label.login");
  const signupBtn = document.querySelector("label.signup");
  const signupLink = document.querySelector("form .signup-link a");

  signupBtn.onclick = () => {
    loginForm.style.marginLeft = "-50%";
    loginText.style.marginLeft = "-50%";
  };
  loginBtn.onclick = () => {
    loginForm.style.marginLeft = "0%";
    loginText.style.marginLeft = "0%";
  };
  signupLink.onclick = () => {
    signupBtn.click();
    return false;
  };



  // password script
  function togglePassword() {
    const passwordInput = document.getElementById("password");
    const eyeIcon = document.getElementById("eyeIcon");

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