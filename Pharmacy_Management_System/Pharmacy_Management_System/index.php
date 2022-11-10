<!DOCTYPE html>
<html>
    <head>
        
        <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script src="https://www.gstatic.com/charts/loader.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <link rel="icon" type="image/x-icon" href="favicon.ico">
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.5/css/bulma.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" rel="stylesheet">
        <link href="css/index.css" rel="stylesheet"/>
    </head>
    <body>
        <div class="container" style="background-color: #041221;max-width: none;margin-top: -1%;">
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
                                <figure class="avatar">
                                    <!-- <img src="https://placehold.it/128x128"> -->
                                </figure>
                            </div>
        
                            <div class="box">
                                <form (submit)="onLogin(loginForm)" #loginForm="ngForm">
                                    <div class="field">
                                        <div class="control">
        
                                            <input name="email" ngModel #emailInput="ngModel" class="input is-medium" type="email" placeholder="Your Email" autofocus="" required email>
                                            <p class="login-error" *ngIf="!emailInput.valid && emailInput.touched">Please enter valid email</p>
        
                                        </div>
                                    </div>
        
                                    <div class="field">
                                        <div class="control">
        
                                            <input name="password" ngModel #passwordInput="ngModel" class="input is-medium" type="password" placeholder="Your Password" required>
                                              <p class="login-error" *ngIf="!passwordInput.valid && passwordInput.touched">Please enter valid password</p>
        
                                        </div>
                                    </div>
                                    <div class="field">
                                        <label class="checkbox">
                                        <input type="checkbox">
                                        Remember me
                                      </label>
                                    </div>
                                    <button class="button is-block is-primary is-medium is-fullwidth" type="submit">Login <i class="fas fas-sign-in" aria-hidden="true"></i></button>
                                </form>
        
        
                            </div>
                            <p class="has-text-grey" style="color: #00d1b2;">
                                <a style="color: #00d1b2;" routerLink="/signup">Sign Up</a> &nbsp;·&nbsp;
                                <a style="color: #00d1b2;" routerLink="/">Forgot Password</a> &nbsp;·&nbsp;
                                <a style="color: #00d1b2;" href="../">Need Help?</a>
                            </p><br><br><br>
                            <!-- <p class="subtitle ">Please login to proceed.</p> -->
                            <a class=" level-item logo-margin" >
                              <img src="image/pharmacare-logo-hori-tagline-2.png" width="152" height="140">
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        
            </div>
        </div>        
    </body>
</html>