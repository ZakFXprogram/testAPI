<?php
  // Adresse de l'API
  $API = "https://potterhead-api.vercel.app/api";

  // Quel onglet ? (par défaut : houses)
  $page  = $_GET['page']  ?? 'houses';
  $house = $_GET['house'] ?? null;

  // Petite fonction qui appelle l'API et renvoie un tableau PHP
  function api($url) {
    $json = file_get_contents($url);
    return json_decode($json, true);
  }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Potterhead</title>
  <link href="style.css" rel="stylesheet">
</head>
<body>

  <!-- HEADER -->
  <header>
    <h1>⚡ Potterhead</h1>
  </header>

  <!-- NAV : 2 onglets -->
  <nav>
    <a href="?page=houses">Houses</a>
    <a href="?page=movies">All Movies</a>
  </nav>

  <!-- ZONE D'AFFICHAGE -->
  <main>
  <?php

    // DÉTAIL D'UNE MAISON : on affiche ses personnages
    if ($house) {
      $eleves = api("$API/houses/" . urlencode($house));
      echo "<h2>" . htmlspecialchars($house) . "</h2>";
      foreach ($eleves as $e) {
        echo '<div class="card">';
        echo   '<img src="' . $e['image'] . '" onerror="this.style.display=\'none\'">';
        echo   '<h3>' . $e['name'] . '</h3>';
        echo   '<p>Acteur : ' . $e['actor'] . '</p>';
        echo '</div>';
      }
    }

    // ONGLET 2 : LES FILMS
    elseif ($page == 'movies') {
      $films = api("$API/movies");
      echo "<h2>Les Films</h2>";
      foreach ($films as $film) {
        echo '<div class="card">';
        echo   '<img src="' . $film['poster'] . '">';
        echo   '<h3>' . $film['title'] . '</h3>';
        echo   '<p>Sortie : ' . $film['release_date'] . '</p>';
        echo '</div>';
      }
    }

    // ONGLET 1 (par défaut) : LES MAISONS
    else {
      $maisons = api("$API/houses");
      echo "<h2>Les Maisons</h2>";
      foreach ($maisons as $maison) {
        echo '<a class="card" href="?house=' . urlencode($maison) . '">' . htmlspecialchars($maison) . '</a>';
      }
    }
  ?>
  </main>

  <!-- FOOTER -->
  <footer>
    <p>© 2026 Potterhead — TP API REST</p>
  </footer>

</body>
</html>
