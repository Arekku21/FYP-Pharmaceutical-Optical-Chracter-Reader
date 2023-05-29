<?php
if(isset($_GET['email']) && isset($_GET['code']))
{
include "db.php";

$email = $_GET['email'];

$password = $confirm_password = "";

$password_err = $confirm_password_err = "";

if(isset($_POST['submit_btn'])){
        // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password."; 
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

// Check input errors before inserting in database
if(empty($password_err) && empty($confirm_password_err)){
    $password = md5($password);
    // Prepare an insert statement
    $signUpQuery = "UPDATE user SET password = '".$password."' WHERE email = '".$email."'";
        
    if (mysqli_query($Links, $signUpQuery)) {
             echo "<script type='text/javascript'>location.href='login.php';</script>";
    } else {
        echo "Oops! Something went wrong. Please try again later.";
    }
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
                                <h3 class="title ">Reset Password</h3>
                                <hr class="login-hr">
                            </div>
                            <div class="box">
    <form action="" method="post">
    <fieldset>
        <input type="hidden" name="email" value="<?php echo $email; ?>">
        <input type="hidden" name="code" value="<?php echo $code; ?>">
        <div class="field">
                    <div class="control">    
                            <label>Password</label>
                            <input type="password" name="password" autofocus="" class="input is-medium form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                            <span class="invalid-feedback"><?php echo $password_err; ?></span>
                    </div>
                    </div>


                    <div class="field">
                    <div class="control">   
                        <label>Confirm Password</label>
                        <input type="password" name="confirm_password" class="input is-medium form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" >
                        <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                    </div>
                    </div>
                    <div class="field">
            <div class="form-group">
            <input type="submit" class="button is-block is-primary is-medium is-fullwidth"  name="submit_btn" class="btn btn-primary"value = "Reset Password">
            </div>
        </div>
    </form>
<?php
}
?>
</div>
</div>
</div>
</body>
</html>