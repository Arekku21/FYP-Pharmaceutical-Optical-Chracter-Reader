<head>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<link rel="stylesheet" type="text/css" href="../css/jquery_dataTables.css">
<script type="text/javascript" charset="utf8" src="../js/jquery_dataTables.js"></script>
<?php
include "../menu/menu.php";
?>
<div >
  <div style="margin-top: 0%; width:85vw;">
    <div style="margin-top: 0.8%; height:900px;">
      <section class="section columns">
        <div class="column is-full-desktop is-full-mobile" style="margin-left: 18.5%; margin-top: 4%;">
          <div class="tabs is-toggle is-fullwidth">
            <ul>
              <li >
                <a href="pos.php">
                  <span>Payment</span>
                </a>
              </li>

              <li class="is-active ">
                <a href="refund.php">
                  <span>Refund</span>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </section>
<script>
  $(document).ready( function () {
    $.noConflict(true);
    $('#drug_table').DataTable();
    //perform click action for add to cart
    $(".btnRefund").click(function(){
        var id = $(this).attr('id');
        $.ajax({
          url: "../ajax/ajax.php",
          method: "POST", 
          data: {action: "refund", id: id},
          success: function(result){
              $("#invoiceID").text(id);
              $("#refundList").html(result);
              document.getElementById("refundView").scrollIntoView();
              $("input[name='chkRefund']").click(function(){
                if($(this).is(':checked')){
                  var status = "add"
                }
                else status = "minus";
                var position = $(this).val();
                var amount = $("#refundAmount").text();
                $.ajax({
                  url: "../ajax/ajax.php",
                  method: "POST", 
                  data: {action: "calculateRefundAmount", position: position, id: id, status: status, amount:amount.trim()},
                  success: function(result){
                    $("#refundAmount").text(result);
                  }
                });
              });
          }
        });
    });

    $(".btnRefund2").click(function(){
      if($("#refundList").html() == ""){
        alert("Please select the invoice id to proceed the refund process!");
      }
      else{
        if($("input[name='chkRefund']").is(':checked')){
          var id = $("#invoiceID").text();
          var position = $("input[name='chkRefund']:checked").map(function(){
                          return $(this).val();
                        }).get();
          position = position.join(":");
          $.ajax({
            url: "../ajax/ajax.php",
            method: "POST", 
            data: {action: "proceedRefund", position: position, id: id},
            success: function(result){
              $("#refundAmount").text('0');
              alert(result.trim());
              $("#" + id).trigger("click");
            }
          });
        }
        else{
          alert("No");
        }
      }
    });
  });
</script>
</head>
<section style="padding-top:0%; width: 98vw; padding-left: 20%">
  <p class="panel-heading" style="background-color:hsl(0, 0%, 88%) ;color:hsl(0, 0%, 21%);">
    Past Orders
  </p>
  <div class="panel-block">
    <table class="table is-full" id="drug_table" style="width:100%;">
      <thead>
        <tr>
          <th width='100px'>InvoiceID</th>
          <th width='200px'>PURCHASE DATE</th>
          <th width='200px'>PURCHASE TIME</th>
          <th width='250px'>TOTAL AMOUNT(RM)</th>
          <td width='900px'></td>
        </tr>
      </thead>
      <tbody>
    <?php
    $list_drugs = mysqli_query($Links, "SELECT purchaseInvoiceID, DATE(purchaseDate) as dt, TIME(purchaseDate) as tm, totalAmount FROM tblpurchase_invoice ORDER BY purchaseDate");
    if(mysqli_num_rows($list_drugs) > 0)
    {
      while($row = mysqli_fetch_array($list_drugs))
      {
        echo "<tr>";
        echo "<td>".$row["purchaseInvoiceID"]."</td>
        <td>".$row["dt"]."</td>
        <td>".$row["tm"]."</td>
        <td>RM ".$row["totalAmount"]."</td>
        <td align='center'><input type='button' value='Proceed Refund' id='".$row["purchaseInvoiceID"]."' class='btnRefund button is-small is-primary' style='font-weight: bold;margin-right: 1%;'></td>
        </tr>";
      }
    }
    ?>
    </tbody>
    </table>
  </div>
</section>


<section class="panel" id="refundView" style="padding-top:5%; width: 98vw; padding-left: 20%">
  <p class="panel-heading" style="background-color:hsl(0, 0%, 88%) ;color:hsl(0, 0%, 21%)">
    InvoiceID # <span id="invoiceID"></span>
  </p>
  <div class="panel-block" >
    <div  style="height: 300px; width: 100%;">
        <div style="overflow-y:auto ;overflow-x: hidden;height: 300px;">
            <div id='refundList'></div>
        </div>
    </div>
  </div>
  <div class="panel-block">
        <button class="btnRefund2 button is-primary   is-fullwidth" style="margin-right: 3px;"  type="button">
            Refund
        </button>
    </div>
</section>
    <br>
  </div>
  </div>