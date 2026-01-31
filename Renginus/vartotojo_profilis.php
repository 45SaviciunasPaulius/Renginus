<?php
include 'connect.php';
session_start();

if (!isset($_SESSION['id'])) {
    header('location:index.php');
    exit();
}

$ID = $_SESSION["id"];
$stmt = $conn->prepare("SELECT role FROM vartotojai WHERE id = ?");
$stmt->bind_param("i", $ID);
$stmt->execute();
$result = $stmt->get_result();
$user_data = $result->fetch_assoc();

if ($user_data) {
    $_SESSION["role"] = $user_data["role"];
}

$all_users = [];

if ($_SESSION["role"] === 'admin') {
    $stmt = $conn->prepare("SELECT id, vardas, pavarde, el_pastas, role FROM vartotojai WHERE id != ?");
    $stmt->bind_param("i", $ID);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $all_users[] = $row;
    }
}

$pending_events = [];

if ($_SESSION['role'] === 'admin') {
    $stmt = $conn->prepare("SELECT * FROM renginys WHERE status = 'pending'");
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $pending_events[] = $row;
    }
}
$sql = "SELECT renginys.*, vartotojai.vardas, vartotojai.pavarde
        FROM renginys
        JOIN vartotojai ON renginys.user_id = vartotojai.id
        WHERE renginys.status = 'pending'";

if (isset($_POST["name"]) || isset($_POST["surname"]) || isset($_FILES["profile_picture"]) || isset($_POST["email"])) {
    $ID = $_SESSION["id"];

    $vardas = isset($_POST["name"]) ? $_POST["name"] : '';
    $pavarde = isset($_POST["surname"]) ? $_POST["surname"] : '';
    $email = isset($_POST["email"]) ? urldecode($_POST["email"]) : '';
    
    $pfp_filename = null;

    if (isset($_FILES["profile_picture"]) && $_FILES["profile_picture"]["error"] == 0) {
        $file_tmp = $_FILES["profile_picture"]["tmp_name"];
        $file_ext = pathinfo($_FILES["profile_picture"]["name"], PATHINFO_EXTENSION);
        $allowed_exts = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array(strtolower($file_ext), $allowed_exts)) {
            $unique_name = "pfp_" . $ID . "_" . uniqid() . "." . $file_ext;
            $upload_dir = "images/";
            $destination = $upload_dir . $unique_name;

            if (move_uploaded_file($file_tmp, $destination)) {
                $pfp_filename = $destination;
            }
        }
    }


    if ($pfp_filename) {
        $stmt = $conn->prepare("UPDATE vartotojai SET vardas = ?, pavarde = ?, el_pastas = ?, profilio_nuotrauka = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $vardas, $pavarde, $email, $pfp_filename, $ID);
        $_SESSION['pfp'] = $pfp_filename;
    } else {
        $stmt = $conn->prepare("UPDATE vartotojai SET vardas = ?, pavarde = ?, el_pastas = ? WHERE id = ?");
        $stmt->bind_param("sssi", $vardas, $pavarde, $email, $ID);
    }
    
    $stmt->execute();


    $_SESSION["vardas"] = $vardas;
    $_SESSION["pavarde"] = $pavarde;
    $_SESSION["elpastas"] = $email;
    if ($pfp_filename) {
        $_SESSION["profile_picture"] = $pfp_filename;
    }
}

if (isset($_POST["password"]) && isset($_POST["confirm_password"]) && !empty($_POST["password"]) && !empty($_POST["confirm_password"])) {
    $ID = $_SESSION["id"];

    $password = md5($_POST["password"]);
    $conf_password = md5($_POST["confirm_password"]);

    if ($password == $conf_password) {
        $stmt = $conn->prepare("UPDATE vartotojai SET slaptazodis = ? WHERE id = ?");
        $stmt->bind_param("si", $password, $ID);
        $stmt->execute();
    } else {
        echo '<script>
            window.onload = function() {
                document.getElementById("alert").style.display = "block";
            };
        </script>';
    }
}
?>

<?php
if(isset($_POST["registerName"]) && isset($_POST["registerSurname"]) && isset($_POST["registerRole"]) && isset($_POST["registerEmail"]) && isset($_POST["registerPassword"]) && isset($_POST["registerRepeatPassword"])){
    $registerName = $_POST["registerName"];
    $registerSurname = $_POST["registerSurname"];
    $registerRole = $_POST["registerRole"];
    $registerEmail = $_POST["registerEmail"];
    $registerPassword = $_POST["registerPassword"];
    $registerRepeatPassword = $_POST["registerRepeatPassword"];
   
    if ($registerPassword !== $registerRepeatPassword) {
        return;
    }

    
    $hashedPassword = md5($registerPassword);

    $stmt = $conn->prepare("INSERT INTO vartotojai (slaptazodis, el_pastas, vardas, pavarde, sukurtas, profilio_nuotrauka, role) VALUES (?, ?, ?, ?, NOW(), ?, ?)");
    
    $defaultProfilePic = 'images/default-pfp.jpg';

    $stmt->bind_param("ssssss", $hashedPassword, $registerEmail, $registerName, $registerSurname, $defaultProfilePic, $registerRole);

    $stmt->execute();

    $stmt->close();

   header("Location: vartotojo_profilis.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <script src="script.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="style.css">
    <title>Renginus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />


</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <nav class="navbar navbar-expand-sm navbar-dark bg-dark ">
        <a href="Pagrindinis.php" class="navbar-brand mb-0 mx-3 h1">RENGINUS</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse mb-0" id="navbarNav">
            <ul class="navbar-nav ms-auto">

                <li class="nav-item active pt-1">

                    <a class="btn-secondary" href="renginio_forma.php" role="button" id="dropdownMenuLink"><svg
                            xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-window-plus" viewBox="0 0 16 16">
                            <path
                                d="M2.5 5a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1M4 5a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1m2-.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0" />
                            <path
                                d="M0 4a2 2 0 0 1 2-2h11a2 2 0 0 1 2 2v4a.5.5 0 0 1-1 0V7H1v5a1 1 0 0 0 1 1h5.5a.5.5 0 0 1 0 1H2a2 2 0 0 1-2-2zm1 2h13V4a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1z" />
                            <path
                                d="M16 12.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0m-3.5-2a.5.5 0 0 0-.5.5v1h-1a.5.5 0 0 0 0 1h1v1a.5.5 0 0 0 1 0v-1h1a.5.5 0 0 0 0-1h-1v-1a.5.5 0 0 0-.5-.5" />
                        </svg> Įdėti renginį</a>
                </li>

                <li class="nav-item active">
                    <div class="dropdown">
                        <a class="btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <img id="smallpfp" src="<?php  echo $_SESSION['pfp'] ?>" class="rounded-circle" style="width: 35px; height: 35px;" alt="Profilis">

                            <?php echo $_SESSION['vardas'] ?>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink">
                            <li><a class="dropdown-item" href="vartotojo_profilis.php"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-person-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                                    </svg> Profilis</a></li>
                            <li><a class="dropdown-item" href="Pagrindinis.php?isiminti"><svg xmlns="http://www.w3.org/2000/svg" width="16"
                                        height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                    </svg> Mano mėgstami</a></li>
                            <li><a class="dropdown-item" href="logout.php"><svg xmlns="http://www.w3.org/2000/svg"
                                        width="16" height="16" fill="currentColor" class="bi bi-box-arrow-left"
                                        viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0z" />
                                        <path fill-rule="evenodd"
                                            d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708z" />
                                    </svg> Atsijungti</a></li>
                        </ul>
                    </div>
                </li>

            </ul>
        </div>
    </nav>

    <div class="mt-5 container">
        
    <div style="display:none;" class="alert alert-danger" id="alert">
  Slaptažodžiai nesutampa!
</div>
        <div class="card">
            <div class="card-header text-center">
                <h2>Profilis</h2>
            </div>
            <form method="post" enctype="multipart/form-data" id="profile_form">
                <div class="row">
                    <div class="col-lg-2"></div>
                    <div class="profile_image_wrapper col-lg-2 pt-5">
                        <div class="container d-flex">
                            <a class="mx-auto" id="upload_link" href="" onclick="Upload(event)"> <img
                                    class="img-thumbnail rounded-circle" id="picture_preview" src="<?php  echo $_SESSION['pfp'] ?>"
                                    alt="Profilio nuotrauka"></a>
                        </div>
                        <div class="mb-4 ">
                            <input class="form-control" type="file" id="formFile" name="profile_picture"
                                accept="image/*" onchange="previewProfilePicture(event)">
                        </div>
                        <div>
                            <button id="KeistiSP" class="btn btn-dark rounded-0 form-control" type="button"
                                data-bs-toggle="collapse" data-bs-target="#collapseWidthExample" aria-expanded="false"
                                aria-controls="collapseWidthExample">
                                Keisti slaptažodi
                            </button>

                            </p>
                            <div>
                                <div class="collapse collapse-vertical" id="collapseWidthExample">
                                    <div>
                                        <label for="password_edit">Naujas slaptažodis</label>
                                        <input class="form-control" type="password" id="password_edit" name="password">

                                        <label for="confirm_password">Pakartokite slaptažodį</label>
                                        <input class="form-control mb-3" type="password" id="confirm_password"
                                            name="confirm_password">

                                    </div>
                                </div>

                            </div>
                            <a href="Pagrindinis.php?mano" class="btn btn-dark rounded-0 form-control" type="button"
                                id="upcoming_events">Mano
                                renginiai</a>
                            <a href="Pagrindinis.php?isiminti" class="btn btn-dark  rounded-0 form-control mt-3 mb-3" type="button"
                                id="past_events">Įsiminti renginiai</a>

                        </div>

                    </div>
                    <div class="profile_info col-lg-5 mt-4">
                        <label class="fw-bold" for="name">Vardas</label>
                        <input type="text" id="name" name="name" value="<?php echo $_SESSION['vardas']; ?>"
                            class="readonly_field form-control">
                        <br>

                        <label class="fw-bold" for="surname">Pavardė</label>
                        <input type="text" id="surname" name="surname" value="<?php echo $_SESSION['pavarde']; ?>"
                            class="readonly_field form-control">
                        <br>

                        <label class="fw-bold" for="email">El. paštas</label>
                        <input type="email" id="email" name="email" value="<?php echo $_SESSION['elpastas']; ?>"
                            class="readonly_field form-control">
                        <br>

                        <label class="fw-bold" for="role">Rolė</label>
                        <input type="text" id="role" name="role" value="<?php echo $_SESSION['role']; ?>" readonly disabled
                            class="readonly_field form-control">
                        
                        <br>



                    </div>
                </div>

                <div>




                    </ul>
                </div>


                <div class="card-footer text-body-secondary">
                    <div class="container d-flex justify-content-center">
                        <button class="btn btn-dark rounded-0" type="submit">Išsaugoti pakeitimus</button>
                    </div>
                </div>

            </form>
        </div>

<!--  -->

<?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>

<script>  function confirmAdminChange(form) {
 
    return confirm("Ar tikrai norite tęsti?");
  return true;
}

</script>
<div class="card mx-auto my-5">
            <div class="card-header text-center">
                <h2>Administravimo skiltis</h2>
            </div>

<h3 class="m-auto my-3">Vartotojų sąrašas</h3>

<button id="KeistiSP" class="btn btn-dark rounded-0 form-control" type="button"
        data-bs-toggle="collapse" data-bs-target="#Registravimas" aria-expanded="false"
        aria-controls="Registravimas">
    Pridėti vartotoją
</button>

<div class="collapse collapse-vertical col-6 m-auto" id="Registravimas">
    <form method="post" onsubmit="return validatePasswords()">
        <br>
        <label class="fw-bold" for="registerName">Vardas</label>
        <input type="text" name="registerName" id="registerName" placeholder="Vardas" class="form-control" required>
        <br>
        <label class="fw-bold" for="registerSurname">Pavardė</label>
        <input type="text" name="registerSurname" id="registerSurname" placeholder="Pavardė" class="form-control" required>
        <br>
        <label for="registerRole" class="fw-bold">Rolė</label>
        <select class="form-select" name="registerRole" id="registerRole">
            <option value="Admin">Administratorius</option>
            <option value="vartotojas">Vartotojas</option>
        </select>
        <br>
        <label class="fw-bold" for="registerEmail">El. paštas</label>
        <input type="email" name="registerEmail" id="registerEmail" placeholder="user@user.lt" class="form-control" required>
        <br>
        <label class="fw-bold" for="registerPassword">Slaptažodis</label>
        <input type="password" name="registerPassword" id="registerPassword" placeholder="***********" class="form-control" required>
        <br>
        <label class="fw-bold" for="registerRepeatPassword">Pakartoti Slaptažodį</label>
        <input type="password" name="registerRepeatPassword" placeholder="***********" id="registerRepeatPassword" class="form-control" required>
        <br>

        <div class="form-check">
            <input class="form-check-input" type="checkbox" onclick="togglePasswords()" id="showPassword">
            <label class="form-check-label" for="showPassword">Rodyti slaptažodį</label>
        </div>
        <br>

        <div id="passwordError" class="text-danger fw-bold" style="display:none;">Slaptažodžiai nesutampa!</div>
        <br>
        <button class="btn btn-dark rounded-0 w-100">Pridėti</button>
    </form>
</div>

<script>
    function togglePasswords() {
        const pw1 = document.getElementById('registerPassword');
        const pw2 = document.getElementById('registerRepeatPassword');
        const type = pw1.type === 'password' ? 'text' : 'password';
        pw1.type = type;
        pw2.type = type;
    }

    function validatePasswords() {
        const pw1 = document.getElementById('registerPassword').value;
        const pw2 = document.getElementById('registerRepeatPassword').value;
        const errorDiv = document.getElementById('passwordError');

        if (pw1 !== pw2) {
            errorDiv.style.display = 'block';
            return false;
        } else {
            errorDiv.style.display = 'none';
            return true;
        }
    }
</script>



<table cellpadding="5" cellspacing="0">
  <thead>
      <tr>
          <th>Vardas</th>
          <th>Pavardė</th>
          <th>El. paštas</th>
          <th>Rolė</th>
          <th>Veiksmai</th>
      </tr>
  </thead>
  <tbody>
      <?php foreach ($all_users as $user): ?>
      <tr>
          <td><?= htmlspecialchars($user['vardas']) ?></td>
          <td><?= htmlspecialchars($user['pavarde']) ?></td>
          <td><?= htmlspecialchars($user['el_pastas']) ?></td>
          <td><?= $user['role'] ?></td>
          <td>
          <form method="post" action="keisti_role.php" onsubmit="return confirmAdminChange(this);">
            <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
              <select class="form-select w-50 d-inline" name="new_role">
               <option value="vartotojas" <?= $user['role'] === 'vartotojas' ? 'selected' : '' ?>>Vartotojas</option>
               <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Administratorius</option>
          </select>
          <button class="btn btn-dark rounded-0 my-1" type="submit" value="change_role" name="action">Keisti rolę</button>
          <button class="btn btn-danger rounded-0 my-1" type="submit" value="delete_user" name="action">Ištrinti</button>
</form>
          </td>
      </tr>
      <?php endforeach; ?>
  </tbody>
</table>


<?php endif; ?>

<?php if (!empty($pending_events)): ?>

<h3 class="m-auto my-3">Nepatvirtinti renginiai</h3>
<table cellpadding="5" cellspacing="0">
  <thead>
      <tr>
          <th>ID</th>
          <th>Pavadinimas</th>
          <th>Vieta</th>
          <th>Data</th>
          <th>Laikas</th>
          <th>Veiksmai</th>
      </tr>
  </thead>
  <tbody>
      <?php foreach ($pending_events as $renginys): ?>
      <tr>
          <td><?= $renginys['id'] ?></td>
          <td>
              <a href="renginys.php?id=<?= $renginys['id'] ?>">
                  <?= htmlspecialchars($renginys['pavadinimas']) ?>
              </a>
          </td>
          <td><?= htmlspecialchars($renginys['vieta']) ?></td>
          <td><?= $renginys['DATA'] ?></td>
          <td><?= $renginys['laikas'] ?></td>

          <td>
              <form action="tvarkyti_rengini.php" method="post">
                  <input type="hidden" name="renginys_id" value="<?= $renginys['id'] ?>">
                  <button class="btn btn-success rounded-0 my-1" type="submit" name="action" value="approve">Patvirtinti</button>
                  <button class="btn btn-danger rounded-0 my-1" type="submit" name="action" value="reject">Atmesti</button>
              </form>
          </td>
      </tr>
      <?php endforeach; ?>
  </tbody>
</table>

<?php endif; ?>
<div class="card-footer text-body-secondary">&nbsp;</div>
</div>

</div>

</body>

</html>