<?php
    class Phone {
        
    // DB Staff
    private $conn;
    private $table = 'phone_list';

    // Phone Properties
    public $id;
    public $phone_number;
    public $sms;
    public $voice_mail;
    public $created_date;
    public $last_updated;

    // Constructor with DB
    public function __construct($db){
        $this->conn = $db;
    }

    public function share_phone(){
        //Create query
        $query = 'SELECT * FROM phone_list where phone_number LIKE :phone_number limit 1'  ;
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        // Bind phone_number
        $phone_number = "%".$this->phone_number."%";
        $stmt->bindParam(':phone_number',$phone_number,PDO::PARAM_STR);
        // Execute query
        $stmt->execute();
        //Check row count
        $cols = $stmt->rowcount();
        if($cols >0)
        {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);                
            //Set Properties            
            $this->phone_number = $row['phone_number'];
            $this->sms = $row['sms'];
            $this->voice_mail = $row['voice_mail'];
            $this->created_date = $row['created_date'];
            $this->last_updated = $row['last_updated'];
            return true;
        }
        
        return false;
    }


     // Search Phone numbers
     public function search(){
        //Create query
        $query = "SELECT * FROM phone_list where phone_number LIKE :phone_number" ;
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        $phone_number = "%".$this->phone_number."%";
        $stmt->bindParam(':phone_number',$phone_number,PDO::PARAM_STR);
        
        // Execute query
        $stmt->execute();
        return $stmt;
    }
    // Get All Phone numbers
    public function read(){
        //Create query
        $query = 'SELECT * FROM phone_list'  ;
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        // Execute query
        $stmt->execute();
        return $stmt;
    }

    // Get Single Phone number
    public function read_single(){
        //Create query
        $query = 'SELECT * FROM phone_list where id = ? limit 1'  ;
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        // Bind id
        $stmt->bindParam(1,$this->id);
        // Execute query
        $stmt->execute();
        //Check row count
        $cols = $stmt->rowcount();
        if($cols >0)
        {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);                
            //Set Properties            
            $this->phone_number = $row['phone_number'];
            $this->sms = $row['sms'];
            $this->voice_mail = $row['voice_mail'];
            $this->created_date = $row['created_date'];
            $this->last_updated = $row['last_updated'];
            return true;
        }
        
        return false;
    }

    // Create Phone number
    public function create(){
        // SELECT EXISTS(SELECT * from customer WHERE cust_id=104) AS Result;  
        $query = 'SELECT count(*) as cnt from phone_list where phone_number = ?'  ;
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        // Bind id
        $stmt->bindParam(1,$this->phone_number);
        // Execute query
        $stmt->execute();
        //Check row count
        $cols = $stmt->fetch();
        // print_r($cols['cnt']);
        
        if($cols['cnt'] == 0)
        {
        
            //Create array
            $query = 'INSERT INTO ' . 
            $this->table . '
            SET
            phone_number = :phone_number,
            sms = :sms,
            voice_mail = :voice_mail,
            created_date = :created_date,
            last_updated = :last_updated';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            //Clean data
            $this->phone_number = htmlspecialchars(strip_tags($this->phone_number));
            $this->sms = htmlspecialchars(strip_tags($this->sms));
            $this->voice_mail = htmlspecialchars(strip_tags($this->voice_mail));
            $this->created_date = htmlspecialchars(strip_tags($this->created_date));
            $this->last_updated = htmlspecialchars(strip_tags($this->last_updated));

            // Bind data
            $stmt->bindParam(':phone_number',$this->phone_number);
            $stmt->bindParam(':sms',$this->sms);
            $stmt->bindParam(':voice_mail',$this->voice_mail);
            $stmt->bindParam(':created_date',$this->created_date);
            $stmt->bindParam(':last_updated',$this->last_updated);

            // Execute query

            if($stmt->execute()){
                return true;
            }
        }
        else{
            // printf("Error: %s.\n",$stmt->error);
            return false;
        }
       

            // printf("Error: %s.\n",$stmt->error);
            // return false;
    }

   // Update Phone number
    public function update(){
        //Update array
        $query = 'UPDATE ' . 
        $this->table . '
        SET
        phone_number = :phone_number,
        sms = :sms,
        voice_mail = :voice_mail,
        created_date = :created_date,
        last_updated = :last_updated
        WHERE
        id = :id';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        //Clean data
        $this->phone_number = htmlspecialchars(strip_tags($this->phone_number));
        $this->sms = htmlspecialchars(strip_tags($this->sms));
        $this->voice_mail = htmlspecialchars(strip_tags($this->voice_mail));
        $this->created_date = htmlspecialchars(strip_tags($this->created_date));
        $this->last_updated = htmlspecialchars(strip_tags($this->last_updated));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind data
        $stmt->bindParam(':phone_number',$this->phone_number);
        $stmt->bindParam(':sms',$this->sms);
        $stmt->bindParam(':voice_mail',$this->voice_mail);
        $stmt->bindParam(':created_date',$this->created_date);
        $stmt->bindParam(':last_updated',$this->last_updated);
        $stmt->bindParam(':id',$this->id);

        // Execute query
        if($stmt->execute()){
            return true;
        }
        printf("Error: %s.\n",$stmt->error);
        return false;

    }

    // Delete Phone number
    public function delete(){
        // Create query
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
        
        // Prepare statement
        $stmt = $this->conn->prepare($query);

        //Clean data
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind data
        $stmt->bindParam(':id',$this->id);

        // Execute query
        if($stmt->execute()){
            return true;
        }
        printf("Error: %s.\n",$stmt->error);
        return false;
    }
}

?>