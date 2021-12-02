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
  $pwdRepeat = $_POST["repeatPassword"];

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
  <form class="register-form" action="register.php" method="POST">
    <label for="email">Email</label>
    <input type="email" name="email" id="email">
    <span class="enter-email">Enter your email</span>
    <span class="invalid-email">Enter valid email</span>
    <label for="username">Username</label>
    <input type="text" name="username" id="username">
    <span class="enter-username">Enter your Username</span>
    <span class="invalid-username">Enter valid Username(It can only have letters & numbers)</span>
    <label for="password">Password</label>
    <input type="password" name="password" id="password">
    <span class="enter-password">Enter your Password</span>
    <span class="invalid-password">Enter valid Password(It can only have letters, spaces & numbers)</span>
    <label for="repeat-password">Repeat password</label>
    <input type="password" name="repeatPassword" id="repeatPassword">
    <span class="enter-rpassword">Confirm your password</span>
    <span class="invalid-rpassword">Both password don't match</span>
    <input type="submit" name="submit" value="Sign up">
  </form>
</main>
<script src="../public/js/registerValidation.js"></script>
</body>

</html>
