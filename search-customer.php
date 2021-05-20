<?php 
    require_once('connection.php');
    require_once('middleware.php');
    if(isset($_POST['name'])){
        $search_name = strtolower(cleanInput($_POST['name']));
        $sql = "SELECT * FROM customers";
        $result = $conn->query($sql);
        $customers = array();
        while($row = $result->fetch_assoc()){
            $customer_name = strtolower($row['name']);
            $k = 0;
            $control = 1;
            $s_len = strlen($search_name);
            $c_len = strlen($customer_name);
            if($s_len > $c_len)
                $len = $c_len;
            else $len = $s_len;
            for($i=0; $i<$len; $i++){
                if($search_name[$i] != $customer_name[$k++]){
                    $control = 0;
                    break;
                }
            }
            if($control){
                array_push($customers, $row);
            }
        }
    }
?>

<?php 
    if(sizeof($customers) == 0){
        ?>
        <div class="danger"><i class="fas fa-exclamation-circle"></i> No customers found with the given name</div>
        <?php
    }
    foreach($customers as $row){
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
        <?php
    }

?>