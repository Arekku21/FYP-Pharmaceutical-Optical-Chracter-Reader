<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<link rel="stylesheet" type="text/css" href="../css/jquery_dataTables.css">
<script type="text/javascript" charset="utf8" src="../js/jquery_dataTables.js"></script>
<?php
include "../db.php";
?>
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
      color:hsl(0, 0%, 21%);
      background-color: hsl(0, 0%, 88%);
      border-radius: 3px;
    }
    .newclass :hover{
      background-color: hsl(0, 0%, 21%);
      color: hsl(0, 0%, 88%);
    }

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
</head>
<script>
  $(document).ready(function(){
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

    $(".btnUpload").click(function(){
      var file_data = $('#image').prop('files')[0]; 
      var form_data = new FormData();
      form_data.append('image', file_data);
      form_data.append('action', 'uploadImage');
      form_data.append('page', 'inventory');
      $.ajax({
        url: "../ajax/ajax.php",
        method: "POST",
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        success: function(result){
          alert(result);
        }
      });
    });
  });
  $(document).ready(function(){
    $(".btnAdd").click(function(){
      $.ajax({
        url: "http://127.0.0.1:5002/api/medicinerecords/update",
        method: "POST",
        success: function(result2){
          // console.log(result.trim());
        }
      });
    });


    // Select the modal and the video element
    const modal = document.getElementById('myModal');
    const videoElement = document.getElementById('videoElement');
    let stream;

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
        })
        .catch(error => {
          console.error('Unable to access the camera.', error);
        });
    });

    // Close the modal and stop the camera stream when the user clicks outside of it
    window.addEventListener('click', event => {
      if (event.target == modal) {
        modal.style.display = 'none';

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
          console.log(result);
          if(result === "No text detected")
            alert("No text detected. Please rescan");
          
          else
          {
            if(result.brand != "")
              $("#name").val(result.brand);
            if(result.dosage != "")
              $("#dosage").val(result.dosage);
          }
        },
        error: function(error){
          console.log(error);
        }
      });
    }
</script>
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
              <li class="is-active ">
                <a href="addInventory.php">
                  <span>Add new Inventory</span>
                </a>
              </li>

              <li>
                <a href="inventoryList.php">
                  <span>Inventory List</span>
                </a>
              </li>

              <li>
                <a href="outofstock.php">
                  <span>Out of Stock</span>
                </a>
              </li>

              <li>
                <a href="expiringSoon.php">
                  <span>Expiring Soon</span>
                </a>
              </li>

              <li>
                <a href="expired.php">
                  <span>Expired Drugs</span>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </section>

    <section class="panel" style="margin-left: 19.8% ; margin-top: -30px; width: 96.5%;">
    <!-- <form action="" method="post" enctype="multipart/form-data">
      Select image to upload:
      <input type="file" name="image" id="image">
      <input type="button" value="Upload Image" name="submit" class="btnUpload button is-small is-primary" style="margin-bottom: 5px;">
    </form> -->
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
    <?php
    if($_POST["btnAdd"])
    {
        $file_path = "../Medicine_Image";
        chdir($file_path);
        $target_file = basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check !== false)
        {
            if(move_uploaded_file($_FILES["image"]["tmp_name"], $_FILES["image"]["name"]))
            {
                $new_file = explode(".".$imageFileType, $target_file);
                $filename = $new_file[0].date('d-m-y_h_i_s').".".$imageFileType;
                rename($target_file, $filename);
                $insert_image = mysqli_query($Links, "INSERT INTO tblmedicine_image(image_path) VALUES('".$filename."')");
                $insert = mysqli_query($Links, "INSERT INTO tblmedicine(drug_image_id, drugName, drugDosage, drugCategory, no_of_unit_in_package, manufacturer, unitPrice) VALUES(".mysqli_insert_id($Links).", '".strtoupper(trim($_POST["name"]))."', ".trim($_POST["dosage"]).", '".strtoupper(trim($_POST["category"]))."', ".trim($_POST["unit"]).", '".strtoupper(trim($_POST["manufacturer"]))."', ".trim($_POST["price"]).")");
                if($insert_image && $insert)
                {
                    echo "<script>alert('Drug Inserted success');</script>";
                }
            }
            else 
            {
                echo "Fail to move image to server!";
            }
        }
    }
    ?>
    <?php if($_SESSION['roleID'] == 1){ ?>
  <p class="panel-heading" style="background-color:hsl(0, 0%, 88%) ;color:hsl(0, 0%, 21%)">
    Add Inventory
  </p>
  <div class="panel-block" style="height: auto">
    <div  style="width: 87.5vw; padding: 2%;">


<div class="spinner-box loadCenter">

<form method="post" enctype="multipart/form-data">

<div class="field">
  <label class="label" >DRUG MANUFACTURER</label>
  <input type="text" class="is-center input" name="manufacturer" style="width: 100%;" placeholder="Pharmaniage" required/>
</div>

<div class="field">
  <label class="label" >DRUG NAME</label>
  <input type="text" class="is-center input" name="name" id="name" style="width: 100%;" placeholder="Panadol" required/>
</div>

<div class="field">
  <label class="label" >DRUG DOSAGE</label>
  <input type="number" class="is-center input" name="dosage" id="dosage" style="width: 100%;" placeholder="10" required/>
</div>

<div class="field">
  <label class="label">DRUG CATEGORY</label>
  <input type="text" class="is-center input" name="category" style="width: 100%;" placeholder="Antihistamines & Antiallergics" required/>
</div>

<div class="field">
  <label class="label">DRUG UNITS IN PACKAGE</label>
  <input type="number" class="is-center input" name="unit" style="width: 100%;" placeholder="100" required/>
</div>

<div class="field">
  <label class="label">DRUG PRICE(RM)</label>
  <input type="number" step="0.1" class="is-center input" name="price" style="width: 100%;" placeholder="30" required/>
</div>

<div class="field">
  <label class="label">DRUG IMAGE</label>
  <input type="file" class="is-center input" name="image" accept="image/*" style="width: 100%;" required/>
</div>


<div style="width: 100%;margin-top: 40px;">
  <input type="submit" class="btnAdd button is-primary is-fullwidth" name="btnAdd" value="Add">
</div>
</form>
    </div>
  </div>
  <?php }
    else echo "No privilege to access this page"; ?>
    </section>
    <br>
</div>