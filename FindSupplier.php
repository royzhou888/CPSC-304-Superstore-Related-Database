
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
        height: 350px;
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

    <h3 id="selectedOption"><b>Manage Supplier</b></h3>

    <button onclick="location.href= 'RemoveSupplier.php';">remove suppliers</button>
    <button onclick="location.href= 'AddSupplier.php';"> add suppliers </button>
    <button onclick="location.href= 'UpdateSupplier.php';"> update supliers </button>
    <button onclick="location.href= 'FindSupplier.php';"> find supliers </button>

    <div class="small_con">


        <form method="POST" action="FindSupplier.php">
            <h3 id="selectedOption"><b>Find supplier (please all use small case)</b></h3>

            <label for="ename"><b>By Name&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</b></label>

            <input type="text" placeholder="Enter Name" name="name" >
            <br>
            <label for="address"><b>By Address&nbsp&nbsp&nbsp&nbsp</b></label>
            <input type="text" placeholder="Enter Address" name="address" >
            <br>
            <label for="pos"><b>By Phone&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</b></label>
            <input type="text" placeholder="Enter Phone" name="phone" >
            <br>
            <label for="rating"><b>By Status&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</b></label>
            <input type="text" placeholder="Enter Status" name="status">
            <br>


            <input type="submit" value="Find" name="findsubmit">


            <br>
        </form>

        <hr></hr>


        <form method="POST" action="FindSupplier.php">
            <input type="submit" value="Reset" name="reset">
        </form>

        <form method="POST" action="FindSupplier.php">
            <input type="submit" value="show data" name="dostuff"></p>
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
include 'ManageSupplier.php';

?>