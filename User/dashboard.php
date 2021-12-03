<?php
$title = "Dashboard | Shorty";
$css_path = "../public/css/style.css";
$dashboard_route = "./dashboard.php";
$logout_route = "./logout.php";
include "../templates/header.php";
require "../db_helper.php";

date_default_timezone_set("Asia/Calcutta");   //India time (GMT+5:30)
if (isset($_SESSION["userid"]) && isset($_GET["id"])) {
  $username = $_SESSION["username"];
  $userid = $_SESSION["userid"];

  if ($_GET["id"] != $username) {
    header("location: ../error.php?error=403");
    mysqli_close($conn);
    exit();
  }

  $user_info_sql = "SELECT * FROM user WHERE id='$userid';";
  $all_shortened_links_sql = "SELECT id ,url, expiryDate FROM url WHERE userid='$userid' ORDER BY createdAt DESC;";

  $user_result = mysqli_query($conn, $user_info_sql);
  $all_shortened_links_result = mysqli_query($conn, $all_shortened_links_sql);

  if (!$user_result || !$all_shortened_links_result) {
    header("location: ../error.php?error=500");
    mysqli_close($conn);
    exit();
  }

  $user = mysqli_fetch_assoc($user_result);
  $useremail = $user["email"];
} else {
  header("location: ../error.php?error=403");
}

?>

<main>
  <h2 class="greeting">Hello, <?php echo $username ?> !</h2>
  <p class="greeting">Your email: <?php echo $useremail ?></p>

  <div class="form-container large-size">
    <?php if (isset($_GET["error"]) && $_GET["error"] == "wrongid") {
      echo "<span class='url-doesnt-exist'>URL doesn't exist</span>";
    } ?>

    <?php if (isset($_GET["success"]) && $_GET["success"] == "deleted") { ?>
      <p class="flash success">Deleted the shrinked URL</p>
    <?php } ?>

    <div class="table-container">
      <h3>Shortened links:</h3>
      <table>
        <thead>
          <tr>
            <th>Shortened link</th>
            <th>Original link</th>
            <th>Expiry date</th>
            <th>Delete link</th>
          </tr>
        </thead>


        <tbody>
          <?php while ($row = mysqli_fetch_array($all_shortened_links_result)) {
            $now = new DateTime("now");
            $expiry_date = $row["expiryDate"];
            $expiry_date_object = new DateTime($row["expiryDate"]);
            $isExpired = NULL;
            if ($expiry_date == NULL) {
              $isExpired = FALSE;
            } else if ($now > $expiry_date_object) {
              $isExpired = TRUE;
            }
          ?>
            <tr class="<?php echo $isExpired ? "expired" : NULL ?>">
              <td><a target="_blank" href="https://shorty.ml?id=<?php echo $row["id"] ?>">shorty.ml?id=<span><?php echo $row["id"] ?></span></a></td>
              <td class="copy" data-link="<?php echo $row["url"] ?>"><?php echo strlen($row["url"]) < 45 ? $row["url"] : substr($row["url"], 0, 45) . "..."; ?></td>
              <td><?php echo $row["expiryDate"] ?? "Not set" ?></td>
              <td>
                <form action="./delete.php" method="POST"><input type="text" name="id" value="<?php echo "{$row["id"]}" ?>" hidden> <input type="submit" name="delete" class="delete" value="Delete"></form>
              </td>
            </tr>
          <?php }
          mysqli_close($conn);
          ?>
        </tbody>
      </table>
    </div>
    <p class="copy-directions">⭐ Click on original link to copy it</p>
  </div>
</main>

<?php
$js_route = "../public/js/dashboard.js";
include "../templates/footer.php";
?>
