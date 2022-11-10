<head>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<link rel="stylesheet" type="text/css" href="../css/jquery_dataTables.css">
        <script type="text/javascript" charset="utf8" src="../js/jquery_dataTables.js"></script>
<style>

.menu-list{
  border-radius: 2px;
  width: 220%;
  display: block;
  padding: 10px;
  }
  .btn{
    width: 100%;
    color:hsl(0, 0%, 21%);
    background-color: hsl(0, 0%, 88%);
    border-radius: 3px;
  }
  .newclass :hover{
    background-color: hsl(0, 0%, 21%);
    color: hsl(0, 0%, 88%);
  }

  /* external css: flickity.css */

*{
-webkit-box-sizing: border-box;
box-sizing: border-box;
}

body { font-family: sans-serif; }

.gallery {
background: #EEE;
}

.gallery-cell {
width: 66%;
height: 200px;
margin-right: 10px;
background: #8C8;
counter-increment:gallery-cell;
}

/* cell number */
.gallery-cell:before {
display: block;
text-align: center;
content: counter(gallery-cell);
line-height: 200px;
font-size: 80px;
color: white;
}

img:hover{
      transform:scale(3.0);
      margin-right: 30%;
    }

</style>
<script>
  $(document).ready( function () {
    $.noConflict(true);
    $('#drug_table').DataTable();

    //perform click action for add to cart
    $(".btnAddToCart").click(function(){
      $.ajax({
        url: "../ajax/ajax.php",
        method: "POST", 
        data: {action: "addToCart", id: $(this).attr('id')},
        success: function(result){
          var table = document.getElementById("shopping_cart").getElementsByTagName('tbody')[0];
          result = JSON.parse(result);
          $("#shopping_cart > tbody > tr").each(function(i){
            var cart_table = $(this);
            var pos_name = cart_table.find("td:eq(0)").text();
            var pos_manufacturer = cart_table.find("td:eq(1)").text();
            if(pos_name == result[0] && pos_manufacturer == result[1])
            {
              var pos_quantity = cart_table.find("td:eq(2)").text();
              result[2] = parseInt(pos_quantity) + 1;
              $("#shopping_cart > tbody > tr:eq("+ i +")").remove();
            }
          });
          var row = table.insertRow(-1);
            var name = row.insertCell(0);
            var manufacturer = row.insertCell(1);
            var quantity = row.insertCell(2);
            var price = row.insertCell(3);
            var total = row.insertCell(4);
            name.innerHTML = result[0];
            manufacturer.innerHTML = result[1];
            quantity.innerHTML = result[2];
            price.innerHTML = result[3];
            total.innerHTML = parseFloat(result[3]) * parseFloat(result[2]);

            var sub_total_amount = 0;
            var total = 0;
            //calculate total amount
            $("#shopping_cart > tbody > tr").each(function(i){
            var cart_table = $(this);
            sub_total_amount += parseFloat(cart_table.find("td:eq(-1)").text());
            var tax = sub_total_amount * 0.06;
            $("#lblSubTotal").html("RM " + sub_total_amount.toFixed(2));
            $("#lblTax").html("RM " + tax.toFixed(2));
            total = parseFloat(sub_total_amount.toFixed(2)) + parseFloat(tax.toFixed(2));
            $("#lblTotal").html("RM " + total.toFixed(2));
            });
        }
      });
    });

    //calculate balance
    $(".btnBalance").click(function(){
      var paid = $(".txtPaidAmount").val();
      var balance = 0;
      if(paid == ""){
        alert("Please enter amount!");
      }
      else{
        var total = parseFloat($("#lblTotal").text().substring(2));
        if(paid < total){
          alert("Insufficient amount!");
        }
        else{
          balance = paid - total;
          $("#lblBalance").html("RM " + balance.toFixed(2));
          $(".btnPrint").attr('id', 'clicked');
        }
      }
    });

    //print receipt
    $(".btnPrint").click(function(){
      if($(this).attr('id') == 'clicked'){
        alert('A');
      }
      else{
        alert('Please proceed to checkout before print bill!');
      }
    });
  });

</script>
</head>
<?php
include "../menu/menu.php";
?>
<section style="padding-top:5%; width: 98vw; padding-left: 18%">
  <p class="panel-heading" style="background-color:hsl(0, 0%, 88%) ;color:hsl(0, 0%, 21%);">
    Search Drugs
  </p>
  <div class="panel-block">
    <table class="table is-full" id="drug_table" style="width:100%;">
      <thead>
        <tr>
          <th>DRUG IMAGE</th>
          <th>DRUG MANUFACTURER</th>
          <th>DRUG NAME</th>
          <th>DRUG CATEGORY</th>
          <th>UNIT IN PACKAGE</th>
          <th>DRUG PRICE(RM)</th>
          <th></th>
        </tr>
      </thead>
    <?php
    $list_drugs = mysqli_query($Links, "SELECT * FROM tblmedicine ORDER BY drugName");
    if(mysqli_num_rows($list_drugs) > 0)
    {
      while($row = mysqli_fetch_array($list_drugs))
      {
        $get_image = mysqli_query($Links, "SELECT * FROM tblmedicine_image WHERE drug_image_id = ".$row["drug_image_id"]."");
        echo "<tr>
        <td>";
        if(mysqli_num_rows($get_image) > 0)
        {
          $row2 = mysqli_fetch_array($get_image);
          echo "<img src='../Medicine_Image/".$row2["image_path"]."' width='150px'>";
        }
        
        echo "</td>
        <td>".$row["manufacturer"]."</td>
        <td>".$row["drugName"]."</td>
        <td>".$row["drugCategory"]."</td>
        <td>".$row["no_of_unit_in_package"]."</td>
        <td>".$row["unitPrice"]."</td>
        <td><input type='button' value='Add to cart' id='".$row["DrugID"]."' class='btnAddToCart button is-small is-primary' style='font-weight: bold;margin-right: 1%;'></td>
        </tr>";
      }
    }
    ?>
    </table>
  </div>
</section>


<section class="panel" style="padding-top:5%; width: 98vw; padding-left: 18%">
  <p class="panel-heading" style="background-color:hsl(0, 0%, 88%) ;color:hsl(0, 0%, 21%)">
    Bill
  </p>
  <div class="panel-block ">
    <div  style="height: 300px; width: 100%;">
    <div style="overflow-y:auto ;overflow-x: hidden;height: 300px;">
              <table id="shopping_cart" class="table is-full" style="width:100%">
                <thead >
                  <tr>
                    <th>DRUG NAME</th>
                    <th>DRUG MANUFACTURER</th>
                    <th>QUANTITY</th>
                    <th>UNIT PRICE(RM)</th>
                    <th>TOTAL AMOUNT(RM)</th>
                  </tr>
                </thead>
                <tbody>

                </tbody>
              </table>
            </div>

    </div>
  </div>
</section>

<section class="panel" style="padding-top:5%; width: 98vw; padding-left: 18%">
        <p class="panel-heading" style="background-color:hsl(0, 0%, 88%) ;color:hsl(0, 0%, 21%)">
          Check Out
        </p>
      <form>
        <div class="panel-block ">
          <div  style=" width: 100%;">
            <br>
            <div class="field has-addons">
              <div class="control" style="margin-right: 20%;padding-top: 3%;">
                <label class="label">Sub Total : </label>
              </div>
              <div class="control" style="padding-top: 3%;">
                <label class="label" id="lblSubTotal">RM0</label>
              </div>
            </div>
            <br>

            <div class="field has-addons">
              <div class="control" style="margin-right: 20%;padding-top: 3%;">
                <label class="label">Tax(6%) : </label>
              </div>
              <div class="control" style="padding-top: 3%;">
                <label class="label" id="lblTax">RM0</label>
              </div>
            </div>
            <br>

            <div class="field has-addons">
              <div class="control" style="margin-right: 20%;padding-top: 3%;">
                <label class="label">Total : </label>
              </div>
              <div class="control" style="padding-top: 3%;">
                <label class="label" id="lblTotal">RM0</label>
              </div>
            </div>
            <br>

            <div class="field has-addons">
              <div class="control" style="margin-right: 0%;padding-top: 0%;">
                <label class="label">Paid Amount :</label>
              </div>
              <div class="control">
                <input class="input txtPaidAmount" type="number" step="0.1" placeholder="Enter amount" name="txtPaidAmount">
              </div>
            </div>
            <br>
            <div class="field has-addons">
              <div class="control" style="margin-right: 15%;padding-top: 3%;">
                <label class="label">Balance :</label>
              </div>
              <div class="control" style="padding-top: 3%;">
                <label class="label" id="lblBalance">RM0  </label>
              </div>
            </div>

          </div>
        </div>
        <div class="panel-block">
          <button class="btnBalance button is-primary   is-fullwidth" style="margin-right: 3px;"  type="button">
            Get Balance
          </button>
          <button type="button" class="btnPrint button is-primary is-fullwidth">Print Bill</button>
        </div>
      </form>
    </section>

