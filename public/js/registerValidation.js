const enterEmail = document.querySelector(".enter-email");
const invalidEmail = document.querySelector(".invalid-email");
const enterUsername = document.querySelector(".enter-username");
const invalidUsername = document.querySelector(".invalid-username");
const enterPassword = document.querySelector(".enter-password");
const invalidPassword = document.querySelector(".invalid-password");
const enterConfirmPassword = document.querySelector(".enter-rpassword");
const invalidConfirmPassword = document.querySelector(".invalid-rpassword");
const registerSubmit = document.querySelector(".register-form");

registerSubmit.addEventListener("submit", validateForm);

function validateForm(event) {
  let isError = false;
  const email = event.target.email.value;
  const username = event.target.username.value;
  const password = event.target.password.value;
  const confirmPassword = event.target.repeatPassword.value;

  const emailRegex = /^[a-zA-Z_.-]+@[a-zA-z]+\.[a-zA-z]{2,4}$/;
  const userameRegex = /^[a-zA-Z0-9]{3,10}$/;
  const passwordRegex = /^[a-zA-Z0-9 ]{6,}$/;

  enterEmail.classList.remove("show");
  invalidEmail.classList.remove("show");
  enterUsername.classList.remove("show");
  invalidUsername.classList.remove("show");
  enterPassword.classList.remove("show");
  invalidPassword.classList.remove("show");
  enterConfirmPassword.classList.remove("show");
  invalidConfirmPassword.classList.remove("show");

  // Validate email
  if (!email) {
    isError = true;
    enterEmail.classList.add("show");
  } else if (!emailRegex.test(email)) {
    isError = true;
    invalidEmail.classList.add("show");
  }

  // Validate username
  if (!username) {
    isError = true;
    enterUsername.classList.add("show");
  } else if (!userameRegex.test(username)) {
    isError = true;
    invalidUsername.classList.add("show");
  }

  // Validate password
  if (!password) {
    isError = true;
    enterPassword.classList.add("show");
  } else if (!passwordRegex.test(password)) {
    isError = true;
    invalidPassword.classList.add("show");
  }

  // Validate confirm password
  if (!confirmPassword) {
    isError = true;
    enterConfirmPassword.classList.add("show");
  } else if (password != confirmPassword) {
    isError = true;
    invalidConfirmPassword.classList.add("show");
  }

  if (isError) {
    event.preventDefault();
  }
}
