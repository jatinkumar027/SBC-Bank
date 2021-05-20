<div class="header no-print">
    <div style="display:flex; align-items:center;">
        <h3 onclick="location.href='index.php'">SBC BANK</h3>
        <button class="view-welcome-btn"><i class="fas fa-user mr-5px"></i><?php echo $_SESSION['username']?></button>
    </div>
    
    <div class="search-bar-container">
        <div>
            <div class="search-bar-rel-cont">
                <i  class="fas fa-search"></i>
                <input id="search-customer" class="border" type="text" placeholder="Search via name..."> 
            </div>
        </div>
    </div>
    <div>
        <button class="search-bar-button"><i class="fas fa-search"></i> Search</button>
        <button class="view-transaction-btn" onclick="location.href='transaction-history.php'"><i class="fas fa-history mr-5px"></i>Transaction History</button>
        <button class="view-logout-btn" onclick="location.href='logout.php'"><i class="fas fa-sign-out-alt mr-5px"></i>Logout</button>
    </div>
</div>

<div class="header-padding"></div>


<script>
    $('.search-bar-button').click(() => {
        $('.search-bar-container').show()
        $('.search-bar-button').hide()
        document.getElementById('search-customer').focus()
    })
</script>

<script>
    $('#search-customer').on('input', () => {
        let x = document.getElementsByClassName('customers')[0]
        let name = $('#search-customer').val()
        let url = 'search-customer.php'
        name = name.trim()
        
        x.innerHTML = '<div class="center primary"><i class="fas fa-sync-alt fa-spin mr-5px"></i> Searching . . .</div>'
        setTimeout(() => {
            $('.customers').load(url, {
                name  
            })
        }, 1000)
    })
</script>