
<!DOCTYPE html>
<html>
<head>
    <title>Page Title</title>
</head>

<style>
    h1 {
        border: 3px dotted black;
        width: 60%;
        height: 40px;
        position: relative;
        left: 15%;
        right: 15%;
        text-align: center;
        padding: 10px;
        color: black;
    }

    img {
        height: 50px;
        width: 50px;
    }

    body {
        background-color: gray;
    }

    .container {
        background-color: white;
        border: 3px solid black;
        width: 83%;
        height: 800px;
        padding: 3% 10% 5% 3%;
        position: relative;
        left: 10px;
    }

    .item {
        width: 105px;
        border: 1px solid black;
        float: left;
        margin-right: 10px;
        margin-top: 10px;
        padding: 10px;
        line-height: 1.5;
    }

    .item_cont {
        right: 35px;
    }

    .text_style {
        position: absolute;
        left: 70%;
    }

    .welcome_style {
        font-size: 20px;
    }

    .item img {
        width: 80px;
        height: 70px;
        padding: 5px;
    }

    .container p {
        left: 10px;
    }

    .mkorder {
        margin-top: 20px;
        float: right
    }

    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    td, th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even) {
        background-color: #dddddd;
    }

    .cr_member {
        float: right;
    }

    .small_con {
        padding: 20px;
        border: 1px dotted black
    }
    .back {
        float:right;
    }
</style>

<body>
<h1><img src="http://supersupermarkets.net/images/super-supermarket-logo-lg.png" style="vertical-align:middle"> Tako
    Supermarket <img src="http://supersupermarkets.net/images/super-supermarket-logo-lg.png"
                     style="vertical-align:middle"></h1>

<div class="container">

    <h3 id="selectedOption"><b>Manage Inventory</b></h3>

    <button onclick="location.href= 'RemoveInventory.php';">remove inventory</button>
    <button onclick="location.href= 'AddInventory.php';"> add inventory </button>
    <button onclick="location.href= 'UpdateInventory.php';"> update Inventory </button>
    <button onclick="location.href= 'FindInventory.php';"> find Inventory </button>

    <div class="small_con">


        <form method="POST" action="FindInventory.php">
            <h3 id="selectedOption"><b>Find Inventory (please all use small case)</b></h3>

            <label for="ename"><b>By Name&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</b></label>

            <input type="text" placeholder="Enter Name" name="name" >
            <br>
            <label for="address"><b>By Part Number&nbsp</b></label>
            <input type="text" placeholder="Enter Part#" name="part" >
            <br>
            <label for="pos"><b>By Supplier &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</b></label>
            <input type="text" placeholder="Enter Supplier" name="supplier" >
            <br>
            <label for="rating"><b>By Quantity&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</b></label>
            <input type="text" placeholder="Enter Quantity" name="quantity">
            <br>


            <input type="submit" value="Find" name="findsubmit">


            <br>
        </form>

        <hr></hr>

        <form method="POST" action="FindInventory.php">
            <h3 id="selectedOption"><b>Find Inventory Suppliers Information </b></h3>


            <label for="address"><b>By Part Number&nbsp</b></label>
            <input type="text" placeholder="Enter Part#" name="part" >
            <br>

            <input type="submit" value="Find" name="findInventorySupplier">


            <br>
        </form>

        <hr></hr>


        <form method="POST" action="FindInventory.php">
            <h3 id="selectedOption"><b>Find Inventory By Sale </b></h3>


            <label for="address"><b>minimum #OfItem ordered &nbsp</b></label>
            <input type="text" placeholder="enter quantity" name="countItem" >
            <br>

            <input type="submit" value="Find" name="findByOrder">


            <br>
        </form>

        <hr></hr>


        <form method="POST" action="FindInventory.php">
            <h3 id="selectedOption"><b>Find Inventory by Average(max/min) per order </b></h3>


            <label for="address"><b>enter max/min &nbsp</b></label>
            <input type="text" placeholder="enter max/min" name="minMax" >
            <br>

            <input type="submit" value="Find" name="findByAverage">


            <br>
        </form>


        <hr></hr>



        <form method="POST" action="FindInventory.php">
            <input type="submit" value="Reset" name="reset">
        </form>

        <form method="POST" action="FindInventory.php">
            <input type="submit" value="show Inventory data" name="dostuff">
        </form>

        <form method="POST" action="FindInventory.php">
            <input type="submit" value="load Order data" name="loadOrder">
        </form>

        <form method="POST" action="FindInventory.php">
            <input type="submit" value="show Order data" name="showOrder"></p>
        </form>


        <button class="back" onclick="location.href= 'EmployeeOrder.php';"> Return to Order Page </button>
        <br>
    </div>
    <br>
    <br>

</div>


</body>
</html>




<?php
/**
 * Created by PhpStorm.
 * User: royzh
 * Date: 2018-03-21
 * Time: 12:08 AM
 */
include 'ManageInventory.php';

?>