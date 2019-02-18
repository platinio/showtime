<?php

include "includes/config.php";

$dom = file_get_html('https://www.imdb.com/title/tt4154756/reviews?ref_=tt_ql_3', false);

if(!empty($dom))
{
  $divclass = "";
  $title = "";
  $i = 0;

  foreach ($dom->find(".review-container") as $divclass)
  {

  }
}

 ?>
