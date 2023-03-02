
<?php
// Include config file
require_once("db.php");

session_start();

    $auth_page = "menu/menu.php";

    // Check if the user is logged in already or not.
    if(!empty($_SESSION['logged_in']))
    {
        // Immediately redirect to page
        header("Location: $auth_page");
    }

    $email = $password = $confirm_password = "";

    $email_err = $password_err = $confirm_password_err = "";

    if(isset($_POST['submit_btn'])){
        // Validate email
        if(empty(trim($_POST["email"]))){
            $email_err = "Please enter email.";
        } elseif(!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)){
            $email_err = "Invalid email";
        }
        else{
            // Prepare a select statement
            $email = trim($_POST["email"]);
        }
        
            // Validate password
        if(empty(trim($_POST["password"]))){
            $password_err = "Please enter a password.";     
        } else{
            $password = trim($_POST["password"]);
        }
        
        // Validate confirm password
        if(empty(trim($_POST["confirm_password"]))){
            $confirm_password_err = "Please confirm password.";     
        } else{
            $confirm_password = trim($_POST["confirm_password"]);
            if(empty($password_err) && ($password != $confirm_password)){
                $confirm_password_err = "Password did not match.";
            }
        }

    // Check input errors before inserting in database
    if(empty($email_err) && empty($password_err) && empty($confirm_password_err)){
        $password = md5($password);
        // Prepare an insert statement
        $signUpQuery = "INSERT INTO user(email, password, roleID) VALUES ( '$email', '$password', 3)";
            
        if (mysqli_query($Links, $signUpQuery)) {
                 echo "<script type='text/javascript'>location.href='login.php';</script>";
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }

}
    // Close connection
    mysqli_close($Links);

?>

<!DOCTYPE html>
<html>
<head>
        <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1" charset="UTF-8">
        <script src="https://www.gstatic.com/charts/loader.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <link rel="icon" type="image/x-icon" href="favicon.ico">
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.5/css/bulma.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link href="css/index.css" rel="stylesheet"/>
        <title>Register</title>
</head>

<body><div class="container" style="background-color: #041221;max-width: none;margin-top: +2%;">
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
                                <h3 class="title ">Register</h3>
                                <hr class="login-hr">

                <div class="box">
                <form action="register.php" method="post">
                <fieldset>
                    <div class="field">
                        <div class="control">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control  <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>">
                        <span class="invalid-feedback"><?php echo $email_err; ?></span>
                        </div>
                    </div>    


                    <div class="field">
                    <div class="control">    
                            <label>Password</label>
                            <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                            <span class="invalid-feedback"><?php echo $password_err; ?></span>
                    </div>
                    </div>


                    <div class="field">
                    <div class="control">   
                        <label>Confirm Password</label>
                        <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" >
                        <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                    </div>
                    </div>


            <div class="form-group">
                <input type="submit"  name="submit_btn" class="button is-block is-primary is-medium is-fullwidth" value="Sign Up"><i class="fas fas-sign-in" aria-hidden="true"></i>
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
        <a class=" level-item logo-margin" >
                              <img src="image/logo.png" width="152" height="140">
                            </a>
    </div>    
</body>
</html>
