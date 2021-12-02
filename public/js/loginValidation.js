const enterUsername = document.querySelector(".enter-username");
const invalidUsername = document.querySelector(".invalid-username");
const enterPassword = document.querySelector(".enter-password");
const invalidPassword = document.querySelector(".invalid-password");
const loginSubmit = document.querySelector(".login-form");

loginSubmit.addEventListener("submit", validateForm);

function validateForm(event) {
  let isError = false;
  const username = event.target.username.value;
  const password = event.target.password.value;

  const userameRegex = /^[a-zA-Z0-9]{3,10}$/;
  const passwordRegex = /^[a-zA-Z0-9 ]{6,}$/;

  enterUsername.classList.remove("show");
  invalidUsername.classList.remove("show");
  enterPassword.classList.remove("show");
  invalidPassword.classList.remove("show");

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

  if (isError) {
    event.preventDefault();
  }
}
