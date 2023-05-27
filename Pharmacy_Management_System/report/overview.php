<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"> -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script> -->
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<link rel="stylesheet" type="text/css" href="../css/jquery_dataTables.css">
<script type="text/javascript" charset="utf8" src="../js/jquery_dataTables.js"></script>
<head>
<style>

  .menu-list{
    border-radius: 2px;
    width: 220%;
    display: block;
    padding: 10px;
    }
    .btn{
      width: 100%;
      /* color:hsl(0, 0%, 21%); */
      color: black;
      background-color: hsl(0, 0%, 88%);
      border-radius: 3px;
    }
    .newclass :hover{
      background-color: hsl(0, 0%, 21%);
      color: hsl(0, 0%, 88%);
    }

    #img:hover{
      z-index: 1;
      position: relative;
      transform:scale(2.0);
    }

    .is-active{
      z-index: 0;
    }

    
</style>
<script>
  $(document).ready( function () {
    $.noConflict(true);
    $('#drug_table').DataTable();

    $("#date").change(function(){
      var date = $(this).val();
      $.ajax({
        url: "../ajax/ajax.php",
        method: "POST",
        data: {action: "reportDaily", date: date},
        success: function(result){
          $("#drug_table tbody").html(result);
          $("#txtDate").text(date);
        }
      });
    });
  });
</script>
</head>
<?php
include "../menu/menu.php";
?>
<div class="container">
  <div style="margin-top: 0%; width:88%;">
    <div style="margin-top: 0.8%; height:900px;">
      <section class="section columns">
        <div class="column is-full-desktop is-full-mobile" style="margin-left: 18.5%; margin-top: 4%">
        <?php if($_SESSION['roleID'] == 1){ ?>
          <div class="tabs is-toggle is-fullwidth">
          <ul>
              <li class="is-active ">
                <a href="overview.php">
                  <span>Overview</span>
                </a>
              </li>
              <li>
                <a href="dailyReport.php">
                  <span>Sales Report (Daily)</span>
                </a>
              </li>

              <li>
                <a href="monthlyReport.php">
                  <span>Sales Report (Monthly)</span>
                </a>
              </li>
            </ul>
          </div>
          <?php 
          }
          else echo "No privilege to access this page";
          ?>
        </div>
      </section>

      <?php if($_SESSION['roleID'] == 1) : ?>
    <section class="panel" style="margin-left: 19.8% ; margin-top: -30px; width: 96.5%;">
    <!-- <div class="container" style="margin-top: 0%;"> -->
    <div class="row"> 
  <!-- <div class="container-fluid"> -->
    <!-- <div class="row-fluid" style="..."> -->
        <!-- <div class="card-cointaner"> -->
        <div class="col-md-4">
      <div class="card" style="width:23rem; height:30%; border-style:solid; border-width:10px; border-radius:10px; margin-right:40px;">
        <div class="card-body">

          <h1 style="font-size:24px; text-align:center;">Number of Employees</h1>
          <h1 style="font-size:20px; text-align:center;">
            <?php
              $count=0;
              $res=mysqli_query($Links, "select * from user");
              $count=mysqli_num_rows($res);
              echo "<br><b>".$count." people</b>";
            ?>
          </h1>
          </h1>

          </div>
          <a href="../employee/employeeList.php"><input type="submit"  name="submit_btn" class="button is-block is-success is-medium is-fullwidth" value="Employees" style="margin-bottom: 15px; margin-top:10px;"></a>
        </div>
    </div>

    <div class="col-md-4">
    <div class="card" style="width:23rem; height:30%; border-style:solid; border-width:10px; border-radius:10px; margin-right:10px">
          <div class="card-body">
          <h1 style="font-size:24px; text-align:center;">Monthly Sales</h1>
          <h1 style="font-size:20px; text-align:center;">
            <?php
                $count=0;
                $sql = mysqli_query($Links, "SELECT * FROM tblpurchase_invoice WHERE DATE_FORMAT(purchaseDate, '%M') = '".date('F')."'");
                if(mysqli_num_rows($sql) > 0)
                {
                  $drugBatchArr = array();
                  $drugNameArr = array();
                  $drugPriceArr = array();
                  $storeBatch = array();
                  for($i = 0; $i < mysqli_num_rows($sql); $i++)
                  {
                    $row = mysqli_fetch_array($sql);
                    $drugName = explode(":", $row["drugID"]);
                    $drugQty = explode(":", $row["drugQty"]);
                    $drugPrice = explode(":", $row["drugPrice"]);
                    $drugBatchNo = explode(":", $row["drugBatchNo"]);
                    for($j = 0; $j < count($drugBatchNo); $j++)
                    {
                      if($drugQty[$j] > 0)
                      {
                        $drugBatchArr[$drugBatchNo[$j]] += $drugQty[$j];
                        $drugNameArr[$drugBatchNo[$j]] = $drugName[$j];
                        $drugPriceArr[$drugBatchNo[$j]] = $drugPrice[$j];
                        array_push($storeBatch, $drugBatchNo[$j]);
                      }
                    }
                  }
                  ksort($drugArr);
                  $unique_batch = array_unique($storeBatch);
                  // print_r($drugArr);
                  $total = 0;
                  foreach ($drugBatchArr as $key => $item)
                  {
                    for($i = 0; $i < count($unique_batch); $i++)
                    {
                      // echo $drugBatchNo[$i]."<br>";
                      if($unique_batch[$i] == $key)
                      {
                        $total += $item * $drugPriceArr[$unique_batch[$i]];
                      }
                    }
                  }
                  echo "<br><b>RM".$total."</b>"; 
                }
            ?>
          </h1>
          </h1>

          </div>
          <a href="../inventory/inventoryList.php"><input type="submit"  name="submit_btn" class="button is-block is-primary is-medium is-fullwidth" value="Sales Report<?php echo "(".date("M").")" ?>" style="margin-bottom: 15px; margin-top:10px;"></a>
      </div>
    </div>

    <div class="col-md-4">
    <div class="card" style="width:23rem; border-style:solid; border-width:10px; border-radius:10px; margin-right:10px;">
          <div class="card-body">
          <h1 style="font-size:24px; text-align:center;">Expired Notifications</h1>
          <h1 style="font-size:20px; text-align:center;">
            <?php
              $count=0;
              $res=mysqli_query($Links, "SELECT * FROM tblmedicine, tblstored_drug WHERE tblmedicine.DrugID = tblstored_drug.DrugID AND tblstored_drug.expiryDate < '".date('Y-m-d')."'");

              if(mysqli_num_rows($res) > 0)
                echo "<br><b>".mysqli_num_rows($res)." drugs expired</b>";
                // {
                //   for($i = 0; $i < mysqli_num_rows($res); $i++)
                //   {
                //     $row = mysqli_fetch_array($res);
                //     echo "<li>".ucwords(strtolower($row["drugName"]))." (".$row["batchNo"].")".'</li>';
                //   }
                // } 
                else {
                  echo "<br><b>None</b>";
                }
            ?>
          </h1>
          </h1>

          </div>
          <a href="../inventory/expired.php"><input type="submit"  name="submit_btn" class="button is-block is-danger is-medium is-fullwidth" value="Expired Drugs" style="margin-bottom: 15px; margin-top:10px;"></a>
            </div>
    </div>
            </div>

          <div class="card" style="width:70rem; height:27rem; border-style:solid; border-width:10px; border-radius:5px; margin-top:15px; margin-right:30px;">
          <div class="card-body">
          <h1 style="font-size:24px; text-align:center;">Sales Information</h1>
          <h1 style="font-size:20px; text-align:center;">

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
          <a href="../report/dailyReport.php"><input type="submit"  name="submit_btn" class="button is-block is-dark is-medium is-fullwidth" value="Sales Report" style="margin-bottom:2px;"></a>
    </div>

    <div class="row">
        <div class="col-md-6">
          <div class="card" style="width:35rem; border-style:solid; border-width:10px; border-radius:10px; margin-top:15px">
          <div class="card-body">
          <h1 style="font-size:24px; text-align:center;">Out of Stock Drugs</h1>
            <h1 style="font-size:20px; margin-left: 20px; text-align:center;">
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
                    echo "<br><b>None</b>";
                }
                ?>
            </h1>
          </h1>

          </div>
          <a href="../inventory/outofstock.php"><input type="submit"  name="submit_btn" class="button is-block is-info is-medium is-fullwidth" value="Out of Stock" style="margin-bottom: 15px; margin-top:10px;"></a>
        </div>
    </div>

    <div class="col-md-6">
          <div class="card" style="width:35rem; border-style:solid; border-width:10px; border-radius:10px; margin-top:15px;">
          <div class="card-body">
          <h1 style="font-size:24px; text-align:center;">Drugs About to Expire</h1>
          <h1 style="font-size:20px; margin-left: 20px; text-align:center;">
          <?php
              $count=0;
              $sql = mysqli_query($Links, "SELECT * FROM tblmedicine, tblstored_drug WHERE tblmedicine.DrugID = tblstored_drug.DrugID AND DATE(tblstored_drug.expiryDate) >= CURDATE() AND DATE(tblstored_drug.expiryDate) <= DATE(LAST_DAY(NOW() + INTERVAL 1 MONTH))");
              if(mysqli_num_rows($sql) > 0)
              {
                echo "<br><b>".mysqli_num_rows($sql)." drugs</b>";
                // for($i = 0; $i < mysqli_num_rows($sql); $i++)
                // {
                //   $row = mysqli_fetch_array($sql);
                //   echo ($i+1).". ".ucwords(strtolower($row["drugName"]))." - ".$row["batchNo"]. " (".$row["expiryDate"].")"."<br>";
                // }
              }
                else {
                  echo "<br><b>None</b>";
                }
            ?>
          </h1>
          </h1>

          </div>
          <a href="../inventory/expiringSoon.php"><input type="submit"  name="submit_btn" class="button is-warning is-primary is-medium is-fullwidth" value="Drugs to be Expired Page" style="margin-bottom: 15px; margin-top:10px;"></a>
            </div>
    </div>
        </div>
      </div>
    <!-- </div> -->
  <!-- </div> -->
<!-- </div> -->
    </section>
    <?php endif; ?>
</div>