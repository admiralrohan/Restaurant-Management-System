<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Report</title>
    <script src="http://d3js.org/d3.v3.min.js"></script>
    <!--<script src="d3.js"></script>-->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
        require_once("checkconnection.php");

        class catalog {
            var $food_id;
            var $food_name;
            var $count;

            function __construct() {
                $this->count = 0;
            }
        }

        $q = "SELECT food_id, food_name from catalog";
        $result = mysqli_query($dbcon, $q);

        if(mysqli_num_rows($result)) {
            $arr = array();
            while($row = mysqli_fetch_assoc($result)) {
                $food = new catalog();
                $food->food_id = (int) $row['food_id'];
                $food->food_name = $row['food_name'];
                $arr[] = $food;
            }

            $count_food = count($arr);

            $q = "SELECT food_id, qty_ordered from item_ordered";
            $result = mysqli_query($dbcon, $q);

            if(mysqli_num_rows($result)) {
                $count_order = 0;
                while($row = mysqli_fetch_assoc($result)) {
                    $food = $row['food_id'];
                    $temp = (int) $row['qty_ordered'];

                    foreach($arr as $item) {
                        if($item->food_id == $food) {
                            $item->count += $temp;
                        }
                    }
                }

                // echo "<table border=\"1\" align=\"center\" cellpadding=\"5\">";
                // echo "<tr><td><b>Food Name</b></td>";
                // echo "<td><b>No of orders</b></td></tr>";
                // foreach($arr as $item) {
                //     echo "<tr>";
                //     echo "<td>$item->food_name</td>";
                //     echo "<td>$item->count</td>";
                //     echo "</tr>";
                // }
                // echo "</table>";

                // echo "<br><p>Go back to <a href='index.php'>Home Page</a><p>";
            
                echo "<script src=\"draw_chart.js\"></script>";
                echo "<script>
                    var data = new Array();
                    function catalog(a, c) {
                        this.area = a;
                        this.count = c;
                    }

                    var t;
                    var count_area = $count_area; 
                    var count_cust = $count_cust;";
                    
                
                    foreach($arr as $item) {
                        $m = (int) $item->area;
                        $n = (int) $item->count;
                         echo "t = new catalog($m, $n);";
                         echo "data.push(t);";
                    }
                
                    echo "drawChart(data);";
                echo "</script>";
            }
        }
    ?>
</body>
</html>