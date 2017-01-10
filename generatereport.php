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

        class member {
            var $area;
            var $count;

            function __construct() {
                $this->count = 0;
            }
        }

        $q = "SELECT area_code from area";
        $result = mysqli_query($dbcon, $q);

        if(mysqli_num_rows($result)) {
            $arr = array();
            while($row = mysqli_fetch_assoc($result)) {
                $mem = new member();
                $mem->area = (int) $row['area_code'];
                $arr[] = $mem;
            }

            $count_area = count($arr);

            $q = "SELECT area from customer";
            $result = mysqli_query($dbcon, $q);

            if(mysqli_num_rows($result)) {
                $count_cust = 0;
                while($row = mysqli_fetch_assoc($result)) {
                    $area = (int) $row['area'];
                    $count_cust++;
                    foreach($arr as $item) {
                        if($item->area == $area) {
                            $item->count++;
                            break;
                        }
                    }
                }
                echo json_encode($arr);

                // echo "<table border=\"1\" align=\"center\" cellpadding=\"5\">";
                // echo "<tr><td><b>Area Code</b></td>";
                // echo "<td><b>No of customers</b></td></tr>";
                // foreach($arr as $item) {
                //     echo "<tr>";
                //     echo "<td>$item->area</td>";
                //     echo "<td>$item->count</td>";
                //     echo "</tr>";
                // }
                // echo "</table>";

                // echo "<br><p>Go back to <a href='index.php'>Home Page</a><p>";
            
                // echo "<script src=\"draw_chart.js\"></script>";
                // echo "<script>
                //     var data = new Array();
                //     function member(a, c) {
                //         this.area = a;
                //         this.count = c;
                //     }

                //     var t;
                //     var count_area = $count_area; 
                //     var count_cust = $count_cust;";
                    
                
                //     foreach($arr as $item) {
                //         $m = (int) $item->area;
                //         $n = (int) $item->count;
                //          echo "t = new member($m, $n);";
                //          echo "data.push(t);";
                //     }
                
                //     echo "drawChart(data);";
                // echo "</script>";
            }
        }
    ?>
</body>
</html>