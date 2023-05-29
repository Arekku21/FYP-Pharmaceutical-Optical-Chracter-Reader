
<link rel="icon" type="image/x-icon" href="favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.5/css/bulma.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
    body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
    }

    .container {
        display: flex;
        flex-wrap: wrap;
    }

    .right-section {
        width: 50%;
        display: flex;
        flex-wrap: wrap;
        align-items: flex-start;
        justify-content: flex-start; /* Update the justify-content property */
        padding: 10px;
        }

    .section {
        margin-top: 5px;
        padding: 5px;
        background-color: #1E90FF;
        border-radius: 5px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .section img {
        width: 100px; /* Adjust the width as desired */
        height: 100px; /* Adjust the height as desired */
        margin-bottom: 10px;
        display: block;
        margin: 0 auto; /* Center the image horizontally */
    }

  

    .right-section .section {
        /* ... previous styles ... */
        margin-right: 12px; /* Set the height to auto */
        float: right; 
        width: 31%;
    }


    
    .left-section .section img {
        width: 450px; /* Adjust the width as desired */
        height: 400px; /* Adjust the height as desired */
        display: block;
        margin: 0 auto;
    }

    .left-section .section h2 {
        font-size : 24px;
    }
    

    .section h2 {
        font-size: 14px;
        font-weight: bold; /* Add font-weight property */
        text-transform: uppercase; /* Add text-transform property */
        margin-bottom: 5px; /* Adjust the margin as desired */
        color: #ffffff;
        text-align: center;
    }
        

        .section .btn {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 6px 10px; /* Adjust the padding as desired */
        background-color: #DC143C;
        color: #ffffff;
        text-decoration: none;
        border-radius: 5px;
        font-size: 12px; /* Adjust the font size as desired */
        height: 50px; /* Adjust the height as desired */
        text-align: center; /* Center the text horizontally */
    }

    .main-content {
        margin-left: 300px;
        padding: 10px;
        box-sizing: border-box;
        
    }
</style>
    <?php include "../menu/menu.php"; ?>


<body>

<div class="main-content">
<br>
<br>
<br>
    
  
    <div class="container">
   
    <div class="left-section">
            <div class="section">
                <h2>Billing Order</h2><img src="../images/bill.png" alt="Billing Order">
                <a href="../billing/billing.php" class="btn">View Billing Order</a>
            </div>
    </div>
        <div class="right-section">
            <div class="section">
                <h2>Inventory</h2><img src="../images/inv.png" alt="Inventory">
                
                <a href="../inventory/inventory.php" class="btn">Manage Inventory</a>
            </div>
            <div class="section">
                <h2>Sales Report</h2>
                <img src="../images/sales.png" alt="Retraining Pipeline">
                <a href="../report/dailyReport.php" class="btn">Sales Report</a>
            </div>
            <div class="section">
                <h2> Pipeline</h2><img src="../images/pipe.png" alt="Retraining Pipeline">
                
                <a href="../retraining/retraining.php" class="btn">Retraining Pipeline</a>
            </div>
            <div class="section"><h2>Registration</h2><img src="../images/reg.png" alt="Registration">
                
                <a href="../registration/addUsers.php" class="btn">Manage Registration</a>
            </div>
            <div class="section">
                <h2>Users</h2><img src="../images/users.png" alt="Users">
                
                <a href="../users/pharma.php" class="btn">View Users</a>
            </div>
            <div class="section">
                <h2>Audit Logs</h2><img src="../images/aud.png" alt="Audit Logs">
                
                <a href="../audit/audit.php" class="btn">View Audit Logs</a>
            </div>
        </div>
    </div>
</div>
</body>
