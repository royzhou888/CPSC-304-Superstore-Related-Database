<!DOCTYPE html>
<html>
<head>
    <title>Manage Supplier</title>
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


        <form method="POST" action="AddSupplier.php">
            <h3 id="selectedOption"><b>Add Supplier</b></h3>

            <label for="ename"><b>Supplier Name&nbsp&nbsp&nbsp</b></label>

            <input type="text" placeholder="Enter Name" name="name" required>
            <br>
            <label for="address"><b>Address&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</b></label>
            <input type="text" placeholder="Enter Address" name="address" required>
            <br>
            <label for="phone"><b>Phone&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</b></label>
            <input type="text" placeholder="Enter Phone" name="phone" required>
            <br>
            <label for="status"><b>Status   &nbsp &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</b></label>
            <input type="text" placeholder="Enter T/F" name="status">


            <input type="submit" value="Add" name="insertsubmit">


            <br>
        </form>

        <hr></hr>


        <form method="POST" action="AddSupplier.php">
            <input type="submit" value="Reset" name="reset">
        </form>

        <form method="POST" action="AddSupplier.php">
            <input type="submit" value="show data" name="dostuff"></p>
        </form>
    </div>
    <br>
    <br>
    <button class="back" onclick="location.href= 'EmployeeOrder.php';"> Return to Login Page </button>
</div>


</body>
</html>


<?php


/**
 * Created by PhpStorm.
 * User: royzh
 * Date: 2018-03-20
 * Time: 5:28 PM
 */

include 'ManageSupplier.php';



?>
