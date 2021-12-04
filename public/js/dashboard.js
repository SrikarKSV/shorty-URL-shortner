const formContainer = document.querySelector(".form-container");
const table = document.querySelector("table");
const tbody = document.querySelector("table tbody");
const originalLink = document.querySelector(".copy");

if (tbody.innerHTML.trim() == "") {
  table.remove();
  formContainer.innerHTML = "<h3>No URLs shortened!</h3>";
}

tbody.addEventListener("click", copyOriginalLink);

function copyOriginalLink(event) {
  if (event.target.classList.contains("copy")) {
    const link = event.target;
    console.log(link.dataset.link);
    navigator.clipboard.writeText(link.dataset.link);

    link.classList.add("copied");
    link.innerText = "Copied!";

    setTimeout(() => {
      link.classList.remove("copied");
      link.innerText =
        link.dataset.link.length < 26
          ? link.dataset.link
          : link.dataset.link.substring(0, 26) + "...";
    }, 1000);
  }
}
