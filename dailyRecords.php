<!DOCTYPE html>
<html>
<head>
    <title>Daily Records</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/style.css">



    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />


</head>
<body>
<?php

include "connection/connect.php";
include "sideNav.php";
include "header.php";

date_default_timezone_set('Asia/Dhaka');

if (isset($_POST['search'])) {

    $today = $_POST['search_day'];
} else {
    $today = date('Y m d');
}


echo "<p class='h4 my-3 text-center'>Production Record of <b>$today</b></p><hr>";

if (isset($_POST['update_production'])) {

    $todays_date = date('Y m d');
    for ($i = 0; $i < sizeof($_POST['product_id']); $i++) {

        $pro_id = mysqli_real_escape_string($con, $_POST['product_id'][$i]);
        $today_prod = mysqli_real_escape_string($con, $_POST['today_production'][$i]);

        $sql_production = "INSERT INTO daily_records (products_id, sell, production, record_date)
                                VALUES ('$pro_id', '0', '$today_prod', '$todays_date')";
        mysqli_query($con, $sql_production);


    }
    echo "<div class='container'>
					<div class='row '>
						<div style='background: #0091EA; color:#ffffff' class='col-md-12 py-3 btn  btn-block mb-4'> Daily Record Added Successfully.</div>
					</div>
				 </div>";
}


?>


<div class="container">

    <form class='border-light' action='dailyRecords.php' method='post'>
        <div class='float-right mb-3 ml-3'>
            <input id="datepicker" name="search_day" placeholder="Search record by date" width="276" />

            <input class='float-right my-1 btn btn-info btn-block' name='search' type='submit' value='Search'>
        </div>




    </form>

    <form class='border-light' action='dailyRecords.php' method='post'>


        <table class='table table-striped border'>
            <thead class='table-primary'>
            <tr>
                <th class='text-center' scope='col '>No.</th>
                <th scope='col '>Product Name</th>
                <th class='text-center' scope='col'>Today</th>
                <th class='text-center' scope='col'>Previous</th>
                <th class='text-center' scope='col'>Total</th>
                <th class='text-center' scope='col'>Sold</th>
                <th class='text-center' scope='col'>Total Remaining</th>

            </tr>
            </thead>
            <tbody>

            <?php


            $record = "SELECT * FROM products";
            $query = mysqli_query($con, $record);
            if (mysqli_num_rows($query) > 0) {
                while ($data = mysqli_fetch_assoc($query)) {

                    //AND DATE_FORMAT(record_date, '%Y %m %d') = DATE_FORMAT('$today', '%Y %m %d')
                    $product_id = $data['id'];
                    $p_name = $data['p_name'];

                    $check_production = "SELECT * FROM daily_records WHERE `products_id` = '$product_id'  GROUP BY products_id";
                    $query_production = mysqli_query($con, $check_production);
                    if (mysqli_num_rows($query_production) > 0) {
                        while ($daily = mysqli_fetch_assoc($query_production)) {

                            //todays calculations
                            $sql_count_today = "SELECT SUM(sell) AS total_sell, SUM(production) AS total_production FROM daily_records  WHERE `products_id` = '$product_id' AND `record_date` = '$today'";
                            $query_count_today = mysqli_query($con, $sql_count_today);
                            $count_today = mysqli_fetch_assoc($query_count_today);

                            $today_sell = $count_today['total_sell'];
                            $today_production = $count_today['total_production'];
                            $remaining_today = $today_production - $today_sell;

                            //previous calculations
                            $sql_count_prev = "SELECT SUM(sell) AS total_sell, SUM(production) AS total_production FROM daily_records  WHERE `products_id` = '$product_id' AND `record_date` < '$today'";
                            $query_count_prev = mysqli_query($con, $sql_count_prev);
                            $count_prev = mysqli_fetch_assoc($query_count_prev);

                            $prev_sell = $count_prev['total_sell'];
                            $prev_production = $count_prev['total_production'];
                            $remaining_previous = $prev_production - $prev_sell;
                            $total_product = $remaining_previous + $today_production;
                            $remaining_total = $total_product - $today_sell;

                            echo "<tr>
						
                                <td><input type='text' value='$product_id' name='product_id[]' class='form-control text-center' readonly></td>
                                
                                <td><input type='text' value='$p_name' name='p_name[]' class='form-control' readonly></td>
                                
                                <td><input type='text' value='$today_production' name='today_production[]' placeholder='0' class='form-control text-center' required> </td>										
                                
                                <td><input type='text' value='$remaining_previous' class='form-control text-center' readonly></td>
                                
                                <td><input type='text' value='$total_product' class='form-control text-center' readonly></td>
                                
                                <td><input type='text' value='$today_sell' placeholder='0' class='form-control text-center' readonly> </td>										
                                
                                <td><input type='text' value='$remaining_total' class='form-control text-center' readonly></td>
                            </tr>";


                        }
                    }else{
                        echo "<tr>
						
                                <td><input type='text' value='$product_id' name='product_id[]' class='form-control text-center' readonly></td>
                                
                                <td><input type='text' value='$p_name' name='p_name[]' class='form-control' readonly></td>
                                
                                <td><input type='text'  name='today_production[]' placeholder='0' class='form-control text-center' required> </td>										
                                
                                <td><input type='text'  class='form-control text-center' placeholder='0' readonly></td>
                                
                                <td><input type='text'  class='form-control text-center' placeholder='0' readonly></td>
                                
                                <td><input type='text'  placeholder='0' class='form-control text-center' readonly> </td>										
                                
                                <td><input type='text' placeholder='0' class='form-control text-center' readonly></td>
                            </tr>";

                    }

                }
            }


            ?>


            </tbody>
        </table>
        <input class='btn btn-info my-4 btn-block' name='update_production' type='submit' value='Update Records'>
    </form>
    "

</div>

<script src="js/script.js"></script>
<script>
    $('#datepicker').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy mm dd'
    });
</script>
</body>
</html>