<!DOCTYPE html>
<html lang="en">
<head>
    <title>Pay Bill</title>
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
    include"connection/connect.php";
    include "sideNav.php";
    include "header.php";

    date_default_timezone_set('Asia/Dhaka');
    $today = date('d-m-Y');
echo "<p class='h4 my-3 align-self-center text-center '>Pay Bill</p><hr>";
if(isset($_GET['id'])){
	$type = $_GET['type'];
	$client_id = $_GET['id'];
	
	

	if ($type == 'AddPayments'){
		
		$skey = $_GET['skey'];
		
		
		$sql_dealers = "SELECT * FROM dealers WHERE `skey` = '$skey' AND `id` = '$client_id'";
		$Query_dealers = mysqli_query($con, $sql_dealers);
		
		if(mysqli_num_rows($Query_dealers)>0){
						
			$clients = mysqli_fetch_assoc($Query_dealers);
			
			$clientName = $clients['d_name'];
			$company_name = $clients['company'];
			$address = $clients['address'];
			$email = $clients['email'];
			$phone = $clients['phone'];
			
			
		}else{
					echo "<div class='container'>
					<div class='row '>
						<div style='background: #B71C1C; color:#ffffff' class='col-md-12 py-3 btn  btn-block mb-4'>Invalid User information! Please check again.</div>
					</div>
				 </div>";
	}
	}
	
	if(isset($_POST['submit'])){
		$pay = mysqli_real_escape_string($con, $_POST['pay']);		
			$sql_payment = "INSERT INTO payment (client_id, invoice_id, debit, credit, payment_date)
							VALUE ('$client_id', '', '$pay', '', '$today')";
			$Query_payment = mysqli_query($con, $sql_payment);
			
			
			
			echo "<div class='container'>
					<div class='row '>
						<div style='background: #0091EA; color:#ffffff' class='col-md-12 py-3 btn  btn-block mb-4'> Payment Added Successfully.</div>
					</div>
				 </div>";
	}
}else{
		echo "<div class='container'>
					<div class='row '>
						<div style='background: #d50000; color:#ffffff' class='col-md-12 py-3 btn  btn-block mb-4'> You didn't select any Dealer. Please try again</div>
					</div>
				 </div>";
	}
		

?>





<div class="container">
		
		<div class=" col-md-12 ">
			<?php
				
					echo"<div class='col invoice-to mb-2'>
						<div class='text-gray-light'> TO:</div>
						<h2 class='to ' >$clientName</h2>
						<div class='address' >$company_name</div>
						<div class='address' >$address</div>
						<div class='email' ><a href='mailto:$email'>$email</a></div>
						<div class='phone' >$phone</a></div>
					</div>";
				
			?>	
            <form class="text-center  border-light  " action="" method="post">

                
				
				<table class='table table-striped'>
					
					<thead class='table-primary'>
						<tr>
						
							<th scope='col '>Method Name</th>
							<th class='text-center' scope='col'>Taka</th>
							
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>													
								<input type="text" value="Cheque/Cash Payments" name="" class="form-control" readonly>
							</td>		
							
							<td>										
								<input type="text" value="0" name="pay" class="form-control text-center"  required>								
							</td>	
						</tr>
						
						
					</tbody>
				</table>
				
					<input class="btn btn-info my-4 btn-block" name="submit" type="submit" value="Submit">

            </form>
        </div>

    <script src="js/script.js"></script>

</body>
</html>
