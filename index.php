<?php
include "templates/header.php";
require "credentials.php";

$shortened_url = "";

if (isset($_GET["id"])) {
  $conn = mysqli_connect($HOSTNAME, $USERNAME, $PASSWORD, $DATABASENAME);
  $id = $_GET["id"];
  $select_sql = "SELECT * FROM url WHERE id='$id'";
  $result = mysqli_query($conn, $select_sql);
  $shortened_url = mysqli_fetch_assoc($result);
  header("Location: {$shortened_url['url']}");

  mysqli_close($conn);
}

if (isset($_POST["submit"])) {
  $conn = mysqli_connect($HOSTNAME, $USERNAME, $PASSWORD, $DATABASENAME);
  $url = $_POST["url"];


  $bytes = random_bytes(5);
  $generated_id = bin2hex($bytes);
  $insert_sql = "INSERT INTO url VALUES('$generated_id', '$url', NULL)";

  if (mysqli_query($conn, $insert_sql)) {
  } else {
    echo 'Query error: ' . mysqli_error($conn);
  }

  $select_sql = "SELECT * FROM url WHERE id='$generated_id'";

  $result = mysqli_query($conn, $select_sql);
  $shortened_url = mysqli_fetch_assoc($result);

  mysqli_close($conn);
}
?>

<title>Shorty | URL shortner</title>

<body>
  <main>
    <h1>Shorten URL</h1>

    <form action="index.php" method="post">
      <label for="url">URL</label>
      <input type="text" name="url" id="url">
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
</body>

</html>
