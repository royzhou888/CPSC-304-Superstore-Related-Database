<?php
/**
 * Created by PhpStorm.
 * User: royzh
 * Date: 2018-03-20
 * Time: 11:20 PM
 */


/**
 * Created by PhpStorm.
 * User: royzh
 * Date: 2018-03-20
 * Time: 5:28 PM
 */

$success = True; //keep track of errors so it redirects the page only if there are no errors
//$db_conn = OCILogon("ora_f3b1b", "a37544103", "dbhost.ugrad.cs.ubc.ca:1522/ug");
$db_conn = OCILogon("ora_b3n0b", "a46634151", "dbhost.ugrad.cs.ubc.ca:1522/ug");

function executePlainSQL($cmdstr)
{ //takes a plain (no bound variables) SQL command and executes it
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

function executeBoundSQL($cmdstr, $list)
{
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

function printResult($result)
{ //prints results from a select statement
    echo "<h2>INVENTORY LIST<h2>";

    echo "<table>";

    echo "<tr>
            <th>Quantity</th>
            <th>Part#</th>
            <th>Name</th>
            <th>Price</th>
             <th>Suppliers</th>
           </tr>";

    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
        echo "<tr>
                <td>" . $row[0] . "<img src=\"http://www.mezincashandcarry.com/wp-content/uploads/2015/05/Coca-Cola-33cl-CAN1.jpg\"> </td>
                <td>" . $row[1] . "  </td>
                <td>" . $row[2] . "</td>
                <td>" . $row[3] . "</td>
                 <td>" . $row[4] . "</td>
              </tr>"; //or just use "echo $row[0]"

    }
    echo "</table>";
}

function printResultSupplier($result)
{ //prints results from a select statement
    echo "<h2>SUPPLIER LIST<h2>";

    echo "<table>";

    echo "<tr>
            <th>Name</th>
            <th>Address</th>
            <th>Phone</th>
            <th>Status</th>
           </tr>";

    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
        echo "<tr>
                <td>" . $row[0] . "<img src=\"http://www.mezincashandcarry.com/wp-content/uploads/2015/05/Coca-Cola-33cl-CAN1.jpg\"> </td>
                <td>" . $row[1] . "  </td>
                <td>" . $row[2] . "</td>
                <td>" . $row[3] . "</td>
              </tr>"; //or just use "echo $row[0]"

    }
    echo "</table>";
}


function printResultOrder($result)
{ //prints results from a select statement
//    sequence_Order NUMBER(10) NOT NULL,
//                order_num NUMBER(10) NOT NULL,
//                part_num NUMBER(5),
//                number_of_item NUMBER(5),
//                customer_phone_num NUMBER(10),
//                employee_sin_num NUMBER(10),
//                DateOfOrder DATE default CURRENT_TIMESTAMP,


    echo "<h2>INVENTORY ORDER LIST<h2>";

    echo "<table>";

    echo "<tr>
            <th>Sequence</th>
            <th>Order_num</th>
            <th>Part_Num</th>
             <th>Number_Of_Item</th>
            <th>Customer_phone</th>
            <th>Employee_sin</th>
            <th>Date</th>
           </tr>";

    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
        echo "<tr>
                <td>" . $row[0] . "</td>
                <td>" . $row[1] . "</td>
                <td>" . $row[2] . "</td>
                <td>" . $row[3] . "</td>
                <td>" . $row[4] . "</td>
                <td>" . $row[5] . "</td>
                <td>" . $row[6] . "</td>
              </tr>"; //or just use "echo $row[0]"

    }
    echo "</table>";
}


function printResultOrderTotal($result)
{ //prints results from a select statement
//    sequence_Order NUMBER(10) NOT NULL,
//                order_num NUMBER(10) NOT NULL,
//                part_num NUMBER(5),
//                number_of_item NUMBER(5),
//                customer_phone_num NUMBER(10),
//                employee_sin_num NUMBER(10),
//                DateOfOrder DATE default CURRENT_TIMESTAMP,


    echo "<h2>INVENTORY ORDER LIST<h2>";

    echo "<table>";

    echo "<tr>
            <th>TotalOfItem_Ordered</th>
            <th>Part_Num</th>
            <th>Name</th>
             <th>Supplier_Phone</th>
            <th>Quantity Remaining</th>
           </tr>";

    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
        echo "<tr>
                <td>" . $row[0] . " </td>
                <td>" . $row[1] . "  </td>
                <td>" . $row[2] . "</td>
                <td>" . $row[3] . "</td>
                <td>" . $row[4] . "</td>
              </tr>"; //or just use "echo $row[0]"

    }
    echo "</table>";
}


function printResultOrderAverage($result)
{ //prints results from a select statement
//    sequence_Order NUMBER(10) NOT NULL,
//                order_num NUMBER(10) NOT NULL,
//                part_num NUMBER(5),
//                number_of_item NUMBER(5),
//                customer_phone_num NUMBER(10),
//                employee_sin_num NUMBER(10),
//                DateOfOrder DATE default CURRENT_TIMESTAMP,


    echo "<h2>INVENTORY ORDER LIST<h2>";

    echo "<table>";

    echo "<tr>
            <th>total average per order</th>
            <th>Part_Num</th>
            <th>Name</th>
             <th>Supplier_Phone</th>
            <th>Quantity Remaining</th>
           </tr>";

    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
        echo "<tr>
                <td>" . $row[0] . " </td>
                <td>" . $row[1] . "  </td>
                <td>" . $row[2] . "</td>
                <td>" . $row[3] . "</td>
                <td>" . $row[4] . "</td>
              </tr>"; //or just use "echo $row[0]"

    }
    echo "</table>";
}


// add employee given whether it's manager or not
function addInventory($post, $conn)
{
    $tuple1 = array(
        ":bind1" => $post['name'],
        ":bind2" => $post['part'],
        ":bind3" => $post['supplier'],
        ":bind4" => $post['price'],
        ":bind5" => $post['quantity']
    );

    $alltuples1 = array(
        $tuple1
    );


    executeBoundSQL("insert into inventory values (:bind5, :bind2,:bind1,:bind4, :bind3)", $alltuples1);
    OCICommit($conn);


}

// try to remove employee given sin
function removeInventory($post, $conn)
{

    $tuple = array(
        ":bind1" => $post['part']
    );

    $alltuples = array(
        $tuple
    );

    executeBoundSQL("DELETE FROM inventory WHERE part =:bind1", $alltuples);

    OCICommit($conn);

}

function updateInventory($post, $conn)
{


    if (!(($_POST['newName']) == "")) {
        $tuple = array(
            ":bind1" => $post['part'],
            ":bind2" => $post['newName']
        );
        $alltuples = array(
            $tuple
        );

        executeBoundSQL("update inventory set name =:bind2 where part =:bind1", $alltuples);
        OCICommit($conn);
    }


    if (!($post['newSupplier'] == "")) {
        $tuple = array(
            ":bind1" => $post['part'],
            ":bind3" => $post['newSupplier']
        );
        $alltuples = array(
            $tuple
        );

        executeBoundSQL("update inventory set supplier =:bind3 where part =:bind1", $alltuples);
        OCICommit($conn);
    }

    if (!($post['newQuantity'] == "")) {
        $tuple = array(
            ":bind1" => $post['part'],
            ":bind4" => $post['newQuantity']

        );

        $alltuples = array(
            $tuple
        );

        executeBoundSQL("update inventory set quantity =:bind4 where part =:bind1", $alltuples);
        OCICommit($conn);
    }


}


function findInventory($post, $conn)
{

    $alltuples = array();
    $name = '';

    if (!(($post['name']) == "")) {
        $name = $name . "lower(inventory.name) like '%" . $post['name'] . "%'";

    }


    if (!($post['part'] == "")) {
        if (strlen($name) != 0) {
            $name = $name . "AND " . " inventory.part=" . $post['part'];
        } else {
            $name = $name . "inventory.part=" . $post['part'];
        }
    }


    if (!($post['supplier'] == "")) {

        if (strlen($name) != 0) {
            $name = $name . "AND " . " inventory.supplier" . $post['supplier'];
        } else {
            $name = $name . "inventory.supplier=" . $post['supplier'];
        }
    }


    if (!($post['quantity'] == "")) {
        if (strlen($name) != 0) {
            $name = $name . "AND " . " inventory.quantity" . $post['quantity'];
        } else {
            $name = $name . "inventory.quantity=" . $post['quantity'];
        }
    }


    $result = executePlainSQL("SELECT * FROM inventory WHERE " . $name);

    printResult($result);

    OCICommit($conn);


}


function findInventorySupplier($post, $conn)
{

    $alltuples = array();
    $name = '';

    if (!($post['part'] == "")) {
        $name = $name . "i.part=" . $post['part'];
    }


    $result = executePlainSQL("SELECT s.name,s.address,s.phone,s.status FROM inventory i,supplier s WHERE " . $name . " and s.phone = i.supplier");

    printResultSupplier($result);

    OCICommit($conn);
}


function findInventoryByOrder($post, $conn)
{

//    select sumitem,i2.part,i2.name,i2.supplier,i2.quantity
//    from inventory i2,(select sum(o.number_of_item)as sumItem,i.part from order_place o,inventory i
//    where o.part_num=i.part group by o.part_num having sum(o.number_of_item)>4) temp where i2.part=temp.part;

    $alltuples = array();
    $name = '';

    if (!($post['countItem'] == "")) {
        $name = $name . "having sum(o.number_of_item)>" . $post['countItem'].") temp";
    }


    $result = executePlainSQL("
      select sumitem,i2.part,i2.name,i2.supplier,i2.quantity 
      from inventory i2,(select sum(o.number_of_item)as sumItem,i.part from order_place o,inventory i 
      where o.part_num=i.part group by o.part_num ".$name."
      where i2.part=temp.part");

    printResultOrderTotal($result);

    OCICommit($conn);
}

function findInventoryByAverage($post, $conn)
{

//    select temp.avg,temp.part_num,i.name,i.supplier,i.quantity,i.price
//    from (select avg(number_of_item)as avg,part_num from order_place group by part_num) temp,inventory i
//    where temp.avg = (select max(avg(number_of_item)) from order_place o group by part_num)and temp.part_num = i.part;

    $alltuples = array();
    $name = '';

    if (!($post['minMax'] == "")) {
        $name = $name . "(select ".$post['minMax']."(avg(number_of_item)) from order_place o group by part_num)";
    }


    $result = executePlainSQL("
     select temp.avg,temp.part_num,i.name,i.supplier,i.quantity,i.price 
     from (select avg(number_of_item)as avg,part_num from order_place group by part_num) temp,inventory i
      where temp.avg =".$name." and temp.part_num = i.part");

    printResultOrderAverage($result);

    OCICommit($conn);
}



// Connect Oracle... check to do which function ===================================================================================================
if ($db_conn) {

    if (array_key_exists('reset', $_POST)) {


        // Drop old table...
        //reset($db_conn);
        // echo "<br> dropping table <br>";
        executePlainSQL("Drop table Inventory");

        // Create new table...
        //  echo "<br> creating new table <br>";

        executePlainSQL(
            "CREATE TABLE Inventory(
            name VARCHAR(20),
                part NUMBER(20),
                supplier NUMBER(12),
                quantity NUMBER,,
                 price NUMBER(5),
         PRIMARY KEY(part_num)，
         FOREIGN KEY (supplier)REFERENCES Supplier(phone)
         )
               
        )");

        executePlainSQL("insert into inventory values ('chips',1234 ,911,10, 2)");
        executePlainSQL("insert into inventory values ('Coke',1234 ,911,10, 2)");

        OCICommit($db_conn);

    } else if (array_key_exists('insertsubmit', $_POST)) {
        //Getting the values from user and insert data into the table


        addInventory($_POST, $db_conn);

    } else if (array_key_exists('updatesubmit', $_POST)) {

        // Update tuple using data from user
        updateInventory($_POST, $db_conn);

    } else if (array_key_exists('dostuff', $_POST)) {
        //Insert data into table...
//        executePlainSQL("insert into EMPLOYEE values ('frank',5093 ,'hi',2,123)");
//
//        // Inserting data into table using bound variables
        // the big boss is roy
//        $list1 = array (
//            ":bind1" => 'peter',
//            ":bind2" => 345,
//            ":bind3" => 'sale associate',
//            ":bind4" => 5,
//            ":bind5" => 123,
//
//            // ":bind5" => 777
//        );
//        $list2 = array (
//            ":bind1" => 'james',
//            ":bind2" => 355,
//            ":bind3" => 'sale associate',
//            ":bind4" => 4,
//            ":bind5" => 123
//        );
//        $allrows = array (
//            $list1,
//            $list2
//        );

        //executeBoundSQL("insert into EMPLOYEE values (:bind1, :bind2,:bind3,:bind4,:bind5)", $allrows); //the function takes a list of lists


        // Select data...
        $result = executePlainSQL("select * from inventory");
        printResult($result);


        OCICommit($db_conn);

    } else if (array_key_exists('removeInventory', $_POST)) {
        // remove the employee given sin#
        removeInventory($_POST, $db_conn);
    } else if (array_key_exists('findsubmit', $_POST)) {
        findInventory($_POST, $db_conn);
    } else if (array_key_exists('findInventorySupplier', $_POST)) {
        findInventorySupplier($_POST, $db_conn);
    } else if (array_key_exists('findByOrder', $_POST)) {
        findInventoryByOrder($_POST, $db_conn);
    }else if (array_key_exists('findByAverage', $_POST)) {
        findInventoryByAverage($_POST, $db_conn);
    } else if (array_key_exists('loadOrder', $_POST)) {


        // executePlainSQL("Drop table Order_place");
        // executePlainSQL("Drop table customer");

        // Create new table...
        //  echo "<br> creating new table <br>";


        executePlainSQL(
            "CREATE TABLE Customer(
            name VARCHAR(20),
	        address VARCHAR(50),
	        phone NUMBER(10) NOT NULL,
	        points NUMBER(5),
	        PRIMARY KEY(phone)
	        )
                ");


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
                FOREIGN KEY(employee_sin_num) REFERENCES Employee(sin),
                FOREIGN KEY(part_num) REFERENCES INVENTORY(part))
                ");
        executePlainSQL("insert into customer values ('roy','ubc',911,100)");
        executePlainSQL("insert into customer values ('peter','sfu',110,100)");
        executePlainSQL("insert into ORDER_PLACE values (1,1,123,3,911,123,DEFAULT )");
        executePlainSQL("insert into ORDER_PLACE values (2,2,123,3,911,123,DEFAULT )");
        executePlainSQL("insert into ORDER_PLACE values (3,3,1234,2,110,123,DEFAULT )");
        executePlainSQL("insert into ORDER_PLACE values (4,4,1234,3,110,123,DEFAULT )");


        OCICommit($db_conn);
    }else if (array_key_exists('showOrder', $_POST)) {
        $result = executePlainSQL("select * from order_place");
        printResultOrder($result);
    }


//    if ($_POST && $success) {
//        //POST-REDIRECT-GET -- See http://en.wikipedia.org/wiki/Post/Redirect/Get
//        header("location: AddEmployee.php");
//    } else {
//        // Select data...
//        $result = executePlainSQL("select * from EMPLOYEE");
//        printResult($result);
//    }

    //Commit to save changes...


    OCILogoff($db_conn);

} else {
    echo "cannot connect";
    $e = OCI_Error(); // For OCILogon errors pass no handle
    echo htmlentities($e['message']);
}


?>
