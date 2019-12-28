<!DOCTYPE html>
<html>
<head>
    <title>Manage Dealers</title>
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

<p class="h4 my-3 text-center">Manage Dealers</p>
<hr>

<div class="container">


    <a href='addDealers.php' class="mb-3 float-right">
        <button type='button' class='btn btn-success'>Add Dealers</button>
    </a>

    <table class='table table-striped'>
        <thead class='table-primary'>
        <tr>

            <th scope='col '>Dealers Info</th>
            <th class='text-center' scope='col'>Total Debit</th>
            <th class='text-center' scope='col'>Total Credit</th>
            <th class='text-center' scope='col'>Advance Paid</th>
            <th class='text-center' scope='col'>Total Due</th>
            <th class='text-center' scope='col'>Bill</th>

        </tr>
        </thead>
        <tbody>

        <?php


        $sql_dealers = "SELECT * FROM dealers";
        $query_dealers = mysqli_query($con, $sql_dealers);

        if (mysqli_num_rows($query_dealers) > 0) {

            while ($dealers = mysqli_fetch_assoc($query_dealers)) {

                $id = $dealers['id'];
                $skey = $dealers['skey'];
                $dealers_name = $dealers['d_name'];
                $company_name = $dealers['company'];
                $address = $dealers['address'];
                $email = $dealers['email'];
                $phone = $dealers['phone'];
                $email = $dealers['email'];
                $total_debit = 0;
                $total_credit = 0;

                $sql_payment = "SELECT * FROM payment WHERE `client_id` = '$id'";
                $query_payment = mysqli_query($con, $sql_payment);

                if (mysqli_num_rows($query_payment) > 0) {

                    while ($payment = mysqli_fetch_assoc($query_payment)) {


                        $total_debit = $total_debit + (int)$payment['debit'];

                        $total_credit = $total_credit + (int)$payment['credit'];

                    }
                    $sum = $total_debit - $total_credit;
                    if ($sum >= 0) {
                        $advance = $sum;
                        $total_due = 0;
                        echo "<tr>
										
										<td class=''>Name: <b>$dealers_name</b>
											<br> Company: $company_name 
											<br> Address: $address
											<br> Email: $email
											<br> Phone: $phone
											
										</td>
											
										<td class='text-center'><b>$total_debit ৳ </b></td>
										<td class='text-center'><b>$total_credit ৳ </b></td>
										<td class='text-center'><b>$advance ৳ </b></td>
										<td class='text-center'><b>$total_due ৳ </b></td>
										<td class='text-center'>
	                                    <a  class='btn btn-success ' href='payBill.php?id=$id&type=AddPayments&skey=$skey'>Pay Bill</a>
                                        </td>
									
										</tr>
										";

                    } else {
                        $advance = 0;
                        $total_due = $sum;
                        echo "<tr>
										
										<td class=''>Name: <b>$dealers_name</b>
											<br> Company: $company_name 
											<br> Address: $address
											<br> Email: $email
											<br> Phone: $phone
											
										</td>
											
										<td class='text-center'><b>$total_debit ৳ </b></td>
										<td class='text-center'><b>$total_credit ৳ </b></td>
										<td class='text-center'><b>$advance ৳ </b></td>
										<td class='text-center'><b>$total_due ৳ </b></td>
										<td class='text-center'>
	                                    <a  class='btn btn-success ' href='payBill.php?id=$id&type=AddPayments&skey=$skey'>Pay Bill</a>
                                        </td>
									
										</tr>
										";

                    }
                } else {
                    echo "<tr>
										
										<td class=''>Name: <b>$dealers_name</b>
											<br> Company: $company_name 
											<br> Address: $address
											<br> Email: $email
											<br> Phone: $phone
											
										</td>
											
										<td colspan='4' class='text-center' style=' color:#d50000; font-size: 25px;'><b>No Transaction has done Yet! </b></td>
										<td><a  class='btn btn-success text-center ml-5' href='../invoices/payBill.php?id=$id&type=AddPayments&skey=$skey'>Pay Bill</a></td>
										</tr>
										";
                }
            }
        }


        ?>

        </tr>


        </tbody>
    </table>


</div>

<script src="js/script.js"></script>

</body>
</html>


					
						