<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>
    <style>
        * {
            box-sizing: border-box;
        }

        /* Create two equal columns that floats next to each other */
        .column {
            float: left;
            width: 15%;
        }
        .columnr {
            float: left;
            width: 15%;
            text-align: right
        }

        .columnl {
            float: left;
            width: 15%;
            text-align: left
        }

        .columnc {
            float: left;
            width: 15%;
            text-align: center;
            background-color:#bbb;
        }

        /* Phone input mask */
        .phone {
            float: left;
        }

        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        /* Style the buttons */
        .btn {
            border: none;
            outline: none;
            padding: 12px 16px;
            background-color: #f1f1f1;
            cursor: pointer;
        }

        .gap {
            height: 10px;
        }
        .btn:hover {
            background-color: #ddd;
        }

        .btn.active {
            background-color: #666;
            color: white;
        }
    </style>

</head>

<body onload='document.form1.text1.focus()'>

    <h2>Phone Registry</h2>

    <p>This application manages the phone numbers of a Company</p>

    <!-- List Header -->
    <div class="row">
        <div class="column" style="background-color:#bbb;">
            <h3>Id</h3>
        </div>
        <div class="column" style="background-color:#bbb;">
            <h3>Phone Number</h3>
        </div>
        <div class="column" style="background-color:#bbb;">
            <h3>SMS</h3>
        </div>
        <div class="column" style="background-color:#bbb;">
            <h3>Voice Mail</h3>
        </div>
        <div class="column" style="background-color:#bbb;">
            <h3>Add / Update</h3>
        </div>
        <div class="column" style="background-color:#bbb;">
            <h3>Delete</h3>
        </div>
    </div>
    <div class="row">
        <div class="column" style="background-color:#fff;">
            <h4>Add Phone Numbers :</h4>
        </div>        
    </div>

    <!-- Row population -->

    <?php
    date_default_timezone_set("America/New_York");

    // Update
    // print("PUT: Update Phone Records:".json_encode($_POST));
    if(isset($_POST['Update'])) 
    {
        $objDateTime = date("Y/m/d h:i:sa");
        // Capture POST variables
        $id = isset($_POST["id"])?$_POST['id']:$_POST["nid"];
        $phone_number = isset($_POST["phone_number"])?$_POST['phone_number']:$_POST["nphone_number"];
        $sms = isset($_POST["sms"])?$_POST['sms']:$_POST["nsms"];
        $voice_mail = isset($_POST["voice_mail"])?$_POST['voice_mail']:$_POST["nvoice_mail"];

        if ($sms=='on'){$sms = 1;} else{$sms = 0;}
        if ($voice_mail=='on'){$voice_mail = 1;} else{$voice_mail = 0;}
        
        // Do preg-replace to store consistent phone number in database
        $phone_number = preg_replace("/^(\+1)\s\((\d{3})\)-(\d{3})\-(\d{4})$/", "$1$2$3$4", $phone_number);

        // Create Post body array
        $post_item = array(
            'id' => $id,
            'phone_number' => $phone_number,
            'sms' => $sms,
            'voice_mail' => $voice_mail,
            'created_date' => $objDateTime,
            'last_updated' => $objDateTime,
        );

        $json_body = json_encode($post_item);
        $phone_url_update_api = 'http://localhost/phone_api/api/phone/update.php?id='.$id;

        # Set context
        $opts = array(
            'http'=>array(
              'method'=>"PUT",
              'header'=>"Content-Type: application/json", 
              'content'=>$json_body
            )
          );
          
        $context = stream_context_create($opts);
        $phone_json_api = file_get_contents($phone_url_update_api,false,$context);
        $phone_array_api = json_decode($phone_json_api,true);
        echo $phone_array_api['message'];
    }

    // Add
    // print_r($_POST);
    if(isset($_POST['Add'])) 
    {
        $objDateTime = date("Y/m/d h:i:sa");
        // Capture POST variables
        $phone_number1 = isset($_POST["phone_number1"])?$_POST['phone_number1']:NULL;
        $sms1 = isset($_POST["sms1"])?$_POST['sms1']:0;
        $voice_mail1 = isset($_POST["voice_mail1"])?$_POST['voice_mail1']:0;

        $sms1 = htmlspecialchars(strip_tags($sms1));
        $voice_mail1 = htmlspecialchars(strip_tags($voice_mail1));

        if ($sms1 == 'on'){$sms1 = 1;} else{$sms1 = 0;}
        if ($voice_mail1 == 'on'){$voice_mail1 = 1;} else{$voice_mail1 = 0;}
        
        // Do preg-replace to store consistent phone number in database
        $phone_number1 = preg_replace("/^(\+1)?\s?\((\d?\d?\d?)\)*\-?(\d?\d?\d?)\-?(\d?\d?\d?\d?)$/", "$1$2$3$4", $phone_number1);

        // echo( $phone_number1);
        // Create Post body array
        if(strlen($phone_number1)==12)
        {
            $add_item1 = array(
                'phone_number' => $phone_number1,
                'sms' => $sms1,
                'voice_mail' => $voice_mail1,
                'created_date' => $objDateTime,
                'last_updated' => $objDateTime,
            );

            $json_body1 = json_encode($add_item1);
            // echo $json_body1;
            $phone_url_add_api = 'http://localhost/phone_api/api/phone/create.php';

            # Set context
            $opts = array(
                'http'=>array(
                'method'=>"POST",
                'header'=>"Content-Type: application/json", 
                'content'=>$json_body1
                )
            );
            
            $context = stream_context_create($opts);
            $phone_json_api = file_get_contents($phone_url_add_api,false,$context);
            $phone_array_api = json_decode($phone_json_api,true);
            echo $phone_array_api['message'];
        }
    }

    // Delete
    if(isset($_POST['Delete'])) 
    {
        // Capture POST variables
        $id = isset($_POST["id"])?$_POST['id']:$_POST["nid"];
        // Create Post body array
        $post_item = array(
            'id' => $id            
        );

        $json_body = json_encode($post_item);
        $phone_url_del_api = 'http://localhost/phone_api/api/phone/delete.php?id='.$id;

        # Set context
        $opts = array(
            'http'=>array(
            'method'=>"DELETE",
              'header'=>"Content-Type: application/json", 
              'content'=>$json_body
            )
          );
          
        $context = stream_context_create($opts);
        $phone_json_api = file_get_contents($phone_url_del_api,false,$context);
        $phone_array_api = json_decode($phone_json_api,true);
        echo $phone_array_api['message'];
    }

 
    // General Load all Phone numbers
    if(isset($_POST['Search']))
    {
        SearchPhoneNumbers();
    }
    else
    {
        listPhoneNumbers();
    }
      
?>

<?php

function listPhoneNumbers(){
    $phone_url_api = 'http://localhost/phone_api/api/phone/read.php';
    $phone_json_api = file_get_contents($phone_url_api);
    $phone_array_api = json_decode($phone_json_api,true);
    //print_r($phone_array_api);
   
    // POST : Add :For Creating records
        echo "<div class='gap'>";
        echo "</div>";
        
        echo "<form name = 'frmadd' method='post' action='#'>";
        echo "<div class='row'>";
        
        echo "<div class='column' style='background-color:#aaa;'>"; 
        echo "<input type = 'text' disabled id = 'id1' name = 'id1' value = 'auto'></div>"; 

        echo "<div class='column' style='background-color:#aaa;'>"; 
        echo "<input type = 'text' class='phone' id = 'phone_number1' name = 'phone_number1' value = ''></div>"; 

        echo "<div class='column' style='background-color:#aaa;'>"; 
        echo "<input type = 'checkbox' id = 'sms1' name = 'sms1'  ></div>";
       
        echo "<div class='column' style='background-color:#aaa;'>"; 
        echo "<input type = 'checkbox' id = 'voice_mail1' name = 'voice_mail1' ></div>";
                
        // Add button
       
        echo "<div class='column' style='background-color:#aaa;'>" ;
        echo "<input type = 'submit' name = 'Add' value = 'Add' onclick=phonenumber(document.frmadd.phone_number1)>";            
        echo "</div>";
        echo "<div class='column' style='background-color:#aaa;'>NA</div>" ;
        echo "</div>";
        echo "</form>";

         // Search Phone
        echo "<div class='gap'>";
        echo "</div>";
        echo "<div class='row'>
        <div class='column' style='background-color:#fff;'>
            <h4>Search Phone Numbers :</h4>
        </div>        
        </div>";

        echo "<form method='post' action='#'>";
        echo "<div class='row'>";
        echo "<div class='column' style='background-color:#aaa;'>"; 
        echo "<input type = 'text' class='phone' id = 'phone_number2' name = 'phone_number2' value = ''></div>"; 
        echo "<div class='column' style='background-color:#fff;'></div>" ;
        echo "<div class='column' style='background-color:#fff;'></div>" ;
        echo "<div class='column' style='background-color:#fff;'></div>" ;
        echo "<div class='column' style='background-color:#fff;'></div>" ;
        echo "<div class='column' style='background-color:#fff;'>"; 
        echo "<input type = 'submit' name = 'Search' value = 'Search'>";            
        echo "</div>";
        echo "<div class='column' style='background-color:#fff;'></div>" ;      
        echo "</form>";
        echo "</div>";
        
       
        echo "<div class='gap'>";
        echo "</div>";
        

        // List Phones
        echo "<div class='row'>
        <div class='column' style='background-color:#fff;'>
            <h4>Phone Registry :</h4>
        </div>        
        </div>";

    // For List Population
    foreach($phone_array_api['data'] as $phone_arr)
    {
        $id = $phone_arr['id'];
        $phone_number = $phone_arr['phone_number'];
        $sms = $phone_arr['sms'];
        $voice_mail = $phone_arr['voice_mail'];

        echo "<form method='post' action='#'>";
        echo "<div class='row'>";
        
        echo "<div class='column' style='background-color:#aaa;'>"; 
        echo "<input type = 'text' disabled id = 'id' name = 'id' value = $id></div>"; 

        echo "<div class='column' style='background-color:#aaa;'>"; 
        echo "<input type = 'text' class='phone' id = 'phone_number' name = 'phone_number' value = $phone_number></div>"; 

        echo "<div class='column' style='background-color:#aaa;'>"; 
        if($sms){echo "<input type = 'checkbox' id = 'sms' name = 'sms' checked></div>";}
        else{echo "<input type = 'checkbox' id = 'sms' name = 'sms' ></div>";}

        echo "<div class='column' style='background-color:#aaa;'>"; 
        if($voice_mail){echo "<input type = 'checkbox' id = 'voice_mail' name = 'voice_mail' checked></div>";}
        else{echo "<input type = 'checkbox' id = 'voice_mail' name = 'voice_mail' ></div>";}
        
        // edit button
       
            echo "<div class='column' style='background-color:#aaa;'>" ;
            echo "<input type = 'submit' name = 'Update' value = 'Update'>";
            echo "<input type = 'hidden' id = 'nid' name = 'nid' value = $id>"; 
            echo "<input type = 'hidden' id = 'nphone_number' name = 'nphone_number' value = $phone_number>";
            echo "<input type = 'hidden' id = 'nsms' name = 'nsms' value = $sms>"; 
            echo "<input type = 'hidden' id = 'nvoice_mail' name = 'nvoice_mail' value = $voice_mail>"; 
            echo "</div>";

        // Delete
            echo "<div class='column' style='background-color:#aaa;'>" ;
            echo "<input type = 'submit' name = 'Delete' value = 'Delete'></div>";
            echo "<input type = 'hidden' id = 'nid' name = 'nid' value = $id>"; 
       
        
        echo "</div>";
        echo "</form>";
        
    }
    
    
}

function SearchPhoneNumbers(){
    // Capture POST variables
    $phone_number = isset($_POST['phone_number2'])?$_POST['phone_number2']:NULL;
    
    // Create Post body array
    $phone_number = htmlspecialchars(strip_tags($phone_number));
    $phone_number = str_replace("_", "", $phone_number);
    // Do preg-replace to store consistent phone number in database
    $phone_number = preg_replace("/^\+1?\s?\((\d?\d?\d?)\)*\-?(\d?\d?\d?)\-?(\d?\d?\d?\d?)$/", "$1$2$3", $phone_number);
    $phone_url_search_api = 'http://localhost/phone_api/api/phone/search.php?phone_number='.$phone_number;

    $phone_json_api = file_get_contents($phone_url_search_api);
    $phone_array_api = json_decode($phone_json_api,true);
    
    // POST : Add :For Creating records
        echo "<div class='gap'>";
        echo "</div>";
        
        echo "<form name = 'frmadd' method='post' action='#'>";
        echo "<div class='row'>";
        
        echo "<div class='column' style='background-color:#aaa;'>"; 
        echo "<input type = 'text' disabled id = 'id1' name = 'id1' value = 'auto'></div>"; 

        echo "<div class='column' style='background-color:#aaa;'>"; 
        echo "<input type = 'text' class='phone' id = 'phone_number1' name = 'phone_number1' value = ''></div>"; 

        echo "<div class='column' style='background-color:#aaa;'>"; 
        echo "<input type = 'checkbox' id = 'sms1' name = 'sms1'  ></div>";
       
        echo "<div class='column' style='background-color:#aaa;'>"; 
        echo "<input type = 'checkbox' id = 'voice_mail1' name = 'voice_mail1' ></div>";
                
        // Add button
       
        echo "<div class='column' style='background-color:#aaa;'>" ;
        echo "<input type = 'submit' name = 'Add' value = 'Add' onclick=phonenumber(document.frmadd.phone_number1)>";            
        echo "</div>";
        echo "<div class='column' style='background-color:#aaa;'>NA</div>" ;
        echo "</div>";
        echo "</form>";

         // Search Phone
        echo "<div class='gap'>";
        echo "</div>";
        echo "<div class='row'>
        <div class='column' style='background-color:#fff;'>
            <h4>Search Phone Numbers :</h4>
        </div>        
        </div>";

        echo "<form method='post' action='#'>";
        echo "<div class='row'>";
        echo "<div class='column' style='background-color:#aaa;'>"; 
        echo "<input type = 'text' class='phone' id = 'phone_number2' name = 'phone_number2' ></div>"; 
        echo "<div class='column' style='background-color:#fff;'></div>" ;
        echo "<div class='column' style='background-color:#fff;'></div>" ;
        echo "<div class='column' style='background-color:#fff;'></div>" ;
        echo "<div class='column' style='background-color:#fff;'></div>" ;
        echo "<div class='column' style='background-color:#fff;'>"; 
        echo "<input type = 'submit' name = 'Search' value = 'Search'>";            
        echo "</div>";
        echo "<div class='column' style='background-color:#fff;'></div>" ;      
        echo "</form>";
        echo "</div>";
        
       
        echo "<div class='gap'>";
        echo "</div>";
        

        // List Phones
        echo "<div class='row'>
        <div class='column' style='background-color:#fff;'>
            <h4>Phone Registry :</h4>
        </div>        
        </div>";

    // For List Population
    if($phone_array_api['message'] == "Phone Found")
    {
        foreach($phone_array_api['data'] as $phone_arr)
        {
            $id = $phone_arr['id'];
            $phone_number = $phone_arr['phone_number'];
            $sms = $phone_arr['sms'];
            $voice_mail = $phone_arr['voice_mail'];

            echo "<form method='post' action='#'>";
            echo "<div class='row'>";
            
            echo "<div class='column' style='background-color:#aaa;'>"; 
            echo "<input type = 'text' disabled id = 'id' name = 'id' value = $id></div>"; 

            echo "<div class='column' style='background-color:#aaa;'>"; 
            echo "<input type = 'text' class='phone' id = 'phone_number' name = 'phone_number' value = $phone_number></div>"; 

            echo "<div class='column' style='background-color:#aaa;'>"; 
            if($sms){echo "<input type = 'checkbox' id = 'sms' name = 'sms' checked></div>";}
            else{echo "<input type = 'checkbox' id = 'sms' name = 'sms' ></div>";}

            echo "<div class='column' style='background-color:#aaa;'>"; 
            if($voice_mail){echo "<input type = 'checkbox' id = 'voice_mail' name = 'voice_mail' checked></div>";}
            else{echo "<input type = 'checkbox' id = 'voice_mail' name = 'voice_mail' ></div>";}
            
            // edit button
        
                echo "<div class='column' style='background-color:#aaa;'>" ;
                echo "<input type = 'submit' name = 'Update' value = 'Update'>";
                echo "<input type = 'hidden' id = 'nid' name = 'nid' value = $id>"; 
                echo "<input type = 'hidden' id = 'nphone_number' name = 'nphone_number' value = $phone_number>";
                echo "<input type = 'hidden' id = 'nsms' name = 'nsms' value = $sms>"; 
                echo "<input type = 'hidden' id = 'nvoice_mail' name = 'nvoice_mail' value = $voice_mail>"; 
                echo "</div>";

            // Delete
                echo "<div class='column' style='background-color:#aaa;'>" ;
                echo "<input type = 'submit' name = 'Delete' value = 'Delete'></div>";
                echo "<input type = 'hidden' id = 'nid' name = 'nid' value = $id>"; 
        
            
            echo "</div>";
            echo "</form>";
            
        }
    }
    else{
        echo "No Data Found";
    }
    
    
}

     
?>
    <script>
    // Get the elements with class="column"
    var elements = document.getElementsByClassName("column");

    $(document).ready(function() {
        $('.phone').inputmask('+1 (999)-999-9999');
    });
    function phonenumber(inputtxt)
    {
        var phoneno = /^(\+1)\s\((\d{3})\)-(\d{3})\-(\d{4})$/;
        if(inputtxt.value.match(phoneno))
            {
            return true;
            }
        else
            {
            alert("Not a valid Phone Number");
            return false;
            }
    }

    </script>

</body>


</html>