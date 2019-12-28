<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
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
<p class='h4 my-3 text-center'>Product Details</p><hr>
<div class="container my-5 py-2">
    <div class='row d-flex justify-content-center'>

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
                        $sql_count_today = "SELECT SUM(sell) AS total_sell, SUM(production) AS total_production FROM daily_records  WHERE `products_id` = '$product_id'";
                        $query_count_today = mysqli_query($con, $sql_count_today);
                        $count_today = mysqli_fetch_assoc($query_count_today);

                        $sell = $count_today['total_sell'];
                        $production = $count_today['total_production'];
                        $remaining = $production - $sell;

                        echo "
                        <div class='card  mx-2 my-2'>
                              <div class='view view-cascade overlay'>
                               <!--<img class='card-img-top' src='../images/mango.jpg' alt='Card image cap'>-->
                                <a>
                                  <div class='mask rgba-white-slight'></div>
                                </a>
                              </div>
                              <div class='card-body card-body-cascade text-center'>
                                <h4 class='card-title' style='color: #3989c6'><strong>$p_name</strong></h4>
                                <!--<h6 class='font-weight-bold indigo-text py-2'>Product Details</h6>-->
                                <p class='card-text'>Total Production: $production<br>Total Sold: $sell<br>Total Remaining: $remaining</p>
                            
                              </div>
                            
                        </div>";
                    }
                }
            }
        }


        ?>


    </div>
</div>


<script src="js/script.js"></script>
</body>
</html>