<?php
$title = "Login | URL shortner";
$css_path = "../public/css/main.css";
$login_route = "./login.php";
$register_route = "./register.php";
include "../templates/header.php";

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
    if ($result = mysqli_query($conn, $sql)) {
    } else {
      die('Query error: ' . mysqli_error($conn));
    }


    $user = mysqli_fetch_assoc($result);

    $pwdHashed = $user["password"];
    $checkPwd = password_verify($pwd, $pwdHashed);

    if ($checkPwd) {
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
  <form action="login.php" method="POST">
    <label for="username">Username</label>
    <input type="text" name="username" id="username">
    <label for="password"></label>
    <input type="password" name="password" id="password">
    <input type="submit" name="submit" value="Sign up">
  </form>
</main>
</body>

</html>
