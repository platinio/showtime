<?php

include "includes/config.php";

$dom = file_get_html('https://www.imdb.com/title/tt4154756/reviews?ref_=tt_ov_rt');
//print_r($dom);

$answer = array();

if(!empty($dom))
{
  $divclass = "";
  $title = "";
  $i = 0;

  foreach ($dom->find(".review-container") as $divclass)
  {

    foreach($divclass->find(".title") as $title)
    {
      $answer[$i]["title"] = $title->plaintext;
    }

    foreach($divclass->find(".ipl-ratings-bar") as $ipl_ratings_bar)
    {
      $answer[$i]["rate"] = trim($ipl_ratings_bar->plaintext);
    }

    foreach($divclass->find("div[class=text show-more__control]") as $desc)
    {
      $text = html_entity_decode($desc->plaintext);
      $text = preg_replace('/\&#39;/', "", $text);

      $answer[$i]['content'] = html_entity_decode($text);
    }

    $i++;

  }

}

print_r($answer);


 ?>
