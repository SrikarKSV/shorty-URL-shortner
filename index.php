<?php
$title = "Shorty | URL shortner";
$css_path = "public/css/main.css";
include "templates/header.php";
require "db_helper.php";

$shortened_url = "";
date_default_timezone_set("Asia/Calcutta");   //India time (GMT+5:30)
if (isset($_GET["id"])) {
  $id = $_GET["id"];
  $select_sql = "SELECT * FROM url WHERE id='$id'";
  $result = mysqli_query($conn, $select_sql);

  if (!$result) {
    header("location: ./error.php?error=500");
    mysqli_close($conn);
    exit();
  }

  $shortened_url = mysqli_fetch_assoc($result);

  if (!$shortened_url) {
    header("location: ./error.php?error=404");
    mysqli_close($conn);
    exit();
  }

  $now = new DateTime("now");
  $expiry_date = new DateTime($shortened_url["expiryDate"]);

  if ($expiry_date == NULL || $now < $expiry_date) {
    header("Location: {$shortened_url['url']}");
  } else {
    header("location: ./error?error=404");
  }

  mysqli_close($conn);
}

if (isset($_POST["submit"])) {
  $url = mysqli_real_escape_string($conn, htmlspecialchars($_POST["url"]));
  $expiry_date = mysqli_real_escape_string($conn, htmlspecialchars($_POST["expiryDate"] == "custom" ? $_POST["customDate"] : NULL));
  $userId = isset($_SESSION["userid"]) ? $_SESSION["userid"] : NULL;
  $expiry_date_set = mysqli_real_escape_string($conn, htmlspecialchars($_POST["expiryDate"]));

  $bytes = random_bytes(5);
  $generated_id = bin2hex($bytes);

  if ($expiry_date == NULL && $userId == NULL) {
    $insert_sql = "INSERT INTO url(id, url, expiryDate, userId) VALUES('$generated_id', '$url', NULL, NULL);";
  } else if ($expiry_date && $userId == NULL) {
    $insert_sql = "INSERT INTO url(id, url, expiryDate, userId) VALUES('$generated_id', '$url', '$expiry_date', NULL);";
  } else if ($expiry_date == NULL && $userId) {
    $insert_sql = "INSERT INTO url(id, url, expiryDate, userId) VALUES('$generated_id', '$url', NULL, '$userId');";
  } else if ($expiry_date && $userId) {
    $insert_sql = "INSERT INTO url(id, url, expiryDate, userId) VALUES('$generated_id', '$url', '$expiry_date', '$userId');";
  }

  if (!mysqli_query($conn, $insert_sql)) {
    header("location: ./error.php?error=500");
    mysqli_close($conn);
    exit();
  }

  $select_sql = "SELECT * FROM url WHERE id='$generated_id'";

  $result = mysqli_query($conn, $select_sql);
  if (!$result) {
    header("location: ./error.php?error=500");
    mysqli_close($conn);
    exit();
  }

  $shortened_url = mysqli_fetch_assoc($result);
  mysqli_close($conn);
}
?>

<style>
  input[type="datetime-local"] {
    display: none;
  }

  input#custom:checked+input[type="datetime-local"] {
    display: block;
  }
</style>


<main>

  <form class="url-form" action="index.php" method="post">
    <label for="url">URL (Include protocol before the URL)</label>
    <input type="text" name="url" id="url">
    <span class="enter-url">Enter your URL</span>
    <span class="invalid-url">Enter valid URL</span>

    <p>Set expiry date for the shortened link</p>
    <label for="permanent">Permanent</label>
    <input type="radio" name="expiryDate" id="permanent" value="permanent">
    <label for="custom">Custom</label>
    <input type="radio" name="expiryDate" id="custom" value="custom">
    <input type="datetime-local" name="customDate">
    <span class="choose-date">Choose expiry date</span>
    <span class="set-date">Set custom expiry date</span>
    <input type="submit" name="submit" value="Shorten">
  </form>


  <?php
  if ($shortened_url) {
  ?>
    <p>URL is shortened: <a href="<?php echo "http://localhost/shorty-url-shortner?id={$shortened_url['id']}" ?>"><?php echo "http://localhost/shorty-url-shortner?id={$shortened_url['id']}" ?></a></p>
  <?php } ?>
</main>

<footer>
  <p>Made with ❤️ by Akash and Srikar</p>
</footer>

<script src="./public/js/urlValidation.js"></script>
</body>

</html>
