<?php
  session_start();
  include "config.php";

  if (isset($_POST["login"])) {
    global $conn;

    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");

    if (mysqli_num_rows($result) === 1) {
      $row = mysqli_fetch_assoc($result);
      
      if (password_verify($password, $row["password"])) {
        $_SESSION["login"] = true;
        $_SESSION["name"]  = $username;
        
        header("Location: /crud1/index.php");
      } else {
        $login_err = "Password yang kamu masukkan salah.";
      }
    } else {
      $login_err = "Username yang kamu masukkan salah.";
    }
  }
?>



    <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>

  <link rel="stylesheet" href="./style.css">
</head>
<body>

  <main class="main-wrap">
    <div class="main-inner">
      <div class="form-box">
        <div class="form-title">
          <h2 class="title">Login</h2>
        </div>
  
        <form action="" method='POST'>
          <input type="text" name="username" id="username" placeholder='Username' required>
  
          <input type="password" name="password" id="password" placeholder='Masukkan Password'  required>
  
          <button type="submit" name='login'>Masuk</button>
  
          <div class="form-text">
            <span>Belum punya akun? <a href="register.php">Daftar</a>.</span>
          </div>
        </form>
      </div>
    </div>
  </main>
</body>
</html>
  
    
    
  </body>
</html>