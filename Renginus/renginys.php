<?php
include 'connect.php';
session_start();

if (!isset($_SESSION['id'])) {
    header('location:index.php');
    exit();
}

if (!isset($_GET['id'])) {
    echo "Renginys nerastas.";
    exit();
}

$renginys_id = (int) $_GET['id'];

$query = $conn->prepare("SELECT r.*, GROUP_CONCAT(n.nuotrauka_url) AS images 
                         FROM renginys r 
                         LEFT JOIN renginio_nuotraukos n ON r.id = n.renginys_id 
                         WHERE r.id = ? 
                         GROUP BY r.id");
$query->bind_param("i", $renginys_id);
$query->execute();
$result = $query->get_result();

if ($result->num_rows == 0) {
    echo "Renginys nerastas.";
    exit();
}

$row = $result->fetch_assoc();

$updateClicks = $conn->prepare("UPDATE renginys SET paspaudimai = paspaudimai + 1 WHERE id = ?");
$updateClicks->bind_param("i", $_GET['id']);
$updateClicks->execute();
$updateClicks->close();
?>


<?php
if (isset($_GET["register"]) && isset($_GET["id"])) {
    $userID = (int) $_GET["register"];
    $eventID = (int) $_GET["id"];

    $query = $conn->prepare("SELECT * FROM rezervacijos WHERE vartotojo_id = ? AND renginio_id = ?");
    $query->bind_param("ii", $userID, $eventID);
    $query->execute();
    $query->store_result();

    if ($query->num_rows > 0) {
        echo "<script>alert('Jau esate užsiregistravę!');</script>";
    } else {
        $checkEvent = $conn->prepare("SELECT laisvu_vietu_skaicius, DATA FROM renginys WHERE id = ?");
        $checkEvent->bind_param("i", $eventID);
        $checkEvent->execute();
        $checkEvent->bind_result($freeSeats, $eventDate);
        $checkEvent->fetch();
        $checkEvent->close();

        $now = new DateTime();
        $eventDateTime = new DateTime($eventDate);

        if ($eventDateTime < $now) {
            echo "<script>alert('Šis renginys jau įvyko! Registracija negalima.');</script>";
        } else if ($freeSeats > 0) {
            $insert = $conn->prepare("INSERT INTO rezervacijos (vartotojo_id, renginio_id) VALUES (?, ?)");
            $insert->bind_param("ii", $userID, $eventID);
            $insert->execute();
            $insert->close();

            $update = $conn->prepare("UPDATE renginys SET laisvu_vietu_skaicius = laisvu_vietu_skaicius - 1 WHERE id = ?");
            $update->bind_param("i", $eventID);
            $update->execute();
            $update->close();

            echo "<script>alert('Sėkmingai užsiregistravote!');</script>";
        } else {
            echo "<script>alert('Nėra laisvų vietų!');</script>";
        }
    }
    $query->close();
}
?>

<?php

if (
    isset($_SESSION['role']) && $_SESSION['role'] === 'admin' &&
    isset($_GET['delete']) && $_GET['delete'] === 'true' &&
    isset($_GET['id'])
) {

    $eventID = (int) $_GET['id'];

    $deleteReservations = $conn->prepare("DELETE FROM rezervacijos WHERE renginio_id = ?");
    $deleteReservations->bind_param("i", $eventID);
    $deleteReservations->execute();
    $deleteReservations->close();

    $deleteFavorites = $conn->prepare("DELETE FROM isiminti WHERE eventID = ?");
    $deleteFavorites->bind_param("i", $eventID);
    $deleteFavorites->execute();
    $deleteFavorites->close();


    $deleteEvent = $conn->prepare("DELETE FROM renginys WHERE id = ?");
    $deleteEvent->bind_param("i", $eventID);

    if ($deleteEvent->execute()) {
        echo "<script>alert('Renginys ir susijusios rezervacijos ištrintos.');</script>";
        header("location: Pagrindinis.php");
    } else {
        echo "<script>alert('Klaida tryniant renginį.');</script>";
    }

    $deleteEvent->close();
}
?>

<?php
if(isset($_GET["favorite"]) && $_GET["favorite"] == true){
    $userID = (int) $_SESSION["id"];
    $eventID = (int) $_GET["id"];

    $query = $conn->prepare("SELECT * FROM isiminti WHERE userID = ? AND eventID = ?");
    $query->bind_param("ii", $userID, $eventID);
    $query->execute();
    $query->store_result();

    if ($query->num_rows > 0) {
       $delete = $conn->prepare("DELETE FROM isiminti WHERE userID = ? AND eventID = ?");
            $delete->bind_param("ii", $userID, $eventID);
            $delete->execute();
            $delete->close();
    } 
    else
    {
         $insert = $conn->prepare("INSERT INTO isiminti (userID, eventID) VALUES (?, ?)");
            $insert->bind_param("ii", $userID, $eventID);
            $insert->execute();
            $insert->close();
    }
}
?>


<!DOCTYPE html>
<html lang="lt">

<head>
    <meta charset="UTF-8">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="style.css">
    <title>Renginus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <title><?php echo htmlspecialchars($row['pavadinimas']); ?></title>
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
                            <img id="smallpfp" src="<?php echo $_SESSION['pfp'] ?>" class="rounded-circle"
                                style="width: 35px; height: 35px;" alt="Profilis">

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
    <div id="container-bg-img"><img id="bg-image" src="" alt=""></div>

    <div class="card col-lg-6 mx-auto">

        <div class="slideshow-container">
            <a href="renginys.php?id=<?php echo $_GET['id']; ?>&favorite=true"> <svg id="isimintiMygtukas" xmlns="http://www.w3.org/2000/svg" width="50" height="50"
                    fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                    <path
                        d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                </svg>
            </a>
            <?php if (!empty($row['images'])): ?>
                <?php
                $images = explode(',', $row['images']);
                foreach ($images as $img): ?>
                    <div class="mySlides fade opacity-100">
                        <img src="images/renginiu_foto/<?php echo htmlspecialchars($img); ?>" id="renginysIMG" alt="Nuotrauka">
                    </div>

                <?php endforeach; ?>
            <?php endif; ?>
            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
            <a class="next" onclick="plusSlides(1)">&#10095;</a>
        </div>
        <h1 class="text-center mt-2 w-100%"><?php echo htmlspecialchars($row['pavadinimas']); ?> </h1>



        <div class="mx-5">
            <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-boxes"
                    viewBox="0 0 16 16">
                    <path
                        d="M7.752.066a.5.5 0 0 1 .496 0l3.75 2.143a.5.5 0 0 1 .252.434v3.995l3.498 2A.5.5 0 0 1 16 9.07v4.286a.5.5 0 0 1-.252.434l-3.75 2.143a.5.5 0 0 1-.496 0l-3.502-2-3.502 2.001a.5.5 0 0 1-.496 0l-3.75-2.143A.5.5 0 0 1 0 13.357V9.071a.5.5 0 0 1 .252-.434L3.75 6.638V2.643a.5.5 0 0 1 .252-.434zM4.25 7.504 1.508 9.071l2.742 1.567 2.742-1.567zM7.5 9.933l-2.75 1.571v3.134l2.75-1.571zm1 3.134 2.75 1.571v-3.134L8.5 9.933zm.508-3.996 2.742 1.567 2.742-1.567-2.742-1.567zm2.242-2.433V3.504L8.5 5.076V8.21zM7.5 8.21V5.076L4.75 3.504v3.134zM5.258 2.643 8 4.21l2.742-1.567L8 1.076zM15 9.933l-2.75 1.571v3.134L15 13.067zM3.75 14.638v-3.134L1 9.933v3.134z" />
                </svg> <?php echo htmlspecialchars($row['renginio_tipas']); ?></p>
            <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo"
                    viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M8 1a3 3 0 1 0 0 6 3 3 0 0 0 0-6M4 4a4 4 0 1 1 4.5 3.969V13.5a.5.5 0 0 1-1 0V7.97A4 4 0 0 1 4 3.999zm2.493 8.574a.5.5 0 0 1-.411.575c-.712.118-1.28.295-1.655.493a1.3 1.3 0 0 0-.37.265.3.3 0 0 0-.057.09V14l.002.008.016.033a.6.6 0 0 0 .145.15c.165.13.435.27.813.395.751.25 1.82.414 3.024.414s2.273-.163 3.024-.414c.378-.126.648-.265.813-.395a.6.6 0 0 0 .146-.15l.015-.033L12 14v-.004a.3.3 0 0 0-.057-.09 1.3 1.3 0 0 0-.37-.264c-.376-.198-.943-.375-1.655-.493a.5.5 0 1 1 .164-.986c.77.127 1.452.328 1.957.594C12.5 13 13 13.4 13 14c0 .426-.26.752-.544.977-.29.228-.68.413-1.116.558-.878.293-2.059.465-3.34.465s-2.462-.172-3.34-.465c-.436-.145-.826-.33-1.116-.558C3.26 14.752 3 14.426 3 14c0-.599.5-1 .961-1.243.505-.266 1.187-.467 1.957-.594a.5.5 0 0 1 .575.411" />
                </svg> <?php echo htmlspecialchars($row['vieta']); ?> <svg xmlns="http://www.w3.org/2000/svg" width="16"
                    height="16" fill="currentColor" class="bi bi-calendar" viewBox="0 0 16 16">
                    <path
                        d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z" />
                </svg> <?php echo htmlspecialchars($row['DATA']); ?> <svg xmlns="http://www.w3.org/2000/svg" width="16"
                    height="16" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16">
                    <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z" />
                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0" />
                </svg> <?php echo htmlspecialchars($row['laikas']); ?></p>
            <p>Laisvų vietų skaičius: <?php echo htmlspecialchars($row['laisvu_vietu_skaicius']); ?></p>
            <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cash"
                    viewBox="0 0 16 16">
                    <path d="M8 10a2 2 0 1 0 0-4 2 2 0 0 0 0 4" />
                    <path
                        d="M0 4a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1zm3 0a2 2 0 0 1-2 2v4a2 2 0 0 1 2 2h10a2 2 0 0 1 2-2V6a2 2 0 0 1-2-2z" />
                </svg> <?php echo ($row['kaina'] > 0 ? htmlspecialchars($row['kaina']) . " €" : "Nemokamas"); ?></p>
            <?php echo $row['aprasymas']; ?>




        </div>
        <div id="mapContainer" style="margin-top: 20px;"><iframe
                src="https://www.google.com/maps?q=<?php echo $row['vieta']; ?>&output=embed"
                style="width:100%; height:400px; border:0;">
            </iframe></div>
        <a href="renginys.php?id=<?php echo $_GET['id']; ?>&register=<?php echo $_SESSION['id']; ?>"
            class="btn btn-dark form-control m-auto my-1 rounded-0">Registruotis</a>
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <a href="renginys.php?id=<?php echo $_GET['id']; ?>&delete=true"
                class="btn btn-danger form-control m-auto my-1 rounded-0"
                onclick="return confirm('Ar tikrai norite ištrinti šį renginį?')">Pašalinti renginį</a>
        <?php endif; ?>
    </div>

    <script>


        let backgroundImg = document.getElementById("bg-image");
        let contBackgroundImg = document.getElementById("container-bg-img");

        let slideIndex = 1;
        showSlides(slideIndex);


        function plusSlides(n) {
            showSlides(slideIndex += n);
        }

        function currentSlide(n) {
            showSlides(slideIndex = n);
        }

        function showSlides(n) {
            let i;
            let slides = document.getElementsByClassName("mySlides");

            if (n > slides.length) { slideIndex = 1 }
            if (n < 1) { slideIndex = slides.length }
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            slides[slideIndex - 1].style.display = "block";
            backgroundImg.src = slides[slideIndex - 1].getElementsByTagName("img")[0].src;

        }

        setInterval(() => {
            contBackgroundImg.style.height = window.getComputedStyle(document.getElementsByClassName("slideshow-container")[0]).height;
        }, 1);
    </script>
    
</body>

<?php
$userID = (int) $_SESSION["id"];
    $eventID = (int) $_GET["id"];

 $favorite = $conn->prepare("SELECT * FROM isiminti WHERE userID = ? AND eventID = ?");
    $favorite->bind_param("ii", $userID, $eventID);
    $favorite->execute();
    $favorite->store_result();

    if ($favorite->num_rows > 0) {
        echo "a";
        echo'<script>document.getElementById("isimintiMygtukas").style.color = "gold"</script>';
    }
?>
</html>