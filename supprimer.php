?<?php
// Si le fichier a été défini et s'il existe...
if (isset($_GET['id']) && $_GET['id']) {
    $id = $_GET['id'];
    unlink($id); // On le supprime
    header('Location: ../files-explorer');
  }
?>
