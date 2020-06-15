<?php

function simplePath($dir) {
  if($dir == '') return './';
    $dir = str_replace('//', '/', str_replace('\\', '/', $dir));
    if($dir[strlen($dir)-1] != '/') $dir .= '/';
    return $dir;
}

if(!empty($_GET['dir'])){
  $dir = simplePath($_GET['dir']);
}
else{
  $dir = './';
}

$opendir = false;
if(is_dir($dir)){
  $opendir = opendir($dir);
}
if(!$opendir) {
  $dir = './';
  $opendir = opendir('./') or die();
}

echo '<div class="bg-info mt-3 text-white px-3 py-2">Chemin : <a class="text-white" href="?dir=./">Root</a> '.$dir.'</div>';

if(substr($dir, 0, 2) == './'){
  $dir = substr($dir, 2);
}

?>
