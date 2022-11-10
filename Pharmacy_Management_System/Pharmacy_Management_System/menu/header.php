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
        <div style="position: fixed; width: 100%; z-index: 1;">
            <div class="navbar-menu level " style="background-color: hsl(0, 0%, 29%); " aria-label="main navigation;">
            <!-- includes the user profile photo , username , and title of the page -->
<div class="navbar-brand level-left">

    <a class="level-item logo-margin" href="https://bulma.io">
      <img src="../image/pharmacare-logo-hori-tagline-2.png" width="152" height="140">
    </a>
  
    <div id="navbarBasicExample" class="navbar-menu level-item logo-margin">
  
      <div class="navbar-start" style="margin-top: 6px;" *ngIf="UserRole" >
        <div style="padding: 4px;margin-right: -10px;">
          <figure class="image is-48x48">
            <img class="is-rounded" src="https://bulma.io/images/placeholders/128x128.png">
          </figure>
        </div>
        <a class="navbar-item subtitle" style="color: azure;">
          Pharmacist
        </a>
      </div>
  
      <!-- <div class="navbar-start" style="margin-top: 6px;" *ngIf="CashierRole" >
        <div style="padding: 4px;margin-right: -10px;">
          <figure class="image is-48x48">
            <img class="is-rounded" src="https://bulma.io/images/placeholders/128x128.png">
          </figure>
        </div>
        <a class="navbar-item subtitle" style="color: azure;">
          Cashier
        </a>
      </div>
  
  
      <div class="navbar-start" style="margin-top: 6px;" *ngIf="ApharmacistRole" >
        <div style="padding: 4px;margin-right: -10px;">
          <figure class="image is-48x48">
            <img class="is-rounded" src="https://bulma.io/images/placeholders/128x128.png">
          </figure>
        </div>
        <a class="navbar-item subtitle" style="color: azure;">
          Assistant Pharmacist
        </a>
      </div> -->
  
    </div>
  
  </div>

  <!-- includes the log out button , search bar , and time -->
<div class="navbar-end level-right" >
  <div class="navbar-item level-item">

    <div class="navbar-item">
      <p class="control has-icons-left">
        <input class="input" type="text" placeholder="Search">
        <span class="icon is-left">
          <i class="fa fa-search" aria-hidden="true"></i>
        </span>
      </p>
    </div>


    <div class="buttons">
      <button class="button is-light" routerLink="/doctorLogin">
        Search
      </button>
      <button *ngIf="!userIsAuthenticated" class="button is-primary"  routerLink="/login">
        <strong>Log in as Admin</strong>
      </button>
      <button *ngIf="userIsAuthenticated" class="button is-primary" (click)="onLogout()" >
        <strong>Log out</strong>
      </button>
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
