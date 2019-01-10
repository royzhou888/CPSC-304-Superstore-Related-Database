
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

    body {background-color: gray;
    }

    .container {background-color: white;
        border: 3px solid black;
        width: 83%;
        height: 500px;
        padding: 3% 10% 5% 3% ;
        position:relative;
        left: 10px;
    }

    .item { width:105px;
        border:1px solid black;
        float:left;
        margin-right:10px;
        margin-top:10px;
        padding:10px;
        line-height:1.5;
    }

    .item_cont{right:35px;}

    .text_style{position:absolute;
        left:70%;}
    .welcome_style {font-size:20px;}
    table{margin-left: 20%;
        padding: 15px;
        border: 1px solid black;
        text-align: center;}
    th{padding-right:15px}
    .item img{width:80px;
        height:70px;
        padding: 5px;}
    .container p {left:10px;}

    .viewHis, .back,.modE,.modS,.modI {
        margin-left:80%;
    }
</style>

<?php

include 'Main.php';
$_SESSION["esin_num"] = 123;
$_SESSION["ename"] = "roy";

?>

<body>

<form method="POST" action="EmployeeOrder.php">

</form>

<h1> <img src="http://supersupermarkets.net/images/super-supermarket-logo-lg.png" style="vertical-align:middle">  Tako Supermarket  <img src="http://supersupermarkets.net/images/super-supermarket-logo-lg.png" style="vertical-align:middle"> </h1>


<div class="container">
    <span class="welcome_style"><b>Welcome! <span id="username"><?php echo $_SESSION["ename"]; ?></span></b></span>
    <br>
<!--    <span class="text_style"><span id="point">Current point:&nbsp<span id="currentpts">--><?php //echo $user_points; ?><!--</span>points</span></span>-->
    <br>
    <!--        <span class="text_style"><a href=""><span id="his" name = "his">View Order History</span></a></span>-->
    <br>
    <br>

    <form method="POST" action="EmployeeOrder.php">
        <input type="submit" class="viewHis" value="View Order History" name="orderHistory" />
    </form>

    <button class="modE" onclick="location.href= 'AddEmployee.php';"> Modify Employee List </button>

    <button class="modS" onclick="location.href= 'AddSupplier.php';"> Modify Supplier List </button>

    <button class="modI" onclick="location.href= 'AddInventory.php';"> Modify Inventory List </button>

    <br>
    <br>

    <div class=\"items\">

        <table name = "tab1">
            <tr><th>PartNum</th><th>ProductName</th><th>Price</th><th>Quantity</th></tr>


            <form method="POST" action="EmployeeOrder.php">


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

                <tr><th>Customer Phone Number</th><th><input type="text" name="customerNum" value=""></th><th></th><th>

                        <input type="submit" value="Make Order" name="employeeMakeOrder" />
            </form></th></tr>

        </table>

    </div>
    <button class="back" onclick="location.href= 'EmployeeLogin.php';"> Return to Login Page </button>

</div>

</body>
</html>

<?php

if ($db_conn) {

    //global $esin_num;
    if (array_key_exists('orderHistory', $_POST)) {

        $var = $_SESSION["esin_num"];

        $result = executePlainSQL("select ORDER_NUM, INVENTORY.NAME, ORDER_PLACE.PART_NUM, NUMBER_OF_ITEM, DATEOFORDER from ORDER_PLACE 
INNER JOIN INVENTORY ON INVENTORY.PART = ORDER_PLACE.PART_NUM where EMPLOYEE_SIN_NUM = $var");

        printHistory($result);
    }
}
?>