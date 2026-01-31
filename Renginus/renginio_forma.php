<?php include 'connect.php';
session_start();

if (!isset($_SESSION['id'])) {
    header('location:index.php');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pavadinimas = $_POST['title'];
    $aprasymas = $_POST['description'];
    $renginio_tipas = $_POST['category'];
    $vieta = $_POST['location'];
    $data = $_POST['date'];
    $laikas = $_POST['time'];
    $vietos = $_POST['slots'];
    //$kaina = ($_POST['paid'] === 'yes') ? $_POST['price'] : 0;
    $kaina = isset($_POST['paid']) ? 0 : $_POST['price'];
    $userID = $_SESSION['id'];

   $sql = "INSERT INTO renginys (pavadinimas, aprasymas, renginio_tipas, vieta, DATA, laikas, laisvu_vietu_skaicius, kaina, status, userID) 
        VALUES ('$pavadinimas', '$aprasymas', '$renginio_tipas', '$vieta', '$data', '$laikas', '$vietos', $kaina, 'pending', '$userID')";

    if ($conn->query($sql) === TRUE) {
        $renginio_id = $conn->insert_id;

        if (!empty($_FILES['images']['name'][0])) {
            $upload_dir = "images/renginiu_foto/";
            foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                $filename = basename($_FILES['images']['name'][$key]);
                move_uploaded_file($tmp_name, $upload_dir . $filename);
                $conn->query("INSERT INTO renginio_nuotraukos (renginys_id, nuotrauka_url) VALUES ('$renginio_id', '$filename')");
            }
        }

        echo "Renginys sėkmingai užregistruotas!";
        header("Location: Pagrindinis.php");
        exit();
    } else {
        echo "Klaida: " . $conn->error;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="lt">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="style.css">
    <title>Renginus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <script src="script.js" defer></script>
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


    <div class=" m-auto card mt-5 event-form col-lg-5 mb-5">
    <div class="card-header text-center">
                <h2>Renginio registracija</h2>
            </div>
        <form method="POST" enctype="multipart/form-data" class=" needs-validation px-5">

            <div>
                <label for="title" class="form-label fw-bold">Pavadinimas</label>
                <input class="form-control" type="text" id="title" name="title" required>
            </div>

            <div>
                <label for="description" class="form-label fw-bold">Aprašymas</label>
                <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
                <input type="hidden" id="hiddenInput" name="description">
                <div id="editor" style="height: 200px;">
                    <p>Įveskite tekstą...</p>
                </div>
                <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
                <script>
                    const quill = new Quill('#editor', { theme: 'snow' });
                    document.querySelector('form').addEventListener('submit', function (e) {
                        const description = quill.root.innerHTML;
                        document.querySelector('#hiddenInput').value = description;
                    });
                </script>
            </div>

            <div>
                <label for="category" class="form-label fw-bold">Kategorija</label>
                <select class="form-select" id="category" name="category" required>
                    <option>Seminaras</option>
                    <option>Mokymai</option>
                    <option>Komandinis renginys</option>
                    <option>Šventė</option>
                </select>
            </div>

            <div>
                <label for="location" class="form-label fw-bold" >Adresas</label>
                <input onchange="vieta()" class="form-control" type="text" id="location" name="location" required>

                <div id="mapContainer" style="margin-top: 20px;"><iframe
                        src="https://www.google.com/maps?q=lietuva&output=embed"
                        style="width:100%; height:400px; border:0;" allowfullscreen>
                    </iframe></div>

                <script>
                    function vieta() {
                        const mapContainer = document.getElementById('mapContainer');
                        const location = document.getElementById('location').value.trim();

                        if (location) {
                            const encodedLocation = encodeURIComponent(location);
                            const iframe = `
            <iframe 
                src="https://www.google.com/maps?q=${encodedLocation}&output=embed"
                style="width:100%; height:400px; border:0;"
                allowfullscreen>
            </iframe>
        `;
                            mapContainer.innerHTML = iframe;
                        }
                    }
                </script>

            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="date" class="form-label fw-bold">Data</label>
                    <input class="form-control" type="date" id="date" name="date" required>
                </div>
                <div class="col-md-6">
                    <label for="time" class="form-label fw-bold">Laikas</label>
                    <input class="form-control" type="time" id="time" name="time" required>
                </div>
            </div>

            <div>
                <label for="slots" class="form-label fw-bold">Laisvų vietų skaičius</label>
                <input class="form-control" type="number" id="slots" name="slots" min="1" required>
            </div>



            <div id="price-container">
                <label for="price" class="form-label fw-bold">Kaina (€)</label>
                <input class="form-control" type="number" id="price" name="price" min="0" step="0.01">
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="paid" name="paid" onchange="togglePrice()">
                <label class="form-check-label" for="paid fw-bold">
                    Renginys nemokamas
                </label>
            </div>
            <br>
            <div>
                <label for="images" class="form-label fw-bold">Įkelkite nuotraukas</label>
                <input class="form-control" type="file" id="images" name="images[]" accept="image/*" multiple
                    onchange="previewImages(event)" required>
            </div>

            <div id="image-preview-container" class="mb-3 d-flex flex-wrap gap-2 shadow p-1 rounded"></div>

    
                    <div class="container d-flex justify-content-center mb-3">
                        <button class="btn btn-dark rounded-0">Registruoti renginį</button>
    
                </div>

        </form>
    </div>
</body>

</html>