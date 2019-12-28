<!DOCTYPE html>
<html>
<head>
	<title>Add Dealers</title>
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

echo "
<p class='h4 text-center my-3 '>Add New Dealer</p><hr>";

if(isset($_POST['submit'])){

    // Escape user inputs for security
    $clientName = mysqli_real_escape_string($con, $_POST['name']);
    $compName = mysqli_real_escape_string($con, $_POST['company']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);


    $skey= uniqid();
    $payment_skey= uniqid();
    $invoice_id = '0';
    $total_payable = '0';
    $total_paid = '0';







    $ClientCheck = "SELECT * FROM dealers WHERE `d_name` = '$clientName' AND `company` = '$compName'";

    $query = mysqli_query($con, $ClientCheck);

    if(mysqli_num_rows($query)>0){

        echo "<div class='container'>
				<div class='row'>
				<h4 style='background: #B71C1C; color:#ffffff' class='col-md-12 py-3 btn btn-block mb-4'>This Dealer have Already Added!!!</h4></div></div>";
    }else{



        $sql_dealer = "INSERT INTO dealers (skey, d_name, company, address, email, phone) 
				
						VALUES ('$skey', '$clientName', '$compName', '$address', '$email', '$phone')";

        mysqli_query($con, $sql_dealer);

        echo "<div class='container'>
				<div class='row'>
				<div style='background: #0091EA; color:#ffffff' class='col-md-12 py-3 btn  btn-block mb-4'> Dealer Added Successfully.</div></div></div>";



    }

}



?>

<div class="container">	

	<form class="text-center  border-light  " action="addDealers.php" method="post">


		
		
		
       
        <div class="form-row mb-4">
            <div class="col">
                <!-- Institution's name -->
                <input type="text" value="" name="name" class="form-control" placeholder="Dealers Name *" required>
            </div>
            <div class="col">
                <!-- Class -->
                <input type="text" value="" name="company" class="form-control" placeholder="Company Name *" required>
            </div>
        </div>
		
		<input type="text" value="" name="address" class="form-control mb-4" placeholder="Address *" required>

		
		<div class="form-row mb-4">
            <div class="col">
                <!-- Institution's name -->
                <input type="email" value="" name="email" class="form-control" placeholder="Email " >
            </div>
            <div class="col">
                <!-- Class -->
                <input type="text" value="" name="phone" class="form-control" placeholder="Contact Number *" required>
            </div>
        </div>
		
		
		
		
        <input class="btn btn-info my-4 btn-block" name="submit" type="submit" value="Submit">

        
    </form>

</div>
<script src="js/script.js"></script>
</body>
</html>