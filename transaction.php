<?php 
    session_start();
    require_once("connection.php");
    if(!isset($_SESSION['username'])){
        header('Location: index.php');
        exit;
    }

    // if(isset($_SESSION['transaction_successfull'])){
    //     header('Location: receipt.php');
    //     exit;
    // }

    //variable declaration
    $control = 0;
    $recipient_account_num_error = '';
    $name_error = '';
    $c_account_error = '';
    $amount_error = '';
    $name = '';
    $recipient_account_num = '';
    $ifsc_code = '';
    $ifsc_code_error = '';

    function filterText($str){
        $str = strip_tags($str);
        $str = trim($str);
        $str = addslashes($str);
        return $str;
    }
    //Getting the customer_id from the home page, the customer's data is taken out to be displayed
    if(isset($_GET['c_id'])){
        $customer_id = $_GET['c_id'];
        $sql = "SELECT name, account_num, IFSC_Code, current_balance FROM customers WHERE customer_id='$customer_id'";
        $result = $conn->query($sql);
        if($result->num_rows == 1){
            $row = $result->fetch_assoc();
            $sender_name = $row['name'];
            $sender_acc_num = $row['account_num'];
            $sender_ifsc_code = $row['IFSC_Code'];
            $sender_balance = $row['current_balance'];
        }
        else {
            header('Location: index.php');
            $_SESSION['message'] = 'Invalid customer ID';
            $_SESSION['message-css'] = 'error-msg';
            exit;
        }
    }
    //if the customer_id is wrong, the client is redirected back to the home page
    else{
        $_SESSION['message'] = 'Invalid customer ID';
        $_SESSION['message-css'] = 'error-msg';
        header('Location: index.php');
        exit;
    }



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make Transaction</title>
    <link rel="stylesheet" href="public/CSS/styles.css">
    <link rel="stylesheet" href="public/CSS/transaction.css">
    <?php require 'includes/layout.php'; ?>
</head>
<body>

    <?php require 'includes/header.php'; ?>

        <div class="flex-row mt-20px pb-50px">
            <div class="child">
                <div class="flex-col trans-card z-index-10 shadow">
                    <h3 class="mb-20px t-c">
                        Sender's details
                    </h3>
                    <div class="sender-detail">
                        <label>Name </label>
                        <div><?php echo $sender_name; ?></div>
                    </div>
                    <div class="sender-detail">
                        <label>Account number </label>
                        <div><?php echo $sender_acc_num; ?></div>
                    </div>
                    <div class="sender-detail">
                        <label>IFSC Code </label>
                        <div><?php echo $sender_ifsc_code; ?></div>
                    </div>
                    <div class="sender-detail">
                        <label>Balance </label>
                        <div><?php echo $sender_balance; ?> <i class="fas fa-rupee-sign"></i></div>
                    </div>
                </div>

            </div>

            <div class="partition">
                <?php require 'includes/transfer-animation.php'; ?>
            </div> 

            <div class="child">
                <div class="flex-col trans-card z-index-10 shadow">
                    <h3 class="mb-20px ml-20px t-c">
                    Enter Recipient details
                    </h3><?php 
                        $sql = "SELECT * FROM customers ORDER BY name";
                        $result = $conn->query($sql);

                    ?>
                    <form id="transaction-form" action="" method="post" class="form">
                        <!-- Choose from listed customers -->
                        <?php if($result->num_rows > 0){ ?>
                        <div class="input-container">
                            <select id="fetch-customer" class="custom-select">
                            <option value="">Choose from listed customers</option>
                            <?php 
                                while($row = $result->fetch_assoc()){
                            ?>
                                <option value="<?php echo $row['customer_id']; ?>"><?php echo $row['name']; ?></option>
                            <?php } ?>
                            </select>
                        </div>
                        <?php } ?>

                        <script>

                            function fillCustomerDetails(res){
                                res = JSON.parse(res)
                                console.log(res)
                                let inputs = document.getElementsByClassName('transaction-input')

                                if(res.success){
                                    let customer = JSON.parse(res.data)
                                    inputs[0].value = customer.name
                                    inputs[1].value = customer.account_num
                                    inputs[3].value = customer.IFSC_Code
                                }
                                else{
                                    inputs[0].value = ''
                                    inputs[1].value = ''
                                    inputs[3].value = ''
                                }
                            }

                            $('#fetch-customer').on('change', () => {
                                let customerId = $('#fetch-customer').val()
                                let reqData = {
                                    customer_id : customerId
                                }
                                let url = 'fetch-customer-details.php'
                                $.ajax({
                                    url,
                                    type : 'POST',
                                    dataType : 'html',
                                    success : (msg) => {

                                    },
                                    complete : (res) => {
                                        fillCustomerDetails(res.responseText)
                                    },
                                    data : reqData
                                })
                            })
                        </script>
                        <div class="input-container">
                            <label for="name" >Name </label>
                            <input class="transaction-input" type="text" name="name" class="input" value="<?php echo $name; ?>">
                            <div class="error">
                            </div>
                            <?php if($name_error != ''){ ?>
                            <i class="fas fa-exclamation-circle error-icon"></i>
                            <?php } ?>
                        </div>
                        <div class="input-container">
                            <label for="account_num">A/C No </label>
                            <input class="transaction-input" type="number" name="account_num" class="input" value="<?php echo $recipient_account_num; ?>">
                            <div class="error">
                            </div>
                            <?php if($recipient_account_num_error != ''){ ?>
                            <i class="fas fa-exclamation-circle error-icon"></i>
                            <?php } ?>
                        </div>
                        <div class="input-container">
                            <label for="c_account_num">Confirm A/C No </label>
                            <input class="transaction-input" type="number" name="c_account_num" class="input" >
                            <div class="error">
                            </div>
                            <?php if($c_account_error != ''){ ?>
                            <i class="fas fa-exclamation-circle error-icon"></i>
                            <?php } ?>
                        </div>
                        <div class="input-container">
                            <label for="ifsc_code">IFSC Code </label>
                            <input class="transaction-input" type="text" name="ifsc_code" class="input" >
                            <div class="error">
                            </div>
                            <?php if($ifsc_code_error != ''){ ?>
                            <i class="fas fa-exclamation-circle error-icon"></i>
                            <?php } ?>
                        </div>
                        <div class="input-container">
                            <label for="amount">Amount </label>
                            <input class="transaction-input" type="number" step="0.000001" name="amount" class="input" >
                            <div class="error">
                            </div>
                            <?php if($amount_error != ''){ ?>
                            <i class="fas fa-exclamation-circle error-icon"></i>
                            <?php } ?>
                        </div>
                        <div class="button-container">
                            <button id="make-transaction-btn" type="submit" class="button">Confirm</button>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    
        <script>
            function fetch_response(response){
                let btn = document.getElementById('make-transaction-btn')
                let inputs = document.getElementsByClassName('transaction-input')
                let errorIcon = '<i class="fas fa-exclamation-circle error-icon"></i>' 
                let successIcon = '<i class="fas fa-check success-icon">'
                response = JSON.parse(response)
                let success = response.success
                console.log('success : ' + success)
                if(!success){
                    console.log(response)
                    let responseErrors = response.error
                    console.log(responseErrors)
                    let errors = document.getElementsByClassName('error')
                    let i = 0
                    responseErrors.forEach((err) => {
                        if(err != ''){
                            errors[i].innerHTML = errorIcon + err
                            inputs[i].className = 'transaction-input input-error'
                        }
                        else {
                            errors[i].innerHTML = ''
                            inputs[i].className = 'transaction-input'
                            if(inputs[i] != ''){
                                errors[i].innerHTML = successIcon
                                inputs[i].className = 'transaction-input input-success'
                            }
                        }
                        i++
                    })
                    btn.innerHTML = 'Confirm'
                    btn.disabled = false
                }
                else{
                    btn.disabled = true
                    transactionAnimation()
                    btn.innerHTML = '<i class="fas fa-sync-alt fa-spin mr-5px"></i> Processing transaction'
                    setTimeout(() => {
                        location.href = 'receipt.php'
                    }, 8000)
                }
            }

            $(document).ready(() => {
                $('#transaction-form').submit((e) => {
                    e.preventDefault()
                    let btn = document.getElementById('make-transaction-btn')
                    btn.disabled = true
                    btn.innerHTML = '<i class="fas fa-sync-alt fa-spin mr-5px"></i> Checking Details'
                    let inputs = document.getElementsByClassName('transaction-input')
                    let holderName = inputs[0].value
                    let accountNumber = inputs[1].value
                    let confirmAccountNumber = inputs[2].value
                    let ifscCode = inputs[3].value
                    let transactionAmount = inputs[4].value
                    let url = 'make-transaction.php'
                    let reqData = {
                        sender_account_num : <?php echo $sender_acc_num; ?>,
                        sender_balance : <?php echo $sender_balance; ?>,
                        name : holderName,
                        account_num : accountNumber,
                        c_account_num : confirmAccountNumber,
                        ifsc_code : ifscCode,
                        amount : transactionAmount 
                    }
                    setTimeout(() => {
                        $.ajax({
                            url,
                            type : 'POST', 
                            dataType : 'html',
                            success : (msg) => {

                            },
                            complete : (res) => {
                                fetch_response(res.responseText)
                            },
                            data : reqData
                        })
                    }, 500)

                    return false
                })
            })


        </script>
        <div id="transaction-response"></div>
</body>
</html>