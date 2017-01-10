<?php
    require_once("checkconnection.php");

    if(isset($_REQUEST)) {
        // customer details
        $fname = $_REQUEST['fname'];
        $lname = $_REQUEST['lname'];
        $area = $_REQUEST['area'];
        $contact = $_REQUEST['contact'];
        $level = $_REQUEST['level'];

        $i = $_REQUEST['i'];
        $orderid = $_REQUEST['id'];
        $totalprice = 0;

        for($j=1; $j<=$i; $j++) {
            $m = 'quantity'.$j;
            $quantity = $_REQUEST[$m];
            if($quantity) {
                $n = 'food_id'.$j;
                $foodid = $_REQUEST[$n];
                $q = "SELECT price from catalog where food_id='$foodid'";
                $result = mysqli_query($dbcon, $q);
                $row = mysqli_fetch_assoc($result);
                $price = $row['price'];
                $totalprice += $quantity * $price;

                $q = "INSERT into item_ordered (food_id, order_no, qty_ordered) values ('$foodid', '$orderid', '$quantity')";
                $result = mysqli_query($dbcon, $q);
            }
        }
        
        // check existing customer
        $q = "SELECT cust_id, cust_level, area from customer where fname like '$fname' and lname like '$lname'";
        $result = mysqli_query($dbcon, $q);
        
        if(! @mysqli_num_rows($result)) {
            // new customer found, insert into the database
            $q = "INSERT into customer (fname, lname, area, contact, level) values ('$fname', '$lname', $area, $contact, '$level')";
            $result = mysqli_query($dbcon, $q);

            $q = "SELECT * from area where area_code=$area";
            $result = mysqli_query($dbcon, $q);
            // new area found, inserted into the database
            if(! @mysqli_num_rows($result)) {
                $q = "INSERT into area (area_code, area_name) values ($area, '')";
                $result = mysqli_query($dbcon, $q);
            }

            $q = "SELECT cust_id, cust_level, area from customer where fname like '$fname' and lname like '$lname'";
            $result = mysqli_query($dbcon, $q);
        }

        $row = mysqli_fetch_assoc($result);
        $cust_id = (int) $row['cust_id'];
        $area = (int) $row['area'];
        $cust_level = $row['cust_level'];

        $q = "INSERT into orders (order_no, order_date, cust_id) values ('$orderid', CURDATE(), $cust_id)";
        $result = mysqli_query($dbcon, $q);

        // premium members will get 10% discount
        if($cust_level == '1') {
            $totalprice = $totalprice * 90 / 100;
        }

        echo "<div align=\"center\">";
        $totalprice = ceil($totalprice);
        echo "Total price: $totalprice";

        $q = "SELECT boy_name from delivery_boy where area_code = $area";
        $result = mysqli_query($dbcon, $q);
        if(@mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            echo "<br>Order delivered by ". $row['boy_name'];
        }
        else {
            echo "<br>No delivery boy are available in that area.";
        }

        echo "<br>Back to <a href='index.php'>Home Page</a>";
        echo "</div>";
    }
?>