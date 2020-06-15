<html>
<head>
  <title>files 2</title>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
  <style>
  .breadcrumb-container {
  width: 100%;
  background-color: #f8f8f8;
  border-bottom-color: 1px solid #f4f4f4;
  list-style: none;
  margin-top: 72px;
  min-height: 25px;
  box-shadow: 0 3px 0 rgba(60, 57, 57, .2)
}

.breadcrumb-container li {
  display: inline
}
.breadcrumb {
  font-size: 12px;
  padding-top: 3px
}
.breadcrumb>li:last-child:after {
  content: none
}

.breadcrumb>li:last-child {
  font-weight: 700;
  font-style: italic
}
.breadcrumb>li>i {
  margin-right: 3px
}

.breadcrumb>li:after {
  font-family: FontAwesome;
  content: "\f101";
  font-size: 11px;
  margin-left: 3px;
  margin-right: 3px
}
.breadcrumb>li+li:before {
  font-size: 11px;
  padding-left: 3px
}
  </style>
</head>
<body>
<?php
function breadcrumbs($home = 'Home') {
  global $page_title; //global varable that takes it's value from the page that breadcrubs will appear on. Can be deleted if you wish, but if you delete it, delete also the title tage inside the <li> tag inside the foreach loop.
    $breadcrumb  = '<div class="breadcrumb-container"><div class="container"><ol class="breadcrumb">';
    $root_domain = 'http://' . $_SERVER['HTTP_HOST'].'/';
    $breadcrumbs = array_filter(explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)));
    $breadcrumb .= '<li><i class="fa fa-home"></i><a href="' . $root_domain . '" title="Home Page"><span>' . $home . '</span></a></li>';
    foreach ($breadcrumbs as $crumb) {
        $link = ucwords(str_replace(array(".php","-","_"), array(""," "," "), $crumb));
        $root_domain .=  $crumb . '/';
        $breadcrumb .= '<li><a href="'. $root_domain .'" title="'.$page_title.'"><span>' . $link . '</span></a></li>';
    }
    $breadcrumb .= '</ol>';
    $breadcrumb .= '</div>';
    $breadcrumb .= '</div>';
    return $breadcrumb;
}

echo breadcrumbs();
?>
</body>
</html>
