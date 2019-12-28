<!DOCTYPE html>
<html lang="en">
<head>
    <title>Create Invoice</title>
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


    <div class="container">
        <div class="row">

            <div class="col-md-12 pb-2">

            <?php



                if(isset($_GET['id'])){

                    $type = $_GET['type'];
                    $client_id = $_GET['id'];



                    if ($type == 'CreateInvoice'){

                        $skey = $_GET['skey'];

                        $sql_dealers = "SELECT * FROM dealers WHERE `skey` = '$skey' AND `id` = '$client_id'";
                        $Query_dealers = mysqli_query($con, $sql_dealers);

                        if(mysqli_num_rows($Query_dealers)== 1){

                            $dealers = mysqli_fetch_assoc($Query_dealers);

                            $id = $dealers['id'];
                            $clientName = $dealers['d_name'];
                            $company_name = $dealers['company'];
                            $address = $dealers['address'];
                            $email = $dealers['email'];
                            $phone = $dealers['phone'];

                            echo"
                            
                            <form class='  border-light' action='printInvoice.php?type=PrintInvoice&uid=$id' method='post'>
                                    
                                    
                                    <div class='col invoice-to mb-2'>
                                    <div class='text-gray-light'>INVOICE TO:</div>
                                    <h2 class='to ' >$clientName</h2>
                                    <div class='address' >$company_name</div>
                                    <div class='address' >$address</div>
                                    <div class='email' ><a href='mailto:$email'>$email</a></div>
                                    <div class='phone' >$phone</a></div>
                                        
                                        <div class='float-right mb-3 ml-3'>Invoice No.:<td><input type='text' placeholder='Enter invoice no.' name='invoice_no' class='form-control text-center border border-primary rounded' required> </td></div>
                                        
                                        <div class='float-right mb-3 ml-3'>Bill No.:<td><input type='text' placeholder='Enter Bill no.' name='bill_no' class='form-control text-center border border-primary rounded' required> </td></div>
                                        
                                        <div class='float-right mb-3'>Bill Paying Now:<td><input type='text' value='0' placeholder='Pay now' name='payNow' class='form-control text-center border border-primary rounded' required> </td></div>
                                                                                
                                    </div>
                                    
                                    
                                    <table class='table table-striped'>
                                        <thead class='table-primary'>
                                            <tr>
                                            
                                                <th scope='col '>No.</th>
                                                <th scope='col '>Product Name</th>
                                                <th class='text-center' scope='col'>Price</th>
                                                <th class='text-center' scope='col'>Quantity</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                            ";

                            $sql_products = "SELECT * FROM products";
                            $Query_products = mysqli_query($con, $sql_products);

                            if (mysqli_num_rows($Query_products)>0){
                                while ($products = mysqli_fetch_assoc($Query_products)) {
                                    $products_id = $products['id'];
                                    $p_name = $products['p_name'];
                                    $price = $products['unit_price'];

                                    echo "
                                    
                                
                                            <tr>
                                                <td><input type='text' value='$products_id' name='products_id[]' class='form-control' readonly></td>
                                                <td><input type='text' value='$p_name'class='form-control' readonly></td>
                                                
                                                <td><input type='text' value='$price' placeholder='price *' name='price[]' class='form-control text-center' required> </td>										
                                                
                                                <td><input type='text' name='quantity[]' class='form-control text-center' placeholder='Quantity *' required></td>
                                            </tr>
                                    
                                            ";
                                }
                            }
                            echo"
                            <input type='hidden' name='cid' value='$id'>
                                
                                        </tbody>
                                    </table>
                                        <input class='btn btn-info my-4 btn-block' name='CreateInvoice' type='submit' value='Print Invoice'>
                                    </form>
                            ";
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
	