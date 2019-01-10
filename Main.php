
<?php
    session_start();
$_SESSION["esin_num"] = 123;
$_SESSION["ename"] = "roy";
?>

<?php

$success = True; //keep track of errors so it redirects the page only if there are no errors
$db_conn = OCILogon("ora_b3n0b", "a46634151", "dbhost.ugrad.cs.ubc.ca:1522/ug");


function executePlainSQL($cmdstr) { //takes a plain (no bound variables) SQL command and executes it
    //echo "<br>running ".$cmdstr."<br>";
    global $db_conn, $success;
    $statement = OCIParse($db_conn, $cmdstr); //There is a set of comments at the end of the file that describe some of the OCI specific functions and how they work

    if (!$statement) {
        echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
        $e = OCI_Error($db_conn); // For OCIParse errors pass the
        // connection handle
        echo htmlentities($e['message']);
        $success = False;
    }

    $r = OCIExecute($statement, OCI_DEFAULT);
    if (!$r) {
        echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
        $e = oci_error($statement); // For OCIExecute errors pass the statementhandle
        echo htmlentities($e['message']);
        $success = False;
    } else {

    }
    return $statement;

}

function executeBoundSQL($cmdstr, $list) {
    /* Sometimes a same statement will be excuted for severl times, only
     the value of variables need to be changed.
     In this case you don't need to create the statement several times;
     using bind variables can make the statement be shared and just
     parsed once. This is also very useful in protecting against SQL injection. See example code below for       how this functions is used */

    global $db_conn, $success;
    $statement = OCIParse($db_conn, $cmdstr);

    if (!$statement) {
        echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
        $e = OCI_Error($db_conn);
        echo htmlentities($e['message']);
        $success = False;
    }

    foreach ($list as $tuple) {
        foreach ($tuple as $bind => $val) {
            //echo $val;
            //echo "<br>".$bind."<br>";
            OCIBindByName($statement, $bind, $val);
            unset ($val); //make sure you do not remove this. Otherwise $val will remain in an array object wrapper which will not be recognized by Oracle as a proper datatype

        }
        $r = OCIExecute($statement, OCI_DEFAULT);
        if (!$r) {
            echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
            $e = OCI_Error($statement); // For OCIExecute errors pass the statementhandle
            echo htmlentities($e['message']);
            echo "<br>";
            $success = False;
        }
    }

}

function printHistory($result) { //prints results from a select statement
    echo "<br>Order History:<br>";
    echo "<table>";
    echo "<tr><th>ORDER NUMBER</th><th>PRODUCT NAME</th><th>PRODUCT PART NUM</th><th>QUANTITY</th><th>DATE</th></tr>";

    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
        echo "<tr><td>" . $row["ORDER_NUM"] . "</td><td>" . $row["NAME"] . "</td>
                <td>" . $row["PART_NUM"] . "</td><td>" . $row["NUMBER_OF_ITEM"] . "</td>
                <td>" . $row["DATEOFORDER"] . "</td></tr>";
    }
    echo "</table>";

}


function checkCustomerPSW($post,$conn) {

    $tuple = array (
        ":bind1" => $post['uname'],
        ":bind2" => $post['psw']
    );

    $alltuples = array (
        $tuple
    );

    //$result = executePlainSQL("select * from Customer where name='".$post['uname']."' and phone=".$post['psw']);
    $result = executePlainSQL("select * from Customer where EXISTS (select * from Customer where name='".$post['uname']."' and phone=".$post['psw'].")");

      if (sizeof($result)){
        //echo $cnum."<br>";
        $_SESSION["cnum"] = $post['psw'];


        header("Location: CustomerOrder.php");

    }
    else{
        echo "wrong username or psw";
    }

}

function checkEmployeePSW($post,$conn) {

    //global $user, $esin_num;
    $tuple = array (
        ":bind1" => $post['uname'],
        ":bind2" => $post['psw']
    );

    $alltuples = array (
        $tuple
    );

    //$result = executePlainSQL("select * from Customer where name='".$post['uname']."' and phone=".$post['psw']);
    $result = executePlainSQL("select * from Customer where EXISTS (select * from EMPLOYEE where name='".$post['uname']."' and sin =".$post['psw'].")");

    //echo "select * from Customer where EXISTS (select * from EMPLOYEE where name='".$post['uname']."' and sin_num=".$post['psw'].")";


    $correctPSW = 0;
    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
        $correctPSW = $correctPSW + 1;
        $_SESSION["esin_num"] = $row["SIN_NUM"];

    }

    //echo $correctPSW;

    if ($correctPSW > 0) {

        $_SESSION["ename"] = $post['uname'];
        $_SESSION["esin_num"] = $post['psw'];

        header("Location: EmployeeMenu.php");

    }
    else{
        echo "wrong username or psw";
    }

}

function customerPlaceOrder(){

    global $db_conn, $success;
    $result = executePlainSQL("select * from INVENTORY");
    $count = 1;
    $numberOfItems = 0;


    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {

        //$_SESSION["cnum"]
        //$phone = "'".$user."'";

        $name = "select". $count;

        $tuple = array (
            ":bind1" => $row["PART"],
            ":bind2" => $_POST[$name],
            ":bind3" => $_SESSION["cnum"]
        );
        $alltuples = array (
            $tuple
        );

        if($_POST[$name] > 0) {
            if ($numberOfItems == 0) {
                executeBoundSQL("insert into Order_place values (seq_order.nextval,seq_order_num.nextval, :bind1, :bind2, :bind3,'',DEFAULT )", $alltuples);
                $numberOfItems = 1;
            } else {
                executeBoundSQL("insert into Order_place values (seq_order.nextval,seq_order_num.currval, :bind1, :bind2, :bind3,'',DEFAULT )", $alltuples);
                $numberOfItems = 1 + $numberOfItems;
            }
        }

        OCICommit($db_conn);

        $count = $count+1;
    }


}

function employeePlaceOrder(){

    global $db_conn;
    $result = executePlainSQL("select * from INVENTORY");
    $count = 1;
    $numberOfItems = 0;

    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {

        $name = "select". $count;

        $tuple = array (
            ":bind1" => $row["PART"],
            ":bind2" => $_POST[$name],
            ":bind3" => $_POST["customerNum"],
            ":bind4" => $_SESSION["esin_num"]
        );
        $alltuples = array (
            $tuple
        );

        if($_POST[$name] > 0) {
            if ($numberOfItems == 0) {
                executeBoundSQL("insert into Order_place values (seq_order.nextval,seq_order_num.nextval, :bind1, :bind2, :bind3,:bind4,DEFAULT )", $alltuples);
                $numberOfItems = 1;
            } else {
                executeBoundSQL("insert into Order_place values (seq_order.nextval,seq_order_num.currval, :bind1, :bind2, :bind3,:bind4,DEFAULT )", $alltuples);
                $numberOfItems = 1 + $numberOfItems;
            }
        }

        OCICommit($db_conn);

        $count = $count+1;
    }


}

// Connect Oracle...
if ($db_conn) {

    if (array_key_exists('Reset', $_POST)) {

        executePlainSQL("Drop table Contain");
        executePlainSQL("Drop table Inventory");
        executePlainSQL("Drop table Order_place");
        executePlainSQL("Drop table Customer CASCADE CONSTRAINTS");
        executePlainSQL("drop TABLE EMPLOYEE CASCADE CONSTRAINTS");
        executePlainSQL("Drop table Manager CASCADE CONSTRAINTS");

        executePlainSQL(
            "CREATE TABLE Customer(
            name VARCHAR(20),
	        address VARCHAR(50),
	        phone NUMBER(10),
	        PRIMARY KEY(phone)
	        )");
        executePlainSQL("insert into Customer values ('John','221B Baker Street' ,'666666',3)");

        executePlainSQL(
            "CREATE TABLE Manager(
                name VARCHAR(20),
                sin_num NUMBER(10),
                position VARCHAR(20),
                rating NUMBER(2),
                PRIMARY KEY (sin_num))");

        executePlainSQL("insert into Manager values ('roy',123 ,'manager',6)");

        executePlainSQL(
            "CREATE TABLE Employee(
            name VARCHAR(20),
            sin_num NUMBER(10) NOT NULL ,
            position VARCHAR(20),
            rating NUMBER(2),
            manager_sin NUMBER(10),
            PRIMARY KEY(sin_num),
            FOREIGN KEY (manager_sin)REFERENCES Manager(sin_num)
            )");

        executePlainSQL("insert into Employee values ('roy',123 ,'manager',6, 123 )");
        executePlainSQL("insert into Employee values ('Qing',234 ,'employee',3, 123 )");

        executePlainSQL(
            "CREATE TABLE Order_place(
            sequence_Order NUMBER(10) NOT NULL,
            order_num NUMBER(10) NOT NULL,
            part_num NUMBER(5),
            number_of_item NUMBER(5),
            customer_phone_num NUMBER(10),
            employee_sin_num NUMBER(10),
            DateOfOrder DATE default CURRENT_TIMESTAMP,
            PRIMARY KEY(sequence_Order),
            FOREIGN KEY(customer_phone_num) REFERENCES Customer(phone),
            FOREIGN KEY(employee_sin_num) REFERENCES Employee(sin_num),
            FOREIGN KEY(part_num) REFERENCES INVENTORY(part_num));");

        executePlainSQL("CREATE SEQUENCE seq_order_num
            MINVALUE 1
            START WITH 1
            INCREMENT BY 1
            CACHE 10");

        executePlainSQL("CREATE SEQUENCE seq_order
            MINVALUE 1
            START WITH 1
            INCREMENT BY 1
            CACHE 10");

        executePlainSQL("insert into ORDER_PLACE values (seq_order.nextval,seq_order_num.nextval,98765,1 ,'666666',123,DEFAULT )");

        executePlainSQL(
            "CREATE TABLE Inventory(
            current_quantity NUMBER(5),
	        part_num NUMBER(5),
	        product_name VARCHAR(20),
	        product_price NUMBER(5),
	        product_suppliers VARCHAR(20),
	        PRIMARY KEY(part_num)
	        )");

        executePlainSQL("insert into Inventory values (10,98765 ,'Coke',6,'C_factory')");
        executePlainSQL("insert into Inventory values (10,98764 ,'Fiji Water',3,'C_factory')");

        executePlainSQL(
            "CREATE TABLE Contain(
            order_num NUMBER(10),
	        part_num NUMBER(5),
            quantity int,
	        PRIMARY KEY(order_num, part_num),
	        FOREIGN KEY(order_num) REFERENCES Order_place(order_num),
	        FOREIGN KEY(part_num) REFERENCES Inventory(part_num)
	        )");

        executePlainSQL("insert into Contain values (54321,98765 ,1)");

    }

    if (array_key_exists('customerLogin', $_POST)) {

        checkCustomerPSW($_POST, $db_conn);

    }
    if (array_key_exists('employeeLogin', $_POST)) {

        checkEmployeePSW($_POST, $db_conn);

    }

    if (array_key_exists('customerMakeOrder', $_POST)){

        customerPlaceOrder();

    }
    if (array_key_exists('employeeMakeOrder', $_POST)){

        employeePlaceOrder();

    }
    if (array_key_exists('clogin', $_POST)){

        header("Location: CustomerLogin.php");

    }
    if (array_key_exists('elogin', $_POST)){

        header("Location: EmployeeMenu.php");

    }
    if (array_key_exists('eorder', $_POST)){

        header("Location: EmployeeOrder.php");

    }
    if (array_key_exists('emanage', $_POST)){

        //header("Location: EmployeeLogin.php");
        //HERE !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

    }


    //Commit to save changes...
    OCILogoff($db_conn);

} else {
    echo "cannot connect";
    $e = OCI_Error(); // For OCILogon errors pass no handle
    echo htmlentities($e['message']);
}