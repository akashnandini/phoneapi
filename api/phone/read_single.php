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
$post->id = isset($_GET['id'])? $_GET['id'] : die();

// Get Phone
if($post->read_single())
{
    $post_arr = array(
        'id' => $post->id,
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