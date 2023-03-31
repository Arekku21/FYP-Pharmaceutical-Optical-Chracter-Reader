<?php
include "../menu/menu.php";
?>
<div class="container">
<div style="margin-top: 0%; width:88%;">
    <div style="margin-top: 0.8%; height:900px;">
      <section class="section columns">
        <div class="column is-full-desktop is-full-mobile" style="margin-left: 18.5%; margin-top: 4%">
          <div class="tabs is-toggle is-fullwidth">
            <ul>
              <li class="is-active" >
                
                <a href="addEmployee.php">
                  <span>Add new Employee</span>
                </a>
              </li>

              <li>
                <a href="employeeList.php">
                  <span>Employee List</span>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </section>

    <section class="panel" style="margin-left: 19.8% ; margin-top: -30px; width: 96.5%;">
    <?php
        if($_POST["btnAdd"])
        {

          $input_date=$_POST['joined'];
          $date=date("Y-m-d",strtotime($input_date));

          $sql = mysqli_query($Links, "INSERT INTO employee(id, Name, Email, Date_joined, Salary, Shifts) VALUES(".mysqli_insert_id($Links).", '".$_POST["name"]."', '".$_POST["email"]."', '".$date."', '".$_POST["salary"]."', '".$_POST["shift"]."')");
          if($sql)
            echo "<script>alert('Employee added success!');</script>";
          else echo "<script>alert('Fail to add new employee!');</script>";
        }
    ?>
    <?php if($_SESSION['roleID'] == 1){ ?>
  <p class="panel-heading" style="background-color:hsl(0, 0%, 88%) ;color:hsl(0, 0%, 21%)">
    Add Employee
  </p>
  <div class="panel-block" style="height: auto">
    <div  style="height: 900px; width: 87.5vw; padding: 2%;">

    <div style="overflow-y:auto ;overflow-x: hidden;height: 900px;">

<div class="spinner-box loadCenter">

<form method="post">

<div class="field">
  <label class="label" >EMPLOYEE NAME</label>
  <input type="text" class="is-center input" name="name" style="width: 100%;" placeholder="Seymour Butts" required/>
</div>

<div class="field">
  <label class="label" >EMPLOYEE EMAIL</label>
  <input type="email" class="is-center input" name="email" style="width: 100%;" placeholder="seymour@butts.com" required/>
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