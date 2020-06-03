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

	        <nav aria-label="breadcrumb">
  		        <ol class="breadcrumb">
    		         <li class="breadcrumb-item"><a href="#">Home</a></li>
    		         <li class="breadcrumb-item"><a href="#">Library</a></li>
    		         <li class="breadcrumb-item active" aria-current="page">Data</li>
  		        </ol>
	       </nav>

      </div>
    </div>
  </div>

<div class="container">
  <div class="row">
    <div class="col-sm mt-3">
<?php
  $url = 'C:\wamp64\www\olivier\files-explorer';
  $contents = scandir($url);
?>

<table class="table table-sm table-hover mb-5">
  <thead>
    <tr>
      <th scope="col">Nom</th>
      <th scope="col">Taille</th>
      <th scope="col">Type</th>
      <th scope="col">Propriétaire</th>
      <th scope="col">Date modif</th>
    </tr>
  </thead>
  <tbody>
<?php
  foreach ($contents as $item) {
     $size = "<span style='font-size:12px;'>".filesize($item)."</span>";
     $type = "<span style='font-size:12px;'>".mime_content_type($item)."</span>";
     $date = "<span style='font-size:12px;'>".date("d-m-Y H:i:s", filemtime($item))."</span>";
     $owner = "<span style='font-size:12px;'>".fileowner($item)."</span>";

     if (is_dir("$item")) {
        echo "<tr><td><i class=\"fas fa-folder-open\"></i> <a href=\"".$item."\">$item</a></td><td>$size<td>$type</td><td>".$owner."</td><td>$date</td>";
     }
     else {
        echo "<tr><td><i class=\"fas fa-file\"></i> <a href=\"".$item."\">$item</a></td><td>$size</td><td>$type</td><td>$owner</td><td>$date</td></tr>";
     }
  }
  echo "</tbody></table>";
?>
  </div>
</div>
</div>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>

</html>
