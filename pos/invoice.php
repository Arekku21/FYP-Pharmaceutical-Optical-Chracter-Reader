<?php include "../db.php";
$login_page = "../login.php";

echo "<script type='text/javascript'> console.log('Role ID: " .  $_SESSION['roleID'] . "' ); </script>";

// Check if user is logged in
if($_SESSION['logged_in'] !== True)
{
  // Redirect to Your Login Page to Prevent Unauthorized Access
  header("Location: $login_page");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/html2canvas.min.js"></script>
    <script src="../js/html2canvas.js"></script>

</head>
<body>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
<?php
if($_GET["invoiceID"] != "")
{
?>
<div id="printPage">
    <div class="container px-0">
        <div class="row mt-4">
            <div class="col-12 col-lg-12">
                <div class="row">
                    <div class="col-12">
                        <div class="text-center text-150">
                                <span class="text-default-d3"><img src="../image/logo.png"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <div class="page-content container">
        <div class="page-header text-blue-d2">
            <?php 
            $sql = mysqli_query($Links, "SELECT * FROM tblpurchase_invoice WHERE purchaseInvoiceID = ".$_GET["invoiceID"]."");
            if(mysqli_num_rows($sql) > 0)
            {
                $row = mysqli_fetch_array($sql);
                echo '<h1 class="page-title text-secondary-d1">
                Invoice
                <small class="page-info">
                    <i class="fa fa-angle-double-right text-80"></i>
                    ID: #'.$row["purchaseInvoiceID"].'
                </small>
                </h1>';
            }
            ?>
            
        </div>

        <div class="container px-0">
            <div class="row mt-4">
                <div class="col-12 col-lg-12">
                    <div class="row">
                        <?php
                        $sql = mysqli_query($Links, "SELECT * FROM tblpurchase_invoice WHERE purchaseInvoiceID = ".$_GET["invoiceID"]."");
                        if(mysqli_num_rows($sql) > 0)
                        {
                            $row = mysqli_fetch_array($sql);
                        ?>
                            <div class="text-95 col-sm-12 align-self-start d-sm-flex justify-content-start">
                                <hr class="d-sm-none" />
                                <div class="text-grey-m2">
                                    <div class="mt-1 mb-2 text-secondary-m1 text-600 text-125">
                                        Invoice
                                    </div>

                                    <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span class="text-600 text-90">ID:</span><?php echo $row["purchaseInvoiceID"]; ?></div>

                                    <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span class="text-600 text-90">Issue Date:</span><?php echo $row["purchaseDate"]; ?></div>
                                </div>
                            </div>
                        <?php 
                        }
                        ?>
                        <!-- /.col -->
                    </div>

                    <div class="mt-4">
                        <div class="row text-600 text-white bgc-default-tp1 py-25">
                            <div class="d-none d-sm-block col-1">#</div>
                            <div class="col-9 col-sm-5">Description</div>
                            <div class="d-none d-sm-block col-4 col-sm-2">Qty</div>
                            <div class="d-none d-sm-block col-sm-2">Unit Price(RM)</div>
                            <div class="col-2">Amount(RM)</div>
                        </div>

                        <div class="text-95 text-secondary-d3">
                            <?php
                            $sql = mysqli_query($Links, "SELECT * FROM tblpurchase_invoice WHERE purchaseInvoiceID = ".$_GET["invoiceID"]."");
                            if(mysqli_num_rows($sql) > 0)
                            {
                                $total = 0;
                                $row = mysqli_fetch_array($sql);
                                $drugName = explode(":", $row["drugID"]);
                                $drugQty = explode(":", $row["drugQty"]);
                                $drugPrice = explode(":", $row["drugPrice"]);
                                $drugBatchNo = explode(":", $row["drugBatchNo"]);
                                $substotal = 0;
                                $count = 0;

                                $refundedItem = explode(":", $row["refundedItem"]);
                                $refundedDrugPrice = explode(":", $row["refundedDrugPrice"]);
                                $refundedBatchNo = explode(":", $row["refundedBatchNo"]);
                                $refundedDrugQty = explode(":", $row["refundedDrugQty"]);
                                $refundedDateTime = explode("|", $row["refundedDateTime"]);

                                $refundAmount = 0;
                                for($i = 0; $i < count($drugName); $i++)
                                {
                                    $flag = false;
                            
                                    if($drugQty[$i] > 0)
                                    {
                                        $count++;
                                        if($i % 2 == 0)
                                            echo '<div class="row mb-2 mb-sm-0 py-25">';
                                        else echo '<div class="row mb-2 mb-sm-0 py-25 bgc-default-l4">';
                                        echo '<div class="d-none d-sm-block col-1">'.$count.'</div>';
                                        
                                        for($j = 0; $j < count($refundedItem); $j++)
                                        {
                                            if($drugName[$i] == $refundedItem[$j] && $drugBatchNo[$i] == $refundedBatchNo[$j])
                                            {
                                                $flag = true;
                                                $refundAmount += (($drugQty[$i] * $drugPrice[$i]) * 0.06) + ($drugQty[$i] * $drugPrice[$i]);
                                                break;
                                            }
                                        }
                                        if($flag == true)
                                        {
                                            echo '<div class="col-9 col-sm-5"><b>(REFUND)</b>'.ucwords(strtolower($drugName[$i])).' - '.$drugBatchNo[$i].'</div>';
                                            echo '<div class="d-none d-sm-block col-2">'.$drugQty[$i].'</div>';
                                            echo '<div class="d-none d-sm-block col-2 text-95">'.$drugPrice[$i].'</div>';
                                            $substotal += ($drugQty[$i] * $drugPrice[$i]);
                                            echo '<div class="col-2 text-secondary-d2">'.($drugQty[$i] * $drugPrice[$i]).'</div>';
                                            $total += $drugQty[$i] * $drugInfo["unitPrice"];
                                            echo '</div>';
                                        }
                                        else
                                        {
                                            echo '<div class="col-9 col-sm-5">'.ucwords(strtolower($drugName[$i])).' - '.$drugBatchNo[$i].'</div>';
                                            echo '<div class="d-none d-sm-block col-2">'.$drugQty[$i].'</div>';
                                            echo '<div class="d-none d-sm-block col-2 text-95">'.$drugPrice[$i].'</div>';
                                            $substotal += ($drugQty[$i] * $drugPrice[$i]);
                                            echo '<div class="col-2 text-secondary-d2">'.($drugQty[$i] * $drugPrice[$i]).'</div>';
                                            $total += $drugQty[$i] * $drugInfo["unitPrice"];
                                            echo '</div>';
                                        }
                                        
                                    }
                                }
                                echo '<div class="row border-b-2 brc-default-l2"></div>
                                <div class="row mt-3">
                                    <div class="col-12 col-sm-7 text-grey-d2 text-95 mt-2 mt-lg-0">
                                        Extra note such as company or payment information...
                                    </div>
            
                                    <div class="col-12 col-sm-5 text-grey text-90 order-first order-sm-last">
                                        <div class="row my-2">
                                            <div class="col-7 text-right">
                                                SubTotal
                                            </div>
                                            <div class="col-5">
                                                <span class="text-120 text-secondary-d1"> RM'.$substotal.'</span>
                                            </div>
                                        </div>
            
                                        <div class="row my-2">
                                            <div class="col-7 text-right">
                                                Tax (';
                                                $tax = explode(":", $row["tax"]);
                                                echo $tax[0].'%)
                                            </div>
                                            <div class="col-5">
                                                <span class="text-110 text-secondary-d1">RM '.$tax[1].'</span>
                                            </div>
                                        </div>
            
                                        <div class="row my-2 align-items-center bgc-primary-l3 p-2">
                                            <div class="col-7 text-right">
                                                Total Amount
                                            </div>
                                            <div class="col-5">
                                                <span class="text-150 text-success-d3 opacity-2"> RM '.$row["totalAmount"].'</span>
                                            </div>
                                        </div>
                                        <div class="row my-2 align-items-center bgc-primary-l3 p-2">
                                            <div class="col-7 text-right">
                                                Paid
                                            </div>
                                            <div class="col-5">
                                                <span class="text-150 text-success-d3 opacity-2"> RM '.$row["paidAmount"].'</span>
                                            </div>
                                        </div>
                                        <div class="row my-2 align-items-center bgc-primary-l3 p-2">
                                            <div class="col-7 text-right">
                                                Balance
                                            </div>
                                            <div class="col-5">
                                                <span class="text-150 text-success-d3 opacity-2"> RM '.$row["remainingAmount"].'</span>
                                            </div>
                                        </div>';
                                        if($flag == true)
                                        {
                                            echo '<div class="row my-2 align-items-center bgc-primary-l3 p-2">
                                                <div class="col-7 text-right">
                                                    Refunded Amount
                                                </div>
                                                <div class="col-5">
                                                    <span class="text-150 text-success-d3 opacity-2"> RM '.$refundAmount.'</span>
                                                </div>
                                            </div>';
                                        }
                                    echo '</div>
                                </div>';
                            }
                            ?>
                        </div>

                        

                        <hr />

                        <div>
                            <span class="text-secondary-d1 text-105">Thank you for your business</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="page-tools" style="text-align:center;">
            <div class="action-buttons">
                <button class="btn bg-white btn-light mx-1px text-95" onclick="saveDiv('printPage','Title')" data-title="PDF">
                    <i class="mr-1 fa fa-file-pdf-o text-danger-m1 text-120 w-2"></i>
                    Export
                </button>
            </div>
        </div>         
<?php 
}
?>

<style type="text/css">
body{
    margin-top:20px;
    color: #484b51;
}
.text-secondary-d1 {
    color: #728299!important;
}
.page-header {
    margin: 0 0 1rem;
    padding-bottom: 1rem;
    padding-top: .5rem;
    border-bottom: 1px dotted #e2e2e2;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-pack: justify;
    justify-content: space-between;
    -ms-flex-align: center;
    align-items: center;
}
.page-title {
    padding: 0;
    margin: 0;
    font-size: 1.75rem;
    font-weight: 300;
}
.brc-default-l1 {
    border-color: #dce9f0!important;
}

.ml-n1, .mx-n1 {
    margin-left: -.25rem!important;
}
.mr-n1, .mx-n1 {
    margin-right: -.25rem!important;
}
.mb-4, .my-4 {
    margin-bottom: 1.5rem!important;
}

hr {
    margin-top: 1rem;
    margin-bottom: 1rem;
    border: 0;
    border-top: 1px solid rgba(0,0,0,.1);
}

.text-grey-m2 {
    color: #888a8d!important;
}

.text-success-m2 {
    color: #86bd68!important;
}

.font-bolder, .text-600 {
    font-weight: 600!important;
}

.text-110 {
    font-size: 110%!important;
}
.text-blue {
    color: #478fcc!important;
}
.pb-25, .py-25 {
    padding-bottom: .75rem!important;
}

.pt-25, .py-25 {
    padding-top: .75rem!important;
}
.bgc-default-tp1 {
    background-color: rgba(121,169,197,.92)!important;
}
.bgc-default-l4, .bgc-h-default-l4:hover {
    background-color: #f3f8fa!important;
}
.page-header .page-tools {
    -ms-flex-item-align: end;
    align-self: flex-end;
}

.btn-light {
    color: #757984;
    background-color: #f5f6f9;
    border-color: #dddfe4;
}
.w-2 {
    width: 1rem;
}

.text-120 {
    font-size: 120%!important;
}
.text-primary-m1 {
    color: #4087d4!important;
}

.text-danger-m1 {
    color: #dd4949!important;
}
.text-blue-m2 {
    color: #68a3d5!important;
}
.text-150 {
    font-size: 150%!important;
}
.text-60 {
    font-size: 60%!important;
}
.text-grey-m1 {
    color: #7b7d81!important;
}
.align-bottom {
    vertical-align: bottom!important;
}
</style>

<script>
        function saveDiv(divId, title)
        {
            var pdf_content = document.getElementById(divId);
            var options = {
                margin:       0.5,
                filename:     'invoice.pdf',
                image:        { type: 'jpeg', quality: 1 },
                html2canvas:  { scale: 2 },
                jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
            };
            html2pdf(pdf_content, options);
        }
    </script>
</body>
</html>