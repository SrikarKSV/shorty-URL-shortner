const tableContainer = document.querySelector(".table-container");
const table = document.querySelector("table");
const tbody = document.querySelector("table tbody");

console.log(tbody.innerHTML.trim().length);
if (tbody.innerHTML.trim() == "") {
  table.remove();
  tableContainer.innerHTML = "<h3>No URLs shortened!</h3>";
}
