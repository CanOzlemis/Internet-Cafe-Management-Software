<?php 

$servername = "localhost";
$database = "magara_db";
$username = "root";
$password = "";
// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else
    echo "<script>console.log('Connected successfully');</script>";

$sql = "SELECT urunler FROM sales_updated";
$result = $conn->query($sql);
if (!$result) {
    trigger_error('Invalid query: ' . $conn->error);
}

if ($result->num_rows > 0) {
    // output data of each row
    echo "<script>var allProducts= [";
    $n = 0;
    while ($row = $result->fetch_assoc()) {
        if ($row["urunler"] == "total_amount")
            continue;
        $allProducts[$n] = $row["urunler"];
        echo "'$allProducts[$n]',";
        $n++;
    }
    echo "];</script>";
} else {
    echo "0 results";
}

$sql = "SELECT prices FROM urunler_tbl";
$result = $conn->query($sql);
if (!$result) {
    trigger_error('Invalid query: ' . $conn->error);
}

if ($result->num_rows > 0) {
    // output data of each row
    echo "<script>var productPrices= [";
    $n = 0;
    while ($row = $result->fetch_assoc()) {
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
    echo "<script>var productNames= [";
    while ($row = $result->fetch_assoc()) {

        $productNames[$n] = $row["urunler"];
        echo "'$productNames[$n]',";
        $n++;
    }
    echo "];</script>";
} else {
    echo "0 results";
}
$conn->close();

$timeOptions = [
    "10 Dakika",
    "15 Dakika",
    "30 Dakika",
    "45 Dakika",
    "1 Saat",
    "1 Saat 30 Dakika",
    "2 Saat",
    "İptal"
];

$tableCounter = 1;
?>




<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Oyun Masası</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="index.css">
</head>

<body>

    <div class="alert alert-danger alert-dismissible fade show" role="alert" id="alert" tabindex="5">
        <strong>Aktarmayı çalıştığınız masa dolu!</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <h3>Playstation</h3>



    <?php 
    for ($tableAmmountPS = 1; $tableAmmountPS < 9; $tableAmmountPS++) {

        echo "<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#tableNumber$tableCounter' id ='table$tableCounter'>
<img src = 'img/ps_logo.png' height = '76px' width = '76px'>Masa $tableCounter
</button>
<div class='modal fade' id='tableNumber$tableCounter' tabindex='-1' role='dialog' aria-labelledby='exampleModalCenterTitle' aria-hidden='true'>
<div class='modal-dialog modal-lg' role='document'>
<div class='modal-content'>
<div class='modal-header'>
<h5 class='modal-title' id='exampleModalLongTitle'>Masa $tableCounter</h5>
<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
<span aria-hidden='true'>&times;</span>
</button>
</div>
<div class='modal-body'>
Ücret = <span id ='price$tableCounter'>0</span><br>
Süre = <span id= 'time$tableCounter'></span><br>
Masa durumu = <span id ='status$tableCounter'>Kapalı</span><br> 
Masa açılış saati (saat : dakika) = <span id ='openTime$tableCounter'>Kapalı</span><br> 
<hr>
<h5 class='modal-title' id='products$tableCounter'>Ürünler</h5>
<hr>
<div id='menu$tableCounter'></div></div>
<div class='modal-footer'>
<!--Product Dropdown-->
<div class='dropdown'>
<button class='btn btn-secondary dropdown-toggle' type='button' id='product$tableCounter' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
Ürünler
</button>
<div class='dropdown-menu' aria-labelledby='product$tableCounter'>";
        for ($y = 1; $y <= sizeof($productNames); $y++) {
            $modifiedy = $y - 1;
            echo "<button class='dropdown-item' type='button' onclick='tableProduct($tableCounter, $y)'>$productNames[$modifiedy]</button>";
        }
        echo "
</div>
</div>
<!--Product Dropdown-->
<!-- Controller select -->
<div class='dropdown'>
<button class='btn btn-secondary dropdown-toggle' type='button' id='controller$tableCounter' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
Kol sayısı
</button>
<div class='dropdown-menu' aria-labelledby='controller$tableCounter'>";

        $controllerOption = ["1 - 2 Kol", "3 Kol", "4 Kol", "İptal"];
        for ($z = 0; $z < 3; $z++) {
            $moifiedz = $z + 1;
            echo "<button class='dropdown-item' type='button' onclick='controllerSelect($tableCounter, $moifiedz)'>$controllerOption[$z]</button>";
        }
        echo "
</div>
</div>
<!-- Controller select -->
<!--Table Transfer Dropdown-->
<div class='dropdown'>
<button class='btn btn-secondary dropdown-toggle' type='button' id='transfer$tableCounter' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                Masayı aktar
            </button>
            <div class='dropdown-menu' aria-labelledby='transfer$tableCounter'>";
        for ($z = 1; $z < 9; $z++) {
            if ($z == $tableCounter);
            else
                echo "<button class='dropdown-item' type='button' onclick='tableTransfer($tableCounter, $z)'>Masa $z</button>";
        }
        echo " </div>
</div>
<!--Table Transfer Dropdown-->
<!--Dropdown-->
<div class='btn-group'>
<button type='button' class='btn btn-info dropdown-toggle'  id='dropdown$tableCounter' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'> <span class='sr-only'>Süre</span>
                </button>
<div class='dropdown-menu'>";

        for ($count = 1; $count <= sizeof($timeOptions); $count++) {
            $modifiedCount = $count - 1;
            echo "<button class='dropdown-item' type='button' id='tableTimeOpt$tableCounter$count' onclick='timeButtons($tableCounter, $count)'>$timeOptions[$modifiedCount]</button>";
        }


        echo "</div>
</div>
<!--Dropdown-->
<button type='button' class='btn btn-danger' id = 'cancel$tableCounter' onclick ='closeTable(0, $tableCounter)'>Masa iptal</button>
<button type='button' class='btn btn-warning' id = 'complete$tableCounter' onclick ='completeOperation($tableCounter)'>Tamamla</button>
<button type='button' class='btn btn-primary' id ='open$tableCounter' onclick ='changeStatus($tableCounter)'>Masayı aç</button>

</div>
</div>
</div>
</div>";
        $tableCounter++;
    }
    ?>




    <?php $playstationNumber = $tableCounter;
    echo "<span style = 'display: none' id = 'playstationNo'> $playstationNumber</span>" ?>



    <h3>Okey Masası</h3>


    <?php 
    $staticTableCounter = $tableCounter;
    for ($t = 1; $t < 7; $t++) {
        echo "<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#tableNumber$tableCounter' id ='table$tableCounter'>
<img src = 'img/okey_logo.png' height = '76px' width = '76px'>Masa $tableCounter
</button>";

        echo "
<!-- Modal -->

<div class='modal fade' id='tableNumber$tableCounter' tabindex='-1' role='dialog' aria-labelledby='exampleModalCenterTitle' aria-hidden='true'>

<div class='modal-dialog modal-lg' role='document'>
    <div class='modal-content'>
    <div class='modal-header'>

        <h5 class='modal-title' id='exampleModalLongTitle'>Masa $tableCounter</h5>
  
        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
        <span aria-hidden='true'>&times;</span>
        </button>
    </div>
    <div class='modal-body'>

        Ücret = <span id ='price$tableCounter'>0</span><br>
        Süre = <span id= 'time$tableCounter'></span><br>
        Masa durumu = <span id ='status$tableCounter'>Kapalı</span><br>
        Masa açılış saati (saat : dakika) = <span id ='openTime$tableCounter'>Kapalı</span><br> 
        <hr>

        <h5 class='modal-title' id='products$tableCounter'>Ürünler</h5>
        <hr>
        <div id='menu$tableCounter'></div>

    </div>
    <div class='modal-footer'>
            <!--Product Dropdown-->
            <div class='dropdown'>

       <button class='btn btn-secondary dropdown-toggle' type='button' id='product$tableCounter' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                Ürünler
                </button>
                <div class='dropdown-menu' aria-labelledby='product$tableCounter'>";
        for ($y = 1; $y <= sizeof($productNames); $y++) {
            $modifiedy = $y - 1;
            echo "<button class='dropdown-item' type='button' onclick='tableProduct($tableCounter, $y)'>$productNames[$modifiedy]</button>";
        }
        echo "</div>
</div>
<!--Product Dropdown-->
<!--Table Transfer Dropdown-->
<div class='dropdown'>

<button class='btn btn-secondary dropdown-toggle' type='button' id='transfer$tableCounter' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' style='display: none'>
    Masayı aktar
</button>
<div class='dropdown-menu' aria-labelledby='transfer$tableCounter'>

    <button class='dropdown-item' type='button'>";

        for ($z = 0; $z < 6; $z++) {
            $m = $z + $staticTableCounter;
            if ($m == $tableCounter);
            else
                echo "<button class='dropdown-item' type='button' onclick='tableTransfer($tableCounter, $m)'>Masa $m</button>";
        }

        echo "</button>
</div>
</div>
<!--Table Transfer Dropdown-->
<!--Dropdown-->
<div class='btn-group'>

<button type='button' class='btn btn-info dropdown-toggle'  id='dropdown$tableCounter' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' > <span class='sr-only'>Süre</span>
    </button>

<div class='dropdown-menu'>";

        echo "<button class='dropdown-item' type='button' id='tableTimeOpt$tableCounter$count' onclick='timeButtons($tableCounter, 7)'>$timeOptions[7]</button>";


        echo " </div>
</div>
<!--Dropdown-->
<button type='button' class='btn btn-danger' id = 'cancel$tableCounter' onclick ='closeTable(0, $tableCounter)'>Masa iptal</button>
<button type='button' class='btn btn-warning' id = 'complete$tableCounter' onclick ='completeOperation($tableCounter)'>Tamamla</button>
    <button type='button' class='btn btn-primary' id ='open$tableCounter' onclick ='changeStatus($tableCounter)'>Masayı aç</button>

</div>
</div>
</div>
</div>";
        $tableCounter++;
    }
    ?>





    <h3>VR Masası</h3>
    <?php 

    echo "<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#tableNumber$tableCounter' id ='table$tableCounter'>
    <img src = 'img/vr_logo.png' height = '76px' width = '76px'>Masa $tableCounter
    </button>
    <div class='modal fade' id='tableNumber$tableCounter' tabindex='-1' role='dialog' aria-labelledby='exampleModalCenterTitle' aria-hidden='true'>
    <div class='modal-dialog modal-lg' role='document'>
    <div class='modal-content'>
    <div class='modal-header'>
    <h5 class='modal-title' id='exampleModalLongTitle'>Masa $tableCounter</h5>
    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
    <span aria-hidden='true'>&times;</span>
    </button>
    </div>
    <div class='modal-body'>
    Ücret = <span id ='price$tableCounter'>0</span><br>
    Süre = <span id= 'time$tableCounter'></span><br>
    Masa durumu = <span id ='status$tableCounter'>Kapalı</span><br> 
    Masa açılış saati (saat : dakika) = <span id ='openTime$tableCounter'>Kapalı</span><br> 
    <hr>
    <h5 class='modal-title' id='products$tableCounter'>Ürünler</h5>
    <hr>
    <div id='menu$tableCounter'></div></div>
    <div class='modal-footer'>
    <!--Product Dropdown-->
    <div class='dropdown'>
    <button class='btn btn-secondary dropdown-toggle' type='button' id='product$tableCounter' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
    Ürünler
    </button>
    <div class='dropdown-menu' aria-labelledby='product$tableCounter'>";
    for ($y = 1; $y <= sizeof($productNames); $y++) {
        $modifiedy = $y - 1;
        echo "<button class='dropdown-item' type='button' onclick='tableProduct($tableCounter, $y)'>$productNames[$modifiedy]</button>";
    }
    echo "
    </div>
    </div>
    <!--Product Dropdown-->
    <!--Table Transfer Dropdown-->
    <div class='dropdown'>
    
    <button class='btn btn-secondary dropdown-toggle' type='button' id='transfer$tableCounter' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' style='display: none'>
        Masayı aktar
    </button>
    <div class='dropdown-menu' aria-labelledby='transfer$tableCounter'>
    
        <button class='dropdown-item' type='button'>";

    echo "<button class='dropdown-item' type='button'>Mevcut değil</button>";
    echo "</button>
    </div>
    </div>
    <!--Table Transfer Dropdown-->
    <!--Dropdown-->
    <div class='btn-group'>
    
    <button type='button' class='btn btn-info dropdown-toggle'  id='dropdown$tableCounter' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' > <span class='sr-only'>Süre</span>
        </button>
    
    <div class='dropdown-menu'>";

    for ($count = 1; $count <= sizeof($timeOptions); $count++) {
        $modifiedCount = $count - 1;
        echo "<button class='dropdown-item' type='button' id='tableTimeOpt$tableCounter$count' onclick='timeButtons($tableCounter, $count)'>$timeOptions[$modifiedCount]</button>";
    }

    echo " </div>
    </div>
    <!--Dropdown-->
    <button type='button' class='btn btn-danger' id = 'cancel$tableCounter' onclick ='closeTable(0, $tableCounter)'>Masa iptal</button>
    <button type='button' class='btn btn-warning' id = 'complete$tableCounter' onclick ='completeOperation($tableCounter)'>Tamamla</button>
        <button type='button' class='btn btn-primary' id ='open$tableCounter' onclick ='changeStatus($tableCounter)'>Masayı aç</button>
    
    </div>
    </div>
    </div>
    </div>";
    $tableCounter++;


    ?>

    <br>
    <h3>Guitar Hero </h3>
    <?php 

    echo "<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#tableNumber$tableCounter' id ='table$tableCounter'>
    <img src ='img/guitar_hero_logo.png' width = '76px' height = '76px'>Masa $tableCounter
    </button>
    <div class='modal fade' id='tableNumber$tableCounter' tabindex='-1' role='dialog' aria-labelledby='exampleModalCenterTitle' aria-hidden='true'>
    <div class='modal-dialog modal-lg' role='document'>
    <div class='modal-content'>
    <div class='modal-header'>
    <h5 class='modal-title' id='exampleModalLongTitle'>Masa $tableCounter</h5>
    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
    <span aria-hidden='true'>&times;</span>
    </button>
    </div>
    <div class='modal-body'>
    Ücret = <span id ='price$tableCounter'>0</span><br>
    Süre = <span id= 'time$tableCounter'></span><br>
    Masa durumu = <span id ='status$tableCounter'>Kapalı</span><br>
    Masa açılış saati (saat : dakika) = <span id ='openTime$tableCounter'>Kapalı</span><br>
      <hr>
    <h5 class='modal-title' id='products$tableCounter'>Ürünler</h5>
    <hr>
    <div id='menu$tableCounter'></div></div>
    <div class='modal-footer'>
    <!--Product Dropdown-->
    <div class='dropdown'>
    <button class='btn btn-secondary dropdown-toggle' type='button' id='product$tableCounter' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
    Ürünler
    </button>
    <div class='dropdown-menu' aria-labelledby='product$tableCounter'>";
    for ($y = 1; $y <= sizeof($productNames); $y++) {
        $modifiedy = $y - 1;
        echo "<button class='dropdown-item' type='button' onclick='tableProduct($tableCounter, $y)'>$productNames[$modifiedy]</button>";
    }
    echo "
    </div>
    </div>
    <!--Product Dropdown-->
    <!--Table Transfer Dropdown-->
    <div class='dropdown'>
    
    <button class='btn btn-secondary dropdown-toggle' type='button' id='transfer$tableCounter' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' style='display: none'>
        Masayı aktar
    </button>
    <div class='dropdown-menu' aria-labelledby='transfer$tableCounter'>
    
        <button class='dropdown-item' type='button'>";

    echo "<button class='dropdown-item' type='button'>Mevcut değil</button>";
    echo "</button>
    </div>
    </div>
    <!--Table Transfer Dropdown-->
    <!--Dropdown-->
    <div class='btn-group'>
    
    <button type='button' class='btn btn-info dropdown-toggle'  id='dropdown$tableCounter' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' > <span class='sr-only'>Süre</span>
        </button>
    
    <div class='dropdown-menu'>";

    for ($count = 1; $count <= sizeof($timeOptions); $count++) {
        $modifiedCount = $count - 1;
        echo "<button class='dropdown-item' type='button' id='tableTimeOpt$tableCounter$count' onclick='timeButtons($tableCounter, $count)'>$timeOptions[$modifiedCount]</button>";
    }

    echo " </div>
    </div>
    <!--Dropdown-->
    <button type='button' class='btn btn-danger' id = 'cancel$tableCounter' onclick ='closeTable(0, $tableCounter)'>Masa iptal</button>
    <button type='button' class='btn btn-warning' id = 'complete$tableCounter' onclick ='completeOperation($tableCounter)'>Tamamla</button>
        <button type='button' class='btn btn-primary' id ='open$tableCounter' onclick ='changeStatus($tableCounter)'>Masayı aç</button>
    
    </div>
    </div>
    </div>
    </div>";
    $tableCounter++;


    ?>


    <br>
    <h3>Araba Simülatörü</h3>
    <?php 

    echo "<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#tableNumber$tableCounter' id ='table$tableCounter'>
<img src = 'img/car_logo.png' height = '76px' width = '76px'>Masa $tableCounter
</button>
<div class='modal fade' id='tableNumber$tableCounter' tabindex='-1' role='dialog' aria-labelledby='exampleModalCenterTitle' aria-hidden='true'>
<div class='modal-dialog modal-lg' role='document'>
<div class='modal-content'>
<div class='modal-header'>
<h5 class='modal-title' id='exampleModalLongTitle'>Masa $tableCounter</h5>
<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
<span aria-hidden='true'>&times;</span>
</button>
</div>
<div class='modal-body'>
Ücret = <span id ='price$tableCounter'>0</span><br>
Süre = <span id= 'time$tableCounter'></span><br>
Masa durumu = <span id ='status$tableCounter'>Kapalı</span><br>
Masa açılış saati (saat : dakika) = <span id ='openTime$tableCounter'>Kapalı</span><br> 
<hr>
<h5 class='modal-title' id='products$tableCounter'>Ürünler</h5>
<hr>
<div id='menu$tableCounter'></div></div>
<div class='modal-footer'>
<!--Product Dropdown-->
<div class='dropdown'>
<button class='btn btn-secondary dropdown-toggle' type='button' id='product$tableCounter' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
Ürünler
</button>
<div class='dropdown-menu' aria-labelledby='product$tableCounter'>";
    for ($y = 1; $y <= sizeof($productNames); $y++) {
        $modifiedy = $y - 1;
        echo "<button class='dropdown-item' type='button' onclick='tableProduct($tableCounter, $y)'>$productNames[$modifiedy]</button>";
    }
    echo "
</div>
</div>
<!--Product Dropdown-->
<!--Table Transfer Dropdown-->
<div class='dropdown'>

<button class='btn btn-secondary dropdown-toggle' type='button' id='transfer$tableCounter' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' style='display: none'>
    Masayı aktar
</button>
<div class='dropdown-menu' aria-labelledby='transfer$tableCounter'>

    <button class='dropdown-item' type='button'>";
    echo "<button class='dropdown-item' type='button'>Mevcut değil</button>";
    echo "</button>
</div>
</div>
<!--Table Transfer Dropdown-->
<!--Dropdown-->
<div class='btn-group'>

<button type='button' class='btn btn-info dropdown-toggle'  id='dropdown$tableCounter' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' > <span class='sr-only'>Süre</span>
    </button>

<div class='dropdown-menu'>";

    for ($count = 1; $count <= sizeof($timeOptions); $count++) {
        $modifiedCount = $count - 1;
        echo "<button class='dropdown-item' type='button' id='tableTimeOpt$tableCounter$count' onclick='timeButtons($tableCounter, $count)'>$timeOptions[$modifiedCount]</button>";
    }

    echo " </div>
</div>
<!--Dropdown-->
<button type='button' class='btn btn-danger' id = 'cancel$tableCounter' onclick ='closeTable(0, $tableCounter)'>Masa iptal</button>
<button type='button' class='btn btn-warning' id = 'complete$tableCounter' onclick ='completeOperation($tableCounter)'>Tamamla</button>
    <button type='button' class='btn btn-primary' id ='open$tableCounter' onclick ='changeStatus($tableCounter)'>Masayı aç</button>

</div>
</div>
</div>
</div>";
    $tableCounter++;


    ?>




    <br>
    <h3>Bilardo (Platin)</h3>
    <?php 

    echo "<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#tableNumber$tableCounter' id ='table$tableCounter'>
<img src = 'img/billiard_logo.png' height = '76px' width = '76px'>Masa $tableCounter
</button>
<div class='modal fade' id='tableNumber$tableCounter' tabindex='-1' role='dialog' aria-labelledby='exampleModalCenterTitle' aria-hidden='true'>
<div class='modal-dialog modal-lg' role='document'>
<div class='modal-content'>
<div class='modal-header'>
<h5 class='modal-title' id='exampleModalLongTitle'>Masa $tableCounter</h5>
<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
<span aria-hidden='true'>&times;</span>
</button>
</div>
<div class='modal-body'>
Ücret = <span id ='price$tableCounter'>0</span><br>
Süre = <span id= 'time$tableCounter'></span><br>
Masa durumu = <span id ='status$tableCounter'>Kapalı</span><br>
Masa açılış saati (saat : dakika) = <span id ='openTime$tableCounter'>Kapalı</span><br> 
 <hr>
<h5 class='modal-title' id='products$tableCounter'>Ürünler</h5>
<hr>
<div id='menu$tableCounter'></div></div>
<div class='modal-footer'>
<!--Product Dropdown-->
<div class='dropdown'>
<button class='btn btn-secondary dropdown-toggle' type='button' id='product$tableCounter' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
Ürünler
</button>
<div class='dropdown-menu' aria-labelledby='product$tableCounter'>";
    for ($y = 1; $y <= sizeof($productNames); $y++) {
        $modifiedy = $y - 1;
        echo "<button class='dropdown-item' type='button' onclick='tableProduct($tableCounter, $y)'>$productNames[$modifiedy]</button>";
    }
    echo "
</div>
</div>
<!--Product Dropdown-->
<!--Table Transfer Dropdown-->
<div class='dropdown'>

<button class='btn btn-secondary dropdown-toggle' type='button' id='transfer$tableCounter' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' style='display: none'>
    Masayı aktar
</button>
<div class='dropdown-menu' aria-labelledby='transfer$tableCounter'>

    <button class='dropdown-item' type='button'>";

    echo "<button class='dropdown-item' type='button'>Mevcut değil</button>";
    echo "</button>
</div>
</div>
<!--Table Transfer Dropdown-->
<!--Dropdown-->
<div class='btn-group'>

<button type='button' class='btn btn-info dropdown-toggle'  id='dropdown$tableCounter' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' > <span class='sr-only'>Süre</span>
    </button>

<div class='dropdown-menu'>";

    for ($count = 1; $count <= sizeof($timeOptions); $count++) {
        $modifiedCount = $count - 1;
        echo "<button class='dropdown-item' type='button' id='tableTimeOpt$tableCounter$count' onclick='timeButtons($tableCounter, $count)'>$timeOptions[$modifiedCount]</button>";
    }

    echo " </div>
</div>
<!--Dropdown-->
<button type='button' class='btn btn-danger' id = 'cancel$tableCounter' onclick ='closeTable(0, $tableCounter)'>Masa iptal</button>
<button type='button' class='btn btn-warning' id = 'complete$tableCounter' onclick ='completeOperation($tableCounter)'>Tamamla</button>
    <button type='button' class='btn btn-primary' id ='open$tableCounter' onclick ='changeStatus($tableCounter)'>Masayı aç</button>

</div>
</div>
</div>
</div>";
    $tableCounter++;


    ?>



    <br>
    <h3>Masa Tenisi</h3>
    <?php 

    echo "<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#tableNumber$tableCounter' id ='table$tableCounter'>
<img src = 'img/ping_pong_logo.png' height = '76px' width = '76px'>Masa $tableCounter
</button>
<div class='modal fade' id='tableNumber$tableCounter' tabindex='-1' role='dialog' aria-labelledby='exampleModalCenterTitle' aria-hidden='true'>
<div class='modal-dialog modal-lg' role='document'>
<div class='modal-content'>
<div class='modal-header'>
<h5 class='modal-title' id='exampleModalLongTitle'>Masa $tableCounter</h5>
<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
<span aria-hidden='true'>&times;</span>
</button>
</div>
<div class='modal-body'>
Ücret = <span id ='price$tableCounter'>0</span><br>
Süre = <span id= 'time$tableCounter'></span><br>
Masa durumu = <span id ='status$tableCounter'>Kapalı</span><br>
Masa açılış saati (saat : dakika) = <span id ='openTime$tableCounter'>Kapalı</span><br> 
 <hr>
<h5 class='modal-title' id='products$tableCounter'>Ürünler</h5>
<hr>
<div id='menu$tableCounter'></div></div>
<div class='modal-footer'>
<!--Product Dropdown-->
<div class='dropdown'>
<button class='btn btn-secondary dropdown-toggle' type='button' id='product$tableCounter' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
Ürünler
</button>
<div class='dropdown-menu' aria-labelledby='product$tableCounter'>";
    for ($y = 1; $y <= sizeof($productNames); $y++) {
        $modifiedy = $y - 1;
        echo "<button class='dropdown-item' type='button' onclick='tableProduct($tableCounter, $y)'>$productNames[$modifiedy]</button>";
    }
    echo "
</div>
</div>
<!--Product Dropdown-->
<!--Table Transfer Dropdown-->
<div class='dropdown'>

<button class='btn btn-secondary dropdown-toggle' type='button' id='transfer$tableCounter' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' style='display: none'>
    Masayı aktar
</button>
<div class='dropdown-menu' aria-labelledby='transfer$tableCounter'>

    <button class='dropdown-item' type='button'>";

    echo "<button class='dropdown-item' type='button'>Mevcut değil</button>";
    echo "</button>
</div>
</div>
<!--Table Transfer Dropdown-->
<!--Dropdown-->
<div class='btn-group'>

<button type='button' class='btn btn-info dropdown-toggle'  id='dropdown$tableCounter' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' > <span class='sr-only'>Süre</span>
    </button>

<div class='dropdown-menu'>";

    for ($count = 1; $count <= sizeof($timeOptions); $count++) {
        $modifiedCount = $count - 1;
        echo "<button class='dropdown-item' type='button' id='tableTimeOpt$tableCounter$count' onclick='timeButtons($tableCounter, $count)'>$timeOptions[$modifiedCount]</button>";
    }

    echo " </div>
</div>
<!--Dropdown-->
<button type='button' class='btn btn-danger' id = 'cancel$tableCounter' onclick ='closeTable(0, $tableCounter)'>Masa iptal</button>
<button type='button' class='btn btn-warning' id = 'complete$tableCounter' onclick ='completeOperation($tableCounter)'>Tamamla</button>
    <button type='button' class='btn btn-primary' id ='open$tableCounter' onclick ='changeStatus($tableCounter)'>Masayı aç</button>

</div>
</div>
</div>
</div>";



    ?>

    <span style="display: none" id="tableAmmount"><?php $tableCounter++;
                                                    echo "$tableCounter"; ?></span>

    <br><br><br><br><br><br><br><br><br><br>



    <script type="text/javascript">
        function copySpanContent() {
            for (var z = 0; z < productNames.length; z++) {
                document.getElementById(allProducts[z] + "_value").value =
                    document.getElementById("endDayMenu" + z).firstChild.data;
            }
            document.getElementById("endDayMoney_value").value =
                document.getElementById("endDayprice").firstChild.data;
        }
    </script>

    <form action="config.php" method="post" onsubmit="copySpanContent()">
        <button type='button' class='btn btn-info' data-toggle='modal' data-target='#tableEndDay' id='table$tableCounter'>
            Gün raporu
        </button>
        <div class='modal fade' id='tableEndDay' tabindex='-1' role='dialog' aria-labelledby='exampleModalCenterTitle' aria-hidden='true'>
            <div class='modal-dialog modal-lg' role='document'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <h5 class='modal-title' id='exampleModalLongTitle'>Gün raporu</h5>
                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>
                    <div class='modal-body'>
                        Toplam kazanılan (bugün) = <span id='endDayprice'>0</span><span> TL</span><br>
                        <br>
                        <hr>
                        <h5 class='modal-title'>Ürünler</h5>
                        <hr>
                        <div id='menuEndDay'>
                            <?php 
                            for ($z = 0; $z < sizeof($productNames); $z++) {
                                echo "$productNames[$z], satılan = <span id = endDayMenu$z>0</span><br>";
                            }

                            ?>
                        </div>
                    </div>
                    <div class='modal-footer'>
                        <h5 class="warning" color="red">UYARI : BÜTÜN MASALARIN BİLGİLERİ KAYBOLUR VE SAYFA YENİLENİR</h5>
                        <input type="submit" class='btn btn-primary' name='submit' value="Gün sonu raporunu çıkar">
                    </div>
                </div>
            </div>
        </div>
        <div style='display: none'>
            <?php
            for ($z = 0; $z < sizeof($productNames); $z++) {
                echo "<input type='hidden' name='$allProducts[$z]_value1' id='$allProducts[$z]_value'><br>
    ";
            }
            echo "<input type='hidden' name='endDayMoney_value1' id='endDayMoney_value'><br>
";
            ?>
        </div>
    </form>



    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">HESAPLAMA SIRASINDA PROBLEM YAŞANDI !</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        İşlemler sırasında problem yaşandı.<br> Masa <span id ="errTable"> </span> .<br>  Masa ücreti = <span id = "errPrice"></span> TL <br>
        Bütün ürün miktarları doğru bir şekilde gün sonuna geçirildi. Lütfen masa ücretini not alıp günün sonunda ekleyin. 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Kapat</button>
      </div>
    </div>
  </div>
</div>
</body>

</html>


<?php 


?>



<?php 
include 'timer1.php';
?> 