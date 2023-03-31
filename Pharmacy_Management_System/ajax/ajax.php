
<?php
// header('Access-Control-Allow-Origin: http://127.0.0.1:5000');
// header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
// header('Access-Control-Allow-Headers: Content-Type, Authorization');
// header('Content-Type: application/json');
include "../db.php";
if($_POST["action"] == "addToCart")
{
    $sql = mysqli_query($Links, "SELECT * FROM tblmedicine, tblstored_drug WHERE tblstored_drug.DrugID = tblmedicine.DrugID AND tblstored_drug.quantity > 0 AND tblmedicine.DrugID = ".$_POST["id"]."");
    $drug = array();
    if(mysqli_num_rows($sql) > 0)
    {
        $row = mysqli_fetch_array($sql);
        array_push($drug, ucwords(strtolower($row["drugName"])));
        array_push($drug, ucwords(strtolower($row["manufacturer"])));
        array_push($drug, 1);
        array_push($drug, $row["unitPrice"]);
        array_push($drug, $row["DrugID"]);
        echo json_encode($drug);
    }
}

else if($_POST["action"] == "addStock")
{
    $sql = mysqli_query($Links, "SELECT * FROM tblmedicine, tblmedicine_image WHERE tblmedicine.drug_image_id = tblmedicine_image.drug_image_id AND tblmedicine.DrugID = ".$_POST["id"]."");
    $drug = array();
    if(mysqli_num_rows($sql) > 0)
    {
        $row = mysqli_fetch_array($sql);
        array_push($drug, ucwords(strtolower($row["drugName"])));
        array_push($drug, ucwords(strtolower($row["manufacturer"])));
        array_push($drug, $row["image_path"]);
        echo json_encode($drug);
    }
}

else if($_POST["action"] == "addStock2")
{
    //check if bachNo exist
    $checkExist = mysqli_query($Links, "SELECT * FROM tblstored_drug WHERE batchNo = '".$_POST["batchNo"]."' AND DrugID = ".$_POST["drugID"]."");
    //if exist update quantity
    if(mysqli_num_rows($checkExist) > 0)
    {
        $row = mysqli_fetch_array($checkExist);
        $quantity = $row["quantity"] + trim($_POST["quantity"]);
        $sql = mysqli_query($Links, "UPDATE tblstored_drug SET quantity = ".$quantity." WHERE batchNo = '".$_POST["batchNo"]."' AND DrugID = ".$_POST["drugID"]."");
    }
    else
    {
        $sql = mysqli_query($Links, "INSERT INTO tblstored_drug(batchNo, DrugID, manufacturerDate, expiryDate, quantity, entryDate) 
        VALUES('".strtoupper(trim($_POST["batchNo"]))."', ".$_POST["drugID"].", '".$_POST["manufacturerDate"]."', '".$_POST["expiryDate"]."', ".trim($_POST["quantity"]).", now())");
    }
    if($sql)
        echo "Stock added success";
    else echo "Fail to add new stock";
}

else if($_POST["action"] == "remove")
{
    $sql = mysqli_query($Links, "SELECT * FROM tblstored_drug WHERE DrugID = ".$_POST["id"]."");
    if(mysqli_num_rows($sql) > 0)
    {
        while($row = mysqli_fetch_array($sql))
        {
            echo "<tr>
            <td>".$row["batchNo"]."</td>
            <td>".$row["manufacturerDate"]."</td>
            <td>".$row["expiryDate"]."</td>
            <td>".$row["quantity"]."</td>
            <td><button type='button' class='btnRemove2 button is-danger is-small' id='".$row["batchNo"]."'>Remove</button></td>
            </tr>";
        }
    }
    else echo "<tr><td colspan='5' style='text-align: center'><b>No record found!</b></td></tr>";
}

else if($_POST["action"] == "remove2")
{
    $sql = mysqli_query($Links, "SELECT * FROM tblmedicine, tblstored_drug WHERE tblmedicine.DrugID = tblstored_drug.DrugID AND tblstored_drug.batchNo = '".$_POST["id"]."'");
    if(mysqli_num_rows($sql) > 0)
    {
        $row = mysqli_fetch_array($sql);
        $remove = mysqli_query($Links, "DELETE FROM tblstored_drug WHERE batchNo = '".$_POST["id"]."'");
        if($remove)
            echo "Deleted Drug Stock\nDrug Name: ".ucwords(strtolower($row["drugName"]))."\nManufacturer: ".ucwords(strtolower($row["manufacturer"]))."\nBatch number: ".$row["batchNo"];
        else echo "Fail to remove Drug Stock\nDrug Name: ".ucwords(strtolower($row["drugName"]))."\nManufacturer: ".ucwords(strtolower($row["manufacturer"]))."\nBatch number: ".$row["batchNo"];
    }
}

else if($_POST["action"] == "getDrugInfo")
{
    $sql = mysqli_query($Links, "SELECT * FROM tblmedicine WHERE DrugID = ".$_POST["id"]."");
    if(mysqli_num_rows($sql) > 0)
    {
        $drug = array();
        $row = mysqli_fetch_array($sql);
        array_push($drug, ucwords(strtolower($row["drugName"])));
        array_push($drug, ucwords(strtolower($row["manufacturer"])));
        echo json_encode($drug);
    }
}

else if($_POST["action"] == "showEditModal")
{
    $sql = mysqli_query($Links, "SELECT * FROM tblmedicine, tblmedicine_image WHERE tblmedicine.drug_image_id = tblmedicine_image.drug_image_id AND tblmedicine.DrugID = ".$_POST["id"]."");
    if(mysqli_num_rows($sql) > 0)
    {
        $row = mysqli_fetch_array($sql);
        $drug = array();
        array_push($drug, ucwords(strtolower($row["manufacturer"])));
        array_push($drug, ucwords(strtolower($row["drugName"])));
        array_push($drug, ucwords(strtolower($row["scientificName"])));
        array_push($drug, $row["drugDosage"]);
        array_push($drug, ucwords(strtolower($row["drugCategory"])));
        array_push($drug, $row["no_of_unit_in_package"]);
        array_push($drug, $row["unitPrice"]);
        array_push($drug, $row["image_path"]);
        echo json_encode($drug);
    }
}

else if($_POST["action"] == "editDrug")
{
    if($_POST["id"] != "")
    {
        $update_drug = mysqli_query($Links, "UPDATE tblmedicine SET manufacturer = '".strtoupper(trim($_POST["manufacturer"]))."', 
                drugName = '".strtoupper(trim($_POST["name"]))."',
                drugDosage = ".trim($_POST["dosage"]).",
                drugCategory = '".strtoupper(trim($_POST["category"]))."',
                no_of_unit_in_package = ".trim($_POST["unit"]).",
                unitPrice = ".trim($_POST["price"])." WHERE DrugID = ".$_POST["id"]."");
        if($_FILES["image"] != null)
        {  
            chdir("../Medicine_Image");
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
                    //get old image name and remove it from directory
                    $sql = mysqli_query($Links, "SELECT * FROM tblmedicine, tblmedicine_image WHERE tblmedicine.drug_image_id = tblmedicine_image.drug_image_id AND tblmedicine.DrugID = ".$_POST["id"]."");
                    if(mysqli_num_rows($sql) > 0)
                    {
                        $row = mysqli_fetch_array($sql);
                        $update_image = mysqli_query($Links, "UPDATE tblmedicine_image SET image_path = '".$filename."' WHERE drug_image_id = ".$row["drug_image_id"]."");
                        unlink($row["image_path"]);
                    }
                }
            }
        }
        if($update_drug || $update_image) 
            echo "Drug updated!";
        else echo "Fail to update drug!";
    }
}

else if($_POST["action"] == "deleteDrug")
{
    $get_image_name = mysqli_query($Links, "SELECT * FROM tblmedicine, tblmedicine_image WHERE tblmedicine.drug_image_id = tblmedicine_image.drug_image_id AND tblmedicine.DrugID = ".$_POST["id"]."");
    if(mysqli_num_rows($get_image_name) > 0)
    {
        $row = mysqli_fetch_array($get_image_name);
        chdir("../Medicine_Image");
        unlink($row["image_path"]);
        $sql = mysqli_query($Links, "DELETE FROM tblmedicine WHERE DrugID = ".$_POST["id"]."");
        $sql2 = mysqli_query($Links, "DELETE FROM tblmedicine_image WHERE drug_image_id = ".$row["drug_image_id"]."");
        $sql3 = mysqli_query($Links, "DELETE FROM tblstored_drug WHERE DrugID = ".$_POST["id"]."");
        echo "Deleted Drug\nDrug Name: ".ucwords(strtolower($row["drugName"]))."\nManufacturer: ".ucwords(strtolower($row["manufacturer"]));
    }
}

else if($_POST["action"] == "reduceStock")
{
    $drugName = array();
    $drugBatchNo = array();
    $drugQty = array();
    $drugPrice = array();
    $drugID = explode(":", $_POST["id"]);
    $quantity = explode(":", $_POST["quantity"]);
    for($i = 0; $i < count($quantity); $i++)
    {
        $sql = mysqli_query($Links, "SELECT * FROM tblstored_drug, tblmedicine WHERE tblstored_drug.DrugID = tblmedicine.DrugID AND tblstored_drug.DrugID = ".$drugID[$i]." ORDER BY tblstored_drug.manufacturerDate");
        if(mysqli_num_rows($sql) == 1)
        {
            $row = mysqli_fetch_array($sql);
            if($row["quantity"] >= $quantity[$i])
            {
                $qty = $row["quantity"] - $quantity[$i];
                $getDrugInfo = mysqli_query($Links, "SELECT * FROM tblmedicine WHERE DrugID = ".$row["DrugID"]."");
                if(mysqli_num_rows($getDrugInfo) > 0)
                {
                    $drugInfo = mysqli_fetch_array($getDrugInfo);
                    array_push($drugName, $drugInfo["drugName"]);
                    array_push($drugPrice, $drugInfo["unitPrice"]);
                }
                array_push($drugBatchNo, $row["batchNo"]);
                array_push($drugQty, $quantity[$i]);
                $update = mysqli_query($Links, "UPDATE tblstored_drug SET quantity = ".$qty." WHERE batchNo = '".$row["batchNo"]."'");
                // echo "UPDATE tblstored_drug SET quantity = ".$qty." WHERE DrugID = ".$drugID[$i]."";
            }
            else
            {
                echo "Product not enough stock!\nDrug Name: ".ucwords(strtolower($row["drugName"]))."\nDrug Manufacturer: ".ucwords(strtolower($row["manufacturer"]))."";
                $quit = true;
            }
        }
        else
        {
            //check total stock is enough or not
            $total_quantity = 0;
            for($j = 0; $j < mysqli_num_rows($sql); $j++)
            {
                $row = mysqli_fetch_array($sql);
                $productName = $row["drugName"];
                $total_quantity += $row["quantity"];
            }
            if($total_quantity >= $quantity[$i])
            {
                $sql2 = mysqli_query($Links, "SELECT * FROM tblstored_drug WHERE DrugID = ".$drugID[$i]." ORDER BY manufacturerDate");
                for($j = 0; $j < mysqli_num_rows($sql2); $j++)
                {
                    $row2 = mysqli_fetch_array($sql2);
                    if($quantity[$i] >= $row2["quantity"])
                    {
                        $quantity[$i] -= $row2["quantity"];
                        $getDrugInfo = mysqli_query($Links, "SELECT * FROM tblmedicine WHERE DrugID = ".$row2["DrugID"]."");
                        if(mysqli_num_rows($getDrugInfo) > 0)
                        {
                            $drugInfo = mysqli_fetch_array($getDrugInfo);
                            array_push($drugName, $drugInfo["drugName"]);
                            array_push($drugPrice, $drugInfo["unitPrice"]);
                        }
                        array_push($drugBatchNo, $row2["batchNo"]);
                        array_push($drugQty, $row2["quantity"]);
                        $update = mysqli_query($Links, "UPDATE tblstored_drug SET quantity = '0' WHERE batchNo = '".$row2["batchNo"]."'");
                        // echo "UPDATE tblstored_drug SET quantity = '0' WHERE batchNo = ".$row2["batchNo"]."";
                    }
                    else
                    {
                        //must put here before the reduce tock
                        array_push($drugQty, $quantity[$i]);
                        $quantity[$i] = $row2["quantity"] - $quantity[$i];
                        $getDrugInfo = mysqli_query($Links, "SELECT * FROM tblmedicine WHERE DrugID = ".$row2["DrugID"]."");
                        if(mysqli_num_rows($getDrugInfo) > 0)
                        {
                            $drugInfo = mysqli_fetch_array($getDrugInfo);
                            array_push($drugName, $drugInfo["drugName"]);
                            array_push($drugPrice, $drugInfo["unitPrice"]);
                        }
                        array_push($drugBatchNo, $row2["batchNo"]);
                        $update = mysqli_query($Links, "UPDATE tblstored_drug SET quantity = ".$quantity[$i]." WHERE batchNo = '".$row2["batchNo"]."'");
                        // echo "UPDATE AAtblstored_drug SET quantity = ".$quantity[$i]." WHERE batchNo = ".$row2["batchNo"]."";
                        break;
                    }
                }
            }
            else
            {
                echo "Product not enough stock!\nDrug Name: ".ucwords(strtolower($productName))."";
                $quit = true;
            }
        }
    }
    if($quit != true)
    {
        $insert = mysqli_query($Links, "INSERT INTO tblpurchase_invoice(purchaseDate, drugID, drugBatchNo, drugQty, drugPrice, tax, totalAmount, paymentType, discount, paidAmount, remainingAmount) VALUES(
            now(),
            '".implode(":", $drugName)."',
            '".implode(":", $drugBatchNo)."',
            '".implode(":", $drugQty)."',
            '".implode(":", $drugPrice)."',
            '".$_POST["tax"]."',
            ".$_POST["total"].",
            'Cash',
            0,
            ".trim($_POST["paid"]).",
            ".$_POST["balance"]."
        )");
        if($insert)
        {
            echo "Payment complete!"."-".mysqli_insert_id($Links);
        }
    }
}

else if($_POST["action"] == "reportDaily" || $_POST["action"] == "reportMonth")
{
    if($_POST["action"] == "reportDaily")
        $sql = mysqli_query($Links, "SELECT * FROM tblpurchase_invoice WHERE DATE_FORMAT(purchaseDate, '%Y-%m-%d') = '".$_POST["date"]."'");
    else $sql = mysqli_query($Links, "SELECT * FROM tblpurchase_invoice WHERE DATE_FORMAT(purchaseDate, '%M') = '".$_POST["month"]."' AND DATE_FORMAT(purchaseDate, '%Y') = '".$_POST["year"]."' ");
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
}

else if($_POST["action"] == "deleteDrugStock")
{
    $sql = mysqli_query($Links, "SELECT * FROM tblmedicine, tblstored_drug WHERE tblmedicine.DrugID = tblstored_drug.DrugID AND tblstored_drug.batchNo = '".$_POST["id"]."'");
    if(mysqli_num_rows($sql) > 0)
    {
        $row = mysqli_fetch_array($sql);
        $remove = mysqli_query($Links, "DELETE FROM tblstored_drug WHERE batchNo = '".$_POST["id"]."'");
        if($remove)
            echo "Deleted Drug\nDrug Name: ".ucwords(strtolower($row["drugName"]))."\nManufacturer: ".ucwords(strtolower($row["manufacturer"]))."\nBatch number: ".$row["batchNo"];
        else echo "Fail to remove";
    }
}

else if($_POST["action"] == "editEmployee")
{
    if($_POST["id"] != "")
    {
        $id = $_POST['id'];
        $Name = $_POST['Name'];
        $Email = $_POST['Email'];
        $Date_joined = $_POST['Date_joined'];
        $Salary = $_POST['Salary'];
        $Shifts = $_POST['Shifts'];


        $sql = "UPDATE `employee` SET `Name`='$Name', `Email`='$Email', `Date_joined`='$Date_joined', `Salary`='$Salary', `Shifts`='$Shifts' WHERE `id` = '$id'";
        $update_employee = mysqli_query($Links, $sql);
        
        if($update_employee) 
            echo "Employee updated!";
        else echo "Fail to update employee!";
    }
}

else if($_POST["action"] == "deleteEmployee")
{
    $id = $_POST['id'];
    $sql_query = "DELETE  FROM `employee` WHERE `id` = '$id'";
    $sql = mysqli_query($Links, $sql_query);
    echo "Employee Removed successfully";
}

else if($_POST["action"] == "uploadImage")
{
    if($_POST["page"] == "pos")
    {
        chdir("../pos/Upload");
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
                if($imageFileType != "jpg")
                {
                    $image = imagecreatefrompng($filename);
                    $bg = imagecreatetruecolor(imagesx($image), imagesy($image));
                    imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
                    imagealphablending($bg, TRUE);
                    imagecopy($bg, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
                    imagedestroy($image);
                    $quality = 100; // 0 = worst / smaller file, 100 = better / bigger file 
                    imagejpeg($bg, $new_file[0].date('d-m-y_h_i_s') . ".jpg", $quality);
                    imagedestroy($bg);
                }
                // $url = "http://127.0.0.1:5000/api/easyocr/output/best_confidence";
                $url = "http://127.0.0.1:5000/api/paddle/output/best_confidence";
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                $headers = array(
                    "Accept: application/json",
                    "Content-Type: application/json",
                );
                curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                $img = file_get_contents($new_file[0].date('d-m-y_h_i_s').".jpg");
                $img_encoded = base64_encode($img);
                unlink($new_file[0].date('d-m-y_h_i_s') . ".jpg");
                $data_json = new stdClass();
                $data_json->image = $img_encoded;
                $data = json_encode($data_json);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                $resp = curl_exec($curl);
                curl_close($curl);
                echo $resp;
            }
            else 
            {
                echo "Fail to move image to server!";
            }
        }
    }
    // else if($_POST["page"] == "inventory")
    // {
    //     chdir("../pos/Upload");
    //     $target_file = basename($_FILES["image"]["name"]);
    //     $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    //     $check = getimagesize($_FILES["image"]["tmp_name"]);
    //     if($check !== false)
    //     {
    //         if(move_uploaded_file($_FILES["image"]["tmp_name"], "".$_FILES["image"]["name"]))
    //         {
    //             $new_file = explode(".", $target_file);
    //             $filename = $new_file[0].date('d-m-y_h_i_s').".".$imageFileType;
    //             rename($target_file, $filename);
    //             if($imageFileType != "jpg")
    //             {
    //                 $image = imagecreatefrompng($filename);
    //                 $bg = imagecreatetruecolor(imagesx($image), imagesy($image));
    //                 imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
    //                 imagealphablending($bg, TRUE);
    //                 imagecopy($bg, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
    //                 imagedestroy($image);
    //                 $quality = 100; // 0 = worst / smaller file, 100 = better / bigger file 
    //                 imagejpeg($bg, $new_file[0].date('d-m-y_h_i_s') . ".jpg", $quality);
    //                 imagedestroy($bg);
    //             }
    //             $url = "http://127.0.0.1:5000/api/easyocr/output/best_confidence";
    //             $curl = curl_init();
    //             curl_setopt($curl, CURLOPT_URL, $url);
    //             curl_setopt($curl, CURLOPT_POST, true);
    //             curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    //             $headers = array(
    //                 "Accept: application/json",
    //                 "Content-Type: application/json",
    //             );
    //             curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    //             $img = file_get_contents($new_file[0].date('d-m-y_h_i_s').".jpg");
    //             $img_encoded = base64_encode($img);
    //             unlink($new_file[0].date('d-m-y_h_i_s') . ".jpg");
    //             $data_json = new stdClass();
    //             $data_json->image = $img_encoded;
    //             $data = json_encode($data_json);
    //             curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    //             $resp = curl_exec($curl);
    //             curl_close($curl);
    //             echo $resp;
    //         }
    //         else 
    //         {
    //             echo "Fail to move image to server!";
    //         }
    //     }
    // }
}

else if($_POST["action"] == "searchDrug")
{
    // index 0: brand
    // index 1: dosage
    $result = json_decode($_POST['result'], true);
    echo "SELECT * FROM tblmedicine WHERE SOUNDEX(drugName) = SOUNDEX('".strtoupper(trim($result["brand"]))."') AND SOUNDEX(drugDosage) = SOUNDEX('".trim($result["dosage"])."')";
    $sql = mysqli_query($Links, "SELECT * FROM tblmedicine WHERE SOUNDEX(drugName) = SOUNDEX('".strtoupper(trim($result["brand"]))."') AND SOUNDEX(drugDosage) = SOUNDEX('".trim($result["dosage"])."')");
    // SELECT * FROM tblmedicine where SOUNDEX(`drugName`) = SOUNDEX('loratidine');
    if(mysqli_num_rows($sql) > 0)
    {
        while($row = mysqli_fetch_array($sql))
        {
            $get_image = mysqli_query($Links, "SELECT * FROM tblmedicine_image WHERE drug_image_id = ".$row["drug_image_id"]."");
            echo "<tr>";
            if(mysqli_num_rows($get_image) > 0)
            {
            $row2 = mysqli_fetch_array($get_image);
            echo " <td><img src='../Medicine_Image/".$row2["image_path"]."' width='150px'></td>";
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

}

else if($_POST["action"] == "refund")
{
    $sql = mysqli_query($Links, "SELECT * FROM tblpurchase_invoice WHERE purchaseInvoiceID = ".$_POST["id"]."");
    if(mysqli_num_rows($sql) > 0)
    {
        $row = mysqli_fetch_array($sql);
        ?>  
			<table class="table">
				<tr>
					<th>Item</th>
					<th>Qty</th>
					<th>Sub Total(RM)</th>
                    <th>Tax(RM)</th>
                    <th>Refund</th>
				</tr>

                <?php
                $item = explode(":", $row["drugID"]);
                $itemBatchNo = explode(":", $row["drugBatchNo"]);
                $qty = explode(":", $row["drugQty"]);
                $drugPrice = explode(":", $row["drugPrice"]);
                $tax = explode(":", $row["tax"]);
                $refundedBatchNo = explode(":", $row["refundedBatchNo"]);
                $refundedDrugPrice = explode(":", $row["refundedDrugPrice"]);
                $refundedDrugQty = explode(":", $row["refundedDrugQty"]);
                $refundedDateTime = explode("|", $row["refundedDateTime"]);
                $refundedTax = explode(":", $row["refundedTax"]);
                for($i = 0; $i < count($item); $i++)
                {
                    $flag = false;
                    $refund = array_sum($refundedDrugPrice);
                    if($qty[$i] != 0)
                    {
                        echo '<tr class="tabletitle">
                            <td class="">'.$item[$i].' - '.$itemBatchNo[$i].'</td>
                            <td class="">'.$qty[$i].'</td>
                            <td class="">'.$drugPrice[$i].'</td>
                            <td class="">'.$drugPrice[$i] * 0.06 * $qty[$i].'</td>
                            <td >';
                        for($j = 0; $j < count($refundedBatchNo); $j++)
                        {
                            if($itemBatchNo[$i] == $refundedBatchNo[$j] && $qty[$i] == $refundedDrugQty[$j])
                            {
                                echo "<font style='color: red;'>Refunded (".$refundedDateTime[$j].")</font>";
                                $flag = true;
                                break;
                            }
                        }
                        if($flag == false)
                            echo '<input type="checkbox" name="chkRefund" value="'.$i.'" style="width: 40px; height: 40px;">';
                        echo '</td>
                        </tr>';
                    }
                }
                ?>

                <tr class="tabletitle">
					<td colspan='3'></td>
					<td class="Rate"><h2>Refund(6% tax inclusive)</h2></td>
					<td class="payment"><h2>RM <span id="refundAmount">0</span></h2></td>
				</tr>
			</table>
    <?php
    }
}

else if($_POST["action"] == "calculateRefundAmount")
{
    $sql = mysqli_query($Links, "SELECT * FROM tblpurchase_invoice WHERE purchaseInvoiceID = ".$_POST["id"]."");
    if(mysqli_num_rows($sql) > 0)
    {
        $row = mysqli_fetch_array($sql);

        $item = explode(":", $row["drugID"]);
        $itemBatchNo = explode(":", $row["drugBatchNo"]);
        $qty = explode(":", $row["drugQty"]);
        $drugPrice = explode(":", $row["drugPrice"]);
        $tax = explode(":", $row["tax"]);
        for($i = 0; $i < count($item); $i++)
        {
            if($i == $_POST["position"])
            {
                if($_POST["status"] == "add")
                {
                    echo $_POST["amount"] + ($drugPrice[$i] * 0.06 * $qty[$i]) + ($drugPrice[$i] * $qty[$i]);
                }
                else echo $_POST["amount"] - ($drugPrice[$i] * 0.06 * $qty[$i]) - ($drugPrice[$i] * $qty[$i]);
            }
        }
    }
}

else if($_POST["action"] == "proceedRefund")
{
    $sql = mysqli_query($Links, "SELECT * FROM tblpurchase_invoice WHERE purchaseInvoiceID = ".$_POST["id"]."");
    if(mysqli_num_rows($sql) > 0)
    {
        $row = mysqli_fetch_array($sql);
        $item = explode(":", $row["drugID"]);
        $itemBatchNo = explode(":", $row["drugBatchNo"]);
        $qty = explode(":", $row["drugQty"]);
        $drugPrice = explode(":", $row["drugPrice"]);
        $tax = explode(":", $row["tax"]);
        $position = explode(":", $_POST["position"]);

        if($row["refundedItem"] == NULL)
        {
            $refundedItem = array();
            $refundedDrugPrice = array();
            $refundedBatchNo = array();
            $refundedDrugQty = array();
            $refundedDateTime = array();
            $refundedTax = 0;
            $refundedAmount = 0;
        }
        else
        {
            $refundedItem = explode(":", $row["refundedItem"]);
            $refundedDrugPrice = explode(":", $row["refundedDrugPrice"]);
            $refundedBatchNo = explode(":", $row["refundedBatchNo"]);
            $refundedDrugQty = explode(":", $row["refundedDrugQty"]);
            $refundedDateTime = explode("|", $row["refundedDateTime"]);
            $refundedTax = explode(":", $row["refundedTax"])[1];
            $refundedAmount = array_sum($refundedDrugPrice) + $refundedTax;
        }

        for($i = 0; $i < count($item); $i++)
        {
            for($j = 0; $j < count($position); $j++)
            {
                if($i == $position[$j])
                {
                    array_push($refundedItem, $item[$i]);
                    array_push($refundedDrugPrice, $drugPrice[$i]);
                    array_push($refundedBatchNo, $itemBatchNo[$i]);
                    array_push($refundedDrugQty, $qty[$i]);
                    array_push($refundedDateTime, date('Y-m-d H:i:s'));
                    $refundedTax += ($drugPrice[$i] * 0.06 * $qty[$i]);
                    $refundedAmount += ($drugPrice[$i] * 0.06 * $qty[$i]) + ($drugPrice[$i] * $qty[$i]);
                }
            }
        }
        $refundedItem = implode(":", $refundedItem);
        $refundedDrugPrice = implode(":", $refundedDrugPrice);
        $refundedBatchNo = implode(":", $refundedBatchNo);
        $refundedDrugQty = implode(":", $refundedDrugQty);
        $refundedDateTime = implode("|", $refundedDateTime);


        $update = mysqli_query($Links, "UPDATE tblpurchase_invoice SET refundedItem = '".$refundedItem."', refundedBatchNo = '".$refundedBatchNo."', refundedDrugQty = '".$refundedDrugQty."', refundedDrugPrice = '".$refundedDrugPrice."', refundedTax = '6:".$refundedTax."', refundedDateTime = '".$refundedDateTime."' WHERE purchaseInvoiceID=".$_POST["id"]."");

        #need to update drug table after they refund
        $refundedDrugQty = explode(":", $refundedDrugQty);
        $refundedBatchNo = explode(":", $refundedBatchNo);
        $sql = mysqli_query($Links, "SELECT * FROM tblstored_drug");
        if(mysqli_num_rows($sql) > 0)
        {
            for($i = 0; $i < mysqli_num_rows($sql); $i++)
            {
                $row = mysqli_fetch_array($sql);
                for($j = 0; $j < count($refundedBatchNo); $j++)
                {
                    if($row["batchNo"] == $refundedBatchNo[$j])
                    {
                        $dbDrugQty = $row["quantity"] + $refundedDrugQty[$j];
                        $sql2 = mysqli_query($Links, "UPDATE tblstored_drug SET quantity= ".$dbDrugQty." WHERE batchNo='".$refundedBatchNo[$j]."'");
                    }
                }
            }
            if($sql2)
                echo "Item refund successfully";
            else echo "Item fail to refund";
        }
    }
}

else if($_POST["action"] == "uploadZip")
{
    $upload_dir = "../retraining/Upload/";
    if(!file_exists($upload_dir) || !is_dir($upload_dir)) {
        die("Upload directory not found or inaccessible");
    }
    chdir($upload_dir);
    $target_file = basename($_FILES["zip"]["name"]);
    $zipFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if(move_uploaded_file($_FILES["zip"]["tmp_name"], $target_file))
    {
        $new_file = explode(".", $target_file);
        $filename = $new_file[0].date('d-m-y_h_i_s').".".$zipFileType;
        //create new folder
        $dir = $new_file[0].date('d-m-y_h_i_s');
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
            // echo 'Directory created successfully...<br>';
        } else {
            // echo 'Directory already exists...\n';
        }
        rename($target_file, $filename);
        $target_file = $filename;
        //unzip folder
        $zip = new ZipArchive();
        $res = $zip->open($target_file);
        if ($res === TRUE) {
            // Extract all files to the current directory
            $zip->extractTo(getcwd()."/".$dir);
            $zip->close();
            // echo 'Files extracted successfully...';
            unlink($new_file[0].date('d-m-y_h_i_s').".".$zipFileType);
            $script = '../Duplicate-Image-Finder/difPy/dif.py'; // the path to your Python script
            chmod($script, 0755);
            try 
            {
                $environment = "difPy";
                // Use escapeshellarg to escape any special characters in the script and directory names
                $command = "source /Users/kyronling/miniforge3/bin/activate $environment && python " . escapeshellarg($script) . " -D " . escapeshellarg(getcwd().$dir);

                // Use exec to execute the command and capture its output
                $output = exec($command);
                
                $files = glob("difPy_results_*");
                $mydata = file_get_contents($files[0]);
                // $mydata = file_get_contents("difPy_results_1678346780_026387.json");
                $matchArray = array();
                $json = json_decode($mydata);
                foreach ($json as $key => $value) {
                    $original = $value->location;
                    $count = 0;
                    $matchLocation = array();
                    foreach ($value->matches as $matchKey => $matchValue) {
                        array_push($matchLocation, $matchValue->location);
                    }
                    $matchArray[$original] = $matchLocation;
                }  
                $json_data = json_encode($matchArray);
                echo $json_data;
            } catch (Exception $e) {
                // echo 'Caught exception: ',  $e->getMessage(), "\n";
            }
        } else {
            // echo 'Failed to extract files';
        }
    }
    else {
        // die("Error uploading file");
    }
}

else if($_POST["action"] == "removeDuplicate")
{
    $duplicateImages = json_decode($_POST["duplicateImage"], true);
    chdir("../retraining");
    echo getcwd();
    print_r($duplicateImages);
    for($i = 0; $i < count($duplicateImages); $i++)
    {
        if(file_exists($duplicateImages[$i]))
        {
            unlink($duplicateImages[$i]);
        }
    }
    echo "All duplicated images removed";
}
?>