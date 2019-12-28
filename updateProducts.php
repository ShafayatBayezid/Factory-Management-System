<!DOCTYPE html>
<html>
<head>
    <title>Update Products Info</title>
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
<p class="h4 my-3 text-center">Update Products Info</p><hr>


<div class="container">
    <div class="row">

        <div class=" col-md-12 ">


            <form class="  border-light" action="manageProducts.php" method="post">

                <table class='table table-striped border'>
                    <thead class='table-dark'>
                    <tr>

                        <th scope='col '>No.</th>
                        <th scope='col '>Products Name</th>
                        <th class='text-center' scope='col'>Price</th>
                    </tr>
                    </thead>
                    <tbody>
                    <div class='form-row mb-4'>
                    <?php

                    $sql_products = "SELECT * FROM products";
                    $query_products = mysqli_query($con, $sql_products);

                    if (mysqli_num_rows($query_products) > 0) {
                        while ($product = mysqli_fetch_assoc($query_products)) {

                            $id = $product['id'];
                            $name = $product['p_name'];
                            $price = $product['unit_price'];

                            echo "
								<tr>
									<td><input type='text' value='$id' name='p_id[]' class='form-control ' readonly></td>
									<td><input type='text' value='$name' name='productsName[]' class='form-control ' placeholder='e.g. mango juice' required></td>
									<td><b><input type='text' value='$price' name='price[]' class='form-control text-center' placeholder='e.g. 100 ৳' required> </b></td>
									
                    
								</tr>
							";
                        }

                    }

                    ?>
                    </div>
                    </tbody>
                </table>

                <input class='col-md-12 btn btn-info my-4 btn-block' name='update_product_info' type='submit' value='Update'>

            </form>


        </div>

    </div>
</div>

<script src="js/script.js"></script>

</body>
</html>