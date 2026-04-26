document.addEventListener('DOMContentLoaded', function () {
  /* phone number validation */
  const phoneInput = document.querySelector('.auth-wrapper input[name="phone_number"]');
  if (phoneInput) {
    phoneInput.addEventListener('input', function () {
      this.value = this.value.replace(/[^0-9+\-]/g, '');
    });
  }

  // Login/Register toggle
  const loginBox = document.getElementById("login");
  const registerBox = document.getElementById("registration");
  const goRegister = document.getElementById("go_register");
  const goLogin = document.getElementById("go_login");
  const heroTitle = document.querySelector(".page-hero-title span");
  const breadcrumbLast = document.querySelector(".breadcrumb-wrap span:last-child");

  goRegister.addEventListener("click", function () {
    loginBox.classList.add("hidden");
    registerBox.classList.remove("hidden");

    heroTitle.textContent = "Register";
    breadcrumbLast.textContent = "Register";
  });
  goLogin.addEventListener("click", function () {
    registerBox.classList.add("hidden");
    loginBox.classList.remove("hidden");

    heroTitle.textContent = "Login";
    breadcrumbLast.textContent = "Login";
  });

});