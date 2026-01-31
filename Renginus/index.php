<?php include 'connect.php' ; 
session_start();

if(isset($_SESSION['id'])){
  header('location:Pagrindinis.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="style.css">
  <title>Renginus</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
</head>

<body class="overflow-hidden ">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>

  <nav class="navbar navbar-expand-sm navbar-dark bg-dark ">
    <a href="#" class="navbar-brand mb-0 mx-3 h1">RENGINUS</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse mb-0" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item active">
          <a class="nav-link active" href="#">Prisijungti</a>
        </li>
      </ul>
    </div>
  </nav>


  <div class="container-fluid">
    <div class="row" id="image-container">
      <div class="col-6">
        <img id="bg-images" src="images/bg1.jpg" alt="">
        <script>
          let bgimg = document.getElementById("bg-images");
          let images = ["images/bg1.jpg", "images/bg2.jpg", "images/bg3.jpg", "images/bg4.jpg"];
          let fadeout = true;
          let opacity = 1;
          let i = 0;

          setInterval(function () {
            if (fadeout) {
              opacity -= 0.05;
              if (opacity <= 0) {
                opacity = 0;
                fadeout = false;
                i++;
                if (i >= images.length) i = 0;
                bgimg.src = images[i];
              }
            } else {
              opacity += 0.05;
              if (opacity >= 1) {
                opacity = 1;
                setTimeout(() => {
                  fadeout = true;
                }, 2000);
              }
            }

            bgimg.style.opacity = opacity;
          }, 50);
        </script>
      </div>



      <div class="col"></div>
      <div class="col-lg-4">
        <form method="post" id="login-form" class="my-5 px-5">
          <h1>Prisijungimas</h1>



          <br />
          <div>
            <label for="email" id="emailLabel">El. pašto adresas</label>
          </div>
          <input class="form-control" type="email" name="email" id="email" />

          <br />
          <div>
            <label for="email">Slaptažodis</label>
          </div>
          <input class="form-control" type="password" name="password" id="password" />
          <br />
          <div class="d-flex justify-content-between pt-3">
            <div>
              <input class="form-check-input" type="checkbox" id="RememberMe" />
              <label class="form-check-label" for="RememberMe">Prisiminti mane</label>
            </div>
            <button name="Login" class="btn btn-dark ms-auto">Prisijungti</button>
          </div>
          <div style="color:red; font-weight: bold" id="ErrorMessage"></div>

        </form>

        <?php
if (isset($_POST["Login"])) {
    $email = $_POST["email"];
    $password = md5($_POST["password"]);

    $stmt = $conn->prepare("SELECT * FROM vartotojai WHERE el_pastas = ? AND slaptazodis = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows < 1) {
        echo "<script>
            let email = document.getElementById(\"email\");
            let password = document.getElementById(\"password\");
            let error = document.getElementById(\"ErrorMessage\");

            email.style.border = \"solid red 1px\";
            password.style.border = \"solid red 1px\";
            error.innerHTML = \"Neteisingas vartotojo vardas arba slaptažodis!\";
        </script>";
    } else {
        $row = $result->fetch_assoc();

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION["id"] = $row["id"];
        $_SESSION["slapyvardis"] = $row["slapyvardis"];
        $_SESSION["vardas"] = $row["vardas"];
        $_SESSION["pavarde"] = $row["pavarde"];
        $_SESSION["elpastas"] = $row["el_pastas"];
        $_SESSION["pfp"] = $row["profilio_nuotrauka"];

        header("Location: Pagrindinis.php?visi");
        exit();
    }

    $stmt->close();
}
?>


        

      </div>
    </div>

  </div>

  
</body>

</html>