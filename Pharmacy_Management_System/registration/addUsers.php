<?php
  include "../menu/menu.php";
  include('../db.php');
  include('sendEmail.php');
?>
<div class="container">
<div style="margin-top: 0%; width:88%;">
    <div style="margin-top: 0.8%; height:900px;">

    <section class="panel" style="margin-left: 19.8% ; margin-top: -30px; width: 96.5%;">
    <?php
        if($_POST["btnAdd"])
          {
          
          $input_date=$_POST['joined'];
          $date=date("Y-m-d",strtotime($input_date));
          $pass = $_POST["name"];
          $password = str_replace(' ','',$pass);
          $code = rand();
          if ($_POST["role"] == "Employee")
          {
            $roless = 2;
          } else if ($_POST["role"] == "Pharmacist") {
            $roless = 3;
          };

          if ($_POST["status"] == "active")
          {
            $stat  = 0;
          } else if ($_POST["status"] == "inactive") {
            $stat = 1;
          };

          $sql = mysqli_query($Links, "INSERT INTO user(id, Name, Email, Date_joined, Salary, Shifts, job, status, password, roleID, `code`) VALUES(".mysqli_insert_id($Links).", '".$_POST["name"]."', '".$_POST["email"]."', '".$date."', '".$_POST["salary"]."', '".$_POST["shift"]."', '".$_POST["role"]."', '$stat', '$password', '$roless', '$code')");
          
          
            echo "Registration successfull. Please verify your email.";
        
            $sendMl->send($code);
        
          
            
          }
    

    ?>
    <?php if($_SESSION['roleID'] == 1){ ?>
  <p class="panel-heading" style="background-color:hsl(0, 0%, 88%) ;color:hsl(0, 0%, 21%)">
    Registration
  </p>
  <div class="panel-block" style="height: auto">
    <div  style="height: 900px; width: 87.5vw; padding: 2%;">

    <div style="overflow-y:auto ;overflow-x: hidden;height: 900px;">

<div class="spinner-box loadCenter">

<form method="post">

<div class="field">
  <label class="label" >USER NAME</label>
  <input type="text" class="is-center input" name="name" style="width: 100%;" placeholder="Seymour Butts" required/>
</div>

<div class="field">
  <label class="label" >USER EMAIL</label>
  <input type="email" class="is-center input" name="email" style="width: 100%;" placeholder="seymour@butts.com" required/>
</div>

<div class="field">
  <label class="label" >DATE OF BIRTH</label>
  <input type="date"  class="is-center input" name="dob" style="width: 100%;" required/>
</div>

<div class="field">
  <label class="label" >DATE JOINED</label>
  <input type="date"  class="is-center input" name="joined" style="width: 100%;" required/>
</div>

<div class="field">
  <label class="label" >SALARY</label>
  <input type="number" class="is-center input" name="salary" style="width: 100%;" placeholder="1000" required/>
</div>

<div class="field">
  <label class="label">SHIFT</label>
  <input list="shifts" name= "shift">
  <datalist  id="shifts">
    <option value="Morning Shift">
    <option value="Afternoon Shift">
    <option value="Evening Shift">
    <option value="Night Shift">
  </datalist>
</div>

<div class="field">
  <label class="label">ROLE</label>
  <input list="roles" name= "role">
  <datalist  id="roles">
    <option value="Employee">
    <option value="Pharmacist">
  </datalist>
</div>

<div class="field">
  <label class="label">STATUS</label>
  <input list="statuses" name= "status">
  <datalist  id="statuses">
    <option value="active">
    <option value="inactive">
  </datalist>
</div>

<div style="width: 100%;margin-top: 40px;">
  <input type="submit" class="button is-primary is-fullwidth" name="btnAdd" value="Insert">
</div>
</form>
</div>
    </div>
  </div>
    </section>
    <?php }
    else echo "No privilege to access this page"; ?>
</div>