<?php

 require_once 'twitteroauth.php';
 
// just enter your twitter tokens 
 $oTwitter = new TwitterOAuth 
(   'API Key',
'API Secret',
'Access Token',
'Access Token Secret');
 $e = 1;
$cursor = -1;
$full_followers = array();
do {

$follows = $oTwitter->get("followers/ids.json?screen_name=avadFa&cursor=".$cursor);

$foll_array = (array)$follows;

  foreach ($foll_array['ids'] as $key => $val) {

       echo $full_followers[$e] = $val;
       echo '</br>';
        $e++; 
  }
       $cursor = $follows->next_cursor;

  } while ($cursor > 0);
echo "Number of following:" .$e. "<br /><br />";

$e = 1;
$cursor = -1;
$full_friends = array();
do {

  $follow = $oTwitter->get("friends/ids.json?screen_name=avadFa&cursor=".$cursor);
  $foll_array = (array)$follow;

  foreach ($foll_array['ids'] as $key => $val) {

        $full_friends[$e] = $val;
        $e++;
  }
      $cursor = $follow->next_cursor;

} while ($cursor > 0);

$index=1;
$unfollow_total=0;
foreach( $full_friends as $iFollow )
{
$isFollowing = in_array( $iFollow, $full_followers );

echo "$iFollow: ".( $isFollowing ? 'OK' : '!!!' )."<br/>";
$index++;
 if( !$isFollowing )
    {
    $parameters = array( 'user_id' => $iFollow );
    $status = $oTwitter->post('friendships/destroy', $parameters);
    $unfollow_total++;
    } if ($unfollow_total === 999) break;
}


$index=1;
$follow_total = 0;
foreach( $full_followers as $heFollows )
{
$amFollowing = in_array( $heFollows, $full_friends );

echo "$heFollows: ".( $amFollowing ? 'OK' : '!!!' )."<br/>";
 $index++;
 if( !$amFollowing )
    {
    $parameters = array( 'user_id' => $heFollows );
    $status = $oTwitter->post('friendships/create', $parameters);
    $follow_total++;
    } if ($follow_total === 999) break;
}

echo 'UnFollowed:'.$unfollow_total.'<br />';
echo 'Followed:'.$follow_total.'<br />';

?>