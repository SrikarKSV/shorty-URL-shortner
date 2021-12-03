<?php
$title = "Register | Shorty";
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

  $email = mysqli_real_escape_string($conn, htmlspecialchars($_POST["email"]));
  $username = mysqli_real_escape_string($conn, htmlspecialchars($_POST["username"]));
  $pwd = mysqli_real_escape_string($conn, htmlspecialchars($_POST["password"]));
  $pwdRepeat = mysqli_real_escape_string($conn, htmlspecialchars($_POST["repeatPassword"]));


  function checkUserExist($conn, $username)
  {
    $sql = "SELECT * FROM user WHERE username='$username';";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
      header("location: ../error.php?error=500");
      mysqli_close($conn);
      exit();
    }

    $users = mysqli_fetch_assoc($result);

    if ($users) {
      header("location: ./register.php?error=usernametaken");
      mysqli_close($conn);
      exit();
    }
  }

  function createUser($conn, $email, $username, $pwd)
  {
    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
    $sql = "INSERT INTO user (email, username, password) VALUES('$email','$username','$hashedPwd');";
    if (mysqli_query($conn, $sql)) {
      header("location: ./login.php?success=registered");
      mysqli_close($conn);
    } else {
      header("location: ../error.php?error=500");
      mysqli_close($conn);
      exit();
    }
  }

  checkUserExist($conn, $username);
  createUser($conn, $email, $username, $pwd);
}
?>

<main>
  <div class="form-container medium-size">
    <h2>Register</h2>
    <form class="register-form" action="register.php" method="POST">
      <?php if (isset($_GET["error"]) && $_GET["error"] == "usernametaken") {
        echo "<span class='usernametaken show'>Username already taken, try another.</span>";
      } ?>
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

      <label for="repeatPassword">Repeat password</label>
      <input type="password" name="repeatPassword" id="repeatPassword">
      <span class="enter-rpassword">Confirm your password</span>
      <span class="invalid-rpassword">Both password don't match</span>

      <input class="btn" type="submit" name="submit" value="Sign up">
    </form>
  </div>
</main>

<?php
$js_route = "../public/js/registerValidation.js";
include "../templates/footer.php";
?>
