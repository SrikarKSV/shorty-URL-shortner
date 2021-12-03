<?php
$title = "Login | Shorty";
$css_path = "../public/css/style.css";
$login_route = "./login.php";
$register_route = "./register.php";
include "../templates/header.php";

// Sending back if user already logged in
if (isset($_SESSION["userid"])) {
  header("location: ../index.php");
  exit();
}

if (isset($_POST["submit"])) {
  require "../db_helper.php";

  $username = mysqli_real_escape_string($conn, htmlspecialchars($_POST["username"]));
  $pwd = mysqli_real_escape_string($conn, htmlspecialchars($_POST["password"]));


  function loginUser($conn, $username, $pwd)
  {
    $sql = "SELECT * FROM user WHERE username='$username';";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
      header("location: ../error.php?error=500");
      mysqli_close($conn);
      exit();
    }

    $user = mysqli_fetch_assoc($result);

    if (!$user) {
      header("location: ./login.php?error=nousername");
      mysqli_close($conn);
      exit();
    }

    $pwdHashed = $user["password"];
    $checkPwd = password_verify($pwd, $pwdHashed);

    if ($checkPwd) {
      session_start();

      $_SESSION["userid"] = $user["id"];
      $_SESSION["username"] = $user["username"];
      header("location: ../index.php");
      exit();
    } else {
      header("location: ./login.php?error=wronglogin");
      exit();
    }

    mysqli_close($conn);
  }

  loginUser($conn, $username, $pwd);
}
?>

<main>
  <div class="form-container medium-size">
    <h2>Login</h2>
    <form class="login-form" action="login.php" method="POST">
      <?php if (isset($_GET["success"]) && $_GET["success"] == "registered") {
        echo "<p class='flash success'>You have been registered, please login.</p>";
      } ?>
      <?php if (isset($_GET["error"]) && $_GET["error"] == "nousername") {
        echo "<span class='usernametaken show'>Username doesn't exist.</span>";
      } ?>
      <?php if (isset($_GET["error"]) && $_GET["error"] == "wronglogin") {
        echo "<span class='usernametaken show'>Password is not correct.</span>";
      } ?>
      <label for="username">Username</label>
      <input type="text" name="username" id="username">
      <span class="enter-username">Enter your Username</span>
      <span class="invalid-username">Enter valid Username</span>
      <label for="password">Password</label>
      <input type="password" name="password" id="password">
      <span class="enter-password">Enter your Password</span>
      <span class="invalid-password">Enter valid Password</span>
      <input class="btn" type="submit" name="submit" value="Log in">
    </form>
  </div>
</main>

<?php
$js_route = "../public/js/loginValidation.js";
include "../templates/footer.php";
?>
