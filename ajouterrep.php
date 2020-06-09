<?php
if (isset($_POST['submitrep'])) {

  // si le nom de répertoire est vide
  if (empty($_POST['namerep'])) {
    header('Location: index.php?action=norep');
    exit();
  }

  else {
    // Si le répertoire n'existe pas...
    if (!file_exists($_POST['namerep'])) {
      $nom_file = htmlspecialchars($_POST['namerep']);

      // création du répertoire...
      mkdir($nom_file, 0700);

      // ... on renvoie sur la page principale du files explorer
      header('Location: ../files-explorer');
    }
    else {
      // si le fichier existe déjà on renvoie sur un message d'erreur
      header('Location: index.php?action=rep_exists');
      exit();
    }
  }
}

else {
    echo "Vous ne pouvez pas accéder à cette page directement.";
}
?>
