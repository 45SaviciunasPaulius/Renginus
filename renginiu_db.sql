-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 30, 2025 at 11:38 AM
-- Server version: 8.0.37
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `renginiu_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `atsiliepimai`
--

CREATE TABLE `atsiliepimai` (
  `id` int NOT NULL,
  `vartotojo_id` int DEFAULT NULL,
  `renginio_id` int DEFAULT NULL,
  `ivertinimas` int DEFAULT NULL,
  `komentaras` text COLLATE utf8mb4_general_ci,
  `data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ;

-- --------------------------------------------------------

--
-- Table structure for table `isiminti`
--

CREATE TABLE `isiminti` (
  `id` int NOT NULL,
  `userID` int NOT NULL,
  `eventID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `isiminti`
--

INSERT INTO `isiminti` (`id`, `userID`, `eventID`) VALUES
(6, 1, 48),
(7, 1, 42),
(8, 5, 47),
(9, 5, 41);

-- --------------------------------------------------------

--
-- Table structure for table `renginio_nuotraukos`
--

CREATE TABLE `renginio_nuotraukos` (
  `id` int NOT NULL,
  `renginys_id` int NOT NULL,
  `nuotrauka_url` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `renginio_nuotraukos`
--

INSERT INTO `renginio_nuotraukos` (`id`, `renginys_id`, `nuotrauka_url`) VALUES
(24, 41, 'corporate-businessman-giving-presentation-large-audience.jpg'),
(25, 41, 'people-taking-part-high-protocol-event.jpg'),
(26, 42, 'headway-F2KRf_QfCqw-unsplash.jpg'),
(27, 42, 'crowd-people-with-raised-arms-having-fun-music-festival-by-night.jpg'),
(28, 43, 'the-climate-reality-project-Hb6uWq0i4MI-unsplash.jpg'),
(29, 43, 'jakob-dalbjorn-cuKJre3nyYc-unsplash.jpg'),
(30, 44, 'hivan-arvizu-soyhivan-MAnhvw0nDDY-unsplash.jpg'),
(31, 44, 'product-school-nOvIa_x_tfo-unsplash.jpg'),
(32, 45, 'md-duran-rE9vgD_TXgM-unsplash.jpg'),
(33, 45, 'evangeline-shaw-nwLTVwb7DbU-unsplash.jpg'),
(34, 46, 'jaime-lopes-0RDBOAdnbWM-unsplash.jpg'),
(35, 46, 'chuttersnap-Q_KdjKxntH8-unsplash.jpg'),
(36, 47, 'charlesdeluvio-wn7dOzUh3Rs-unsplash.jpg'),
(37, 47, 'antenna-ohNCIiKVT1g-unsplash.jpg'),
(38, 48, 'markus-spiske-hvSr_CVecVI-unsplash.jpg'),
(39, 48, 'joshua-sortino-LqKhnDzSF-8-unsplash.jpg'),
(41, 50, 'filters_format(jpeg).jpg');

-- --------------------------------------------------------

--
-- Table structure for table `renginys`
--

CREATE TABLE `renginys` (
  `id` int NOT NULL,
  `pavadinimas` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `aprasymas` text COLLATE utf8mb4_general_ci NOT NULL,
  `renginio_tipas` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `vieta` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `DATA` date NOT NULL,
  `laikas` time NOT NULL,
  `laisvu_vietu_skaicius` int NOT NULL,
  `kaina` decimal(10,2) NOT NULL,
  `kokiai_role` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kokiai_komandai` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'pending',
  `paspaudimai` int NOT NULL DEFAULT '0',
  `userID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `renginys`
--

INSERT INTO `renginys` (`id`, `pavadinimas`, `aprasymas`, `renginio_tipas`, `vieta`, `DATA`, `laikas`, `laisvu_vietu_skaicius`, `kaina`, `kokiai_role`, `kokiai_komandai`, `status`, `paspaudimai`, `userID`) VALUES
(41, 'Kviečiame į įmonės renginį!', '<p>Mieli kolegos, draugai ir partneriai,</p><p><br></p><p>Maloniai kviečiame Jus dalyvauti mūsų <strong>„Verslo sprendimai“</strong> organizuojamame renginyje, kuris vyks <strong>2025 m. birželio 15 d., nuo 17:00 iki 21:00 val.</strong>, adresu <strong>Vilniaus konferencijų centras, Konstitucijos pr. 20, Vilnius</strong>.</p><p>Renginio metu Jūsų laukia:</p><ol><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span>Įdomios pranešimų sesijos apie naujausias mūsų veiklos tendencijas</li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span>Komandos žaidimai ir pramogos</li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span>Puiki galimybė susipažinti su kolegomis ir užmegzti naujus kontaktus</li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span>Skani vaišės ir muzika gyvai</li></ol><p>Ateikite pasidalinti gera nuotaika, įkvėpimu ir pasisemkite naujų idėjų!</p><p><br></p><p>Laukiame Jūsų!</p>', 'Seminaras', 'Konstitucijos pr. 20, Vilnius.', '2025-06-15', '17:10:00', 49, 0.00, NULL, NULL, 'approved', 41, 1),
(42, 'Įmonės vasaros šventė 2025', '<h2><strong>Mieli kolegos,</strong></h2><p><br></p><p>Su dideliu džiaugsmu kviečiame Jus į tradicinę <strong><em>Įmonės vasaros šventę</em></strong>, kurioje mūsų visų laukia ne tik smagiai praleistas laikas, bet ir dar glaudesni komandiniai ryšiai bei bendruomeniškumo jausmas.</p><p>Šventės metu mėgausimės atpalaiduojančia atmosfera miesto širdyje, dalyvausime linksmose komandų rungtyse, išklausysime trumpas, įkvepiančias vadovų kalbas bei pasidžiaugsime šauniais metų pasiekimais.</p><p><br></p><h2><strong>Jūsų lauks:</strong></h2><ol><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span>Gardus maistas ir įvairūs užkandžiai</li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span>Gaivieji gėrimai ir desertų kampelis</li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span>Komandinės pramogos ir žaidimai</li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span>Gyva muzika ir DJ pasirodymas</li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span>Apdovanojimai ir siurprizai</li></ol><p>Tai puiki proga pabendrauti neformalioje aplinkoje, geriau pažinti kolegas, pasidalyti šypsenomis ir pasikrauti pozityvios energijos artėjančiam sezonui!</p>', 'Šventė', 'Upės g. 6, Vilnius', '2025-05-25', '15:18:00', 100, 0.00, NULL, NULL, 'approved', 17, 1),
(43, 'Vakaras su komanda', '<p><strong>Sveiki, brangūs kolegos!</strong></p><p>Kviečiame Jus į ypatingą vakarą, skirtą mums visiems – komandai, kuri kuria, dirba ir švenčia kartu. Tai bus laikas, kai galima pabėgti nuo kasdienybės, pasimėgauti vasaros nuotaika ir tiesiog pabūti drauge.</p><p><strong>Ką planuojame?</strong></p><p>🌿 Neformalus susitikimas jaukioje aplinkoje</p><p> 🎤 Gyva muzika ir staigmenos vakaro eigoje</p><p> 🍽 Skani vakarienė, desertų kampelis ir gėrimai</p><p> 🎉 Žaidimai, juokas ir komandos stiprinimo veiklos</p><p> 🏆 Maži apdovanojimai ir padėkos už šių metų pastangas</p><p>Tegul tai būna vakaras, kupinas įkvėpimo, juoko ir bendrystės!</p><p><br></p><p><strong>Nepamirškite:</strong></p><p> ✔️ Patogios aprangos</p><p> ✔️ Geros nuotaikos</p><p> ✔️ Šypsenos kolegoms</p><p><strong>Iki greito susitikimo!</strong></p><p> 💛 <em>Jūsų [Įmonės pavadinimas] komanda</em></p>', 'Komandinis renginys', 'Aukštaičių g. 7, Vilnius', '2025-07-22', '18:19:00', 11, 0.00, NULL, NULL, 'approved', 21, 1),
(44, 'Įmonės susitikimas', '<p><strong>Gerbiami kolegos,</strong></p><p><br></p><p>Artėjant rudeniui kviečiame Jus susitikti jaukiame renginyje, skirtame pasidalinti metų įspūdžiais, aptarti ateities planus ir tiesiog gerai praleisti laiką kartu.</p><p>Renginys vyks šiltame ir draugiškame atmosferos užtaise, kur lauks:</p><ol><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span>Įdomūs pranešimai ir trumpi seminarai</li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span>Komandos veiklos, kurios sustiprins tarpusavio ryšius</li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span>Gardūs užkandžiai ir užkandžių stalas</li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span>Muzikiniai pasirodymai ir netikėtos pramogos</li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span>Laikinas atsipalaidavimas nuo kasdienybės ir darbo rūpesčių</li></ol><p>Tai puiki proga susitikti su kolegomis neformalioje aplinkoje, pasisemti naujų idėjų ir kartu švęsti pasiekimus.</p>', 'Mokymai', 'Tiltų g. 12, Kuršėnai', '2025-08-18', '12:22:00', 78, 0.00, NULL, NULL, 'pending', 4, 5),
(45, 'Tarptautinė technologijų konferencija', '<p><strong>Gerbiami kolegos,</strong></p><p><br></p><p>Kviečiame Jus dalyvauti <strong>Tarptautinėje technologijų konferencijoje 2025</strong>, kuri vyks <strong>2025 m. lapkričio 12–14 d.</strong> Vilniuje, <strong>Lietuvos parodų ir kongresų centre</strong>.</p><p><br></p><p>Šios konferencijos tikslas – pristatyti naujausias inovacijas technologijų srityje, skatinti žinių mainus tarp specialistų, akademikų ir verslo atstovų bei stiprinti tarptautinį bendradarbiavimą.</p><p>Konferencijoje Jūsų laukia:</p><ol><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span>Įkvepiančios pranešimų sesijos apie dirbtinį intelektą, debesų kompiuteriją, kibernetinį saugumą ir kt.</li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span>Panelių diskusijos su žinomais pramonės ekspertais</li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span>Praktiniai seminarai ir dirbtuvės</li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span>Paroda, kurioje galėsite susipažinti su naujausiomis technologijomis ir sprendimais</li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span>Tinklaveikos renginiai ir neformalūs susitikimai</li></ol><p><br></p>', 'Mokymai', 'Laisvės pr. 5, Vilniu', '2025-10-12', '15:23:00', 148, 0.00, NULL, NULL, 'pending', 0, 5),
(46, 'Verslo inovacijų konferencija 2025', '<p><strong>Mieli verslo partneriai,</strong></p><p><br></p><p>Kviečiame Jus dalyvauti <strong>Verslo inovacijų konferencijoje 2025</strong>, kuri vyks <strong>2025 m. rugsėjo 22 d.</strong> Kaune, <strong>Verslo centre „Kauno tiltai“</strong>.</p><p>Ši konferencija skirta pristatyti naujausias verslo tendencijas, inovatyvius sprendimus ir efektyvias strategijas, kurios padės Jūsų įmonei augti ir prisitaikyti prie sparčiai besikeičiančios rinkos.</p><p>Konferencijos metu Jūsų laukia:</p><ol><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span>Įkvepiančios kalbos iš verslo lyderių ir inovacijų ekspertų</li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span>Praktiniai seminarai apie skaitmenines transformacijas ir tvarų verslą</li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span>Panelių diskusijos apie rinkos ateitį ir naujas galimybes</li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span>Tinklaveikos renginiai ir galimybė užmegzti vertingus verslo ryšius</li></ol><p><br></p>', 'Seminaras', 'Laisvės al. 29, Kaunas', '2025-09-22', '15:24:00', 250, 0.00, NULL, NULL, 'approved', 3, 5),
(47, 'Aplinkosaugos ir tvarumo mokymai 2025', '<p><strong>Gerbiami dalyviai,</strong></p><p><br></p><p><em>Kviečiame Jus į </em><strong><em>Aplinkosaugos ir tvarumo konferenciją 2025</em></strong><em>, kuri vyks </em><strong><em>2025 m. spalio 8 d.</em></strong><em> Vilniuje, </em><strong><em>Žalgirio g. 10, konferencijų centre <u><a href=\"„EcoHub“.\" rel=\"noopener noreferrer\" target=\"_blank\">„EcoHub“</a></u></em></strong><em><u><a href=\"„EcoHub“.\" rel=\"noopener noreferrer\" target=\"_blank\">.</a></u></em></p><p><br></p><p>Konferencijos tikslas – skatinti dialogą apie aplinkosaugos iššūkius ir tvarius sprendimus verslo, mokslo ir valdžios sektoriuose. Dalyvaudami galėsite išgirsti naujausias tendencijas, pasidalinti patirtimi ir susipažinti su inovatyviomis idėjomis.</p><p>Konferencijoje laukia:</p><ol><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span>Pranešimai apie klimato kaitos mažinimo strategijas</li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span>Panelių diskusijos su ekspertais iš Lietuvos ir užsienio</li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span>Darbo grupių sesijos praktiniams sprendimams kurti</li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span>Parodos, pristatančios tvarius produktus ir technologijas</li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span>Tinklaveikos renginiai ir partnerystės galimybės</li></ol><p><br></p>', 'Mokymai', 'Žalgirio g. 10, Vilnius', '2025-10-08', '12:25:00', 5, 0.00, NULL, NULL, 'approved', 20, 5),
(48, 'Efektyvaus komandų valdymo mokymai', '<p><strong>Gerbiami kolegos,</strong></p><p>Kviečiame Jus dalyvauti <strong>Efektyvaus komandų valdymo mokymuose</strong>, kurie vyks <strong>2025 m. birželio 10 d.</strong> Vilniuje, <strong>Savanorių pr. 45</strong>.</p><p>Šių mokymų metu sužinosite, kaip:</p><ol><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span>Kurti ir stiprinti komandų bendradarbiavimą</li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span>Efektyviai spręsti konfliktus darbe</li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span>Motyvuoti ir įtraukti komandos narius</li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span>Tobulinti savo vadovavimo įgūdžius</li><li data-list=\"bullet\"><span class=\"ql-ui\" contenteditable=\"false\"></span>Pagerinti komunikaciją ir darbo organizavimą</li></ol><p>Mokymai skirti visiems, kurie siekia tobulinti savo lyderystės gebėjimus ir kurti produktyvias darbo komandas.</p>', 'Mokymai', 'Savanorių pr. 45, Vilnius', '2025-06-25', '15:27:00', 77, 0.00, NULL, NULL, 'approved', 30, 5),
(50, 'renginys', '<p><strong>Įveskite tekstą...</strong></p>', 'Šventė', 'Kalvarijų 129', '2025-05-22', '16:16:00', 1, 0.00, NULL, NULL, 'approved', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `rezervacijos`
--

CREATE TABLE `rezervacijos` (
  `id` int NOT NULL,
  `vartotojo_id` int NOT NULL,
  `renginio_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rezervacijos`
--

INSERT INTO `rezervacijos` (`id`, `vartotojo_id`, `renginio_id`) VALUES
(15, 1, 48),
(16, 1, 41),
(17, 1, 43);

-- --------------------------------------------------------

--
-- Table structure for table `vartotojai`
--

CREATE TABLE `vartotojai` (
  `id` int NOT NULL,
  `slaptazodis` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `el_pastas` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `vardas` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pavarde` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sukurtas` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `profilio_nuotrauka` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `role` enum('admin','vartotojas') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'vartotojas',
  `komanda` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vartotojai`
--

INSERT INTO `vartotojai` (`id`, `slaptazodis`, `el_pastas`, `vardas`, `pavarde`, `sukurtas`, `profilio_nuotrauka`, `role`, `komanda`) VALUES
(1, '0192023a7bbd73250516f069df18b500', 'admin@admin.com', 'Admin', 'Admin', '2025-04-27 17:01:13', 'images/pfp_1_6838a522720d9.jpg', 'admin', NULL),
(5, '092e859d508456d35d09b32971b2a50f', 'paulius@vvk.lt', 'Paulius', 'Savičiūnas', '2025-05-27 18:28:48', 'images/default-pfp.jpg', 'admin', NULL),
(9, '8f8aaec60360bb86581450cf3eb08ed7', 'user@user.lt', 'Svečias', 'S', '2025-05-29 22:04:45', 'images/default-pfp.jpg', 'vartotojas', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `atsiliepimai`
--
ALTER TABLE `atsiliepimai`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vartotojo_id` (`vartotojo_id`),
  ADD KEY `renginio_id` (`renginio_id`);

--
-- Indexes for table `isiminti`
--
ALTER TABLE `isiminti`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `renginio_nuotraukos`
--
ALTER TABLE `renginio_nuotraukos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `renginys_id` (`renginys_id`);

--
-- Indexes for table `renginys`
--
ALTER TABLE `renginys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rezervacijos`
--
ALTER TABLE `rezervacijos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vartotojo_id` (`vartotojo_id`),
  ADD KEY `renginio_id` (`renginio_id`);

--
-- Indexes for table `vartotojai`
--
ALTER TABLE `vartotojai`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `el_pastas` (`el_pastas`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `atsiliepimai`
--
ALTER TABLE `atsiliepimai`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `isiminti`
--
ALTER TABLE `isiminti`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `renginio_nuotraukos`
--
ALTER TABLE `renginio_nuotraukos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `renginys`
--
ALTER TABLE `renginys`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `rezervacijos`
--
ALTER TABLE `rezervacijos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `vartotojai`
--
ALTER TABLE `vartotojai`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `atsiliepimai`
--
ALTER TABLE `atsiliepimai`
  ADD CONSTRAINT `atsiliepimai_ibfk_1` FOREIGN KEY (`vartotojo_id`) REFERENCES `vartotojai` (`id`),
  ADD CONSTRAINT `atsiliepimai_ibfk_2` FOREIGN KEY (`renginio_id`) REFERENCES `renginys` (`id`);

--
-- Constraints for table `renginio_nuotraukos`
--
ALTER TABLE `renginio_nuotraukos`
  ADD CONSTRAINT `renginio_nuotraukos_ibfk_1` FOREIGN KEY (`renginys_id`) REFERENCES `renginys` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rezervacijos`
--
ALTER TABLE `rezervacijos`
  ADD CONSTRAINT `rezervacijos_ibfk_1` FOREIGN KEY (`vartotojo_id`) REFERENCES `vartotojai` (`id`),
  ADD CONSTRAINT `rezervacijos_ibfk_2` FOREIGN KEY (`renginio_id`) REFERENCES `renginys` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
