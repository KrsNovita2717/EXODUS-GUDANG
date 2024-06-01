<?php
require 'function.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>Laman Register</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link href="./assets/css/styles.css" rel="stylesheet" />
  <link rel="shortcut icon" href="./assets/images/favicon.jpg" type="image/x-icon">
  <style>
    .bold {
      font-weight: bold;
    }

    .bg-btn,
    .bg-btn:hover {
      background-color: #392222;
    }
  </style>
</head>

<body>
  <div class="row">
    <div class="col-md-6 justify-content-center">
      <img src="./assets/images/bg-login.png" alt="" style="max-width:100%; height:100vh;">
    </div>
    <div class="col-md-6 d-flex align-items-center">
      <!-- FORM REGISTRASI -->
      <form method="post">
        <div class="row ms-3 me-5 pe-5">
          <div class="fs-1 text-center mb-3 bold ">
            Register
          </div>
          <div class="mb-3">
            <label class="fs-3 mb-2 bold" for="inputEmailAddress">Username</label>
            <input class="form-control" name="username" id="inputEmailAddress" type="text" placeholder="Enter Your Username" required>
          </div>
          <div class="mb-3">
            <label class="fs-3 mb-2 bold" for="inputPassword">Password</label>
            <input class="form-control" name="pass" id="inputPassword" type="password" placeholder="Enter Your Password" required>
          </div>
          <div class="mb-3">
            <label class="fs-3 mb-2 bold" for="inputPhoneNumber">Nomor Telepon</label>
            <input class="form-control" name="phone_number" id="inputPhoneNumber" type="tel" placeholder="Enter Your Phone Number" required>
          </div>
          <div class="mt-3 text-center">
            <button class="btn fs-3 bold text-white bg-btn" name="register" style="width:100%;">REGISTER</button>
          </div>
          <div class="text-center mt-3">
            <a href="login.php" class="text-decoration-none">Sudah punya akun? Masuk di sini</a>
          </div>
        </div>
      </form>
      <!-- END FORM REGISTRASI -->
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>

<!-- EOF -->