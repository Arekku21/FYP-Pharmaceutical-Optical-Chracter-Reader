<!-- 

> -->

<?php
error_reporting(0);

chdir("Upload");
$target_file = basename($_FILES["image"]["name"]);
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
$check = getimagesize($_FILES["image"]["tmp_name"]);
if($check !== false)
{
    if(move_uploaded_file($_FILES["image"]["tmp_name"], "".$_FILES["image"]["name"]))
    {
        $new_file = explode(".", $target_file);
        $filename = $new_file[0].date('d-m-y_h_i_s').".".$imageFileType;

        rename($target_file, $filename);

        $img = file_get_contents($target_file);

        $img_encoded = base64_encode($img);

       

        $url = "http://127.0.0.1:5000/api/easyocr/output/best_confidence";
        
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);

        curl_setopt($curl, CURLOPT_POST, true);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(

          "Accept: application/json",

          "Content-Type: application/json",

        );

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);



        $img = file_get_contents($target_file);



        $img_encoded = base64_encode($img);



        $data_json = new stdClass();

        $data_json->image = $img_encoded;



        $data = json_encode($data_json);



        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);



        $resp = curl_exec($curl);

        curl_close($curl);

        // echo $resp;
    }
    else 
    {
        echo "Fail to move image to server!";
    }
}
?>