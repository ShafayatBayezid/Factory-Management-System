<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Invoice</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>

<?php
include "connection/connect.php";
include "sideNav.php";
include "header/header.php";


?>


<div class="container">
    <div class="row">

        <div class="col-md-12 pb-2">

            <?php



            if(isset($_GET['client_id'])){

                $type = $_GET['type'];
                $client_id = $_GET['client_id'];



                if ($type == 'EditInvoice'){
                    $invoice_id = $_GET['invoice_id'];

                    $sql_invoice = "SELECT * FROM invoice WHERE `id` = '$invoice_id' AND `client_id` = '$client_id'";
                    $query_invoice = mysqli_query($con, $sql_invoice);

                    if (mysqli_num_rows($query_invoice) == 1){
                        $invoice = mysqli_fetch_assoc($query_invoice);

                        $invoice_no = $invoice['invoice_no'];
                        $bill_no = $invoice['bill_no'];

                    $sql_dealers = "SELECT * FROM dealers WHERE `id` = '$client_id'";
                    $Query_dealers = mysqli_query($con, $sql_dealers);

                    if(mysqli_num_rows($Query_dealers)== 1){

                        $dealers = mysqli_fetch_assoc($Query_dealers);

                        $id = $dealers['id'];
                        $clientName = $dealers['d_name'];
                        $company_name = $dealers['company'];
                        $address = $dealers['address'];
                        $email = $dealers['email'];
                        $phone = $dealers['phone'];

                    $sql_payment = "SELECT * FROM payment WHERE `invoice_id` = '$invoice_id' AND `client_id` = '$client_id'";
                    $query_payment = mysqli_query($con, $sql_payment);
                    if (mysqli_num_rows($query_payment)==1){
                        $payment = mysqli_fetch_assoc($query_payment);

                        $debit = $payment['debit'];


                        echo"
                            
                            <form class='  border-light' action='printInvoice.php?type=PrintInvoice&invoice_id=$invoice_id&client_id=$client_id' method='post'>
                                    
                                    
                                    <div class='col invoice-to mb-2'>
                                    <div class='text-gray-light'>INVOICE TO:</div>
                                    <h2 class='to ' >$clientName</h2>
                                    <div class='address' >$company_name</div>
                                    <div class='address' >$address</div>
                                    <div class='email' ><a href='mailto:$email'>$email</a></div>
                                    <div class='phone' >$phone</a></div>
                                                                           
                                    </div>
                                    
                                    <div class='float-right mb-3 ml-3'>Invoice No.:<td><input type='text' value='$invoice_no' placeholder='Enter invoice no.' name='invoice_no' class='form-control text-center border border-primary rounded' required> </td></div>
                                        
                                        <div class='float-right mb-3 ml-3'>Bill No.:<td><input type='text' value='$bill_no' placeholder='Enter Bill no.' name='bill_no' class='form-control text-center border border-primary rounded' required> </td></div>
                                        
                                        <div class='float-right mb-3'>Bill Paying Now:<td><input type='text' value='$debit' placeholder='Pay now' name='payNow' class='form-control text-center border border-primary rounded' required> </td></div>
                                            
                                    
                                        <table class='table table-striped'>
                                        <thead class='table-primary'>
                                            <tr>
                                            
                                                <th scope='col '>No.</th>
                                                <th scope='col '>Product Name</th>
                                                <th class='text-center' scope='col'>Price</th>
                                                <th class='text-center' scope='col'>Quantity</th>
                                                
                                            </tr>
                                        </thead>
                                        ";
                            $sql_invoice_details = "SELECT * FROM invoice_details WHERE `invoice_id` = '$invoice_id'";
                            $query_invoice_details = mysqli_query($con, $sql_invoice_details);
                            if (mysqli_num_rows($query_invoice_details)>0){
                                while ($invoice_details = mysqli_fetch_assoc($query_invoice_details)){

                                    $products_id = $invoice_details['products_id'];
                                    $price = $invoice_details['unit_price'];
                                    $quantity = $invoice_details['quantity'];

                                    $sql_products = "SELECT * FROM products WHERE `id` = '$products_id'";
                                    $query_products = mysqli_query($con, $sql_products);
                                    if (mysqli_num_rows($query_products)>0){
                                        while ($products = mysqli_fetch_assoc($query_products)){

                                            $p_name = $products['p_name'];
                                            echo"
                                        
                                        <tbody>
                                            <tr>
                                                <td><input type='text' value='$products_id' name='products_id[]' class='form-control' readonly></td>
                                                <td><input type='text' value='$p_name'class='form-control' readonly></td>
                                                
                                                <td><input type='text' value='$price' placeholder='price *' name='price[]' class='form-control text-center' required> </td>										
                                                
                                                <td><input type='text' value='$quantity' name='quantity[]' class='form-control text-center' placeholder='Quantity *' required></td>
                                            </tr>
                                    </tbody>
                                            ";

                                        }
                                    }
                                }
                            }


                        echo"
                            <input type='hidden' name='client_id' value='$client_id'>
                            <input type='hidden' name='invoice_id' value='$invoice_id'>
                                
                                        
                                    </table>
                                        <input class='btn btn-info my-4 btn-block' name='UpdateInvoice' type='submit' value='Update and Print Invoice'>
                                    </form>
                            ";
                    }}
                }

                }
            }

            ?>

        </div>
    </div>
</div>

<script src="js/script.js"></script>
</body>
</html>
