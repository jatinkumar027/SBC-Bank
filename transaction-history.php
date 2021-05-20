<?php 
    session_start();
    require_once('connection.php');
    $sql = "SELECT * FROM transactions";
    $result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History</title>
    <link rel="stylesheet" href="public/CSS/styles.css">
    <link rel="stylesheet" href="public/CSS/hide-header-option.css">
    <?php require 'includes/layout.php'; ?>
</head>
<body>
    <?php require 'includes/header.php'; ?>
    <div class="wrapper">
        <?php if($result->num_rows > 0){ ?>
        <h1 class="mb-10px secondary"><i class="fas fa-history mr-5px"></i> Transaction History</h1>
        <table>
            <thead>
                <tr>
                    <th>S No.</th>
                    <th>Transaction ID</th>
                    <th>Sender A/C</th>
                    <th>Recipient A/C</th>
                    <th>Amount</th>
                    <th>Timestamp</th>  
                </tr>
            </thead>
            <tbody>
                <?php 
                    $serial_no = 1;
                    while($row = $result->fetch_assoc()){
                ?>
                <tr>
                    <td><?php echo $serial_no; ?></td>
                    <td><?php echo $row['transaction_id']; ?></td>
                    <td><?php echo $row['sender_acc_num']; ?></td>
                    <td><?php echo $row['recipient_acc_num']; ?></td>
                    <td><?php echo $row['amount']; ?></td>
                    <td><?php echo $row['timestamp']; ?></td>
                </tr>
                <?php $serial_no++; ?>
                <?php } ?>
            </tbody>
        </table>
        <?php }
        else {
            ?>
                <h3 class="danger"><i class="fas fa-exclamation-circle mr-5px"></i> No transaction were found</h3>
            <?php
        }
        ?>
    </div>
</body>
</html>