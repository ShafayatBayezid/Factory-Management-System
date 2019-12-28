<!DOCTYPE html>
<html>
<head>
	<title>Add Products</title>
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

		echo "<p class='h4 my-3 text-center'>Add New Products</p><hr>";
	
	?>



	
<div class="container">
    <div class="row">
  
		<div class=" col-md-12 ">

            <!-- Default form register -->
            <form class="  border-light" action="manageProducts.php" method="post">

               
                <div class="form-row mb-4">
                    <div class="col">
                        <p>Products Name:*</p>
                        <input type="text" name="productsName" class="form-control " placeholder="e.g. mango juice" required>
                    </div>
                    <div class="col">
                        <p>Price:*</p>
                        <input type="text" name="price" class="form-control" placeholder="e.g. 100 ৳" required>
                    </div>
                </div>
				
				
                <input class="col-md-12 btn btn-info my-4 btn-block" name="addProduct" type="submit" value="Submit">

                
            </form>
                            

        </div>

	</div>
</div>

    <script src="js/script.js"></script>

</body>
</html>