<?php include 'connect.php';
session_start();

if (!isset($_SESSION['id'])) {
  header('location:index.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
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

  <nav class="navbar navbar-expand-md navbar-dark bg-dark ">
    <a href="Pagrindinis.php" class="navbar-brand mb-0 mx-3 h1">RENGINUS</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse mb-0" id="navbarNav">
      <ul class="navbar-nav ms-auto">

        <li class="nav-item active pt-1">

          <a class="btn-secondary" href="renginio_forma.php" role="button" id="dropdownMenuLink"><svg
              xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-window-plus"
              viewBox="0 0 16 16">
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
              <img id="smallpfp" src="<?php echo $_SESSION['pfp'] ?>" class="rounded-circle"
                style="width: 35px; height: 35px;" alt="Profilis">

              <?php echo $_SESSION['vardas'] ?>
            </a>

            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink">
              <li><a class="dropdown-item" href="vartotojo_profilis.php"><svg xmlns="http://www.w3.org/2000/svg"
                    width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                    <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                  </svg> Profilis</a></li>
              <li><a class="dropdown-item" href="Pagrindinis.php?isiminti"><svg xmlns="http://www.w3.org/2000/svg"
                    width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                    <path
                      d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                  </svg> Mano mėgstami</a></li>
              <li><a class="dropdown-item" href="logout.php"><svg xmlns="http://www.w3.org/2000/svg" width="16"
                    height="16" fill="currentColor" class="bi bi-box-arrow-left" viewBox="0 0 16 16">
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

  <div id="NavFooterBG" class="bg-dark">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">

    <div class="container" id="SearchContainer">
      <div class="row mx-auto mt-5">
        <div class="col-md-12">
          <form class="d-flex justify-content-center">
            <div class="input-group">
              <input class="form-control form-control-lg" type="search" placeholder="Paieška" aria-label="Search"
                name="search">
              <button class="btn btn-light px-4" type="submit">
                <i class="bi bi-search"></i>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="container">
      <div class="row m-auto">
        <div class="col-12 my-4 d-flex justify-content-center">
          <a href="?visi" type="button" class="btn btn-dark m-1"><svg xmlns="http://www.w3.org/2000/svg" width="16"
              height="16" fill="currentColor" class="bi bi-boxes" viewBox="0 0 16 16">
              <path
                d="M7.752.066a.5.5 0 0 1 .496 0l3.75 2.143a.5.5 0 0 1 .252.434v3.995l3.498 2A.5.5 0 0 1 16 9.07v4.286a.5.5 0 0 1-.252.434l-3.75 2.143a.5.5 0 0 1-.496 0l-3.502-2-3.502 2.001a.5.5 0 0 1-.496 0l-3.75-2.143A.5.5 0 0 1 0 13.357V9.071a.5.5 0 0 1 .252-.434L3.75 6.638V2.643a.5.5 0 0 1 .252-.434zM4.25 7.504 1.508 9.071l2.742 1.567 2.742-1.567zM7.5 9.933l-2.75 1.571v3.134l2.75-1.571zm1 3.134 2.75 1.571v-3.134L8.5 9.933zm.508-3.996 2.742 1.567 2.742-1.567-2.742-1.567zm2.242-2.433V3.504L8.5 5.076V8.21zM7.5 8.21V5.076L4.75 3.504v3.134zM5.258 2.643 8 4.21l2.742-1.567L8 1.076zM15 9.933l-2.75 1.571v3.134L15 13.067zM3.75 14.638v-3.134L1 9.933v3.134z" />
            </svg> Visi Renginiai</a>
          <a href="?isiminti" type="button" class="btn btn-dark m-1 "><svg xmlns="http://www.w3.org/2000/svg" width="16"
              height="16" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
              <path
                d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.56.56 0 0 0-.163-.505L1.71 6.745l4.052-.576a.53.53 0 0 0 .393-.288L8 2.223l1.847 3.658a.53.53 0 0 0 .393.288l4.052.575-2.906 2.77a.56.56 0 0 0-.163.506l.694 3.957-3.686-1.894a.5.5 0 0 0-.461 0z" />
            </svg> Įsiminti renginiai</a>
          <a href="?populiarus" type="button" class="btn btn-dark m-1 "><svg xmlns="http://www.w3.org/2000/svg"
              width="16" height="16" fill="currentColor" class="bi bi-trophy" viewBox="0 0 16 16">
              <path
                d="M2.5.5A.5.5 0 0 1 3 0h10a.5.5 0 0 1 .5.5q0 .807-.034 1.536a3 3 0 1 1-1.133 5.89c-.79 1.865-1.878 2.777-2.833 3.011v2.173l1.425.356c.194.048.377.135.537.255L13.3 15.1a.5.5 0 0 1-.3.9H3a.5.5 0 0 1-.3-.9l1.838-1.379c.16-.12.343-.207.537-.255L6.5 13.11v-2.173c-.955-.234-2.043-1.146-2.833-3.012a3 3 0 1 1-1.132-5.89A33 33 0 0 1 2.5.5m.099 2.54a2 2 0 0 0 .72 3.935c-.333-1.05-.588-2.346-.72-3.935m10.083 3.935a2 2 0 0 0 .72-3.935c-.133 1.59-.388 2.885-.72 3.935M3.504 1q.01.775.056 1.469c.13 2.028.457 3.546.87 4.667C5.294 9.48 6.484 10 7 10a.5.5 0 0 1 .5.5v2.61a1 1 0 0 1-.757.97l-1.426.356a.5.5 0 0 0-.179.085L4.5 15h7l-.638-.479a.5.5 0 0 0-.18-.085l-1.425-.356a1 1 0 0 1-.757-.97V10.5A.5.5 0 0 1 9 10c.516 0 1.706-.52 2.57-2.864.413-1.12.74-2.64.87-4.667q.045-.694.056-1.469z" />
            </svg> Populiarus renginiai</a>

        </div>
      </div>
    </div>
  </div>
  </di>
  <div class="contain
  er-fluid">
    <div class="row">
      <div class="col-md-2">
        <form method="get" class="d-none d-md-block mx-3 filtraiSone">
          <br>
          <div class="card border rounded p-3">
            <div><b>Renginio tipas</b></div>
            <hr>
            <div><input type="checkbox" name="filtras[]" value="Seminaras"> Seminaras </div>
            <div><input type="checkbox" name="filtras[]" value="Mokymai"> Mokymai </div>
            <div><input type="checkbox" name="filtras[]" value="Komandinis renginys"> Komandinis renginys </div>
            <div><input type="checkbox" name="filtras[]" value="Šventė"> Šventė </div>
            <br>

            <?php

            if (isset($_GET['filtras']) && is_array($_GET['filtras'])) {
              echo '<script>';
              foreach ($_GET['filtras'] as $filtras) {
                echo 'document.getElementsByName("filtras[]").forEach(el => { if (el.value == "' . $filtras . '") el.checked = true; });';
              }
              echo '</script>';
            }



            if (isset($_GET['dates'])) {
              echo "<script>
                    window.onload = function() {
                        document.getElementsByName('dates')[0].value = '" . htmlspecialchars($_GET['dates'], ENT_QUOTES) . "';
                    };
                </script>";
            }

            ?>


            <button class="btn btn-dark rounded-0 form-control">Keisti</button>
          </div>

          <br>
          <div class="card border rounded p-3">
            <div><b>Data</b></div>
            <hr>

            <div>
              <input class="border form-control text-center" type="text" name="dates" value="2024-01-01 - 2026-01-01">
              <script>$(function () {
                  $('input[name="dates"]').daterangepicker({

                    locale: {
                      format: 'YYYY-MM-DD'
                    }
                  });
                });</script>

              <button class="btn btn-dark rounded-0 form-control mt-2">Keisti</button>
            </div>
          </div>

        </form>

        <div class="dropdown d-block d-md-none">
          <button class="rounded-0 btn btn-dark dropdown-toggle w-100" type="button" data-bs-toggle="dropdown"
            aria-expanded="false">
            Filtrai
          </button>
          <ul class="dropdown-menu w-100">
            <form>
              <form method="get" class="d-none d-md-block mx-3">
                <br>
                <div class="border rounded p-3">
                  <div><b>Renginio tipas</b></div>
                  <hr>
                  <div><input type="checkbox" name="filtras[]" value="Seminaras"> Seminaras </div>
                  <div><input type="checkbox" name="filtras[]" value="Mokymai"> Mokymai </div>
                  <div><input type="checkbox" name="filtras[]" value="Komandinis renginys"> Komandinis renginys </div>
                  <div><input type="checkbox" name="filtras[]" value="Šventė"> Šventė </div>
                  <br>

                  <?php

                  if (isset($_GET['filtras']) && is_array($_GET['filtras'])) {
                    echo '<script>';
                    foreach ($_GET['filtras'] as $filtras) {
                      echo 'document.getElementsByName("filtras[]").forEach(el => { if (el.value == "' . $filtras . '") el.checked = true; });';
                    }
                    echo '</script>';
                  }



                  if (isset($_GET['dates'])) {
                    echo "<script>
                    window.onload = function() {
                        document.getElementsByName('dates')[0].value = '" . htmlspecialchars($_GET['dates'], ENT_QUOTES) . "';
                    };
                </script>";
                  }

                  ?>


                  <button class="btn btn-dark rounded-0 form-control">Keisti</button>
                </div>

                <br>
                <div class="border rounded p-3">
                  <div><b>Data</b></div>
                  <hr>

                  <div>
                    <input class="form-control text-center" type="text" name="dates" value="">
                    <script>$(function () {
                        $('input[name="dates"]').daterangepicker({

                          locale: {
                            format: 'YYYY-MM-DD'
                          }
                        });
                      });</script>
                    <br>
                    <button class="btn btn-dark rounded-0 form-control mt-2">Keisti</button>
                  </div>
                </div>

              </form>
            </form>
          </ul>
        </div>

      </div>
      <div class="col-md-8">

        <?php
        $where = ["r.status = 'approved'"];

        if (isset($_GET["dates"])) {
          $date = $_GET["dates"];
          $dates = explode(" - ", $date);
          if (count($dates) === 2) {
            $start = $conn->real_escape_string($dates[0]);
            $end = $conn->real_escape_string($dates[1]);
            $where[] = "r.DATA BETWEEN '$start' AND '$end'";
          }
        }

        if (isset($_GET["filtras"]) && is_array($_GET["filtras"])) {
          $filtered = array_map(function ($f) use ($conn) {
            return "'" . $conn->real_escape_string($f) . "'";
          }, $_GET["filtras"]);

          if (!empty($filtered)) {
            $placeholder = implode(",", $filtered);
            $where[] = "renginio_tipas IN ($placeholder)";
          }
        }

        if (isset($_GET["search"]) && $_GET["search"] !== "") {
          $search = $conn->real_escape_string($_GET["search"]);
          $where[] = "(r.pavadinimas LIKE '%$search%' OR r.aprasymas LIKE '%$search%' OR r.vieta LIKE '%$search%')";
        }

        $where_sql = implode(" AND ", $where);

        $all = $conn->query("SELECT r.*, GROUP_CONCAT(n.nuotrauka_url) AS images 
FROM renginys r 
LEFT JOIN renginio_nuotraukos n ON r.id = n.renginys_id 
WHERE $where_sql 
GROUP BY r.id");
        ?>

        <?php
        if (isset($_GET["populiarus"])) {

          $all = $conn->query("SELECT r.*, GROUP_CONCAT(n.nuotrauka_url) AS images 
FROM renginys r 
LEFT JOIN renginio_nuotraukos n ON r.id = n.renginys_id 
WHERE $where_sql 
GROUP BY r.id ORDER BY r.paspaudimai DESC");
        }
        ?>

        <?php
        if (isset($_GET["mano"])) {
          $userID = $_SESSION['id'];

          $all = $conn->query("SELECT r.*, GROUP_CONCAT(n.nuotrauka_url) AS images 
FROM renginys r 
LEFT JOIN renginio_nuotraukos n ON r.id = n.renginys_id 
WHERE r.userID = $userID
GROUP BY r.id");
        }
        ?>

        <?php
        if (isset($_GET["isiminti"])) {
          $userID = $_SESSION['id'];

          $all = $conn->query("SELECT r.*, GROUP_CONCAT(n.nuotrauka_url) AS images
FROM renginys r
LEFT JOIN renginio_nuotraukos n ON r.id = n.renginys_id 
LEFT JOIN isiminti f ON r.id = f.eventID
WHERE f.userID = $userID
GROUP BY r.id
");
        }
        ?>
        <div class="row">
          <?php
          if ($all->num_rows > 0):
            date_default_timezone_set('Europe/Vilnius');
            $today = date('Y-m-d');

            while ($row = $all->fetch_assoc()):
              $isPast = $row['DATA'] < $today;
              $linkStyle = $isPast ? 'style="filter: grayscale(100%) opacity(0.5);"' : '';
              ?>
              <a <?= $linkStyle ?> href="renginys.php?id=<?= $row['id'] ?>"
                class="link-underline link-underline-opacity-0 col-md-4 mt-2 link-dark">

                <?php if (!empty($row['images'])):
                  $image = explode(',', $row['images']);
                  ?>
                  <img class="renginiu-foto-menu shadow p-1 rounded"
                    src="images/renginiu_foto/<?= htmlspecialchars($image[0]) ?>" alt="Renginio nuotrauka" width="200">
                <?php endif; ?>

                <div class="fs-2"><?= htmlspecialchars($row['pavadinimas']) ?></div>

                <div>
                  <strong>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                      class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                      <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6" />
                    </svg>
                  </strong> <?= htmlspecialchars($row['vieta']) ?>
                </div>

                <div>
                  <strong>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                      class="bi bi-clock-fill" viewBox="0 0 16 16">
                      <path
                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z" />
                    </svg>
                  </strong> <?= htmlspecialchars($row['DATA']) ?>&nbsp;<?= htmlspecialchars($row['laikas']) ?>
                </div>

                <div>
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-person-fill" viewBox="0 0 16 16">
                    <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                  </svg> <?= htmlspecialchars($row['laisvu_vietu_skaicius']) ?>
                </div>

                <p>
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cash"
                    viewBox="0 0 16 16">
                    <path d="M8 10a2 2 0 1 0 0-4 2 2 0 0 0 0 4" />
                    <path
                      d="M0 4a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1zm3 0a2 2 0 0 1-2 2v4a2 2 0 0 1 2 2h10a2 2 0 0 1 2-2V6a2 2 0 0 1-2-2z" />
                  </svg> <?= $row['kaina'] > 0 ? htmlspecialchars($row['kaina']) . "€" : "Nemokamas" ?>
                </p>

              </a>
            <?php endwhile; else: ?>
            <p>Nėra registruotų renginių.</p>
          <?php endif; ?>
        </div>
              
</body>

</html>

