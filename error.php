<?php
$title = "Error | URL shortner";
$css_path = "./public/css/main.css";
include "./templates/header.php";

if (isset($_GET["error"])) {
  if ($_GET["error"] == "404") {
    echo "Requested shortened link is either expired or invalid.";
  } else if ($_GET["error"] == "500") {
    echo "There was an error on server try again later.";
  } else {
    header("location: index.php");
  }
} else {
  header("location: index.php");
}
