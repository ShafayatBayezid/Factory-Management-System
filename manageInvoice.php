<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Invoices</title>
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
    <p class="h4 my-3 pb-2 align-self-center text-center ">Manage Invoices</p><hr>

    <div class="container">


        <div class="row">
            <table class='table table-striped'>
                <thead class='table-primary'>
                <tr>


                </tr>
                </thead>
                <tbody>

                <?php

                $sql_client = "SELECT * FROM dealers";
                $query_client = mysqli_query($con, $sql_client);

                if (mysqli_num_rows($query_client) > 0) {

                    while ($clients = mysqli_fetch_assoc($query_client)) {

                        $id = $clients['id'];
                        $skey = $clients['skey'];
                        $clientName = $clients['d_name'];
                        $company_name = $clients['company'];
                        $address = $clients['address'];
                        $email = $clients['email'];
                        $phone = $clients['phone'];
                        $email = $clients['email'];


                        echo "<tr>
                                <td>Name: <b>$clientName</b>
									<br> Company: $company_name 
									<br> Address: $address
									<br> Email: $email
									<br> Phone: $phone
												
								</td>
											
								<td class='text-center'>
									<a class='btn btn-success' href='createInvoice.php?id=$id&type=CreateInvoice&skey=$skey'>Create Invoice</a>
								</td>											
											
								<td class='text-center'>
									<a class='btn btn-success' href='viewAll_invoice.php?id=$id&type=ViewInvoice&skey=$skey'>View Invoices</a>
								</td>
								<td class='text-center'>
							    	<a class='btn btn-success' href='payBill.php?id=$id&type=AddPayments&skey=$skey'>Pay Bill</a>
								</td>
							</tr>";
                    }
                }

                ?>

                </tbody>
            </table>

        </div>
    </div>

    <script src="js/script.js"></script>

</body>
</html>
