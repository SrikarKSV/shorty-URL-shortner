<?php
$title = "Login | URL shortner";
$css_path = "../public/css/main.css";
$login_route = "./login.php";
$register_route = "./register.php";
include "../templates/header.php";

// Sending back if user already logged in
if (isset($_SESSION["userid"])) {
  header("location: ../index.php");
  exit();
}

if (isset($_POST["submit"])) {
  $username = $_POST["username"];
  $pwd = $_POST["password"];

  require "../db_helper.php";

  function loginUser($conn, $username, $pwd)
  {
    $sql = "SELECT * FROM user WHERE username='$username';";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
      header("location: ../error.php?error=500");
      exit();
    }


    $user = mysqli_fetch_assoc($result);

    $pwdHashed = $user["password"];
    $checkPwd = password_verify($pwd, $pwdHashed);

    if ($checkPwd) {
      ini_set('session.cookie_lifetime', 60 * 60 * 24 * 7);
      session_start();


      $_SESSION["userid"] = $user["id"];
      $_SESSION["username"] = $user["username"];
      header("location: ../index.php");
      exit();
    }


    mysqli_close($conn);
  }

  loginUser($conn, $username, $pwd);
}
?>

<main>
  <form class="login-form" action="login.php" method="POST">
    <?php if (isset($_GET["success"]) && $_GET["success"] == "registered") {
      echo "<span class='registered show'>You have been registered, please login.</span>";
    } ?>
    <label for="username">Username</label>
    <input type="text" name="username" id="username">
    <span class="enter-username">Enter your Username</span>
    <span class="invalid-username">Enter valid Username(It can only have letters & numbers)</span>
    <label for="password"></label>
    <input type="password" name="password" id="password">
    <span class="enter-password">Enter your Password</span>
    <span class="invalid-password">Enter valid Password(It can only have letters, spaces & numbers)</span>
    <input type="submit" name="submit" value="Sign up">
  </form>
</main>
<script src="../public/js/loginValidation.js"></script>
</body>

</html>
