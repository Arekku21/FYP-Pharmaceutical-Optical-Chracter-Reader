<?php

    require("db.php");

    session_start();
    error_reporting(0);

    $auth_page = "menu/dashboard.php";

    // Check if the user is logged in already or not.
    if(!empty($_SESSION['logged_in'])){
        // Immediately redirect to page
        header("Location: $auth_page");

    }

	if(isset($_POST['submit_btn'])){
    
        $emailLogin = $_POST['email_add'];        
        $passwordLogin = $_POST['pass'];
        // Encrypting the password
        $passwordLogin = md5($passwordLogin);

        // Login query here
        $sql = "SELECT * FROM user WHERE email = '$emailLogin' AND password = '$passwordLogin'";
        $verified = "SELECT is_verified FROM user WHERE email = '$emailLogin' AND password = '$passwordLogin';";
        $result = mysqli_query($Links, $sql);
        $isVer = mysqli_query($Links, $verified);
        // If any record exists means the user has entered the correct
        if (mysqli_num_rows($result) > 0 && $isVer == 1) {
             // output data of each row
             // PHP IS SO L MANNN
             $_SESSION['logged_in'] = True;
             $loggedInUser;
             while ($row = $result->fetch_assoc()) {
                $loggedInUser = $row;
            }
             $_SESSION['roleID'] = $loggedInUser['roleID'];
             $_SESSION['id'] = $loggedInUser['id'];
             $_SESSION['email'] = $loggedInUser['email'];

             $log = "User logged in";
             $email =  $loggedInUser['email'];
             $role = $loggedInUser['roleID'];
             $logger = "INSERT INTO logs(role, email, action) VALUES ($role, '$email', '$log')";
             $result = mysqli_query($Links, $logger);

             echo "<script type='text/javascript'>location.href='menu/dashboard.php';</script>";
        } else if (mysqli_num_rows($result) > 0 && $isVer == 0){
            echo "<script type='text/javascript'>alert('Please verify your account to continue');</script>";
        } else {
            echo "<script type='text/javascript'>alert('Invalid credentials');</script>";
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
                                <h3 class="title ">Login</h3>
                                <hr class="login-hr">
                            </div>

                            <div class="box">
                                <form action="login.php" method="post">
                                    <fieldset>

                                        <div class="field">
                                            <div class="control">
                                            <label for="email_add">  Email Address: </label> <br/>
                                            <input type="email" placeholder="Email Address" name="email_add" id="email_add" class="input is-medium"  autofocus="" required email />
                                            </div>
                                        </div>
            
                                        <div class="field">
                                            <div class="control">    
                                            <p>
                                            <label for="pass">  Password: </label> <br/>
                                            <input name="pass" class="input is-medium" type="password" placeholder="Your Password" required>
                                            
                                            </p>
                                            </div>
                                        </div>
                            </div>
                            <button class="button is-block is-primary is-medium is-fullwidth" type="submit"  name="submit_btn" value="Submit" >Login <i class="fas fas-sign-in" aria-hidden="true"></i></button><br/>
                        </form>

                            <p class="has-text-grey" style="color: #00d1b2;">
                            <a style="color: #00d1b2;" href="forgot_password.php">Forgot Password</a>
                            </p><br><br><br>
                            <!-- <p class="subtitle ">Please login to proceed.</p> -->
                            <a class=" level-item logo-margin" >
                              <img src="image/logo.png" width="152" height="140">
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        
            </div>
        </div>  
    </body>
</html>