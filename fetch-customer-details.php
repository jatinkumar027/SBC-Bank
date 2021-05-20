<?php 

    session_start();
    require_once('connection.php');
    if(!isset($_SESSION['username'])){
        header('Location: index.php');
        exit;
    }
    
    class response{
        public $success;
        public $data;
    }

    $customer = new response();

    function filterText($str){
        $str = strip_tags($str);
        $str = trim($str);
        $str = addslashes($str);
        return $str;
    }
    if(isset($_REQUEST['customer_id'])){
        $customer_id = filterText($_REQUEST['customer_id']);
        $sql = "SELECT * FROM customers WHERE customer_id='$customer_id'";
        $result = $conn->query($sql);
        if($result->num_rows == 1){
            $row = $result->fetch_assoc();
            $formated_data = json_encode($row);
            $customer->success = true;
            $customer->data = $formated_data;
        }
        else{
            $customer->success = false;
            $customer->data = '';
        }
        print_r(json_encode($customer));
    }

?>