<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
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

    $("#sMonth").change(function(){
      var month = $(this).val();
      var year = $("#sYear").val();
      $.ajax({
        url: "../ajax/ajax.php",
        method: "POST",
        data: {action: "reportMonth", month: month, year: year},
        success: function(result){
          $("#drug_table tbody").html(result);
          $("#txtMonth").text(month + " - " + year);
        }
      });
    });
    $("#sYear").change(function(){
      var month = $("#sMonth").val();
      var year = $("#sYear").val();
      $.ajax({
        url: "../ajax/ajax.php",
        method: "POST",
        data: {action: "reportMonth", month: month, year: year},
        success: function(result){
          $("#drug_table tbody").html(result);
          $("#txtMonth").text(month + " - " + year);
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
              <li>
                <a href="overview.php">
                  <span>Overview</span>
                </a>
              </li>

              <li>
                <a href="dailyReport.php">
                  <span>Sales Report (Daily)</span>
                </a>
              </li>

              <li class="is-active ">
                <a href="monthlyReport.php">
                  <span>Sales Report (Monthly)</span>
                </a>
              </li>
            </ul>
          </div>
          <span>Month:
              <select id="sMonth">
                <?php
                for($i =1;$i<=12;$i++)
                {
                  echo "<option ";
                  if(date("F", strtotime("$i/12/10")) == date('F'))
                    echo "selected ";
                  echo ">".date("F", strtotime("$i/12/10"))."</option>";
                }
                ?>
              </select>
          </span>
          <span>Year:
              <select id="sYear">
                <option></option>
                <?php
                $sql = mysqli_query($Links, "SELECT DISTINCT YEAR(purchaseDate) AS  yr FROM tblpurchase_invoice");
                if(mysqli_num_rows($sql) > 0)
                {
                  for($i =0;$i<mysqli_num_rows($sql);$i++)
                  {
                    $row = mysqli_fetch_array($sql);
                    echo "<option ";
                    if(strtotime(date('Y')) == strtotime($row["yr"]))
                      echo "selected ";
                    echo ">".$row["yr"]."</option>";
                  }
                }
                ?>
              </select>
          </span>
            <?php 
          }
          else echo "No priviledge to access this page";
          ?>
        </div>
      </section>

      <?php if($_SESSION['roleID'] == 1) : ?>
    <section class="panel" style="margin-left: 19.8% ; margin-top: -30px; width: 96.5%;">
  <p class="panel-heading" style="background-color:hsl(0, 0%, 88%) ;color:hsl(0, 0%, 21%)">
    Monthly Sales Report (<strong><span id="txtMonth"><?php echo date('F'); ?></span></strong>)
  </p>
  <div class="panel-block" style="height: auto">
    <div  style="height: 660px; width: 87.5vw; padding: 0%;">
    <div style="overflow-y:auto ;overflow-x: hidden;">
  <table class="table is-full "  >
    <tbody>

      <div class="spinner-box loadCenter is-center">
      </div>
        <tr  >
                <table id="drug_table" class="table is-full" style="width: 100%;">
                  <thead style="font-weight: bold;">
                    <td>#</td>
                    <td>DRUG BATCH NO</td>
                    <td>DRUG NAME</td>
                    <td>SOLD QUANTITY</td>
                    <td>DRUG PRICE</td>
                    <td>TOTAL PRICE</td>
                  </thead>
                  <tbody>
                  <?php 
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
                          echo '<tr>
                          <td style="width: 10%;">'.($i+1).'</td>
                          <td style="width: 20%;">'.$unique_batch[$i].'</td>
                          <td style="width: 20%;">'.ucwords(strtolower($drugNameArr[$unique_batch[$i]])).'</td>
                          <td style="width: 20%;">'.$item.'</td>
                          <td style="width: 20%;">'.$drugPriceArr[$unique_batch[$i]].'</td>
                          <td style="width: 20%;">'.($item * $drugPriceArr[$unique_batch[$i]]).'</td>
                          </tr>
                          ';
                          $total += $item * $drugPriceArr[$unique_batch[$i]];
                        }
                      }
                    }
                    echo "<tr>
                    <td style='font-size: 0'>S</td>
                    <td style='font-size: 0'>A</td>
                    <td style='font-size: 0'>A</td>
                    <td style='font-size: 0'>A</td>
                    <td style='text-align: right; font-size:25px;'>Total:</td>
                    <td style='font-size:25px;'>RM ".$total."</td></tr>";
                  }
                  ?>
                  </tbody>
                </table>
          <br>
        </tr>
      </div>
    </tbody>
  </table>
  </div>
    </div>
  </div>
    </section>
    <?php endif; ?>
</div>