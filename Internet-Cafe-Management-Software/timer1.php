
<script>


    //Adding all products to all the tables
    for (var tables = 1; tables < parseInt(document.getElementById("tableAmmount").innerHTML); tables++)
    {
        for (var addProduct = 0; addProduct < allProducts.length; addProduct++) {
            var menu = document.getElementById("menu" + tables);
            var div = document.createElement('div');
            var button = document.createElement('button');
            var span = document.createElement('span');
            var p = document.createElement('span');
            var br = document.createElement("br");
            div.setAttribute("id", allProducts[addProduct] + tables);
            button.setAttribute("type", "button");
            button.setAttribute("class", "btn btn-info btn-sm");
            var modifiedAddProduct = addProduct + 1;
            button.setAttribute("onclick", "tableProductDecrease(" + tables + "," + modifiedAddProduct + ")");
            button.innerHTML = "Eksilt";
            p.innerHTML = productNames[addProduct] + ", adet : ";
            div.appendChild(button);
            div.appendChild(p);
            span.setAttribute("id", "ammount" + allProducts[addProduct] + tables);
            span.innerHTML = "0";
            div.appendChild(span);
            div.appendChild(br);
            menu.appendChild(div);

        }
    }

    // setting all the products to display: none
    for (var p = 1; p < parseInt(document.getElementById("tableAmmount").innerHTML); p++) {
        for (var z = 0; z < allProducts.length; z++) {
            document.getElementById(allProducts[z] + p).style.display = "none";
        }

    }
    //Setting the PS tables to only show the controller option
    for (var z = 1; z < parseInt(document.getElementById("playstationNo").innerHTML); z++) //PS table setup
    {
        document.getElementById("dropdown" + z).setAttribute("disabled", "disabled");
        document.getElementById("dropdown" + z).setAttribute("style", "display: none");
        document.getElementById("open" + z).setAttribute("disabled", "disabled");
        document.getElementById("open" + z).setAttribute("style", "display: none");
        document.getElementById("controller" + z).innerHTML = "Kol sayısı";
    }

    document.getElementById("alert").style.display = "none";

    
    // arrays that hold data
    var seconds = [];
    var price = [];
    var getstatus = [];
    var priceRate = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.0055555555555556, 0.0083333333333333, 0.0041666666666667, 0.0083333333333333, 0.0055555555555556, 0, 0, 0, 0, 0, 0, 0, 0, 0];
                                                                //VR                  Guitar hero         Car simulator      Bilard               Masa tenisi         



    //Status switches
    function changeStatus(s) {

        var d = new Date();
                var hour = d.getHours();
                var minute = d.getMinutes();
                document.getElementById("openTime" + s).innerHTML = hour + " : " + minute;


        if (getstatus[s] == 0) {
            if (seconds[s] != 0)
                getstatus[s] = 2; //make another value that changes it to 3
            else
                getstatus[s] = 1;
        } else if (getstatus[s] == 1 || getstatus[s] == 2)
            getstatus[s] = 3;
        else
        {
            getstatus[s] = 0;
        }

    }



    //Closing the table and deleting all the data
    function closeTable(condition, no) // 0 = manual table close, 1 = time over
    {
        if (condition == 0)
            document.getElementById("time" + no).innerHTML = "";
        else
            document.getElementById("time" + no).innerHTML = "Süre bitti";

        document.getElementById("price" + no).innerHTML = "0";
        document.getElementById("table" + no).className = "btn btn-primary";
        document.getElementById("dropdown" + no).innerHTML = "Süre";
        document.getElementById("open" + no).innerHTML = "Masayı aç";
        document.getElementById("status" + no).innerHTML = "Kapalı";


        for (var z = 1; z <= allProducts.length; z++) {
            document.getElementById("ammount" + allProducts[z - 1] + no).innerHTML = "0";
            tableProductDecrease(no, z);
        }
        document.getElementById("openTime" + no).innerHTML = "Kapalı";
        getstatus[no] = 0;
        seconds[no] = 0;
        price[no] = 0;
        seconds[no] = 0;
    }



    //Time options to be set
    function timeButtons(tableNo, optionNo) {
        var timerText = document.getElementById("tableTimeOpt" + tableNo + optionNo).innerHTML;
        if (timerText == "İptal") {
            document.getElementById("dropdown" + tableNo).innerHTML = "Süre";
            seconds[tableNo] = 0;
            price[tableNo] = 0;
        } else {
            if (optionNo == 1)
                seconds[tableNo] = 600; //10 Dakika 600
            else if (optionNo == 2)
                seconds[tableNo] = 900; //15 Dakika
            else if (optionNo == 3)
                seconds[tableNo] = 1800; //30 Dakika
            else if (optionNo == 4)
                seconds[tableNo] = 2700; //45 Dakika
            else if (optionNo == 5)
                seconds[tableNo] = 3600; //1 Saat
            else if (optionNo == 6)
                seconds[tableNo] = 5400; //1 Saat 30 Dakika
            else if (optionNo == 7)
                seconds[tableNo] = 7200; //2 Saat
            price[tableNo] = seconds[tableNo] * priceRate[tableNo];
            document.getElementById("dropdown" + tableNo).innerHTML = timerText;
            changeStatus(tableNo);
        }

    }


    //Block the table from deleting info when timer finishes
    function waitTable(tableNo) {
        document.getElementById("dropdown" + tableNo).setAttribute("disabled", "disabled");
        document.getElementById("open" + tableNo).setAttribute("disabled", "disabled");
        document.getElementById("transfer" + tableNo).setAttribute("disabled", "disabled");
        document.getElementById("product" + tableNo).setAttribute("disabled", "disabled");
        document.getElementById("table" + tableNo).className = "btn btn-warning";
        document.getElementById("status" + tableNo).innerHTML = "Bitti, hesap kapatılmayı bekliyor";
        document.getElementById("complete" + tableNo).removeAttribute("style");
    }


    //Save all the data to end day
    function completeOperation(tableNo) {
        var holdAmmount;
        var raportAmmount;
        var holdPrice = parseFloat(document.getElementById("price" + tableNo).innerHTML);
        document.getElementById("openTime" + tableNo).innerHTML = "Kapalı";
        if (isNaN(parseFloat(document.getElementById("endDayprice").innerHTML)) || isNaN(holdPrice))
        {
            console.log("Masa '" + tableNo + "'  NaN error : Masa ücreti = " + holdPrice + " --- Gün sonu ücreti = " + parseFloat(document.getElementById("endDayprice").innerHTML));
            document.getElementById("errTable").innerHTML = tableNo;
            document.getElementById("errPrice").innerHTML = holdPrice;
            $("#exampleModal").modal("show");
        }
        else
        {
            var sumPrice = parseFloat(document.getElementById("endDayprice").innerHTML) + holdPrice;
            document.getElementById("endDayprice").innerHTML = sumPrice;
        }

        //Get the price from database and add it and send it back
        for (var z = 0; z < allProducts.length; z++) {
            if (document.getElementById(allProducts[z] + tableNo).innerHTML == "0") {
                console.log("empty");
            } else {
                holdAmmount = parseInt(document.getElementById("ammount" + allProducts[z] + tableNo).innerHTML);
                raportAmmount = parseInt(document.getElementById("endDayMenu" + z).innerHTML);
                document.getElementById("endDayMenu" + z).innerHTML = holdAmmount + raportAmmount;
            }
        }
        closeTable(0, tableNo);
    }


    //Timer that calculates every second
    var x = setInterval(function() {
        for (var no = 1; no < parseInt(document.getElementById("tableAmmount").innerHTML); no++) {
            if (getstatus[no] == 1) //Unlimited time
            {
                seconds[no]++;
                if ((parseFloat(Math.round((3600 * priceRate[no]) * 100) / 100)) == 10) {
                    if (!(seconds[no] % 90)) {
                        price[no] = price[no] + 0.25;
                    }
                }
                if ((parseFloat(Math.round((3600 * priceRate[no]) * 100) / 100)) == 15) {
                    if (!(seconds[no] % 60)) {
                        price[no] = price[no] + 0.25;
                    }
                }
                if ((parseFloat(Math.round((3600 * priceRate[no]) * 100) / 100)) == 20) {
                    if (!(seconds[no] % 45)) {
                        price[no] = price[no] + 0.25;
                    }
                }
                if ((parseFloat(Math.round((3600 * priceRate[no]) * 100) / 100)) == 30) {
                    if (!(seconds[no] % 30)) {
                        price[no] = price[no] + 0.25;
                    }
                }

                document.getElementById("open" + no).innerHTML = "Masayı kapat";
                document.getElementById("price" + no).innerHTML = price[no] + " TL";
                document.getElementById("time" + no).innerHTML = seconds[no];
                document.getElementById("status" + no).innerHTML = "Açık";
                document.getElementById("table" + no).className = "btn btn-success";
                document.getElementById("dropdown" + no).setAttribute("disabled", "disabled");
                document.getElementById("transfer" + no).removeAttribute("disabled");
                document.getElementById("product" + no).removeAttribute("disabled");
                document.getElementById("product" + no).removeAttribute("style");
                document.getElementById("transfer" + no).removeAttribute("style");
                document.getElementById("dropdown" + no).removeAttribute("style");
                document.getElementById("open" + no).removeAttribute("style");
                document.getElementById("complete" + no).setAttribute("style", "display: none");
                document.getElementById("cancel" + no).removeAttribute("style");
                document.getElementById("cancel" + no).removeAttribute("disabled");

                if (no < (parseInt(document.getElementById("playstationNo").innerHTML))) {
                    document.getElementById("controller" + no).setAttribute("disabled", "disabled");
                }
            } else if (getstatus[no] == 2) // Countdown timer
            {
                if (seconds[no] <= 0) {
                    waitTable(no);
                } else {
                    seconds[no]--;
                    if (no < (parseInt(document.getElementById("playstationNo").innerHTML))) {
                        document.getElementById("controller" + no).setAttribute("disabled", "disabled");
                    }
                    document.getElementById("open" + no).innerHTML = "Masayı kapat";
                    document.getElementById("price" + no).innerHTML = parseFloat(Math.round(price[no] * 100) / 100).toFixed(2) + " TL";
                    document.getElementById("time" + no).innerHTML = seconds[no] + " Saniye kaldı";
                    document.getElementById("status" + no).innerHTML = "Açık";
                    document.getElementById("table" + no).className = "btn btn-success";
                    document.getElementById("transfer" + no).removeAttribute("disabled");
                    document.getElementById("product" + no).removeAttribute("disabled");

                    document.getElementById("complete" + no).setAttribute("style", "display: none");
                    document.getElementById("product" + no).removeAttribute("style");
                    document.getElementById("transfer" + no).removeAttribute("style");
                    document.getElementById("dropdown" + no).setAttribute("disabled", "disabled");

                    document.getElementById("dropdown" + no).removeAttribute("style");
                    document.getElementById("open" + no).removeAttribute("style");

                    document.getElementById("cancel" + no).removeAttribute("style");
                    document.getElementById("cancel" + no).removeAttribute("disabled");

                }
            } else // table is off
            {


                document.getElementById("dropdown" + no).removeAttribute("disabled");
                document.getElementById("transfer" + no).setAttribute("disabled", "disabled");
                document.getElementById("product" + no).setAttribute("disabled", "disabled");
                document.getElementById("complete" + no).setAttribute("style", "display: none");

                document.getElementById("product" + no).setAttribute("style", "display: none");
                document.getElementById("transfer" + no).setAttribute("style", "display: none");

                document.getElementById("cancel" + no).setAttribute("style", "display: none");
                document.getElementById("cancel" + no).setAttribute("disabled", "disabled");

                document.getElementById("open" + no).removeAttribute("disabled");
                document.getElementById("open" + no).removeAttribute("style");

                if (no < parseInt(document.getElementById("playstationNo").innerHTML)) {
                    if ((document.getElementById("controller" + no).innerHTML) == "Kol sayısı") {
                        document.getElementById("dropdown" + no).setAttribute("disabled", "disabled");
                        document.getElementById("dropdown" + no).setAttribute("style", "display: none");
                        document.getElementById("open" + no).setAttribute("disabled", "disabled");
                        document.getElementById("open" + no).setAttribute("style", "display: none");

                    } else {
                        document.getElementById("open" + no).removeAttribute("disabled");
                        document.getElementById("open" + no).removeAttribute("style");
                        document.getElementById("dropdown" + no).removeAttribute("style");
                        document.getElementById("controller" + no).removeAttribute("disabled");

                    }
                }
                if (getstatus[no] == 3) {
                    document.getElementById("cancel" + no).removeAttribute("style");
                    document.getElementById("cancel" + no).removeAttribute("disabled");
                    document.getElementById("dropdown" + no).setAttribute("disabled", "disabled");
                    waitTable(no);
                } else
                    closeTable(0, no);
            }
        }
    }, 1000);

    //PS controller options
    function controllerSelect(tableNumber, controllers) {
        if (controllers == 1) {
            document.getElementById("dropdown" + tableNumber).removeAttribute("disabled");
            document.getElementById("open" + tableNumber).removeAttribute("disabled");
            document.getElementById("controller" + tableNumber).innerHTML = "1 - 2 Kol";
            priceRate[tableNumber] = 0.0027777777777778;
        } else if (controllers == 2) {
            document.getElementById("dropdown" + tableNumber).removeAttribute("disabled");
            document.getElementById("open" + tableNumber).removeAttribute("disabled");
            document.getElementById("controller" + tableNumber).innerHTML = "3 Kol";
            priceRate[tableNumber] = 0.0041666666666667;
        } else if (controllers == 3) {
            document.getElementById("dropdown" + tableNumber).removeAttribute("disabled");
            document.getElementById("open" + tableNumber).removeAttribute("disabled");
            document.getElementById("controller" + tableNumber).innerHTML = "4 Kol";
            priceRate[tableNumber] = 0.0055555555555556;
        } else if (controllers == 4) {
            document.getElementById("dropdown" + tableNumber).setAttribute("disabled", "disabled");
            document.getElementById("open" + tableNumber).setAttribute("disabled", "disabled");
            document.getElementById("controller" + tableNumber).innerHTML = "Kol sayısı";
        }
    }

    //Table transfer function
    function tableTransfer(tableNo, transferTable) {
        if (getstatus[transferTable] == 1 || getstatus[transferTable] == 2) {
            document.getElementById("alert").style.display = "block";
        } else {
            for (var z = 1; z <= allProducts.length; z++) {
                document.getElementById("ammount" + allProducts[z - 1] + transferTable).innerHTML = document.getElementById("ammount" + allProducts[z - 1] + tableNo).innerHTML;
                tableProduct(transferTable, z);
                tableProductDecrease(transferTable, z);
            }


            if (tableNo < parseInt(document.getElementById("playstationNo").innerHTML)) {
                document.getElementById("controller" + transferTable).innerHTML = document.getElementById("controller" + tableNo).innerHTML;
                document.getElementById("open" + transferTable).removeAttribute("disabled");
            }
            document.getElementById("openTime" + transferTable).innerHTML = document.getElementById("openTime" + tableNo).innerHTML;
            document.getElementById("openTime" + tableNo).innerHTML = "Kapalı";
            priceRate[transferTable] = priceRate[tableNo];
            getstatus[transferTable] = getstatus[tableNo];
            price[transferTable] = price[tableNo];
            seconds[transferTable] = seconds[tableNo];
            closeTable(0, tableNo);
        }
    }
</script>


<?php
// Increasing the product ammount with every click
echo "<script>function tableProduct(tableNumber, productNumber){";


for ($z = 1; $z <= sizeof($allProducts); $z++) {
        $modifiedz = $z - 1;
        echo "
        if(productNumber == $z)
        {
            document.getElementById(allProducts[$modifiedz] + tableNumber).style.display = 'block';
            document.getElementById('ammount' + allProducts[$modifiedz] + tableNumber).innerHTML = parseInt(document.getElementById('ammount' + allProducts[$modifiedz] + tableNumber).innerHTML) + 1;
            price[tableNumber] += parseFloat(productPrices[$modifiedz]);
        }
        ";
    }
echo  "}</script>";

// decreasing the product ammount with every click
echo "<script>function tableProductDecrease(tableNumber, productNumber){";

for ($z = 1; $z <= sizeof($allProducts); $z++) {
        $modifiedz = $z - 1;
        echo "if (productNumber == $z)
        {
            if((parseInt(document.getElementById('ammount' + allProducts[$modifiedz] + tableNumber).innerHTML)) - 1 <= 0)
            {
                document.getElementById('ammount' + allProducts[$modifiedz] + tableNumber).innerHTML = 0;
                document.getElementById(allProducts[$modifiedz] + tableNumber).style.display = 'none';
            }
            else
                document.getElementById('ammount' + allProducts[$modifiedz] + tableNumber).innerHTML = parseInt(document.getElementById('ammount' + allProducts[$modifiedz] + tableNumber).innerHTML) - 1;
            price[tableNumber] -= parseFloat(productPrices[$modifiedz]);
        }";
    }

echo "}</script>";

?> 