<?php
    session_start();
$_SESSION["cnum"] = "666666";
$_SESSION["cname"] = "John";

?>

    <!DOCTYPE html>
<html>
<head>
    <title>Page Title</title>
</head>

<style>
    h1{border:3px dotted black;
        width: 60%;
        height: 40px;
        position: relative;
        left:15%;
        right:15%;
        text-align:center;
        padding: 10px;
        color: black;}

    img {height: 50px;
        width: 50px;}

    body {background-color: orange;
    }

    .container {background-color: white;
        border: 3px solid black;
        width: 83%;
        height: 300px;
        padding: 3% 10% 5% 3% ;
        position:relative;
        left: 10px;
    }

    .text_style{position:absolute;
        left:70%;}
    .welcome_style {margin-left: 40px;font-size:20px;}

    .item img{width:80px;
        height:70px;
        padding: 5px;}
    .container p {left:10px;}
    .viewHis {position:absolute;
        left:70%}
    table{margin-left: 20%;
        padding: 15px;
        border: 1px solid black;
        text-align: center;}
    th{padding-right:15px}
    .viewHis{float：right;
             right:30%}
    .back {
        float:right;
    }
</style>

<?php

    include 'Main.php';
?>

<body>

<form method="POST" action="CustomerOrder.php">
</form>

<h1> <img src="http://supersupermarkets.net/images/super-supermarket-logo-lg.png" style="vertical-align:middle">  Tako Supermarket  <img src="http://supersupermarkets.net/images/super-supermarket-logo-lg.png" style="vertical-align:middle"> </h1>


    <div class="container">
        <span class="welcome_style"><b>Welcome! <span id="username"><?php echo $_SESSION["cname"] ; ?></span></b></span>
        <br>

<!--        <span class="text_style"><a href=""><span id="his" name = "his">View Order History</span></a></span>-->
        <br>
        <br>

        <form method="POST" action="CustomerOrder.php">
            <input class="viewHis" type="submit" value="View Order History" name="orderHistory" />
        </form>


        <div class=\"items\">

            <table name = "tab1">
                <tr><th>PartNum</th><th>ProductName</th><th>Price</th><th>Quantity</th></tr>


                <form method="POST" action="CustomerOrder.php">


                <?php

                //include 'Main.php';

                $success = True; //keep track of errors so it redirects the page only if there are no errors
                $db_conn = OCILogon("ora_b3n0b", "a46634151", "dbhost.ugrad.cs.ubc.ca:1522/ug");


                $result = executePlainSQL("select * from INVENTORY");

                $count = "1";

                while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {

                    $name = "select". $count;
                    echo "<tr><td>" . $row["PART"] . "</td>
                  <td>" . $row["NAME"] . "</td>
                  <td>" . $row["PRICE"] . "</td>
                  <td>" . "<select name = $name>
                    <option value=\"0\" selected = \"selected\">--</option>
                    <option value=\"1\">1</option>
                    <option value=\"2\">2</option>
                    <option value=\"3\">3</option>
                    <option value=\"4\">4</option>
                    <option value=\"5\">5</option>
                    <option value=\"6\">6</option>
                    <option value=\"7\">7</option>
                    <option value=\"8\">8</option>
                    <option value=\"9\">9</option>
                    <option value=\"10\">10</option>
                </select>" . "</td></tr>";

                    $count = $count + "1";
                }

                ?>

                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>


                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th><input type="submit" value="Make Order" name="customerMakeOrder" /></form></th>

                </tr>

                </table>

        </div>

        <button class="back" onclick="location.href= 'CustomerLogin.php';"> Return to Login Page </button>
        <br>
    </div>

</body>
</html>

<?php

if ($db_conn) {

    if (array_key_exists('orderHistory', $_POST)) {

        //global $cnum;
        $var = $_SESSION["cnum"] ;
        //printInventoryForCustomer();
        $result = executePlainSQL("select ORDER_NUM, INVENTORY.NAME, ORDER_PLACE.PART_NUM, NUMBER_OF_ITEM, DATEOFORDER from ORDER_PLACE 
INNER JOIN INVENTORY ON INVENTORY.PART = ORDER_PLACE.PART_NUM where CUSTOMER_PHONE_NUM = $var");

        printHistory($result);
    }
}
?>