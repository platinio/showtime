<?php

include "includes/config.php";

//$dom = file_get_html('https://www.cinecalidad.to/');
$dom = file_get_html('https://www.cinecalidad.to/page/12/');

$favoritetags = array('Accion',
                      'Comedia',
                      'Ciencia ficción',
                      'Animación',
                      'Aventura',
                      'Fantasía');

$favoriteactors = array('Tom Cruise',
                        'Denzel Washington',
                        'Mark Wahlberg',
                        'Sandra Bullock',
                        'Chris Pratt',
                        'Keanu Reeves',
                        'Tom Hardy',
                        'Chris Pine',
                        'Dwayne Johnson',
                        'Ryan Reynolds',
                        'Robert Downey Jr',
                        'Chris Evans',
                        'Chris Hemsworth',
                        'Jason Momoa',
                        'Brad Pitt',
                        'Scarlett Johansson',
                        'Julia Roberts',
                        'Robin Williams',
                        'Cuba Gooding Jr.',
                        'Tom Hanks',
                        'Jeremy Renner',
                        'Matt Damon',
                        'Hugh Jackman',
                        'Sylvester Stallone',
                        'Christian Bale',
                        'Jason Statham',
                        '');


$answer = array();

if(!empty($dom))
{
  $divclass = "";
  $title = "";
  $i = 0;

  foreach ($dom->find(".post_box") as $divclass)
  {

    foreach($divclass->find("img") as $img)
    {
      $answer[$i]["title"] = $img->title;
    }

    foreach($divclass->find("a") as $anchor)
    {
      $answer[$i]["link"] = $anchor->href;
    }

    $moviedom = file_get_html($answer[$i]["link"]);



    $answer[$i]["score"] = explode("/" , $moviedom->find("#imdb-box")[0]->find("a")[0]->plaintext)[0];


    foreach($moviedom->find("p span") as $span)
    {
      if(strpos($span->plaintext , 'Género:') !== false)
      {
        $tagArray = explode( '|' , $span->plaintext );

        $n = 0;
        foreach ($tagArray as $tag)
        {
          $answer[$i]["tags"][$n] = str_replace(' ' , '' ,str_replace("Género:","",$tag));
          $n++;
        }
      }

      if(strpos($span->plaintext , 'Elenco:') !== false)
      {
        $tagArray = explode( ',' , $span->plaintext );

        $n = 0;
        foreach ($tagArray as $tag)
        {
          $answer[$i]["actors"][$n] = str_replace(' ' , '' , str_replace("Elenco:","",$tag));
          $n++;
        }
      }



    }

    /*
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
    */
    $i++;

  }

}

$moviescore = 0;
$moviecleandata = array();
$i = 0;
foreach ($answer as $movie)
{
  $moviecleandata[$i]['title'] = $movie['title'];

if($movie['score'] >= 7)
{

  $moviecleandata[$i]['score'] = 1.7;
}
else if ($movie['score'] > 6.5)
{
  $moviecleandata[$i]['score'] = 1.0;
}
else if($movie['score'] > 6)
{
  $moviecleandata[$i]['score'] = 0.5;
}
else
{
    $moviecleandata[$i]['score'] = 0;
}



  for($j = 0 ; $j < count($favoriteactors) ; $j++)
  {
    if(array_search( str_replace(' ' , '' , $favoriteactors[$j]) , $movie['actors']) !== false)
    {

      $moviecleandata[$i]['score'] += 0.8 ;
      break;
    }
  }

  for($j = 0 ; $j < count($favoritetags) ; $j++)
  {
    if(array_search( str_replace(' ' , '' ,  $favoritetags[$j]) , $movie['tags']) !== false)
    {

      $moviecleandata[$i]['score'] += 0.5;
      break;
    }
  }

  $moviecleandata[$i]['score'] = ($moviecleandata[$i]['score'] / 3) * 10;

  $i++;
}

print_r($moviecleandata);


 ?>
