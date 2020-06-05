<?php include_once 'functions.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1">
  <title>Files manager</title>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>

<body>

  <div class="container">
    <div class="row">
      <div class="col-sm px-3 py-3 mt-3">
        <h2>Files Manager</h2>
      </div>
    </div>

    <div class="row">
      <div class="col-sm px-3 py-1">

        <?php
        // BREADCRUMBS
        //$url = getcwd();
        $url = "olivier/";

        // analyse l'url et retourne ses composants
        $parts = parse_url($url);

        // retourne les infos sur le chemin du répertoire
        $path = pathinfo($parts['path']);

        // explode sépare chaque élément, trim = supprime les espaces
        $segments = explode('/', trim($path['dirname'],'/'));

        //  $breadcrumbs[] = '<a href="/">Home</a>';
        $crumb_path = '';

        foreach ($segments as $segment)
        {
            $crumb_path .= '/' . $segment;

            // ucfirst : majuscule première lettre du mot
            $value = ucfirst($segment);

            $breadcrumbs[] = '<a href="' . $crumb_path . '">' . $value . '</a>';
        }

        $breadcrumbs[] = ucwords(str_replace('_', ' ', $path['filename']));
        $breadcrumbs   = implode(' > ', $breadcrumbs);

        ?>

        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><?php echo $breadcrumbs; ?></li>
          </ol>
        </nav>

      </div>
    </div>
  </div>

<div class="container">
  <div class="row">
    <div class="col-sm mt-3">

<table class="table table-sm table-hover mb-5">
  <thead>
    <tr>
      <th scope="col">Nom</th>
      <th scope="col">Taille</th>
      <th scope="col">Type</th>
      <th scope="col">Propriétaire</th>
      <th scope="col">Date modif</th>
      <th scope="col">Utils.</th>
    </tr>
  </thead>
  <tbody>

    <?php
    $url = getcwd(); //gets the current working directory
    $contents = scandir($url); //scan the directory

      foreach ($contents as $item) {
         $size = "<span style='font-size:12px;'>".formatSizeUnits(filesize($item))."</span>";
         $type = "<span style='font-size:12px;'>".mime_content_type($item)."</span>";
         $date = "<span style='font-size:12px;'>".date("d-m-Y H:i:s", filemtime($item))."</span>";
         $owner = "<span style='font-size:12px;'>".fileowner($item)."</span>";

         $finfo = finfo_open(FILEINFO_MIME_TYPE);
         $type = finfo_file($finfo, $item);

         if (isset($type) && in_array($type, array("image/png", "image/jpeg", "image/gif"))) {
           //echo 'This is an image file';
           $check = "<i class=\"far fa-image\"></i>";
         }
         else {
           $check = "";
         }

         if (is_dir("$item")) {
            echo "
            <tr>
              <td><i class='fas fa-folder-open'></i> <a href='$item'>$item</a></td>
              <td>$size</td>
              <td>$type</td>
              <td>$owner</td>
              <td>$date</td>
            </tr>
            ";
         }
         else {
            echo "
            <tr>
              <td><i class='fas fa-file'> ".$check."</i> <a href='$item'>$item</a></td>
              <td>$size</td>
              <td>$type</td>
              <td>$owner</td>
              <td>$date</td>
              <td><a href=\"supprimer.php?id=".$item."\" onclick=\"return confirm('Êtes-vous certain de vouloir supprimer ce fichier ?')\"><i class=\"fas fa-trash\"></i></a></td>
            </tr>
            ";
         }
      } //for each
    ?>

  </tbody>
</table>
  </div>
</div>
</div>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>

</html>
