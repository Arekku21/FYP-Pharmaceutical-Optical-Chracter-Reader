<script>
function logOut(){
  location.href = "logout.php";
}
</script>

<!DOCTYPE html>
<html>
    <head>
        <style>
            .logo-margin{
              margin-left: 13%;
            }
        </style>
    </head>
    <body>
    <?php
// Start the session (Important!)

session_start();
error_reporting(0);
// Your Login Page

$login_page = "../login.php";



// Check if user is logged in

if($_SESSION['logged_in'] !== True){



// Redirect to Your Login Page to Prevent Unauthorized Access

header("Location: $login_page");
}
  ?>
        <div style="position: fixed; width: 100%; z-index: 1;">
            <div class="navbar-menu level " style="background-color: #353935; margin-left:270px" aria-label="main navigation;">
            <p  class="menu-label" style="color: azure; font-size:18px;margin-top: 20px; margin-left: 10px;"> PHARMACY MANAGEMENT SYSTEM</p>

            <!-- includes the user profile photo , username , and title of the page -->
<div class="navbar-brand level-left">
    <div id="navbarBasicExample" class="navbar-menu level-item logo-margin">
    </div>
  </div>

  <!-- includes the log out button , search bar , and time -->
<div class="navbar-end level-right" >

  <div class="navbar-start" style="margin-top: 6px;" >
        <div style="padding: 4px;margin-right: -10px;">
          <figure class="image is-48x48">
            <img class="is-rounded" src="https://bulma.io/images/placeholders/128x128.png">
          </figure>
        </div>
        <span style="padding: 15px; color: white; font-size: 18px;">
        <?php
        if($_SESSION['roleID'] == 1)
          echo "Admin";
        else if($_SESSION['roleID'] == 2)
          echo "Employee";
        else echo "Pharmacist";
        ?>
</span>
      </div>

    <div class="buttons">
    <form action="../menu/logout.php">
    <input type="submit" class="button is-primary"  name="submit_btn"  value="Log Out"><i class="fas fas-sign-in" aria-hidden="true"></i>
    
    </form>

    <!-- <button class="btnLogOut button is-primary" onclick="logOut()" name="submit_btn">
      LogOut
          </button> -->
      <!-- <button class="button is-primary" >
        <strong>Log out</strong>
      </button> -->
      <button *ngIf="PharamacistRole" class="button is-primary is-rounded"  >
        <strong><span class="icon"><i class="fa fa-cogs fa-lg "  routerLink="/settings"></i></span></strong>
      </button>
    </div>


  </div>
</div>

            </div>
        </div>
    </body>
</html>
