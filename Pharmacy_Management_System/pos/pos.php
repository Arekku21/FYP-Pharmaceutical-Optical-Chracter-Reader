<head>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
<!-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" type="text/css" href="../css/jquery_dataTables.css">
<script type="text/javascript" charset="utf8" src="../js/jquery_dataTables.js"></script>
<style>
  /* The modal (hidden by default) */
  .modal {
    display: none;
    position: fixed;
    z-index: 1;
    padding-top: 100px;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
  }

  /* Modal content */
  .modal-content {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 600px;
    text-align: center;
  }

  .is-active{
      z-index: 0;
    }

    .loading-overlay {
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
    }


    .loading-overlay {
      position: fixed;
      width: 5000px;
      height: 5000px;
      background-image: url('../image/loading.gif');
      background-repeat: no-repeat;
      background-position: center;
      background-color: rgba(0, 0, 0, 0.5);
      top: 50%;
      left: 50%;
      /* transform: translate(-50%, -50%); */
      z-index: 9999;
    }

    .freeze {
      position: relative;
      z-index: 9998; /* lower than the loading overlay */
    }

    /* Optional: apply a transparent background to the freeze element */
    .freeze::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(255, 255, 255, 0.5);
    }

.btnScan{
  width: 20px;
  height: 20px;
  margin-right: 10px;
}

</style>
<?php
include "../menu/menu.php";
?>
<div class="container"> 
  <div style="margin-top: 0%; width: 88%;">
    <div style="margin-top: 0.8%; height:900px;">
      <section class="section columns">
        <div class="column is-full-desktop is-full-mobile" style="margin-left: 18.5%; margin-top: 4%;">
          <div class="tabs is-toggle is-fullwidth">
            <ul>
              <li class="is-active ">
                <a href="pos.php">
                  <span>Payment</span>
                </a>
              </li>

              <li>
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

    var loadingOverlay = $('<div class="loading-overlay"></div>');
    $(document).ajaxStart(function() {
        // Show the loading overlay and freeze the background
        $('body').append(loadingOverlay);
        $('body').addClass('freeze');
    });

    $(document).ajaxStop(function() {
        // Hide the loading overlay and unfreeze the background
        loadingOverlay.remove();
        $('body').removeClass('freeze');
    });

    //perform click action for add to cart
    $(".btnAddToCart").click(function(){
      $.ajax({
        url: "../ajax/ajax.php",
        method: "POST", 
        data: {action: "addToCart", id: $(this).attr('id')},
        success: function(result){
          var table = document.getElementById("shopping_cart").getElementsByTagName('tbody')[0];
          result = JSON.parse(result);
          console.log(result);
          $("#shopping_cart > tbody > tr").each(function(i){
            var cart_table = $(this);
            var pos_name = cart_table.find("td:eq(0)").text();
            var pos_manufacturer = cart_table.find("td:eq(1)").text();
            if(pos_name == result[0] && pos_manufacturer == result[1])
            {
              result[2] = parseInt(cart_table.find("td:eq(2)").text()) + 1;
              $("#shopping_cart > tbody > tr:eq("+ i +")").remove();
            }
          });
            var row = table.insertRow(-1);
            var name = row.insertCell(0);
            var manufacturer = row.insertCell(1);
            var quantity = row.insertCell(2);
            var price = row.insertCell(3);
            var total = row.insertCell(4);
            var button = row.insertCell(5);
            name.innerHTML = result[0];
            manufacturer.innerHTML = result[1];
            quantity.innerHTML = result[2]+ "<input type='hidden' name='quantity[]' value='" + result[2] + "'><input type='hidden' name='drugID[]' value='" + result[4] + "'>";
            price.innerHTML = result[3];
            total.innerHTML = parseFloat(result[3]) * parseFloat(result[2]);

            button.innerHTML = "<button onclick=\"increaseQty('" + result[0] + "', '" + result[1] + "', '" + result[2] + "', '" + result[3] + "', '" + result[4] + "')\" type='button' class='btnIncrease button is-small is-primary'><i class='fa fa-plus'></i></button>&nbsp;<button onclick=\"decreaseQty('" + result[0] + "', '" + result[1] + "', '" + result[2] + "', '" + result[3] + "', '" + result[4] + "')\" type='button' class='btnDecrease button is-small is-danger'><i class='fa fa-minus'></i></button>";



            var sub_total_amount = 0;
            var total = 0;
            //calculate total amount
            $("#shopping_cart > tbody > tr").each(function(i){
              var cart_table = $(this);
              sub_total_amount += parseFloat(cart_table.find("td:eq(-2)").text());

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
                alert(split[0].trim());
                if(!split[0].trim().includes("Product not enough stock!")){
                  window.open("invoice.php?invoiceID=" + split[1]);
                  location.reload();
                }
              }
            });
            //print bill logic here
            //....
          }
        }
      }
    });

  //   $(".btnUpload").click(function(){
  //     var file_data = $('#image').prop('files')[0]; 
  //     var form_data = new FormData();
  //     form_data.append('image', file_data);
  //     form_data.append('action', 'uploadImage');
  //     form_data.append('page', 'pos');
  //     $.ajax({
  //       url: "../ajax/ajax.php",
  //       method: "POST",
  //       cache: false,
  //       contentType: false,
  //       processData: false,
  //       data: form_data,
  //       success: function(result){
  //         console.log(result);
  //         $.ajax({
  //         url: "../ajax/ajax.php",
  //         method: "POST",
  //         data: {action: "searchDrug", result: JSON.parse(result)},
  //         success: function(result2){
  //           //  alert("AI extracted word: " + result);
  //           console.log(result);
  //           $("#drug_table > tbody").html(result2);
  //          $(".btnAddToCart").click(function(){
  //             $.ajax({
  //               url: "../ajax/ajax.php",
  //               method: "POST", 
  //               data: {action: "addToCart", id: $(this).attr('id')},
  //               success: function(result){
  //                 var table = document.getElementById("shopping_cart").getElementsByTagName('tbody')[0];
  //                 result = JSON.parse(result);
  //                 $("#shopping_cart > tbody > tr").each(function(i){
  //                   var cart_table = $(this);
  //                   var pos_name = cart_table.find("td:eq(0)").text();
  //                   var pos_manufacturer = cart_table.find("td:eq(1)").text();
  //                   if(pos_name == result[0] && pos_manufacturer == result[1])
  //                   {
  //                     var pos_quantity = cart_table.find("td:eq(2)").text();
  //                     result[2] = parseInt(pos_quantity) + 1;
  //                     $("#shopping_cart > tbody > tr:eq("+ i +")").remove();
  //                   }
  //                 });
  //                 var row = table.insertRow(-1);
  //                   var name = row.insertCell(0);
  //                   var manufacturer = row.insertCell(1);
  //                   var quantity = row.insertCell(2);
  //                   var price = row.insertCell(3);
  //                   var total = row.insertCell(4);
  //                   var button = row.insertCell(5);
  //                   name.innerHTML = result[0];
  //                   manufacturer.innerHTML = result[1];
  //                   quantity.innerHTML = result[2]+ "<input type='hidden' name='quantity[]' value='" + result[2] + "'><input type='hidden' name='drugID[]' value='" + result[4] + "'>";
  //                   price.innerHTML = result[3];
  //                   total.innerHTML = parseFloat(result[3]) * parseFloat(result[2]);
  //                   button.innerHTML = "A";

  //                   var sub_total_amount = 0;
  //                   var total = 0;
  //                   //calculate total amount
  //                   $("#shopping_cart > tbody > tr").each(function(i){
  //                   var cart_table = $(this);
  //                   sub_total_amount += parseFloat(cart_table.find("td:eq(-1)").text());
  //                   var tax = sub_total_amount * 0.06;
  //                   $("#lblSubTotal").html("RM " + sub_total_amount.toFixed(2));
  //                   $("#taxAmount").html(tax.toFixed(2));
  //                   total = parseFloat(sub_total_amount.toFixed(2)) + parseFloat(tax.toFixed(2));
  //                   $("#lblTotal").html("RM " + total.toFixed(2));
  //                   });
  //               }
  //             });
  //           });
  //         }
  //       });
  //       }
  //     });
  //   });
  });

  // function increaseQty(name, manufacturer, qty, price, total)
  function increaseQty(name, manufacturer, qty, price, drugID)
  {
    $("#shopping_cart > tbody > tr").each(function(i){
      var cart_table = $(this);
      var pos_name = cart_table.find("td:eq(0)").text();
      var pos_manufacturer = cart_table.find("td:eq(1)").text();
      if(pos_name == name && pos_manufacturer == manufacturer)
      {
        //update the quantity column
        qty = parseInt(qty) + 1;
        total = parseFloat(price) * parseInt(qty);
        cart_table.find("td:eq(2)").html(qty + "<input type='hidden' name='quantity[]' value='" + qty + "'><input type='hidden' name='drugID[]' value='" + drugID + "'>");
        cart_table.find("td:eq(4)").text(total); 
        cart_table.find("td:eq(5)").html("<button onclick=\"increaseQty('" + name + "', '" + manufacturer + "', '" + qty + "', '" + price + "', '" + drugID + "')\" type='button' class='btnIncrease button is-small is-primary'><i class='fa fa-plus'></i></button>&nbsp;<button onclick=\"decreaseQty('" + name + "', '" + manufacturer + "', '" + qty + "', '" + price + "', '" + drugID + "')\" type='button' class='btnDecrease button is-small is-danger'><i class='fa fa-minus'></i></button>");
        var sub_total_amount = 0;
        var total = 0;
        //calculate total amount
        $("#shopping_cart > tbody > tr").each(function(i){
          var cart_table = $(this);
          sub_total_amount += parseFloat(cart_table.find("td:eq(-2)").text());

          var tax = sub_total_amount * 0.06;
          $("#lblSubTotal").html("RM " + sub_total_amount.toFixed(2));
          $("#taxAmount").html(tax.toFixed(2));
          total = parseFloat(sub_total_amount.toFixed(2)) + parseFloat(tax.toFixed(2));
          $("#lblTotal").html("RM " + total.toFixed(2));
        });
      }
    });
  }

  function decreaseQty(name, manufacturer, qty, price, drugID)
  {
    $("#shopping_cart > tbody > tr").each(function(i){
      var cart_table = $(this);
      var pos_name = cart_table.find("td:eq(0)").text();
      var pos_manufacturer = cart_table.find("td:eq(1)").text();
      if(pos_name == name && pos_manufacturer == manufacturer)
      {
        //update the quantity column
        qty = parseInt(qty) - 1;
        total = parseFloat(price) * parseInt(qty);
        cart_table.find("td:eq(2)").html(qty + "<input type='hidden' name='quantity[]' value='" + qty + "'><input type='hidden' name='drugID[]' value='" + drugID + "'>");
        cart_table.find("td:eq(4)").text(total); 
        cart_table.find("td:eq(5)").html("<button onclick=\"increaseQty('" + name + "', '" + manufacturer + "', '" + qty + "', '" + price + "', '" + drugID + "')\" type='button' class='btnIncrease button is-small is-primary'><i class='fa fa-plus'></i></button>&nbsp;<button onclick=\"decreaseQty('" + name + "', '" + manufacturer + "', '" + qty + "', '" + price + "', '" + drugID + "')\" type='button' class='btnDecrease button is-small is-danger'><i class='fa fa-minus'></i></button>");
        //remove the row if qty is 0
        if(qty < 1)
        {
          $("#shopping_cart > tbody > tr:eq("+ i +")").remove();
        }

        var sub_total_amount = 0;
        var total = 0;
        //calculate total amount
        $("#shopping_cart > tbody > tr").each(function(i){
          var cart_table = $(this);
          sub_total_amount += parseFloat(cart_table.find("td:eq(-2)").text());

          var tax = sub_total_amount * 0.06;
          $("#lblSubTotal").html("RM " + sub_total_amount.toFixed(2));
          $("#taxAmount").html(tax.toFixed(2));
          total = parseFloat(sub_total_amount.toFixed(2)) + parseFloat(tax.toFixed(2));
          $("#lblTotal").html("RM " + total.toFixed(2));
       });
      }
    });
  }

  $(document).ready(function(){
    // Select the modal and the video element
    const modal = document.getElementById('myModal');

    const videoElement = document.getElementById('videoElement');
    let stream;
    let isModalOpen = false;

    // Select the button that opens the modal
    const openModalBtn = document.getElementById('openModal');

    // Select the capture button and set its click event listener
    const captureBtn = document.getElementById('captureBtn');
    captureBtn.addEventListener('click', () => {
      // Get the canvas element
      const canvas = document.createElement('canvas');
      const context = canvas.getContext('2d');

      // Set the canvas dimensions to match the video element
      canvas.width = videoElement.videoWidth;
      canvas.height = videoElement.videoHeight;

      // Draw the video frame onto the canvas
      context.drawImage(videoElement, 0, 0, canvas.width, canvas.height);

      // Convert the canvas image to a base64-encoded string
      const base64Image = canvas.toDataURL('image/jpeg');
      capture(base64Image);

      // Close the modal
      modal.style.display = 'none';

      isModalOpen = false;

      // Stop the camera stream
      if (stream) {
        stream.getTracks().forEach(track => track.stop());
      }
    });

    // Request permission to access the camera and display the stream in the modal
    openModalBtn.addEventListener('click', () => {
      navigator.mediaDevices.getUserMedia({ video: true })
        .then(streamObj => {
          // Attach the camera stream to the video element
          videoElement.srcObject = streamObj;
          videoElement.play();

          // Store the stream object so we can stop it later
          stream = streamObj;

          // Open the modal
          modal.style.display = 'block';

          // Set the isModalOpen variable to true
          isModalOpen = true;
        })
        .catch(error => {
          console.error('Unable to access the camera.', error);
        });
    });

    document.addEventListener("keypress", function(event) {
      if (event.keyCode === 13 && isModalOpen) {
        captureBtn.click();

      }
    });

   
    // Close the modal and stop the camera stream when the user clicks outside of it
    window.addEventListener('click', event => {
      if (event.target == modal) {
        modal.style.display = 'none';

        isModalOpen = false;

        // Stop the camera stream
        if (stream) {
          stream.getTracks().forEach(track => track.stop());
        }
      }
    });
    });    





    function capture(base64Image)
    {
      let api = $("#modalAPI").val().trim();
      // console.log(base64Image);
      $.ajax({
        url: api,
        method: "POST",
        data: {image_data: encoded_image = base64Image.split(",")[1]},
        success: function(result){
          // console.log(result);
          if(result === "No text detected")
            alert("No text detected. Please rescan");
          
          else
          {
            var encodedImg = result.base64;
            // Create a new `img` element
            const img = document.createElement('img');
            // console.log(encodedImg);
            // Set the `src` attribute of the `img` element to the Base64 data
            img.src = 'data:image/png;base64, ' + encodedImg;
            // Append the `img` element to the `div`
            const div = document.getElementById('output');
            div.innerHTML = "";
            div.appendChild(img);
            $.ajax({
              url: "../ajax/ajax.php",
              method: "POST",
              data: {action: "searchDrug", result: JSON.stringify(result)},
              success: function(result2){
                $("#drug_table > tbody").html(result2);
                $.ajax({
                  url: "../ajax/ajax.php",
                  method: "POST",
                  data: {action: "FuzzySearchDrug", result: JSON.stringify(result)},
                  success: function(result3){
                    $("#fuzzyResult").html(result3);
                    //perform click action for add to cart
                    $(".btnAddToCart").click(function(){
                      $.ajax({
                        url: "../ajax/ajax.php",
                        method: "POST", 
                        data: {action: "addToCart", id: $(this).attr('id')},
                        success: function(result){
                          var table = document.getElementById("shopping_cart").getElementsByTagName('tbody')[0];
                          result = JSON.parse(result);
                          console.log(result);
                          $("#shopping_cart > tbody > tr").each(function(i){
                            var cart_table = $(this);
                            var pos_name = cart_table.find("td:eq(0)").text();
                            var pos_manufacturer = cart_table.find("td:eq(1)").text();
                            if(pos_name == result[0] && pos_manufacturer == result[1])
                            {
                              result[2] = parseInt(cart_table.find("td:eq(2)").text()) + 1;
                              $("#shopping_cart > tbody > tr:eq("+ i +")").remove();
                            }
                          });
                            
                          var row = table.insertRow(-1);
                            var name = row.insertCell(0);
                            var manufacturer = row.insertCell(1);
                            var quantity = row.insertCell(2);
                            var price = row.insertCell(3);
                            var total = row.insertCell(4);
                            var button = row.insertCell(5);
                            name.innerHTML = result[0];
                            manufacturer.innerHTML = result[1];
                            quantity.innerHTML = result[2]+ "<input type='hidden' name='quantity[]' value='" + result[2] + "'><input type='hidden' name='drugID[]' value='" + result[4] + "'>";
                            price.innerHTML = result[3];
                            total.innerHTML = parseFloat(result[3]) * parseFloat(result[2]);

                            button.innerHTML = "<button onclick=\"increaseQty('" + result[0] + "', '" + result[1] + "', '" + result[2] + "', '" + result[3] + "', '" + result[4] + "')\" type='button' class='btnIncrease button is-small is-primary'><i class='fa fa-plus'></i></button>&nbsp;<button onclick=\"decreaseQty('" + result[0] + "', '" + result[1] + "', '" + result[2] + "', '" + result[3] + "', '" + result[4] + "')\" type='button' class='btnDecrease button is-small is-danger'><i class='fa fa-minus'></i></button>";



                            var sub_total_amount = 0;
                            var total = 0;
                            //calculate total amount
                            $("#shopping_cart > tbody > tr").each(function(i){
                              var cart_table = $(this);
                              sub_total_amount += parseFloat(cart_table.find("td:eq(-2)").text());

                              var tax = sub_total_amount * 0.06;
                              $("#lblSubTotal").html("RM " + sub_total_amount.toFixed(2));
                              $("#taxAmount").html(tax.toFixed(2));
                              total = parseFloat(sub_total_amount.toFixed(2)) + parseFloat(tax.toFixed(2));
                              $("#lblTotal").html("RM " + total.toFixed(2));
                            });
                          }
                        });
                      });
                    $(".brandSuggestion1").click(function(){
                      $.ajax({
                        url: "../ajax/ajax.php",
                        method: "POST",
                        data: {action: "displayFuzzyDrug", result: $(".brandSuggestionValue1").val()},
                        success: function(result4){
                          $("#drug_table > tbody").html(result4);
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
                                    result[2] = parseInt(cart_table.find("td:eq(2)").text()) + 1;
                                    $("#shopping_cart > tbody > tr:eq("+ i +")").remove();
                                  }
                                });
                                  var row = table.insertRow(-1);
                                  var name = row.insertCell(0);
                                  var manufacturer = row.insertCell(1);
                                  var quantity = row.insertCell(2);
                                  var price = row.insertCell(3);
                                  var total = row.insertCell(4);
                                  var button = row.insertCell(5);
                                  name.innerHTML = result[0];
                                  manufacturer.innerHTML = result[1];
                                  quantity.innerHTML = result[2]+ "<input type='hidden' name='quantity[]' value='" + result[2] + "'><input type='hidden' name='drugID[]' value='" + result[4] + "'>";
                                  price.innerHTML = result[3];
                                  total.innerHTML = parseFloat(result[3]) * parseFloat(result[2]);

                                  button.innerHTML = "<button onclick=\"increaseQty('" + result[0] + "', '" + result[1] + "', '" + result[2] + "', '" + result[3] + "', '" + result[4] + "')\" type='button' class='btnIncrease button is-small is-primary'><i class='fa fa-plus'></i></button>&nbsp;<button onclick=\"decreaseQty('" + result[0] + "', '" + result[1] + "', '" + result[2] + "', '" + result[3] + "', '" + result[4] + "')\" type='button' class='btnDecrease button is-small is-danger'><i class='fa fa-minus'></i></button>";



                                  var sub_total_amount = 0;
                                  var total = 0;
                                  //calculate total amount
                                  $("#shopping_cart > tbody > tr").each(function(i){
                                    var cart_table = $(this);
                                    sub_total_amount += parseFloat(cart_table.find("td:eq(-2)").text());

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
                    });

                    $(".brandSuggestion2").click(function(){
                      $.ajax({
                        url: "../ajax/ajax.php",
                        method: "POST",
                        data: {action: "displayFuzzyDrug", result: $(".brandSuggestionValue2").val()},
                        success: function(result4){
                          $("#drug_table > tbody").html(result4);
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
                                    result[2] = parseInt(cart_table.find("td:eq(2)").text()) + 1;
                                    $("#shopping_cart > tbody > tr:eq("+ i +")").remove();
                                  }
                                });
                                  var row = table.insertRow(-1);
                                  var name = row.insertCell(0);
                                  var manufacturer = row.insertCell(1);
                                  var quantity = row.insertCell(2);
                                  var price = row.insertCell(3);
                                  var total = row.insertCell(4);
                                  var button = row.insertCell(5);
                                  name.innerHTML = result[0];
                                  manufacturer.innerHTML = result[1];
                                  quantity.innerHTML = result[2]+ "<input type='hidden' name='quantity[]' value='" + result[2] + "'><input type='hidden' name='drugID[]' value='" + result[4] + "'>";
                                  price.innerHTML = result[3];
                                  total.innerHTML = parseFloat(result[3]) * parseFloat(result[2]);

                                  button.innerHTML = "<button onclick=\"increaseQty('" + result[0] + "', '" + result[1] + "', '" + result[2] + "', '" + result[3] + "', '" + result[4] + "')\" type='button' class='btnIncrease button is-small is-primary'><i class='fa fa-plus'></i></button>&nbsp;<button onclick=\"decreaseQty('" + result[0] + "', '" + result[1] + "', '" + result[2] + "', '" + result[3] + "', '" + result[4] + "')\" type='button' class='btnDecrease button is-small is-danger'><i class='fa fa-minus'></i></button>";



                                  var sub_total_amount = 0;
                                  var total = 0;
                                  //calculate total amount
                                  $("#shopping_cart > tbody > tr").each(function(i){
                                    var cart_table = $(this);
                                    sub_total_amount += parseFloat(cart_table.find("td:eq(-2)").text());

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
                    });

                    $(".dosageSuggestion1").click(function(){
                      $.ajax({
                        url: "../ajax/ajax.php",
                        method: "POST",
                        data: {action: "displayFuzzyDrug", result: $(".dosageSuggestionValue1").val()},
                        success: function(result4){
                          $("#drug_table > tbody").html(result4);
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
                                    result[2] = parseInt(cart_table.find("td:eq(2)").text()) + 1;
                                    $("#shopping_cart > tbody > tr:eq("+ i +")").remove();
                                  }
                                });
                                  var row = table.insertRow(-1);
                                  var name = row.insertCell(0);
                                  var manufacturer = row.insertCell(1);
                                  var quantity = row.insertCell(2);
                                  var price = row.insertCell(3);
                                  var total = row.insertCell(4);
                                  var button = row.insertCell(5);
                                  name.innerHTML = result[0];
                                  manufacturer.innerHTML = result[1];
                                  quantity.innerHTML = result[2]+ "<input type='hidden' name='quantity[]' value='" + result[2] + "'><input type='hidden' name='drugID[]' value='" + result[4] + "'>";
                                  price.innerHTML = result[3];
                                  total.innerHTML = parseFloat(result[3]) * parseFloat(result[2]);

                                  button.innerHTML = "<button onclick=\"increaseQty('" + result[0] + "', '" + result[1] + "', '" + result[2] + "', '" + result[3] + "', '" + result[4] + "')\" type='button' class='btnIncrease button is-small is-primary'><i class='fa fa-plus'></i></button>&nbsp;<button onclick=\"decreaseQty('" + result[0] + "', '" + result[1] + "', '" + result[2] + "', '" + result[3] + "', '" + result[4] + "')\" type='button' class='btnDecrease button is-small is-danger'><i class='fa fa-minus'></i></button>";



                                  var sub_total_amount = 0;
                                  var total = 0;
                                  //calculate total amount
                                  $("#shopping_cart > tbody > tr").each(function(i){
                                    var cart_table = $(this);
                                    sub_total_amount += parseFloat(cart_table.find("td:eq(-2)").text());

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
                    });

                    $(".dosageSuggestion2").click(function(){
                      $.ajax({
                        url: "../ajax/ajax.php",
                        method: "POST",
                        data: {action: "displayFuzzyDrug", result: $(".dosageSuggestionValue2").val()},
                        success: function(result4){
                          $("#drug_table > tbody").html(result4);
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
                                    result[2] = parseInt(cart_table.find("td:eq(2)").text()) + 1;
                                    $("#shopping_cart > tbody > tr:eq("+ i +")").remove();
                                  }
                                });
                                  var row = table.insertRow(-1);
                                  var name = row.insertCell(0);
                                  var manufacturer = row.insertCell(1);
                                  var quantity = row.insertCell(2);
                                  var price = row.insertCell(3);
                                  var total = row.insertCell(4);
                                  var button = row.insertCell(5);
                                  name.innerHTML = result[0];
                                  manufacturer.innerHTML = result[1];
                                  quantity.innerHTML = result[2]+ "<input type='hidden' name='quantity[]' value='" + result[2] + "'><input type='hidden' name='drugID[]' value='" + result[4] + "'>";
                                  price.innerHTML = result[3];
                                  total.innerHTML = parseFloat(result[3]) * parseFloat(result[2]);

                                  button.innerHTML = "<button onclick=\"increaseQty('" + result[0] + "', '" + result[1] + "', '" + result[2] + "', '" + result[3] + "', '" + result[4] + "')\" type='button' class='btnIncrease button is-small is-primary'><i class='fa fa-plus'></i></button>&nbsp;<button onclick=\"decreaseQty('" + result[0] + "', '" + result[1] + "', '" + result[2] + "', '" + result[3] + "', '" + result[4] + "')\" type='button' class='btnDecrease button is-small is-danger'><i class='fa fa-minus'></i></button>";



                                  var sub_total_amount = 0;
                                  var total = 0;
                                  //calculate total amount
                                  $("#shopping_cart > tbody > tr").each(function(i){
                                    var cart_table = $(this);
                                    sub_total_amount += parseFloat(cart_table.find("td:eq(-2)").text());

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
                    });
                  }
                });
                // $(".btnAddToCart").click(function(){
                //   $.ajax({
                //     url: "../ajax/ajax.php",
                //     method: "POST", 
                //     data: {action: "addToCart", id: $(this).attr('id')},
                //     success: function(result){
                //       var table = document.getElementById("shopping_cart").getElementsByTagName('tbody')[0];
                //       result = JSON.parse(result);
                //       $("#shopping_cart > tbody > tr").each(function(i){
                //         var cart_table = $(this);
                //         var pos_name = cart_table.find("td:eq(0)").text();
                //         var pos_manufacturer = cart_table.find("td:eq(1)").text();
                //         if(pos_name == result[0] && pos_manufacturer == result[1])
                //         {
                //           var pos_quantity = cart_table.find("td:eq(2)").text();
                //           result[2] = parseInt(pos_quantity) + 1;
                //           $("#shopping_cart > tbody > tr:eq("+ i +")").remove();
                //         }
                //       });
                //       var row = table.insertRow(-1);
                //       var name = row.insertCell(0);
                //       var manufacturer = row.insertCell(1);
                //       var quantity = row.insertCell(2);
                //       var price = row.insertCell(3);
                //       var total = row.insertCell(4);
                //       var button = row.insertCell(5);
                //       name.innerHTML = result[0];
                //       manufacturer.innerHTML = result[1];
                //       quantity.innerHTML = result[2]+ "<input type='hidden' name='quantity[]' value='" + result[2] + "'><input type='hidden' name='drugID[]' value='" + result[4] + "'>";
                //       price.innerHTML = result[3];
                //       total.innerHTML = parseFloat(result[3]) * parseFloat(result[2]);

                //       button.innerHTML = "<button onclick=\"increaseQty('" + result[0] + "', '" + result[1] + "', '" + result[2] + "', '" + result[3] + "', '" + result[4] + "')\" type='button' class='btnIncrease button is-small is-primary'><i class='fa fa-plus'></i></button>&nbsp;<button onclick=\"decreaseQty('" + result[0] + "', '" + result[1] + "', '" + result[2] + "', '" + result[3] + "', '" + result[4] + "')\" type='button' class='btnDecrease button is-small is-danger'><i class='fa fa-minus'></i></button>";
                      

                //       var sub_total_amount = 0;
                //       var total = 0;
                //       //calculate total amount
                //       $("#shopping_cart > tbody > tr").each(function(i){
                //       var cart_table = $(this);
                //       sub_total_amount += parseFloat(cart_table.find("td:eq(-1)").text());
                //       var tax = sub_total_amount * 0.06;
                //       $("#lblSubTotal").html("RM " + sub_total_amount.toFixed(2));
                //       $("#taxAmount").html(tax.toFixed(2));
                //       total = parseFloat(sub_total_amount.toFixed(2)) + parseFloat(tax.toFixed(2));
                //       $("#lblTotal").html("RM " + total.toFixed(2));
                //       });
                //     }
                //   });
                // });
              },
              error: function(error){
                console.log(error);
              }
            });
          }
        }
      });
    }
</script>
</head>
<section style="padding-top:0%; width: 116%; padding-left: 20%">
<!-- The modal -->
<div id="myModal" class="modal">
    <div class="modal-content">
      <video id="videoElement"></video>
      <br>
      <button id="captureBtn" type="button" class="btnOpenCamera button is-small is-primary" >Capture</button>
    </div>
  </div>
  <form action="" method="post" enctype="multipart/form-data">
    Modal API: <select id="modalAPI">
      <option value="http://127.0.0.1:5002/api/paddleocr/output/best_confidence" selected>PaddleOCR</option>
      <option value="http://127.0.0.1:5001/api/easyocr/output/best_confidence">EasyOCR</option>
      <option value="http://127.0.0.1:5001/api/easyocr_custom/output/best_confidence">EasyOCR (Custom)</option>
      <option value="http://127.0.0.1:5001/api/pytesseract/output/best_confidence">PyTesseract</option>
    </select>
    <!-- The button to open the modal -->
    <button id="openModal" type="button" class="btnOpenCamera button is-small is-primary" ><img src="../image/scan-icon-white.png" class='btnScan' alt="button image">Scan Medicine</button>
  </form>
  <div>
    <div id="output">

    </div>
    <div id="fuzzyResult">

    </div>
  </div>
  <p class="panel-heading" style="background-color:hsl(0, 0%, 88%) ;color:hsl(0, 0%, 21%);">
    Search Drugs
  </p>
  <div class="panel-block table-responsive">
    <table class="table is-full" id="drug_table" style="width:100%;">
      <thead>
        <tr>
          <th>DRUG IMAGE</th>
          <th>DRUG MANUFACTURER</th>
          <th>DRUG NAME</th>
          <th>DRUG DOSAGE</th>
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
        }
        
        echo "<td>".ucwords(strtolower($row["manufacturer"]))."</td>
        <td>".ucwords(strtolower($row["drugName"]))."</td>
        <td>".$row["drugDosage"]."</td>
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


<section class="panel" style="padding-top:5%; width: 116%; padding-left: 20%">
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
      <div>
    </div>
  </div>
</section>

<section class="panel" style="padding-top:5%; width: 116%; padding-left: 20%">
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
<br>
</div>
<!-- </div> -->