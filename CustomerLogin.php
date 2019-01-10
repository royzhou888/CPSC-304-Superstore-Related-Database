
<?php
session_start();

?>

<!--Test Oracle file for UBC CPSC304 2011 Winter Term 2
Created by Jiemin Zhang
Modified by Simona Radu
This file shows the very basics of how to execute PHP commands
on Oracle.
specifically, it will drop a table, create a table, insert values
update values, and then query for values

IF YOU HAVE A TABLE CALLED "tab1" IT WILL BE DESTROYED

The script assumes you already have a server set up
All OCI commands are commands to the Oracle libraries
To get the file to work, you must place it somewhere where your
Apache server can run it, and you must rename it to have a ".php"
extension.  You must also change the username and password on the
OCILogon below to be your ORACLE username and password -->



<head>
    <title>Page Title</title>
</head>
<style>

    *{font-size: 18px}
    h1{border:3px dotted black;
        width: 60%;
        height: 40px;
        position: relative;
        left:15%;
        right:15%;
        text-align:center;
        padding: 10px;
        color: black;
    }
    img {height: 50px;
        width: 50px;
    }
    body {
        background-image: url("https://vignette.wikia.nocookie.net/southpark/images/a/a8/FatButtandPancakeHead06.jpg/revision/latest?cb=20100418055907");
        background-color: #cccccc;
        background-size: 20%;
        background-blend-mode:overlay}

    p{border: 3px solid black;
        background-color: white;
        left:10%;
        right:10%
    }

    form{background-color: white;
        border: 3px solid orange;
        width: 83%;
        height: 350px;
        padding: 3% 10% 5% 3% ;
        position:relative;
        left: 10px;
        line-height:3;
    }
    .container {position:relative;
        left: 40%;
        font-size: 18px; }
    .container button{position:relative;left:65%}
    .forget{padding:3px;
        position:relative;
        left: 30%}
    .reg {padding:3px; position:relative; left:60% }
    .emLogin img{height:50px;width:60px; padding:0%; position:absolute; left:0px; top:5px;}

</style>
<body>

<h1> <img src="http://supersupermarkets.net/images/super-supermarket-logo-lg.png" style="vertical-align:middle">  Tako Supermarket  <img src="http://supersupermarkets.net/images/super-supermarket-logo-lg.png" style="vertical-align:middle"> </h1>

<form method="POST" action="CustomerLogin.php"
<div class="emLogin"><a href="EmployeeLogin.php"><img src="http://news.bandao.cn/news_upload/200905/20090519070908_H5T42OOJ.jpg" title="Employee Login Click Here"></a></div>

<div class="container">
    <label for="uname"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="uname" required>
    <br>
    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" required>
    <br>
    <input type="submit" value="Login" name="customerLogin" />
    <br>
    <label>
        <input type="checkbox" checked="checked" name="remember"> Remember me
    </label>
</div>

<span class="forget" style="background-color:#f1f1f1"><a href="#">Forget</a></span>
<span class="reg" style="background-color:#f1f1f1"><a href="#">Sign Up</a></span>

</form>
</body>



<?php

include 'Main.php';

?>




