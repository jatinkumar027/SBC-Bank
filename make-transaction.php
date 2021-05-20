<?php 

session_start();
require_once("connection.php");
if(!isset($_SESSION['username'])){
    header('Location: index.php');
    exit;
}

function filterText($str){
    $str = strip_tags($str);
    $str = trim($str);
    $str = addslashes($str);
    return $str;
}

class response{
    public $data;
    public $error;
    public $success;

    function create_response($suc, $err, $data){
        $this->success = $suc;
        $this->error = $err;
        $this->data = $data;
    }

    function send_response(){
        $json_format_data = json_encode($this);
        print_r($json_format_data);
    }
}

$transaction_response = new response();

if(isset($_POST["name"]) && isset($_POST["account_num"]) && isset($_POST["c_account_num"]) && isset($_POST["ifsc_code"]) && isset($_POST["amount"]) && isset($_POST['sender_account_num']) && isset($_POST['sender_balance'])){
    
    $control = 1;
    $errors = array();
    for($i=0; $i<5; $i++)
        array_push($errors, '');
    $sender_acc_num = filterText($_POST['sender_account_num']);
    $sender_balance = filterText($_POST['sender_balance']);
    $name = filterText($_POST["name"]);
    $recipient_account_num = filterText($_POST["account_num"]);
    $c_account_num = filterText($_POST["c_account_num"]);
    $ifsc_code = filterText($_POST["ifsc_code"]);
    $amount = filterText($_POST["amount"]);
    if($name==''){
        $name_error = 'Name required';
        $control = 0;
        $errors[0] = $name_error;
    }

    if($recipient_account_num==''){
        $recipient_account_num_error = 'Account number required';
        $control = 0;
        $errors[1] = $recipient_account_num_error;
    }

    if($c_account_num==''){
        $c_account_error = 'Please confirm your account number';
        $control = 0;
        $errors[2] = $c_account_error;
    }
    else if($sender_acc_num==$recipient_account_num){
        $recipient_account_num_error = 'Cannot transfer money to own account';
        $control = 0;
        $errors[1] = $recipient_account_num_error;
    }
    else if($c_account_num!=$recipient_account_num){
        $c_account_error = 'Account numbers not matched';
        $control = 0;
        $errors[2] = $c_account_error;
    }

    if($ifsc_code == ''){
        $ifsc_code_error = 'IFSC Code required';
        $control = 0;
        $errors[3] = $ifsc_code_error;
    }

    //if recipient's account number doesn't exist
    else{
        $sql = "SELECT * FROM customers WHERE name='$name' AND account_num='$recipient_account_num' And IFSC_Code='$ifsc_code'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        if($result->num_rows == 0){
            $control = 0;
            $errors[2] = 'Invalid Credentials';
            $errors[3] = 'Invalid Credentials';
        }
        else $recipient_balance = $row['current_balance'];
    }

    if($amount==''){
        $amount_error = 'Amount required';
        $control = 0;
        $errors[4] = $amount_error;
    }
    else if($amount<=0){
        $control = 0;
        $amount_error = 'Invalid amount';
        $errors[4] = $amount_error;
    }
    else if($amount>$sender_balance){
        $control = 0;
        $amount_error = 'Insufficient balance';
        $errors[4] = $amount_error;
    }

    $transaction_response->create_response(false, $errors, '');

    if($control){
        $transaction_response->success = true;
        //updating sender and recipient balance
        $new_sender_bal = $sender_balance - $amount;
        $new_recipient_bal = $recipient_balance + $amount;
        $sql = "UPDATE `customers` SET current_balance='$new_sender_bal' WHERE account_num='$sender_acc_num'";
        $conn->query($sql);

        $new_sender_bal = $sender_balance-$amount;
        $sql = "UPDATE `customers` SET current_balance='$new_recipient_bal' WHERE account_num='$recipient_account_num'";
        $conn->query($sql);

        //sending transaction details to the transaction table
        $sql = "INSERT INTO `transactions` (`transaction_id`, `sender_acc_num`, `recipient_acc_num`, `amount`,  `timestamp`) VALUES (NULL, '$sender_acc_num', '$recipient_account_num', '$amount', current_timestamp())";
        $conn->query($sql);

        //after the transaction is complete, the details for the receipt are sent to the receipt page by session
        $sql = "SELECT * FROM transactions ORDER BY transaction_id DESC LIMIT 0, 1";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $_SESSION['transaction_successfull'] = true;
        $_SESSION['success_msg'] = 'Transaction successful';
        $_SESSION['sender_account_num'] = $sender_acc_num;
        $_SESSION['recipient_account_num'] = $recipient_account_num;
        $_SESSION['amount'] = $amount;
        $_SESSION['transaction_id'] = $row['transaction_id'];
        $_SESSION['transaction_time'] = $row['timestamp'];
        $_SESSION['receipt-working'] = 1;
    }

    $transaction_response->send_response();
}

?>