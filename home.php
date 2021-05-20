<?php
    //connecting to db
    session_start();
    require_once('connection.php');
    if(!isset($_SESSION['username'])){
        header('Location: index.php');
        exit;
    }

    //PHP script to take data out of db
    $sql = "SELECT * FROM `sbc bank`.`customers`";
    $result = $conn->query($sql);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SBC Bank</title>
    <link rel="stylesheet" href="public/CSS/styles.css">
    <script>
        function show_customers(){
            document.getElementsByClassName('table-container')[0].style.display = 'block';
            document.getElementById('view-customer').style.display = 'none';
            document.getElementsByClassName('error-msg')[0].style.display = 'none';
        }
    </script>
    <?php require 'includes/layout.php'; ?>
</head>
<body>
    <?php require 'includes/header.php'; ?>
    <div class="wrapper">
        <?php 
            if(isset($_SESSION['message'])){
                ?>
                <div class="message error-msg">
                    <?php echo $_SESSION['message']; ?>
                </div>
                <?php
                unset($_SESSION['message']);
                unset($_SESSION['message-css']);
            }
        ?>
        <div class="customers flex-row wrap">
            
            <?php 
                $i = 1;
                while($row = $result->fetch_assoc()){
            ?>
            
            <div class="customer-card border card flex-row">
                <div class="flex-col pr-20px">
                    <label class="label">Name</label>
                    <label class="label">A/C</label>
                    <label class="label">IFSC code</label>
                    <label class="label">E-mail</label>
                    <label class="label">Contact</label>
                    <label class="label">Location</label>
                    <label class="label">State</label>
                    <label class="label mt-10px">Balance</label>
                </div>
                <div class="flex-col">
                    <label ><?php echo $row['name']; ?></label>
                    <label ><span class="highlight-blue"><?php echo $row['account_num']; ?></span></label>
                    <label ><?php echo $row['IFSC_Code']; ?></label>
                    <label><?php echo $row['email']; ?></label>
                    <label><?php echo $row['contact_num']; ?></label>
                    <label><?php echo $row['location']; ?></label>
                    <label><?php echo $row['State']; ?></label>
                    <label class="mt-10px"><span class="highlight-green"><?php echo $row['current_balance']; ?> <i class="fas fa-rupee-sign"></i></span></label>
                </div>
                <i class="fas fa-user user-icon"></i>
                <button onclick="location.href='transaction.php?c_id=<?php echo $row['customer_id']; ?>'" class="pay"><i class="fas fa-share mr-5px"></i>Pay</button>
            </div>

            <?php $i++; } ?>
        </div>
    </div>
</body>
</html>