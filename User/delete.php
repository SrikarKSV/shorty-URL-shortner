<?php
session_start();

if (isset($_POST["delete"])) {
  if (!isset($_SESSION["userid"])) {
    header("location: ../error.php?error=403");
    exit();
  }

  require "../db_helper.php";

  $sql = "SELECT * FROM url WHERE id='{$_POST["id"]}';";

  $result = mysqli_query($conn, $sql);

  if (!$result) {
    header("location: ../error.php?error=500");
    mysqli_close($conn);
    exit();
  }

  $url = mysqli_fetch_assoc($result);

  if (!$url) {
    header("location: ./dashboard.php?id={$_SESSION["username"]}&error=wrongid");
    mysqli_close($conn);
    exit();
  }

  if ($url["userId"] != $_SESSION["userid"]) {
    header("location: ./error.php?error=403");
    mysqli_close($conn);
    exit();
  }

  $delete_sql = "DELETE FROM url WHERE id='{$_POST["id"]}';";

  if (!mysqli_query($conn, $delete_sql)) {
    header("location: ../error.php?error=500");
  } else {
    header("location: ./dashboard.php?id={$_SESSION["username"]}&success=deleted");
  }

  mysqli_close($conn);
} else {
  header("location: ../error.php?error=403");
}
