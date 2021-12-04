<?php
$title = "{$_GET["error"]} error | Shorty";
$css_path = "./public/css/style.css";
include "./templates/header.php";
?>

<main>
  <div class="form-container">
    <h2><?php echo $_GET["error"]; ?> error</h2>
    <?php
    if (isset($_GET["error"])) {
      if ($_GET["error"] == "403") {
        header("HTTP/1.1 403 Forbidden");
        echo "<h5>You cannot access this page</h5>";
      } else if ($_GET["error"] == "404") {
        header("HTTP/1.1 404 Not Found");
        echo "<h5>Requested shortened link is either expired or invalid.</h5>";
      } else if ($_GET["error"] == "500") {
        header("HTTP/1.1 500 Internal Server Error");
        echo "<h5>There was an error on server try again later.</h5>";
      } else {
        header("location: index.php");
      }
    } else {
      header("location: index.php");
    }

    ?>
  </div>
</main>

<?php
include "./templates/footer.php";
?>
