<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Phone.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate post object

$post = new Phone($db);

// Get raw posted data 
$data = json_decode(file_get_contents("php://input"));

$post->phone_number = $data->phone_number;
$post->sms = $data->sms;
$post->voice_mail = $data->voice_mail;
$post->created_date = $data->created_date;
$post->last_updated = $data->last_updated;

// Create post
if($post->create()){
    echo json_encode(
        array('message' => 'Phone Created')
    );
} else {
    echo json_encode(
        array('message' => 'Phone Exists')
    );
}

?>