<?php 

$servername = "localhost";
$database = "tablemanagement";
$username = "root";
$password = "";
// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
else
    echo "<script>console.log('Connected successfully');</script>";

    $sql = "SELECT urunler FROM sales_updated"; //products
    $result = $conn->query($sql);
    if (!$result) {
        trigger_error('Invalid query: ' . $conn->error);
    }
    
    if ($result->num_rows > 0) {  //place all the products in a array to access it from js
        // output data of each row
        echo "<script>var allProducts= [";
        $n = 0;
        while($row = $result->fetch_assoc()) {
            $allProducts[$n] = $row["urunler"];
            echo "'$allProducts[$n]',";
            $n++;
        }
        echo "];</script>";
    } else {
        echo "0 results";
    }

    $sql = "SELECT prices FROM urunler_tbl";  //takes product prices
    $result = $conn->query($sql);
    if (!$result) {
        trigger_error('Invalid query: ' . $conn->error);
    }
    
    if ($result->num_rows > 0) { //place all the product prices in a array to access it from js
        // output data of each row
        echo "<script>var productPrices= [";
        $n = 0;
        while($row = $result->fetch_assoc()) {
            $productPrices[$n] = $row["prices"];
            echo "'$productPrices[$n]',";
            $n++;
        }
        echo "];</script>";
    } else {
        echo "0 results";
    }





    $sql = "SELECT urunler, prices FROM urunler_tbl";
    $result = $conn->query($sql);
    if (!$result) {
        trigger_error('Invalid query: ' . $conn->error);
    }
    
    if ($result->num_rows > 0) {
        // output data of each row
        $n = 0;
        echo "<script>var productNames= ["; //place all the product names in a array to access it from js
        while($row = $result->fetch_assoc()) {
            
            $productNames[$n] = $row["urunler"];
            echo "'$productNames[$n]',";
            $n++;
        }
        echo "];</script>";
    } else {
        echo "0 results";
    }
    $conn->close();

    $timeOptions = ["10 Dakika",  //Time settings to display in the dropdown options
    "15 Dakika", 
    "30 Dakika",
    "45 Dakika",
    "1 Saat",
    "1 Saat 30 Dakika",
    "2 Saat",
    "İptal"];

    $tableCounter = 1;
?>




<?php
if (isset($_POST["submit"]))   // Takes all of the sales and collected money from the day and uploads it to MySQL to have a record
{


    $endTotalPrice;
    $soldProducts;
    $endTotalPrice = $_POST["endDayMoney_value1"]; 
    if (isset($_POST["endDayMoney_value1"]))
        $endTotalPrice = (float)$_POST["endDayMoney_value1"]; 

    for ($z = 0; $z < sizeof($allProducts) - 1; $z++)
    {
        if(isset($_POST["$allProducts[$z]_value1"]))
            $soldProducts[$z] = (int)$_POST["$allProducts[$z]_value1"];

    }
    $_POST["submit"] = NULL;
    $conn = new mysqli($servername, $username, $password, $database);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    else
        echo "<script>console.log('Connected successfully');</script>";
    
        $sql = "INSERT INTO end_day_report(tarih,pepsi,seven_up,7gun,ice_tea,meyve_suyu,cay,nescafe,soda,meyveli_soda,su,turk_kahvesi,bitki_cayi,sicak_cikolata,enerji_icecegi,cips,jelibon,lolipop,toplam_fiyat) VALUES(NOW(), $soldProducts[0], $soldProducts[1], $soldProducts[2], $soldProducts[3], $soldProducts[4], $soldProducts[5], $soldProducts[6], $soldProducts[7], $soldProducts[8], $soldProducts[9], $soldProducts[10], $soldProducts[11], $soldProducts[12], $soldProducts[13], $soldProducts[14], $soldProducts[15], $soldProducts[16], $endTotalPrice)";
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
            header("Location: index.php");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        
        $conn->close();
    }
    ?>
