
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
<style>
    .panel-heading{
        background-color:hsl(0, 0%, 88%) ;color:hsl(0, 0%, 21%);
    }
 .image {
     display: none;
 }
 
 .loading-overlay {
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}


.loading-overlay {
  position: fixed;
  width: 100%;
  height: 100%;
  background-image: url('../image/loading.gif');
  background-repeat: no-repeat;
  background-position: center;
  background-color: rgba(0, 0, 0, 0.5);
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
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

</style>
<script>
  $(document).ready( function () {
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
      var file_data = $('#zip').prop('files')[0]; 
      var form_data = new FormData();
      form_data.append('zip', file_data);
      form_data.append('action', 'uploadZip');

      $.ajax({
        url: "../ajax/ajax.php",
        method: "POST",
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        success: function(result){
            console.log(result.trim());
			var result = JSON.parse(result);
            $(".btnProceed").show();
            var countRow = 0;
            var duplicateImages = [];
            for (var original in result) 
            {
                if (result.hasOwnProperty(original)) 
                {
                    countRow++;
                    var tableBody = $("#image_table tbody");
                    var startIndex = original.indexOf('Upload/');
                    var originalFilePath = original.substring(startIndex);
                    var matchImages = "";
                    // Loop through the file paths and create a new row for each path
                    for (var i = 0; i < result[original].length; i++) 
                    {
                        var matchFilePath = result[original][i].substring(startIndex);
                        duplicateImages.push(matchFilePath);
                        matchImages += "<p onmouseover=\"this.style.cursor='pointer'; this.style.textDecoration='underline';\" onmouseout=\"this.style.textDecoration='none';\" onclick=\"toggleImage(this)\">" + matchFilePath.split("/").slice(-2).join("/") + "</p><img class='image match' style=\"display:none;\" id=" + matchFilePath + " src=\"" + matchFilePath + "\">";
                    }
                    tableBody.append("<tr><td><p onmouseover=\"this.style.cursor='pointer'; this.style.textDecoration='underline';\" onmouseout=\"this.style.textDecoration='none';\" onclick=\"toggleImage(this)\">" + originalFilePath.split("/").slice(-2).join("/") + "</p><img class='image original' style=\"display:none;\" id=" + originalFilePath + " src=\"" + originalFilePath + "\"><td>" + matchImages + "</td></tr>");
                }
            }
            console.log(duplicateImages);
            $("#btnProceed").click(function(){
                $.ajax({
                    url: "../ajax/ajax.php",
                    method: "POST",
                    data: {action: "removeDuplicate", duplicateImage: JSON.stringify(duplicateImages)},
                    success: function(result){
                        console.log(result);
                    }
                });
            });
          }
        });
    });
  });

</script>
<div class="container">
    <div style="margin-top: 0%; width: 88%;">
        <div style="margin-top: 0.8%;">
            <section class="section columns">
            </section>
            <section style="padding-top:0%; width: 116%; padding-left: 20%;">
                <form action="" method="post" enctype="multipart/form-data">
                    Select zip folder to retrain:
                    <input  type="file" name="zip" id="zip" accept=".zip,.rar,.7z,.gz">
                    <input type="button" value="Upload Zip" name="submit" class="btnUpload button is-small is-primary" style="margin-bottom: 5px; ">
                </form>
                <script>
                    function toggleImage(clickedElement) {
                        // get the parent tr element of the clicked td element
                        var tr = clickedElement.parentElement.parentElement;
                        // select all img elements within the same row as the clicked td element
                        var images = tr.querySelectorAll('img');
                        // loop through the img elements and display them
                        for (var i = 0; i < images.length; i++) {
                            if(images[i].style.display === 'block')
                            images[i].style.display = 'none';  
                        else images[i].style.display = 'block';
                        }
                    }
                </script>
                <p class="panel-heading">
                    Duplicate Image
                </p>
                <div class="panel-block">
                    <table class="table is-full" id="image_table" style="width:100%;">
                        <thead>
                            <tr>
                            <th width="40%">ORIGINAL IMAGE</th>
                            <th width="40%">MATCH IMAGE</th>
                            <!-- <th width="20%"><input type='checkbox'></th> -->
                            </tr>
                        </thead>
                        <tbody id='original'>
                            <!-- <div ></div> -->
                            <!-- <tr>
                                <td colspan='3' class="panel-block">
                                    <button class="btnBalance button is-danger   is-fullwidth" style="margin-right: 3px;"  type="button">
                                        Delete
                                    </button>
                                </td>
                            </tr> -->
                        </tbody>
                    </table>
                </div>
                <br>
                <div class="btnProceed" style="text-align: center; display: none;">
                    <button id="btnProceed" class="button is-info">Proceed</button>
                </div>
                <br>
            </section>
        </div>
    </div>
</div>