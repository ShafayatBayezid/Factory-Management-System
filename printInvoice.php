<!DOCTYPE html>
<html lang="en">
<head>
    <title>Print Invoice</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <style>
        @page {
            size: auto;
            margin-top: 0mm;
            margin-bottom: 0mm;
            margin-left: 10mm;
            margin-right: 10mm;
        }
    </style>

</head>
<body>


<?php

include "connection/connect.php";
include "sideNav.php";
include "header.php";

if (isset($_POST['CreateInvoice'])) {

    $client_id = mysqli_real_escape_string($con, $_POST['cid']);
    $invoice_no = mysqli_real_escape_string($con, $_POST['invoice_no']);
    $bill_no = mysqli_real_escape_string($con, $_POST['bill_no']);
    $debit = mysqli_real_escape_string($con, $_POST['payNow']);

    date_default_timezone_set('Asia/Dhaka');
    $today = date('d-m-Y');
    $record_date = date('Y m d');


    $sql_invoice = "INSERT INTO invoice (client_id, invoice_no, bill_no, invoice_date)
				        VALUES('$client_id', '$invoice_no', '$bill_no', '$today')";
    $query_invoice = mysqli_query($con, $sql_invoice);
    $invoice_id = $con->insert_id;


    for ($i = 0; $i < sizeof($_POST['products_id']); $i++) {

        $products_id = mysqli_real_escape_string($con, $_POST['products_id'][$i]);
        $price = mysqli_real_escape_string($con, $_POST['price'][$i]);
        $quantity = mysqli_real_escape_string($con, $_POST['quantity'][$i]);

        $total = $price * $quantity;

        $sql_invoice_details = "INSERT INTO invoice_details (invoice_id, products_id, unit_price, quantity, total)
				        VALUES('$invoice_id', '$products_id', '$price', '$quantity', '$total')";
        $query_invoice_details = mysqli_query($con, $sql_invoice_details);

        $sql_sell_record = "INSERT INTO daily_records (products_id, sell, production, record_date)
				        VALUES('$products_id', '$quantity', '0', '$record_date')";
        $query_sell_record = mysqli_query($con, $sql_sell_record);


    }

    $credit = 0;
    $sql_total = "SELECT * FROM invoice_details WHERE  `invoice_id` = '$invoice_id'";
    $query_total = mysqli_query($con, $sql_total);
    if (mysqli_num_rows($query_total) > 0) {
        while ($total = mysqli_fetch_assoc($query_total)) {

            $credit = $credit + (int)$total['total'];
        }

    }

    $sql_payment_insert = "INSERT INTO payment (client_id, invoice_id, debit, credit, payment_date)
						VALUE ('$client_id', '$invoice_id', '$debit', '$credit', '$today')";
    $Query_payment_insert = mysqli_query($con, $sql_payment_insert);


}


if (isset($_POST['UpdateInvoice'])) {

    $invoice_id = mysqli_real_escape_string($con, $_POST['invoice_id']);
    $client_id = mysqli_real_escape_string($con, $_POST['client_id']);
    $invoice_no = mysqli_real_escape_string($con, $_POST['invoice_no']);
    $bill_no = mysqli_real_escape_string($con, $_POST['bill_no']);
    $debit = mysqli_real_escape_string($con, $_POST['payNow']);


    $update_invoice = "UPDATE invoice SET  invoice_no = '$invoice_no', bill_no = '$bill_no' WHERE id = '$invoice_id' AND client_id = '$client_id'";
    $query_invoice = mysqli_query($con, $update_invoice);


    for ($i = 0; $i < sizeof($_POST['products_id']); $i++) {

        $products_id = mysqli_real_escape_string($con, $_POST['products_id'][$i]);
        $price = mysqli_real_escape_string($con, $_POST['price'][$i]);
        $quantity = mysqli_real_escape_string($con, $_POST['quantity'][$i]);

        $total = $price * $quantity;

        $update_invoice_details = "UPDATE invoice_details SET unit_price = '$price', quantity = '$quantity', total = '$total' WHERE invoice_id = '$invoice_id' AND products_id = '$products_id'";
        $query_invoice_details = mysqli_query($con, $update_invoice_details);

        $update_sell_record = "UPDATE daily_records SET sell = '$quantity' WHERE products_id = '$products_id'";
        $query_sell_record = mysqli_query($con, $update_sell_record);


    }

    $credit = 0;
    $sql_total = "SELECT * FROM invoice_details WHERE  `invoice_id` = '$invoice_id'";
    $query_total = mysqli_query($con, $sql_total);
    if (mysqli_num_rows($query_total) > 0) {
        while ($total = mysqli_fetch_assoc($query_total)) {

            $credit = $credit + (int)$total['total'];
        }

    }

    $update_payment_insert = "UPDATE payment SET debit = '$debit', credit = '$credit' WHERE client_id = '$client_id' AND invoice_id = '$invoice_id'";
    $query_payment_insert = mysqli_query($con, $update_payment_insert);


}

?>

<div class="container">

    <div class="toolbar hidden-print">
        <div class="text-right">
            <button id="printInvoice"  class="btn btn-info"><i class="fa fa-print"></i>
                Print Invoice
            </button>
            <!--  <button class="btn btn-info"><i class="fa fa-file-pdf-o"></i> Export as PDF</button>  -->
        </div>
        <hr>
    </div>

    <div id="invoice" class="invoiceArea">


        <div class="invoice overflow-auto">
            <div style="min-width: 600px">
                <header>
                    <div class="row">
                        <div class="col">
                            <a target="_blank" href="https://www.androlation.com">
                                <img src="images/logo.png" data-holder-rendered="true"/>
                            </a>
                        </div>
                        <div class="col company-details">
                            <h2 class="name">

                                Shafayat Hossain

                            </h2>
                            <div>Kaderabad Housing, Mohammadpur, Dhaka</div>
                            <div>(123) 456-789</div>
                            <div>www.androlation.com</div>
                            <div>contact@androlation.com</div>
                            <div>+8801515665070</div>
                        </div>
                    </div>
                </header>
                <main>

                    <?php


                    if (isset($_GET['uid'])) {

                        $type = $_GET['type'];
                        if ($type == "PrintInvoice") {
                            $client_id = $_GET['uid'];

                            $debit_amount = 0;
                            $credit_amount = 0;

                            $sql_dealer = "SELECT * FROM dealers WHERE  `id` = '$client_id'";
                            $query_dealer = mysqli_query($con, $sql_dealer);
                            if (mysqli_num_rows($query_dealer) > 0) {

                                $dealers = mysqli_fetch_assoc($query_dealer);

                                $client_id = $dealers['id'];
                                $name = $dealers['d_name'];
                                $company = $dealers['company'];
                                $address = $dealers['address'];
                                $email = $dealers['email'];
                                $phone = $dealers['phone'];

                                $sql_invoice1 = "SELECT * FROM invoice WHERE  `client_id` = '$client_id' ORDER BY id DESC ";
                                $query_invoice1 = mysqli_query($con, $sql_invoice1);
                                if (mysqli_num_rows($query_invoice1) > 0) {
                                    $invoice1 = mysqli_fetch_assoc($query_invoice1);

                                    $invoice_id = $invoice1['id'];
                                    $invoice_no = $invoice1['invoice_no'];
                                    $bill_no = $invoice1['bill_no'];
                                    $date = date("d M Y", strtotime($invoice1['invoice_date']));


                                    echo "
                                    <div class='row contacts'>
                                        <div class='col invoice-to'>
                                            <div class='text-gray-light'>INVOICE TO:</div>
                                            <h2 class='to'>$name</h2>
                                            <div class='address'>$company</div>
                                            <div class='address'>$address</div>
                                            <div class='email'><a href='mailto:$email'>$email</a></div>
                                            <div class='phone'>$phone</a></div>
                                        </div>
                                        <div class='col invoice-details'>
                                            <h3 class='invoice-id'>DATE: $date</h3>
                                            <h3 class='invoice-id'>INVOICE NO: $invoice_no</h3>
                                            <h3 class='invoice-id'>BILL NO: $bill_no</h3>
                                            
                                        </div>
                                    </div>
                
                                    <table cellspacing='0' cellpadding='0'>
                
                                        <thead>
                                        <tr>
                                        
                                            <th class='text-center border'>No.</th>
                                            <th class='text-left border'>Description</th>
                                            <th class='text-center border'>Price</th>
                                            <th class='text-center border'>Quantity</th>
                                            <th class='text-center border'>Total</th>
                                        </tr>
                                        </thead>
                                    ";

                                }
                            }

                            $sql_invoice2 = "SELECT * FROM invoice_details WHERE  `invoice_id` = '$invoice_id' ";
                            $query_invoice2 = mysqli_query($con, $sql_invoice2);
                            if (mysqli_num_rows($query_invoice2) > 0) {
                                while ($invoice2 = mysqli_fetch_assoc($query_invoice2)) {

                                    $products_id = $invoice2['products_id'];
                                    $price = $invoice2['unit_price'];
                                    $quantity = $invoice2['quantity'];
                                    $total = $invoice2['total'];

                                    $check_product = "SELECT * FROM products WHERE `id` = '$products_id'";
                                    $query_prod = mysqli_query($con, $check_product);
                                    if (mysqli_num_rows($query_prod) > 0) {
                                        while ($prod = mysqli_fetch_assoc($query_prod)) {
                                            $p_name = $prod['p_name'];
                                            $p_id = $prod['id'];

                                            echo "<tbody>
                                        <tr>
                                        
                                            <td class='unit text-center border'><h3>$p_id</h3></td>
                                            <td class='text-left border'><h3>$p_name</h3></td>
                                            <td class='unit text-center border'>$price ৳</td>
                                            <td class='qty text-center border'>$quantity</td>
                                            <td class='unit text-center border'>$total<b> ৳ </b></td>
                                        </tr>
                
                                        </tbody>";
                                        }
                                    }

                                }
                            }
                            $sql_payment_check = "SELECT * FROM payment WHERE  `client_id` = '$client_id' ";
                            $query_payment_check = mysqli_query($con, $sql_payment_check);
                            if (mysqli_num_rows($query_payment_check) > 0) {
                                while ($payCheck = mysqli_fetch_assoc($query_payment_check)) {
                                    $debit_amount = $debit_amount + (int)$payCheck['debit'];
                                    $credit_amount = $credit_amount + (int)$payCheck['credit'];

                                }

                                $sql_credit = "SELECT * FROM payment WHERE  `invoice_id` = '$invoice_id' ";
                                $query_credit = mysqli_query($con, $sql_credit);
                                if (mysqli_num_rows($query_credit) > 0) {
                                    $credit = mysqli_fetch_assoc($query_credit);
                                    $subTotal = $credit['credit'];

                                    $sum = $debit_amount - $credit_amount+$subTotal;
                                    if ($sum < 0) {
                                        $due = $sum;

                                        $grandTotal = $subTotal - $due;

                                        echo "<tfoot>
                                    <tr>
                                        <td colspan='2'></td>
                                        <td colspan='2'>Subtotal</td>
                                        <td class='text-center'>$subTotal<b> ৳ </b></td>
                                    </tr>
                                    <tr>
                                        <td colspan='2'></td>
                                        <td colspan='2'>Previous Due</td>
                                        <td class='text-center'><b>$due ৳ </b></td>
                                    </tr>
                                    <tr>
                                        <td colspan='2'></td>
                                        <td colspan='2'>Grand Total</td>
                                        <td class='text-center'>$grandTotal<b> ৳ </b></td>
                                    </tr>
                                    </tfoot>
            
                                </table>";

                                    } else {
                                        echo "<tfoot>
                                    <tr>
                                        <td colspan='2'></td>
                                        <td colspan='2'>Subtotal</td>
                                        <td class='text-center'>$subTotal<b> ৳ </b></td>
                                    </tr>
                                    <tr>
                                        <td colspan='2'></td>
                                        <td colspan='2'>Previous Due</td>
                                        <td class='text-center'>0 ৳ </td>
                                    </tr>
                                    <tr>
                                        <td colspan='2'></td>
                                        <td colspan='2'>Grand Total</td>
                                        <td class='text-center'>$subTotal<b> ৳ </b></td>
                                    </tr>
                                    </tfoot>
            
                                </table>";
                                    }
                                }


                            }
                        }
                    }elseif (isset($_GET['invoice_id'])) {

                        $invoice_id = $_GET['invoice_id'];
                        $type = $_GET['type'];

                        if ($type == "PrintInvoice") {
                            $client_id = $_GET['client_id'];

                            $debit_amount = 0;
                            $credit_amount = 0;

                            $sql_invoice = "SELECT * FROM invoice WHERE `id` = '$invoice_id' AND `client_id` = '$client_id'";
                            $query_invoice = mysqli_query($con, $sql_invoice);

                            if (mysqli_num_rows($query_invoice) == 1){
                                $invoice = mysqli_fetch_assoc($query_invoice);

                                $invoice_no = $invoice['invoice_no'];
                                $bill_no = $invoice['bill_no'];
                                $date = date("d M Y", strtotime($invoice['invoice_date']));

                                $sql_dealers = "SELECT * FROM dealers WHERE `id` = '$client_id'";
                                $Query_dealers = mysqli_query($con, $sql_dealers);

                                if(mysqli_num_rows($Query_dealers)== 1){

                                    $dealers = mysqli_fetch_assoc($Query_dealers);

                                    $id = $dealers['id'];
                                    $clientName = $dealers['d_name'];
                                    $company = $dealers['company'];
                                    $address = $dealers['address'];
                                    $email = $dealers['email'];
                                    $phone = $dealers['phone'];


                                    echo "
                                    <div class='row contacts'>
                                        <div class='col invoice-to'>
                                            <div class='text-gray-light'>INVOICE TO:</div>
                                            <h2 class='to'>$clientName</h2>
                                            <div class='address'>$company</div>
                                            <div class='address'>$address</div>
                                            <div class='email'><a href='mailto:$email'>$email</a></div>
                                            <div class='phone'>$phone</a></div>
                                        </div>
                                        <div class='col invoice-details'>
                                            <h3 class='invoice-id'>DATE: $date</h3>
                                            <h3 class='invoice-id'>INVOICE NO: $invoice_no</h3>
                                            <h3 class='invoice-id'>BILL NO: $bill_no</h3>
                                            
                                        </div>
                                    </div>
                
                                    <table cellspacing='0' cellpadding='0'>
                
                                        <thead>
                                        <tr>
                                        
                                            <th class='text-center border'>No.</th>
                                            <th class='text-left border'>Description</th>
                                            <th class='text-center border'>Price</th>
                                            <th class='text-center border'>Quantity</th>
                                            <th class='text-center border'>Total</th>
                                        </tr>
                                        </thead>
                                    ";

                                }
                            }

                            $sql_invoice2 = "SELECT * FROM invoice_details WHERE  `invoice_id` = '$invoice_id' ";
                            $query_invoice2 = mysqli_query($con, $sql_invoice2);
                            if (mysqli_num_rows($query_invoice2) > 0) {
                                while ($invoice2 = mysqli_fetch_assoc($query_invoice2)) {

                                    $products_id = $invoice2['products_id'];
                                    $price = $invoice2['unit_price'];
                                    $quantity = $invoice2['quantity'];
                                    $total = $invoice2['total'];

                                    $check_product = "SELECT * FROM products WHERE `id` = '$products_id'";
                                    $query_prod = mysqli_query($con, $check_product);
                                    if (mysqli_num_rows($query_prod) > 0) {
                                        while ($prod = mysqli_fetch_assoc($query_prod)) {
                                            $p_name = $prod['p_name'];
                                            $p_id = $prod['id'];

                                            echo "<tbody>
                                        <tr>
                                        
                                            <td class='unit text-center border'><h3>$p_id</h3></td>
                                            <td class='text-left border'><h3>$p_name</h3></td>
                                            <td class='unit text-center border'>$price ৳</td>
                                            <td class='qty text-center border'>$quantity</td>
                                            <td class='unit text-center border'>$total<b> ৳ </b></td>
                                        </tr>
                
                                        </tbody>";
                                        }
                                    }

                                }
                            }
                            $sql_payment_check = "SELECT * FROM payment WHERE  `client_id` = '$client_id' ";
                            $query_payment_check = mysqli_query($con, $sql_payment_check);
                            if (mysqli_num_rows($query_payment_check) > 0) {
                                while ($payCheck = mysqli_fetch_assoc($query_payment_check)) {
                                    $debit_amount = $debit_amount + (int)$payCheck['debit'];
                                    $credit_amount = $credit_amount + (int)$payCheck['credit'];

                                }

                                $sql_credit = "SELECT * FROM payment WHERE  `invoice_id` = '$invoice_id' ";
                                $query_credit = mysqli_query($con, $sql_credit);
                                if (mysqli_num_rows($query_credit) > 0) {
                                    $credit = mysqli_fetch_assoc($query_credit);
                                    $subTotal = $credit['credit'];

                                    $sum = $debit_amount - $credit_amount+$subTotal;
                                    if ($sum < 0) {
                                        $due = $sum;

                                        $grandTotal = $subTotal - $due;

                                        echo "<tfoot>
                                    <tr>
                                        <td colspan='2'></td>
                                        <td colspan='2'>Subtotal</td>
                                        <td class='text-center'>$subTotal<b> ৳ </b></td>
                                    </tr>
                                    <tr>
                                        <td colspan='2'></td>
                                        <td colspan='2'>Previous Due</td>
                                        <td class='text-center'><b>$due ৳ </b></td>
                                    </tr>
                                    <tr>
                                        <td colspan='2'></td>
                                        <td colspan='2'>Grand Total</td>
                                        <td class='text-center'>$grandTotal<b> ৳ </b></td>
                                    </tr>
                                    </tfoot>
            
                                </table>";

                                    } else {
                                        echo "<tfoot>
                                    <tr>
                                        <td colspan='2'></td>
                                        <td colspan='2'>Subtotal</td>
                                        <td class='text-center'>$subTotal<b> ৳ </b></td>
                                    </tr>
                                    <tr>
                                        <td colspan='2'></td>
                                        <td colspan='2'>Previous Due</td>
                                        <td class='text-center'>0 ৳ </td>
                                    </tr>
                                    <tr>
                                        <td colspan='2'></td>
                                        <td colspan='2'>Grand Total</td>
                                        <td class='text-center'>$subTotal<b> ৳ </b></td>
                                    </tr>
                                    </tfoot>
            
                                </table>";
                                    }
                                }


                            }
                        }
                    }

                    ?>


                    <div class="notices">
                        <div class="notice"><h2>Thank you!</h2></div>
                    </div>
                </main>
                <footer>
                    Invoice was created on a computer and is valid without the signature and seal.
                </footer>
            </div>

            <div></div>
        </div>
    </div>

</div>


<script src="js/script.js"></script>
<script src="js/jquery.js"></script>
<script src="js/jquery.PrintArea.js"></script>
<script>
    $(document).ready(function () {

        $("#printInvoice").click(function () {
            var mode = 'iframe';
            var close = mode == "popup";
            var options = {
                mode: mode,
                popClose: close
            };
            $("div.invoiceArea").printArea(options);
            
        });

    });
</script>
</body>
</html>
