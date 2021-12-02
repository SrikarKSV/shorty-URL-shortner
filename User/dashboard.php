<?php
$title = "Dashboard | URL shortner";
$css_path = "../public/css/main.css";
$dashboard_route = "./dashboard.php";
$logout_route = "./logout.php";
include "../templates/header.php";
require "../db_helper.php";

if (isset($_SESSION["userid"]) && isset($_GET["id"])) {
  $username = $_SESSION["username"];
  $userid = $_SESSION["userid"];

  if ($_GET["id"] != $username) {
    header("location: ../error.php?error=403");
  }

  $user_info_sql = "SELECT * FROM user WHERE id='$userid';";
  $all_shortened_links_sql = "SELECT id ,url, expiryDate FROM url WHERE userid='$userid' ORDER BY createdAt DESC;";

  $user_result = mysqli_query($conn, $user_info_sql);
  $all_shortened_links_result = mysqli_query($conn, $all_shortened_links_sql);

  if (!$user_result || !$all_shortened_links_result) {
    header("location: ../error.php?error=500");
    exit();
  }

  $user = mysqli_fetch_assoc($user_result);
  $useremail = $user["email"];
} else {
  header("location: ../error.php?error=403");
}

?>

<main>
  <h2>Welcome <?php echo $username ?></h2>
  <span><?php echo $useremail ?></span>

  <table>
    <thead>
      <th>Shortened link id</th>
      <th>Original link</th>
      <th>Expiry date</th>
    </thead>


    <tbody>
      <?php while ($row = mysqli_fetch_array($all_shortened_links_result)) {
        $now = new DateTime("now");
        $expiry_date = $row["expiryDate"];
        if ($expiry_date == NULL) {
          $isExpired = FALSE;
        } else if ($now > $expiry_date) {
          $isExpired = TRUE;
        }
      ?>
        <tr class="<?php echo $isExpired ? "expired" : NULL ?>">
          <td><a href="http://localhost/shorty-url-shortner?id=<?php echo $row["id"] ?>"><?php echo $row["id"] ?></a></td>
          <td><a href="<?php echo $row["url"] ?>"></a><?php echo $row["url"] ?></td>
          <td><?php echo $row["expiryDate"] ?? "Not set" ?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</main>

<?php
include "../templates/footer.php";
?>
