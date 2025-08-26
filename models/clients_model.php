<?php
    
    class clients_model extends Model{
        function _construct(){
                parent::_construct();       
            
        }
        
        //list clients in list portal
        public function list_clients() {
        $results = $this->db->query('SELECT * FROM clients');
        $results->execute();
        return $results->fetchAll();
        }
        
        //list clients in management portal
        public function client_management(){
            
        $results = $this->db->query('SELECT * FROM clients');
        $results->execute();
        return $results->fetchAll();
            
        }
        
        //update client management portal     
        public function update_clients($autocode,$fname,$lname,$address,$phone) {
            
            $adder = $this->db->prepare("UPDATE clients SET client_fname=?,client_lname=?,client_address=?,client_phone=? WHERE client_id=? LIMIT 1");
            $adder->bindValue(1, $fname);
            $adder->bindValue(2, $lname);
            $adder->bindValue(3, $address);
            $adder->bindValue(4, $phone);
            $adder->bindValue(5, $autocode);
             $adder->execute();
            
            
        }
        
        //add transactions to trasaction portal
        public function addtransactions($client_no,$client_name,$client_vechicle,$client_pumper,$pump_date,$fuel_type,$pump_number,$pump_liters,$pump_value) {
                      
            $trans= $this->db->prepare("INSERT INTO client_transactions (trcusid,client_name,client_pump_vechicle,client_pumper,pump_date,client_pump_no,client_pump_liters,pump_value,trtype)"
                    . "VALUES(:client,:client_name, :client_vechicle, :client_pumper,:pump_date,:client_pump_no,:client_pump_liters,:client_pump_value,:ftype)");
               
            $trans->execute(array(
                ':client' => $client_no, 
                ':client_name' => $client_name, 
                ':client_vechicle' => $client_vechicle,
                ':client_pumper'=>$client_pumper,
                ':pump_date'=>$pump_date,
               
                ':client_pump_no'=>$pump_number,
                ':client_pump_liters'=>$pump_liters,
                ':client_pump_value'=>$pump_value,
                    ':ftype'=>$fuel_type
        ));
    }       
        
        //add clients to management portal
        public function addclient($autocode,$fname,$lname,$address,$nic,$phone,$purchasedate,$amount,$profile) {
            
        $adder = $this->db->prepare("INSERT INTO clients (client_id,client_fname,client_lname,client_address,client_nic,client_phone,client_purchase_date,client_purchase_amount,profile)
                                    VALUES(:autocode,:fname,:lname,:address,:nic,:phone,:purchasedate,:amount,:profile)");

        $adder->execute(array(':autocode' => $autocode, ':fname' => $fname, ':lname' => $lname, ':address' => $address, ':nic' => $nic, ':phone' => $phone, ':purchasedate' => $purchasedate, ':amount' => $amount,':profile' => $profile));
            }
        
     
        //search clients in client management poratal 
        public function searchClients($id){
                $val=(string)$id;
                
                $c1=  $this->db->prepare("Select * from clients WHERE client_id=:ID");
                $c1->execute(array (':ID'=>$val));
                print_r($c1->fetchAll());
            
            
        }   
        
        //delete clients
         public function deleteClients($id) {
                    $sql = $this->db->prepare("DELETE FROM clients WHERE client_id=?");
                    $sql->bindValue(1, $id);
                    $sql->execute();
            
         }
         
   
        //client detailed report
        public function clients() {
            $clients = []; // Fixed: Initialize as array
            $sql = $this->db->prepare("select client_id,client_fname,client_address,client_nic,client_phone FROM clients");
            $sql->execute();

            while ($obj = $sql->fetch(PDO::FETCH_OBJ)) {
                $clients[] = $obj;
            }
            return $clients;
        }
        
        
     
        //sending update emails for clients
        public function  sendemail($email,$user,$subject,$body)
        {
        // Load environment variables
        $envFile = __DIR__ . '/../.env';
        if (file_exists($envFile)) {
            $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                if (strpos($line, '#') === 0) continue; // Skip comments
                if (strpos($line, '=') !== false) {
                    list($key, $value) = explode('=', $line, 2);
                    $_ENV[trim($key)] = trim($value);
                }
            }
        }
              
        require_once 'libs/email/PHPMailer/PHPMailerAutoload.php';
        $mail = new PHPMailer;
    //$mail->SMTPDebug = 1;                               // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = isset($_ENV['MAIL_HOST']) ? $_ENV['MAIL_HOST'] : 'ssl://smtp.gmail.com';
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = isset($_ENV['MAIL_USERNAME']) ? $_ENV['MAIL_USERNAME'] : 'ioc.negambo@gmail.com';
        $mail->Password = isset($_ENV['MAIL_PASSWORD']) ? $_ENV['MAIL_PASSWORD'] : 'IocNegambo123';
        $mail->SMTPSecure = isset($_ENV['MAIL_ENCRYPTION']) ? $_ENV['MAIL_ENCRYPTION'] : 'ssl';
        $mail->Port = isset($_ENV['MAIL_PORT']) ? $_ENV['MAIL_PORT'] : 465;

        $mail->From = isset($_ENV['MAIL_FROM_ADDRESS']) ? $_ENV['MAIL_FROM_ADDRESS'] : 'carwash@gmail.com';
        $mail->FromName = isset($_ENV['MAIL_FROM_NAME']) ? $_ENV['MAIL_FROM_NAME'] : 'IOC';
       $mail->addAddress($email, $user);   // Add a recipient
//$mail->addAddress('ellen@example.com');               // Name is optional
        $mail->addReplyTo('ioc.negambo@gmail.com', 'IOC');
//$mail->addCC('cc@example.com');
        $mail->addBCC('bcc@example.com');
//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        if (!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Message has been sent';
        }
                  
        }
        
         public function historypump(){
            
        $results = $this->db->query('SELECT * FROM client_transactions');
        $results->execute();
        return $results->fetchAll();
            
        }
        
        
        
            public function trReports($year,$code){

               
                
        	$tr = []; // Fixed: Initialize as array
            $sql = $this->db->prepare("SELECT client_name,client_pump_vechicle,pump_date,client_pump_liters,pump_value,trtype FROM client_transactions WHERE  pump_date LIKE ? AND trcusid = ? ");
        $sql->bindValue(1, '%'.$year.'%');
        $sql->bindValue(2, $code);
 $sql->execute();
            while ($obj = $sql->fetch(PDO::FETCH_OBJ)) {
                $tr[] = $obj;
            }
            return $tr;
        }
        
        
        
    }
    




