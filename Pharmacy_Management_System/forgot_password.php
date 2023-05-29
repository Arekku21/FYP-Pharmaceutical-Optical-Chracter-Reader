<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('db.php');
include('reset_password.php'); 

if (isset($_POST['submit'])) {

    $email = $_POST['email'];

    // Check if the email exists in the database
    $sql = "SELECT * FROM user WHERE email='$email'";
    $result = mysqli_query($Links,$sql);
    $count = mysqli_num_rows($result);
    if ($count > 0) {

        $code = rand();
        $sql = "UPDATE user SET code='$code' WHERE email='$email'";
        $result = mysqli_query($Links,$sql);

        if ($result) {
          $sendMl->send($code);
          echo '<script>alert("An email has been sent to the given address. Please click on the link to reset your password.");</script>';
          echo "<script type='text/javascript'>location.href='login.php';</script>";
        } else {
            echo "Failed to update password in database.";
        }

    } else {
        echo "Email not found in database.";
    }

}

?>


<!DOCTYPE html>
<html lang="en">
    <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/x-icon" href="favicon.ico">
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.5/css/bulma.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" rel="stylesheet">
        <link href="css/index.css" rel="stylesheet"/>
    </head>
    


    <body>
        <div class="container" style="background-color: #041221;max-width: none;margin-top: +2%;">
            <div id="flow">
                <span class="flow-1"></span>
                <span class="flow-2"></span>
                <span class="flow-3"></span>
            </div>
            <div class="section" >
        
            <section class="hero is-success is-fullheight">
                <div class="hero-body">
                    <div class="container has-text-centered" style="max-width: 1132px;">
                    
                        <div class="column is-4 is-offset-4">
                            
                            <div class="login-header">
                                <h3 class="title ">Forgot Password</h3>
                                <hr class="login-hr">
                            </div>
                            <div class="box">
    <form action="" method="post">
    <fieldset>

    <div class="field">
                    <div class="control">    

      <label for="email">Email:</label>

      <input type="email" class="form-control input is-medium" id="email" placeholder="Enter email" name="email">

    </div>
    </div>
    <div class="field">
    <div class="form-group">

    <button type="submit" name="submit" class="button is-block is-primary is-medium is-fullwidth">Submit</button>
    </div>
    </div>
  </form>

</div>

 

</body>

</html>

