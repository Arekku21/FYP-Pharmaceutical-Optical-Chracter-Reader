<head>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<link rel="stylesheet" type="text/css" href="../css/jquery_dataTables.css">
<script type="text/javascript" charset="utf8" src="../js/jquery_dataTables.js"></script>
<?php
include "../menu/menu.php";
?>
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
            quantity.innerHTML = result[2]+ "<input type='hidden' name='quantity[]' value='" + result[2] + "'><input type='hidden' name='drugID[]' value='" + result[4] + "'>";
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
              $("#taxAmount").html(tax.toFixed(2));
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
      var rowCount = $('#shopping_cart tbody tr').length;
      if(rowCount == 0){
        alert("Cart is empty!");
      }
      else{
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
            var quantity = $("input[name='quantity[]']").map(function(){return $(this).val();}).get();
            var drugID = $("input[name='drugID[]']").map(function(){return $(this).val();}).get();
            var tax =  $("#taxValue").text() + ":" + $("#taxAmount").text();
            quantity = quantity.join(":");
            drugID = drugID.join(":");
            $.ajax({
              url: "../ajax/ajax.php",
              method: "POST",
              data: {action: "reduceStock", id: drugID, quantity: quantity, balance: Number(balance).toFixed(2), paid: Number(paid).toFixed(2), total: Number(total).toFixed(2), tax: tax},
              success: function(result){
                var split = result.split("-");
                alert(split[0]);
                window.open("invoice.php?invoiceID=" + split[1]);
                // location.reload();
              }
            });
            //print bill logic here
            //....
          }
        }
      }
    });

    $(".btnUpload").click(function(){
      var file_data = $('#image').prop('files')[0]; 
      var form_data = new FormData();
      form_data.append('image', file_data);
      form_data.append('action', 'uploadImage');
      $.ajax({
        url: "../ajax/ajax.php",
        method: "POST",
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        success: function(result){
          $.ajax({
          url: "../ajax/ajax.php",
          method: "POST",
          data: {action: "searchDrug", result: result},
          success: function(result2){
             alert("AI extracted word: " + result);
            $("#drug_table > tbody").html(result2);
           // result = JSON.parse(result);
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
                    quantity.innerHTML = result[2]+ "<input type='hidden' name='quantity[]' value='" + result[2] + "'><input type='hidden' name='drugID[]' value='" + result[4] + "'>";
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
                    $("#taxAmount").html(tax.toFixed(2));
                    total = parseFloat(sub_total_amount.toFixed(2)) + parseFloat(tax.toFixed(2));
                    $("#lblTotal").html("RM " + total.toFixed(2));
                    });
                }
              });
            });
          }
        });
        }
      });
    });
  });

</script>
</head>
<section style="padding-top:5%; width: 98vw; padding-left: 18%">
  <form action="" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="image" id="image">
    <input type="button" value="Upload Image" name="submit" class="btnUpload button is-small is-primary" style="margin-bottom:??5px;">
  </form>
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
      <tbody>
    <?php
    $list_drugs = mysqli_query($Links, "SELECT * FROM tblmedicine, tblstored_drug WHERE tblstored_drug.DrugID = tblmedicine.DrugID  AND tblstored_drug.quantity > 0 GROUP BY tblstored_drug.DrugID ORDER BY tblmedicine.drugName");
    if(mysqli_num_rows($list_drugs) > 0)
    {
      while($row = mysqli_fetch_array($list_drugs))
      {
        $get_image = mysqli_query($Links, "SELECT * FROM tblmedicine_image WHERE drug_image_id = ".$row["drug_image_id"]."");
        echo "<tr>";
        if(mysqli_num_rows($get_image) > 0)
        {
          $row2 = mysqli_fetch_array($get_image);
          echo " <td><img src='../Medicine_Image/".$row2["image_path"]."' width='150px'/></td>";
		  //echo " <td><img src='".$row2["image_path"]."' width='150px'></td>";
		  //echo " <td><img src='".$row2["image_path"]."' width='150px'></td>";
        }
        
        echo "<td>".ucwords(strtolower($row["manufacturer"]))."</td>
        <td>".ucwords(strtolower($row["drugName"]))."</td>
        <td>".ucwords(strtolower($row["drugCategory"]))."</td>
        <td>".$row["no_of_unit_in_package"]."</td>
        <td>".$row["unitPrice"]."</td>
        <td><input type='button' value='Add to cart' id='".$row["DrugID"]."' class='btnAddToCart button is-small is-primary' style='font-weight: bold;margin-right: 1%;'></td>
        </tr>";
      }
    }
    ?>
    </tbody>
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
                    <th></th>
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
                <label class="label">Tax(<span id="taxValue">6</span>%) : </label>
              </div>
              <div class="control" style="padding-top: 3%;">
                <label class="label" id="lblTax">RM<span id="taxAmount">0</span></label>
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
            Checkout
          </button>
        </div>
      </form>
    </section>