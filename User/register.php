<?php
$title = "Register | URL shortner";
$css_path = "../public/css/main.css";
$login_route = "./login.php";
$register_route = "./register.php";
include "../templates/header.php";

if (isset($_SESSION["userid"])) {
  header("location: ../index.php");
  exit();
}

if (isset($_POST["submit"])) {
  $email = $_POST["email"];
  $username = $_POST["username"];
  $pwd = $_POST["password"];
  $pwdRepeat = $_POST["repeat-password"];

  require "../db_helper.php";

  function createUser($conn, $email, $username, $pwd)
  {
    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
    $sql = "INSERT INTO user (email, username, password) VALUES('$email','$username','$hashedPwd');";
    if (mysqli_query($conn, $sql)) {
      echo "Registered successfully!";
    } else {
      echo 'Query error: ' . mysqli_error($conn);
    }
    mysqli_close($conn);
  }

  createUser($conn, $email, $username, $pwd);
}
?>

<main>
  <form action="register.php" method="POST">
    <label for="email">Email</label>
    <input type="email" name="email" id="email">
    <label for="username">Username</label>
    <input type="text" name="username" id="username">
    <label for="password">Password</label>
    <input type="password" name="password" id="password">
    <label for="repeat-password">Repeat password</label>
    <input type="password" name="repeat-password" id="repeat-password">
    <input type="submit" name="submit" value="Sign up">
  </form>
</main>
</body>

</html>
