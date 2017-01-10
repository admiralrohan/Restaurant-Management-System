<?php
    $charset = "0123456789";
    function random_string($randstring, $length) {
        $rand_string = "ORD";
        for($count = 0; $count < $length; $count++) {
            $rand_string .= random_char($randstring);
        }
        return $rand_string;
    }

    function random_char($string) {
        $length = strlen($string);
        $position = rand(0, $length-1);
        return ($string[$position]);
    }

    require_once("checkconnection.php");
    
    echo "<div align='center' max-width= '500px'>";
    echo "Enter no. of foods required in the box at the left side<br><br>";
    $q = "SELECT food_id, food_name, price from catalog";
    $result = mysqli_query($dbcon, $q);
    
    $random = random_string($charset, 4);
    echo "<form action='checkout.php?id=$random' method='POST'>";
    echo "<table border='1' align='center' cellpadding='5'>";
    echo "<tr>";
    echo "<td></td>";
    echo "<td><b>Food Name</b></td>";
    echo "<td><b>Price</b></td>";
    echo "</tr>";

    $i = 0;
    while($row = mysqli_fetch_assoc($result)) {
        $i++;
        echo "<tr>";
        echo "<td>";
        echo "<input type='text' name='quantity{$i}' size='2' value='0'>";
        echo "<input type='hidden' name='food_id{$i}' value='{$row['food_id']}'>";
        echo "</td>";
        echo "<td>{$row['food_name']}</td>";
        echo "<td>{$row['price']}</td>";
        echo "</tr>";
    }
    echo "</table>";

    include("customer_details.php");
    echo "<input type='hidden' name='i' value='$i'>";
    echo "<input type=\"Submit\" name=\"Submit\" value=\"Place Order\">";
    echo "</form>";

    echo "<form action='generatereport.php' method='POST'>";
    echo "<input type=\"Submit\" name=\"Submit\" value=\"Generate Report: Area wise no of customers\">";
    echo "</form>";

    echo "<form action='generatefoodreport.php' method='POST'>";
    echo "<input type=\"Submit\" name=\"Submit\" value=\"Generate Report: No of sells of each food item\">";
    echo "</form>";

    echo "</div>";
?>