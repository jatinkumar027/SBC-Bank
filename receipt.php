<?php 
    require_once('connection.php');
    session_start();
    if(!isset($_SESSION['username'])){
        header('Location: index.php');
        exit;
    }
    
    if(!isset($_SESSION['transaction_successfull'])){
        header('Location: index.php');
        exit;
    }
    
    $success_msg = $_SESSION['success_msg'];
    $sender_account_num = $_SESSION['sender_account_num'];
    $recipient_account_num = $_SESSION['recipient_account_num'];
    $amount = $_SESSION['amount'];
    $transaction_id = $_SESSION['transaction_id'];
    $timestamp = $_SESSION['transaction_time'];

    //taking out sender and reciever details
    $sql = "SELECT * FROM customers WHERE `account_num` = $sender_account_num";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $sender_name = $row['name'];
    $sender_ifsc_code = $row['IFSC_Code'];
    
    $sql = "SELECT * FROM CUSTOMERS WHERE `account_num` = $recipient_account_num";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $recipient_name = $row['name'];
    $recipient_ifsc_code = $row['IFSC_Code'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <link rel="stylesheet" href="public/CSS/styles.css">
    <link rel="stylesheet" href="public/CSS/receipt.css">
    <?php require 'includes/layout.php'; ?>
</head>
<body>

    <!-- <img src="public/CSS/transactionbg.jpg" class="index-bg no-print"> -->

    
    <?php require 'includes/header.php'; ?>

    <div class="main pt-20px pb-50px">

        <?php 
            if(isset($_SESSION['transaction_successfull'])){
                ?>
                <div class="message success-msg no-print">
                    <i class="fas fa-check mr-5px"></i> Transaction successfull
                </div>
                <?php
                unset($_SESSION['message']);
                unset($_SESSION['message-css']);
            }
        ?>
        <div class="r-card border pt-10px">
            <div class="flex-row ptb-20px border-b">
                <h3 class="flex-row">SBC Bank</h3>
                <h3 class="pl-50px center flex-1">Payment Receipt</h3>
            </div>
            <div class="flex-row ptb-20px border-b space-between">
                <div>
                    <h4 class="fs-17px pb-10px">Sender Detail's</h4>
                    <div class="flex-row">
                        <div class="flex-col pr-20px">
                            <label class="fw-b">Name</label>
                            <label class="fw-b">A/C</label>
                            <label class="fw-b">IFSC code</label>
                        </div>
                        <div class="flex-col">
                            <label ><?php echo $sender_name; ?></label>
                            <label ><?php echo $sender_account_num; ?></label>
                            <label ><?php echo $sender_ifsc_code; ?></label>
                        </div>
                    </div>
                </div>
                <div>
                    <h4 class="pb-10px">Recipient Detail's</h4>
                    <div class="flex-row">
                        <div class="flex-col pr-20px">
                            <label class="fw-b">Name</label>
                            <label class="fw-b">A/C</label>
                            <label class="fw-b">IFSC code</label>
                        </div>
                        <div class="flex-col">
                            <label ><?php echo $recipient_name; ?></label>
                            <label ><?php echo $recipient_account_num; ?></label>
                            <label ><?php echo $recipient_ifsc_code; ?></label>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <table >
                    <thead>
                        <tr>
                            <th class="dark">Transaction Id</th>
                            <th class="dark">Amount</th>
                            <th class="dark">Timestamp</th>
                            <th class="dark">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="t-c"><?php echo $transaction_id; ?></td>
                            <td class="t-c"><?php echo $amount; ?> <i class="fas fa-rupee-sign"></i></td>
                            <td class="t-c">
                                <?php
                                        $timestamp = new DateTime($timestamp);
                                        echo $timestamp->format('d-m-Y');
                                        echo '<br/>';
                                        echo $timestamp->format('h:i:sa'); 
                                ?>
                            </td>
                            <td class="t-c">Success</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>    

        <div class="receipt-holder">
            
            <div class="button-container no-print">
                <button onclick="window.print()" class="button">Print receipt</button>
            </div>
            <div class="button-container no-print">
                <a href="home.php"><button onclick="<?php $_SESSION['receipt-working']=0; ?>" class="button">Back to homepage</button></a>
            </div>

        </div>
    </div>
    
</body>
</html>

<?php //session_destroy(); ?>