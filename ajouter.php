<?php

// si on a cliqué sur le bouton "Créer un nouveau fichier"...
if (isset($_POST['submit'])) {

  // si le nom de fichier est vide
  if (empty($_POST['name'])) {
    header('Location: index.php?action=nofile');
    exit();
  }

  else {
    // Si le fichier n'existe pas...
    if (!file_exists($_POST['name'])) {
      $nom_file = htmlspecialchars($_POST['name']);

      // création du fichier
      $f = fopen($nom_file, "x+");

      // fermeture
      fclose($f);

      // on renvoie sur la page principale du files explorer
      header('Location: ../files-explorer');
    }
    else {
      // si le fichier existe déjà on renvoie sur un message d'erreur
      header('Location: index.php?action=file_exists');
      exit();
    }
  }
}

else {
    echo "Vous ne pouvez pas accéder à cette page directement.";
}

?>
