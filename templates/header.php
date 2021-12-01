<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="https://img.icons8.com/color/50/000000/shorten-urls.png" type="image/x-icon">
  <title><?php echo $title ?></title>
  <link rel="stylesheet" href="<?php echo $css_path ?>">
</head>

<body>
  <header>
    <h1>Shorten URL</h1>
    <nav>
      <ul>
        <?php
        if (isset($_SESSION["userid"])) {
          echo "<li><a href='profile.php'>Profile</a></li>";
          echo "<li><a href='logout.php'>Logout</a></li>";
        } else {
          $login_route_final =  $login_route ?? 'User/login.php';
          echo "<li><a href='$login_route_final'>Login</a></li>";
          $register_route_final = $register_route ?? 'User/register.php';
          echo "<li><a href='$register_route_final'>Register</a></li>";
        }
        ?>
      </ul>
    </nav>
  </header>