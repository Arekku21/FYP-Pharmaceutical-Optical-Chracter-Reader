<link rel="icon" type="image/x-icon" href="favicon.ico">
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.5/css/bulma.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <!-- <link href="../css/index.css" rel="stylesheet"/> -->
<?php
include "../menu/menu.php";
?>
<br>
<div class="container" style="margin-top: 0%;">
  <div class="container-fluid">
    <div class="row-fluid" style="...">
      <div class="card" style="left:8%; width:23rem; height:30%; border-style:solid; border-width:10px; border-radius:10px; float:right; margin-top:5%; margin-right:40px;">
        <div class="card-body">

          <h1 style="font-size:20px; text-align:center;">Number of Employees</h1>
          <h1 style="font-size:24px; text-align:center;">
            <?php
              $count=0;
              $res=mysqli_query($Links, "select * from user");
              $count=mysqli_num_rows($res);
              echo $count;
            ?>
          </h1>
          </h1>

          </div>
          <a href="../employee/employeeList.php"><input type="submit"  name="submit_btn" class="button is-block is-primary is-medium is-fullwidth" value="Employees" style="margin-bottom: 15px; margin-top:10px;background-color:#150050"></a>
    </div>

    <div class="card" style="left:8%; width:23rem; height:30%; border-style:solid; border-width:10px; border-radius:10px; float:right; margin-top:5%; margin-right:10px;">
          <div class="card-body">
          <h1 style="font-size:20px; text-align:center;">Drug Quantity</h1>
          <h1 style="font-size:24px; text-align:center;">
            <?php
              $count=0;
              $res=mysqli_query($Links, "select * from tblmedicine");
              $count=mysqli_num_rows($res);
              echo $count;
            ?>
          </h1>
          </h1>

          </div>
          <a href="../inventory/inventoryList.php"><input type="submit"  name="submit_btn" class="button is-block is-primary is-medium is-fullwidth" value="Drugs" style="margin-bottom: 15px; margin-top:10px; background-color:#150050"></a>
    </div>

    <div class="card" style="left: 8%; width:23rem; border-style:solid; border-width:10px; border-radius:10px; float:right; margin-top:5%; margin-right:10px;">
          <div class="card-body">
          <h1 style="font-size:20px; text-align:center;">Expired Notifications</h1>
          <h1 style="font-size:24px; text-align:center;">
            <?php
              $count=0;
              $res=mysqli_query($Links, "SELECT * FROM tblmedicine, tblstored_drug WHERE tblmedicine.DrugID = tblstored_drug.DrugID AND tblstored_drug.expiryDate < '".date('Y-m-d')."'");

              if(mysqli_num_rows($res) > 0)
                {
                  for($i = 0; $i < mysqli_num_rows($res); $i++)
                  {
                    $row = mysqli_fetch_array($res);
                    echo $row["drugName"].'<br>';
                  }
                } 
                else {
                  echo 'None';
                }
            ?>
          </h1>
          </h1>

          </div>
          <a href="../inventory/expired.php"><input type="submit"  name="submit_btn" class="button is-block is-primary is-medium is-fullwidth" value="Expired Drugs" style="margin-bottom: 15px; margin-top:10px; background-color:#150050"></a>
    </div>

          <div class="card" style="left:7%; width:70rem; height:27rem; border-style:solid; border-width:10px; border-radius:5px; float:right; margin-top:15px; margin-right:30px;">
          <div class="card-body">
          <h1 style="font-size:20px; text-align:center;">Sales Information</h1>
          <h1 style="font-size:24px; text-align:center;">

          <div id="my-chart" style="width: 100%;"></div>

          <script type="text/javascript">
            google.charts.load('current', {
              'packages': ['corechart'],
              'mapsApiKey': 'AIzaSyD0UKyZ2eq4DmHKoDjCR4gU4kqq0xsWghM'
            });
            google.charts.setOnLoadCallback(drawRegionsMap);

            function drawRegionsMap() {
              var data = google.visualization.arrayToDataTable([
                ['Date','Drugs'],
                  <?php
                    $chartQuery = "SELECT * FROM tblpurchase_invoice";
                    $chartQueryRecords = mysqli_query($Links, $chartQuery);
                      while($row = mysqli_fetch_assoc($chartQueryRecords)){
                        $date = ".$row[purchaseDate].";
                        $times = date('d-m-Y',strtotime($date));

                        echo"['$times',".$row['totalAmount']."],";
                      }
                  ?>
            ]);
          
              var options = {

              };

              var chart = new google.visualization.LineChart(document.getElementById('my-chart'));
              chart.draw(data, options);

            }
            </script>

          </h1>
          </h1>

          </div>
          <a href="../report/dailyReport.php"><input type="submit"  name="submit_btn" class="button is-block is-primary is-medium is-fullwidth" value="Sales Report" style="margin-bottom:2px;background-color:#150050"></a>
    </div>

          <div class="card" style="left:6%; width:35rem; border-style:solid; border-width:10px; border-radius:10px; float:right; margin-top:15px; margin-right:10px; ">
          <div class="card-body">
          <h1 style="font-size:20px; text-align:center;">Out of Stock Drugs</h1>
          <h1 style="font-size:24px; margin-left: 20px;">
          <?php
              $count=0;
              $sql = mysqli_query($Links, "SELECT DISTINCT DrugID from tblstored_drug WHERE NOT EXISTS(SELECT * from tblmedicine WHERE tblmedicine.DrugID = tblstored_drug.DrugID) OR (SELECT DISTINCT DrugID FROM tblmedicine WHERE tblmedicine.DrugID = tblstored_drug.DrugID AND tblstored_drug.quantity = 0)");
              if(mysqli_num_rows($sql) > 0)
              {
                for($i = 0; $i < mysqli_num_rows($sql); $i++)
                {
                  $row = mysqli_fetch_array($sql);
                  $check_row = mysqli_query($Links, "SELECT * FROM tblstored_drug WHERE DrugID = ".$row["DrugID"]." AND quantity > 0");
                  if(mysqli_num_rows($check_row) == 0)
                  {
                    $sql2 = mysqli_query($Links, "SELECT * FROM tblmedicine WHERE DrugID = ".$row["DrugID"]."");
                    if(mysqli_num_rows($sql2) > 0)
                    {
                      $count++;
                      $row2 = mysqli_fetch_array($sql2);
                      echo $count.". ".ucwords(strtolower($row2["drugName"]))." - ".ucwords(strtolower($row2["manufacturer"]))."<br>";
                    }
                  }
                }
              }
              else {
                echo 'None';
              }
            ?>
          </h1>
          </h1>

          </div>
          <a href="../inventory/outofstock.php"><input type="submit"  name="submit_btn" class="button is-block is-primary is-medium is-fullwidth" value="Out of Stock" style="margin-bottom: 15px; margin-top:10px; background-color:#150050"></a>
    </div>

          <div class="card" style="left:6%; width:35rem; border-style:solid; border-width:10px; border-radius:10px; float:right; margin-top:15px; margin-right:10px;">
          <div class="card-body">
          <h1 style="font-size:20px; text-align:center;">Drugs About to Expire</h1>
          <h1 style="font-size:24px; margin-left: 20px;">
          <?php
              $count=0;
              $sql = mysqli_query($Links, "SELECT * FROM tblmedicine, tblstored_drug WHERE tblmedicine.DrugID = tblstored_drug.DrugID AND DATE(tblstored_drug.expiryDate) >= CURDATE() AND DATE(tblstored_drug.expiryDate) <= DATE(LAST_DAY(NOW() + INTERVAL 1 MONTH))");
              if(mysqli_num_rows($sql) > 0)
              {
                for($i = 0; $i < mysqli_num_rows($sql); $i++)
                {
                  $row = mysqli_fetch_array($sql);
                  echo ($i+1).". ".ucwords(strtolower($row["drugName"]))." - ".$row["batchNo"]. " (".$row["expiryDate"].")"."<br>";
                }
              }
                else {
                  echo 'None';
                }
            ?>
          </h1>
          </h1>

          </div>
          <a href="../inventory/expiringSoon.php"><input type="submit"  name="submit_btn" class="button is-block is-primary is-medium is-fullwidth" value="Drugs to be Expired Page" style="margin-bottom: 15px; margin-top:10px; background-color:#150050"></a>
    </div>
        </div>
      </div>
    </div>
  </div>
</div>