<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Phone.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate Phone object

$post = new Phone($db);

// Phone query

$result = $post->read();
// Get row count
$num = $result->rowCount();

// Check if any phone
if($num>0){
    //Phone array
    $posts_arr = array();
    $post_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $post_item = array(
            'id' => $id,
            'phone_number' => $phone_number,
            'sms' => $sms,
            'voice_mail' => $voice_mail,
            'created_date' => $created_date,
            'last_updated' => $last_updated
        );
        // Push to "data"
        array_push($post_arr['data'],$post_item);
    }
    // Turn to Json $ output
    echo json_encode($post_arr);
} 
else {
    // No Phones
    echo json_encode(
        array('message' => 'No Phone Found')
    );
}

?>