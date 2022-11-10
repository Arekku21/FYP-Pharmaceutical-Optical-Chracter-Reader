<?php
include "../db.php";
if($_POST["action"] == "addToCart")
{
    $sql = mysqli_query($Links, "SELECT * FROM tblmedicine WHERE DrugID = ".$_POST["id"]."");
    $drug = array();
    if(mysqli_num_rows($sql) > 0)
    {
        $row = mysqli_fetch_array($sql);
        array_push($drug, $row["drugName"]);
        array_push($drug, $row["manufacturer"]);
        array_push($drug, 1);
        array_push($drug, $row["unitPrice"]);
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
        array_push($drug, $row["drugName"]);
        array_push($drug, $row["manufacturer"]);
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
        $quantity = $row["quantity"] + $_POST["quantity"];
        $sql = mysqli_query($Links, "UPDATE tblstored_drug SET quantity = ".$quantity." WHERE batchNo = '".$_POST["batchNo"]."' AND DrugID = ".$_POST["drugID"]."");
    }
    else
    {
        $sql = mysqli_query($Links, "INSERT INTO tblstored_drug(batchNo, DrugID, manufacturerDate, expiryDate, quantity, entryDate) 
        VALUES('".$_POST["batchNo"]."', ".$_POST["drugID"].", '".$_POST["manufacturerDate"]."', '".$_POST["expiryDate"]."', ".$_POST["quantity"].", now())");
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
            <td><button type='button' class='button is-danger is-small' value='".$row["batchNo"]."'>Remove</button></td>
            </tr>";
        }
    }
}
?>