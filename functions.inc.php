<?php

function generateLink($url, $label, $class) {
   $link = '<a href="' . $url . '" class="' . $class . '">';
   $link .= $label;
   $link .= '</a>';
   return $link;
}


function outputPostRow($number)  {
    include("travel-data.inc.php");
    $row = '<div class="row"><div class="col-md-4">';
    $url = "postId";
    $url .= $number;
    $image = "thumb";
    $image .= $number;
    $label = '<img src="images/';
    $label .= $$image;
    $label .='" alt="';
    $title = "title";
    $title .= $number;
    $label .= $$title;
    $label .= '" class="img-responsive"/>';
    $row .= generateLink($$url,$label,"");
    $row .= '</div>';

    $row .= '<div class="col-md-8"><h2>';
    $row .= $$title;
    $row .= '</h2><div class="details">Posted by ';
    $url = "userId";
    $url .= $number;
    $data = "userName";
    $data .= $number;
    $label = $$data;
    $row .= generateLink($$url,$label,"");
    $row .= '<span class="pull-right">';
    $data = "date";
    $data .= $number;
    $row .= $$data;
    $row .= '</span><p class="ratings">';
    $data = "reviewsRating";
    $data .= $number;
    $row .= constructRating($$data);
    $row .= ' ';
    $data = "reviewsNum";
    $data .= $number;
    $row .= $$data;
    $row .= ' Reviews</p></div><p class="excerpt">';
    $data = "excerpt";
    $data .= $number;
    $row .= $$data;
    $row .= '</p><p>';
    $url = "postId";
    $url .= $number;
    $row .= generateLink($$url,'Read more',"btn btn-primary btn-sm");
    $row .= "</div></div><hr>";
    echo $row;
}

/*
  Function constructs a string containing the <img> tags necessary to display
  star images that reflect a rating out of 5
*/
function constructRating($rating) {
    $imgTags = "";
    
    // first output the gold stars
    for ($i=0; $i < $rating; $i++) {
        $imgTags .= '<img src="images/star-gold.svg" width="16" />';
    }
    
    // then fill remainder with white stars
    for ($i=$rating; $i < 5; $i++) {
        $imgTags .= '<img src="images/star-white.svg" width="16" />';
    }    
    
    return $imgTags;    
}

?>

