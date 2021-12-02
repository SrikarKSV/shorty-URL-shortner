const enterURL = document.querySelector(".enter-url");
const invalidURL = document.querySelector(".invalid-url");
const chooseExpiryDate = document.querySelector(".choose-date");
const setExpiryDate = document.querySelector(".set-date");
const urlSubmit = document.querySelector(".url-form");

urlSubmit.addEventListener("submit", validateForm);

function validateForm(event) {
  let isError = false;
  const url = event.target.url.value;
  const expiryDate = event.target.expiryDate.value;
  const customDate = event.target.customDate.value;

  const urlRegex =
    /https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&//=]*)/;

  enterURL.classList.remove("show");
  invalidURL.classList.remove("show");
  chooseExpiryDate.classList.remove("show");
  setExpiryDate.classList.remove("show");

  if (!url) {
    isError = true;
    enterURL.classList.add("show");
  } else if (!urlRegex.test(url)) {
    isError = true;
    invalidURL.classList.add("show");
  }

  if (!expiryDate) {
    isError = true;
    chooseExpiryDate.classList.add("show");
  }

  // If custom date is selected then it should be set
  if (expiryDate === "custom" && !customDate) {
    setExpiryDate.classList.add("show");
  }

  if (isError) {
    event.preventDefault();
  }
}
