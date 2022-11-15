<?php
  session_start();
  include "config.php";
  
  
  if (isset($_POST["submit"])) {
    global $conn;

    $username    = strtolower(stripslashes($_POST["username"]));
    $password    = mysqli_real_escape_string($conn, $_POST["password"]);
    $password_en = password_hash($password, PASSWORD_DEFAULT);

    $username_check = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");

    if (mysqli_fetch_assoc($username_check)) $username_err = "Username sudah digunakan.";

    if (!isset($_POST["terms"])) $terms_err = "Klik centang pada syarat & ketentuan pendaftaran.";

    if (!empty($username) && !empty($password) && isset($_POST["terms"]) && !mysqli_fetch_assoc($username_check)) {
      $result = mysqli_query($conn, "INSERT INTO user VALUES('', '$username', '$password_en')");
    }

    if (isset($result)) header("Location: /crud1/login.php");
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>

  <link rel="stylesheet" href="style.css">
</head>
<body>
<main class="main-wrap">
    <div class="main-inner">
      <div class="form-box">
        <div class="form-title">
          <h2 class="title">Register</h2>
        </div>
    <form action="" method='POST'>
    <input type="text" name="username" id="username" placeholder='Username' required>
  
  <input type="password" name="password" id="password" placeholder='Password'  required>

  <div class="form-group">
    <input type="checkbox" name="terms" id='terms'>
    <label for="terms">Syarat & Ketentuan</label>
  </div>

  <button type="submit" name='submit'>Daftar</button>
          <div class="form-text">
            <span>Sudah punya akun? <a href="login.php">Login</a>.</span>
          </div>
        </form>
      </div>
    </div>
  </main>

          <?php global $username_err; if(!empty($username_err)) echo "<div class='text-error'>* ". $username_err ."</div>" ?>
          <?php global $terms_err; if(!empty($terms_err)) echo "<div class='text-error'>* ". $terms_err ."</div>" ?>
        </form>
</body>
</html>