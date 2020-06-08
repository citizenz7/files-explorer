<?php
// si on a cliqué sur le bouton "Créer un nouveau fichier"...
if (isset($_GET['submit'])) {

  // si le nom de fichier est vide
  if (empty($_GET['name'])) {
    header('Location: ../files-explorer/index.php?action=nofile');
    exit;
  }

  else {
    $nom_file = htmlspecialchars($_GET['name']);

    // création du fichier
    $f = fopen($nom_file, "x+");

    // fermeture
    fclose($f);

    // on renvoie sur la page principale du files explorer
    header('Location: ../files-explorer');
  }

}
?>
