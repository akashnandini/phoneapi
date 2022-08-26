<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Phone.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate post object
$post = new Phone($db);

// Get id
$post->phone_number = isset($_GET['phone_number'])? $_GET['phone_number'] : die();
$post->phone_number = preg_replace("/^\+?(\d?)\s?\(?(\d?\d?\d?)\)?\s*\-?(\d?\d?\d?)?\s*\-?(\d?\d?\d?\d?)\s*?$/", "$1$2$3$4", $post->phone_number);


// Get Phone
if($post->share_phone())
{
    $post->phone_number = strrev($post->phone_number);
    $post_arr = array(
        'phone_number' => $post->phone_number,
        'sms' => $post->sms,
        'voice_mail' => $post->voice_mail,
        'created_date' => $post->created_date,
        'last_updated' => $post->last_updated
    );
    //Make Json
    print_r(json_encode($post_arr));
}
else {
    // No Phones
    echo json_encode(
        array('message' => 'No Phone Found')
    );
}



?>