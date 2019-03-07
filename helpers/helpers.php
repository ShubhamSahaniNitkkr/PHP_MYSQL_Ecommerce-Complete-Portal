<?php
function display_errors($errors){
  $display = '<ul class="bg-warning">';
  foreach ($errors as $error) {
    $display .= '<li class="">'.$error.'</li>';
  }
  $display .='</ul>';
  return $display;
}

function sanitize($dirty){
  return htmlentities($dirty,ENT_QUOTES,"UTF-8");
}
 ?>
