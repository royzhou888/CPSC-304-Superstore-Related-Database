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
    echo "<h2>EMPLOYEE LIST<h2>";

    echo "<table>";

    echo "<tr>
            <th>Name</th>
            <th>Address</th>
            <th>Phone</th>
            <th>status</th>
           </tr>";

    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
        echo "<tr>
                <td>".$row[0]."<img src=\"http://www.mezincashandcarry.com/wp-content/uploads/2015/05/Coca-Cola-33cl-CAN1.jpg\"> </td>
                <td>".$row[1]."  </td>
                <td>" . $row[2] . "</td>
                <td>" . $row[3] . "</td>
              </tr>"; //or just use "echo $row[0]"

    }
    echo "</table>";
}

// add employee given whether it's manager or not
function addSupplier($post, $conn)
{
    $tuple1 = array(
        ":bind1" => $post['name'],
        ":bind2" => $post['address'],
        ":bind3" => $post['phone'],
        ":bind4" => $post['status']
    );

    $alltuples1 = array(
        $tuple1
    );


   
    executeBoundSQL("insert into supplier values (:bind1, :bind2,:bind3,:bind4)", $alltuples1);
    OCICommit($conn);
    

}

// try to remove employee given sin
function removeSupplier($post, $conn)
{

    $tuple = array(
        ":bind1" => $post['phone']
    );

    $alltuples = array(
        $tuple
    );

    executeBoundSQL("DELETE FROM supplier WHERE phone =:bind1", $alltuples);

    OCICommit($conn);

}

function updateSupplier($post, $conn)
{


    if (!(($_POST['newName'])=="")) {
        $tuple = array(
            ":bind1" => $post['phone'],
            ":bind2" => $post['newName']
        );
        $alltuples = array(
            $tuple
        );

        executeBoundSQL("update supplier set name =:bind2 where phone =:bind1", $alltuples);
        OCICommit($conn);
    }


    if (!($post['newAddress']=="")) {
        $tuple = array(
            ":bind1" => $post['phone'],
            ":bind3" => $post['newAddress']
        );
        $alltuples = array(
            $tuple
        );

        executeBoundSQL("update supplier set address =:bind3 where phone =:bind1", $alltuples);
        OCICommit($conn);
    }

    if (!($post['newStatus']=="")) {
        $tuple = array(
            ":bind1" => $post['phone'],
            ":bind4" => $post['newStatus']

        );

        $alltuples = array(
            $tuple
        );

        executeBoundSQL("update supplier set status =:bind4 where phone =:bind1", $alltuples);
        OCICommit($conn);
    }

    

}



function findSupplier($post, $conn)
{

    $alltuples = array();
    $name ='';

    if (!(($post['name'])=="")) {
        $name = $name."lower(supplier.name) like '%".$post['name']."%'" ;

    }



    if (!($post['phone']=="")) {
        if (strlen($name)!=0) {
            $name =$name . "AND " . " supplier.phone=" . $post['phone'];
        }else{
            $name =$name. "supplier.phone=" . $post['phone'];
        }
    }


    if (!($post['address']=="")) {

        if (strlen($name)!=0) {
            $name =$name . "AND " . " lower(supplier.address) like '%".$post['address']."%'" ;
        }else{
            $name =$name. "lower(supplier.address) like '%".$post['address']."%'" ;
        }
    }



    if (!($post['status']=="")) {
        if (strlen($name)!=0) {
            $name =$name . "AND " . "lower(supplier.status) like '%".$post['status']."%'" ;
        }else{
            $name =$name. "lower(supplier.status) like '%".$post['status']."%'" ;
        }
    }

    

    $result = executePlainSQL("SELECT * FROM supplier WHERE ". $name);

    printResult($result);

    OCICommit($conn);


}

// Connect Oracle... check to do which function ===================================================================================================
if ($db_conn) {

    if (array_key_exists('reset', $_POST)) {


        // Drop old table...
        //reset($db_conn);
        // echo "<br> dropping table <br>";
        executePlainSQL("Drop table Supplier");
       
        // Create new table...
        //  echo "<br> creating new table <br>";

        executePlainSQL(
            "CREATE TABLE supplier(
                name VARCHAR(20),
                address VARCHAR(50),
                phone NUMBER(12),
                status VARCHAR(2),
                PRIMARY KEY (phone))");

        executePlainSQL("insert into supplier values ('roy','ubc' ,'222222','t')");

        OCICommit($db_conn);

    } else if (array_key_exists('insertsubmit', $_POST)) {
        //Getting the values from user and insert data into the table


            addSupplier($_POST, $db_conn);

    } else if (array_key_exists('updatesubmit', $_POST)) {

        // Update tuple using data from user
        updateSupplier($_POST, $db_conn);

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

        executeBoundSQL("insert into EMPLOYEE values (:bind1, :bind2,:bind3,:bind4,:bind5)", $allrows); //the function takes a list of lists


        // Select data...
        $result = executePlainSQL("select * from supplier");
        printResult($result);


        OCICommit($db_conn);

    } else if (array_key_exists('removeSupplier', $_POST)) {
        // remove the employee given sin#
        removeSupplier($_POST, $db_conn);
    }else if (array_key_exists('findsubmit', $_POST)){
        findSupplier($_POST,$db_conn);
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
