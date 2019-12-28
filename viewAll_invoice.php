<html lang="en">
<head>
    <title>View All Invoices</title>
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
include "header.php";


?>
<p class="h4 my-3 pb-2  text-center ">View All Invoices</p>
<hr>


<div class="container">
    <div class="row">

        <div class="col-md-12 pb-2 ">
            <?php


            if (isset($_GET['id'])) {

                $type = $_GET['type'];
                $client_id = $_GET['id'];


                if ($type == 'ViewInvoice') {

                    $skey = $_GET['skey'];


                    $sql_clients = "SELECT * FROM dealers WHERE `skey` = '$skey' AND `id` = '$client_id'";
                    $Query_clients = mysqli_query($con, $sql_clients);

                    if (mysqli_num_rows($Query_clients) > 0) {

                        $clients = mysqli_fetch_assoc($Query_clients);

                        $client_id = $clients['id'];
                        $clientName = $clients['d_name'];
                        $company_name = $clients['company'];
                        $address = $clients['address'];
                        $email = $clients['email'];
                        $phone = $clients['phone'];

                        echo "
                        <div class='row contacts py-2'>
                            <div class='col invoice-to'>
                            <div class='text-gray-light'>INVOICES OF:</div>
                            <h2 class='to'>$clientName</h2>
                            <div class='address'>$company_name</div>
                            <div class='address'>$address</div>
                            <div class='email'><a href='mailto:$email'>$email</a></div>
                            <div class='phone'>$phone</div>
                            </div>
                                        
                        </div>";


                        $sql_invoice = "SELECT * FROM invoice WHERE `client_id` = '$client_id' ORDER BY id DESC";
                        $Query_invoice = mysqli_query($con, $sql_invoice);

                        if (mysqli_num_rows($Query_invoice) > 0) {

                            while ($invoice = mysqli_fetch_assoc($Query_invoice)) {
                                $invoice_id = $invoice['id'];
                                $invoice_no = $invoice['invoice_no'];
                                $bill_no = $invoice['bill_no'];
                                $invoice_date = $invoice['invoice_date'];

                                echo "
										<div class='col-md-12 mb-5 card'>
										<div class='col-md-12 p3-5 card-body'>
                                            
                                            <div class='float-left btn p-2 border border-primary rounded mb-3'>Invoice No: $invoice_no</div>
                                            <div class='float-left ml-2 p-2 border border-primary rounded'>Bill No: $bill_no</div>
                                            
											<a class='p-2 border border-primary rounded text-center float-right' href='editInvoice.php?invoice_id=$invoice_id&type=EditInvoice&client_id=$client_id'>Edit Invoice </a>
                                            <div class='float-right mx-2 p-2 border border-primary rounded'>Date: $invoice_date</div>
                                            
                                            
                                            <table class='table card-body'>
                                                <thead class='table-primary'>
                                                    <tr>
                                                        <th scope='col '>No.</th>
                                                        <th scope='col '>Product Name</th>
                                                        <th class='text-center' scope='col'>Price</th>
                                                        <th class='text-center' scope='col'>Quantity</th>
                                                        <th class='text-center' scope='col'>Total</th>
    
                                                    </tr>
                                                </thead>
                                                
											<tbody>";

                                $subTotal =0;
                                $sql_invoice_details = "SELECT * FROM invoice_details WHERE `invoice_id` = '$invoice_id'";
                                $query_invoice_details = mysqli_query($con, $sql_invoice_details);
                                if (mysqli_num_rows($query_invoice_details)>0){
                                    while ($invoice_details = mysqli_fetch_assoc($query_invoice_details)){
                                        $p_id = $invoice_details['products_id'];
                                        $u_price = $invoice_details['unit_price'];
                                        $quantity = $invoice_details['quantity'];


                                        $total = $invoice_details['total'];
                                        $subTotal = $subTotal + (int)$invoice_details['total'];;

                                        $sql_prod_info = "SELECT * FROM products WHERE `id` = '$p_id'";
                                        $query_prod_info = mysqli_query($con, $sql_prod_info);
                                        if (mysqli_num_rows($query_prod_info)>0){
                                            while ($prod_info = mysqli_fetch_assoc($query_prod_info)){
                                                $p_name = $prod_info['p_name'];



                                                echo "

												<tr>
													<td >$p_id</td>
													<td >$p_name</td>
													<td class='text-center'>$u_price</td>
													<td class='text-center'>$quantity</td>
													<td class='text-center'>$total</td>
													
													
												</tr>
												
											";
                                            }
                                        }


                                    }
                                }
                                        echo "<tr style='background: #90CAF9; color:#ffffff' class='round'>
													<td colspan='3'></td>
													<td class='text-center' colspan='1' >Subtotal</td>
													<td class='text-center' >$subTotal<b> ৳ </b></td>
													
												</tr>
												
												<tbody>
												
</table>
										</div>
										</div>";


                            }


                        } else {
                            echo "<div class='container'>
									<div class='row'>
										 <div style='background: #B71C1C; color:#ffffff' class='col-md-12 py-5 btn btn-block mb-4'> 
										    <h3>No Invoices availabe</h3>
										 </div>
									</div>
								  </div>";

                        }
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
