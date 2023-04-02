<html>
    <head>
        <title>WedUP</title>
        <link rel="stylesheet" href="style.php">
    </head>
    <body>
        <a href="main_page.php" class="side-button">Main Menu</a>
        <h1 style="text-align:center">Weddings</h1>
        <form action="view_weddings.php">
            <input type="hidden" id="selectJoinRequest" name="selectJoinRequest">
            Find all people in specified wedding (Provide Wedding ID):
            <input type="text" name="selectArgument"> <br /><br />

            <input type="submit" value="Submit" name="insertSubmit"></p>
        </form>
        <hr>
        <form action="view_weddings.php">
            <input type="hidden" id="selectGroupByRequest" name="selectGroupByRequest">
            List the number of staff for each wedding:<br /><br />

            <input type="submit" value="Submit" name="insertSubmit"></p>
        </form>
        <hr>
        <form action="view_weddings.php">
            <input type="hidden" id="selectGroupByHavingRequest" name="selectGroupByHavingRequest">
            Find the weddings that have a total hourly cost over (in $):
            <input type="text" name="selectArgument"><br /><br />

            <input type="submit" value="Submit" name="insertSubmit"></p>
        </form>
        <hr>
        <form action="view_weddings.php">
            <input type="hidden" id="selectGroupByNestedRequest" name="selectGroupByNestedRequest">
            Find the weddings that have at least 
            <input type="text" name="selectArgument">
            guests bringing plus ones:
            <br /><br />

            <input type="submit" value="Submit" name="insertSubmit"></p>
        </form>
        <hr>
        <form action="view_weddings.php">
            <input type="hidden" id="divisionRequest" name="divisionRequest">
            Find all staff who worked in all weddings:<br /><br />

            <input type="submit" value="Submit" name="insertSubmit"></p>
        </form>
        <hr>



        <?php


        $success = True; //keep track of errors so it redirects the page only if there are no errors
        $db_conn = NULL; // edit the login credentials in connectToDB()
        $show_debug_alert_messages = False; // set to True if you want alerts to show you which methods are being triggered (see how it is used in debugAlertMessage())

        function debugAlertMessage($message) {
            global $show_debug_alert_messages;

            if ($show_debug_alert_messages) {
                echo "<script type='text/javascript'>alert('" . $message . "');</script>";
            }
        }

        function executePlainSQL($cmdstr) { //takes a plain (no bound variables) SQL command and executes it
            //echo "<br>running ".$cmdstr."<br>";
            global $db_conn, $success;

            $statement = OCIParse($db_conn, $cmdstr);
            //There are a set of comments at the end of the file that describe some of the OCI specific functions and how they work

            if (!$statement) {
                echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
                $e = OCI_Error($db_conn); // For OCIParse errors pass the connection handle
                echo htmlentities($e['message']);
                $success = False;
            }

            $r = OCIExecute($statement, OCI_DEFAULT);
            if (!$r) {
                echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
                $e = oci_error($statement); // For OCIExecute errors pass the statementhandle
                echo htmlentities($e['message']);
                $success = False;
            }

            return $statement;
        }

        function printResult($result) { //prints results from a select statement
            echo "<table>";
            $headers = "";
            $ncols = oci_num_fields($result);
            for ($i = 1; $i <= $ncols; $i++) {
                $column_name  = oci_field_name($result, $i);
                $headers = $headers . "<th>" . $column_name . "</th>";
            }
            $headers = "<tr>" . $headers . "</tr>";
            echo $headers;

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                $tuple = "";
                for ($i = 0; $i < $ncols; $i++) {
                    $tuple = $tuple . "<td>" . $row[$i] . "</td>";
                }
                echo "<tr>" . $tuple . "</tr>";
            }

            echo "</table>";
        }

        function connectToDB() {
            global $db_conn;

            // Your username is ora_(CWL_ID) and the password is a(student number). For example,
            // ora_platypus is the username and a12345678 is the password.
            $db_conn = OCILogon("ora_parkerl6", "a35909605", "dbhost.students.cs.ubc.ca:1522/stu");

            if ($db_conn) {
                debugAlertMessage("Database is Connected");
                return true;
            } else {
                debugAlertMessage("Cannot connect to Database");
                $e = OCI_Error(); // For OCILogon errors pass no handle
                echo htmlentities($e['message']);
                return false;
            }
        }

        function disconnectFromDB() {
            global $db_conn;

            debugAlertMessage("Disconnect from Database");
            OCILogoff($db_conn);
        }

        // selectArgument is a value of same domain as selectCondition (empty if IS (NOT) NULL)
        function handleSelectJoinRequest() {
            global $db_conn;

            if (filter_var($_GET['selectArgument'], FILTER_VALIDATE_INT) == false) {
                print_r("INVALID WEDDING ID. WEDDING IDS ARE NUMBERS.");
                return;
            }

            $union = " UNION ";
            $select = "(SELECT a.FirstName as \"First Name\", a.LastName as \"Last Name\", a.Email as \"Email\"";

            $fromGrooms = " FROM GroomsMarry a, WeddingsBookFor b";
            $whereGrooms = " WHERE a.WeddingNumber = b.WeddingNumber AND b.WeddingNumber =" . $_GET['selectArgument'] . ")";

            $fromBrides = " FROM BridesHolds a, WeddingsBookFor b, GroomsMarry c";
            $whereBrides = " WHERE c.WeddingNumber = b.WeddingNumber AND a.Email=c.BrideEmail AND b.WeddingNumber =" . $_GET['selectArgument'] . ")";

            $fromEntourages = " FROM Entourages a, WeddingsBookFor b, ParticipateIn c";
            $whereEntourages = " WHERE c.WeddingNumber = b.WeddingNumber AND c.EntourageEmail=a.Email AND b.WeddingNumber =" . $_GET['selectArgument'] . ")";

            $fromGuests = " FROM Guests a, WeddingsBookFor b, Attends c";
            $whereGuests = " WHERE c.WeddingNumber = b.WeddingNumber AND c.GuestEmail=a.Email AND b.WeddingNumber =" . $_GET['selectArgument'] . ")";

            $selectPlusOne = "(SELECT a.FirstName as \"First Name\", a.LastName as \"Last Name\", a.PlusOneEmail as \"Email\"";
            $fromPlusOnes = " FROM PlusOnesBring a, WeddingsBookFor b, Attends c, Guests d";
            $wherePlusOnes = " WHERE c.WeddingNumber = b.WeddingNumber AND c.GuestEmail=d.Email AND a.GuestEmail=d.Email AND b.WeddingNumber =" . $_GET['selectArgument'] . ")";

            $fromStaff = " FROM Staff a, WeddingsBookFor b, WorksAt c";
            $whereStaff = " WHERE c.WeddingNumber = b.WeddingNumber AND c.StaffEmail=a.Email AND b.WeddingNumber =" . $_GET['selectArgument'] . ")";
            
            $result = executePlainSQL(
                $select . $fromGrooms . $whereGrooms . 
                $union . 
                $select . $fromBrides. $whereBrides . 
                $union . 
                $select . $fromEntourages. $whereEntourages . 
                $union . 
                $select . $fromGuests. $whereGuests . 
                $union . 
                $selectPlusOne . $fromPlusOnes. $wherePlusOnes . 
                $union . 
                $select . $fromStaff. $whereStaff
            );

            printResult($result);
        }

        function handleSelectGroupByRequest() {
            global $db_conn;

            $select = "SELECT a.WeddingNumber as \"Wedding ID\", COUNT(*) as \"Number of Staff\"";
            $from = " FROM WeddingsBookFor a, Staff b, WorksAt c";
            $where = " WHERE a.WeddingNumber=c.WeddingNumber AND c.StaffEmail=b.Email";
            $groupby = " GROUP BY a.WeddingNumber";

            $result = executePlainSQL($select . $from . $where . $groupby);

            printResult($result);
        }

        function handleSelectGroupByHavingRequest() {
            global $db_conn;

            if (filter_var($_GET['selectArgument'], FILTER_VALIDATE_INT) == false) {
                print_r("INPUT MUST BE A NUMBER.");
                return;
            }

            $select = "SELECT a.WeddingNumber as \"Wedding ID\", SUM(d.HourlyRate) as \"Total Hourly Cost\"";
            $from = " FROM WeddingsBookFor a, Staff b, WorksAt c, StaffHourlyRate d";
            $where = " WHERE a.WeddingNumber=c.WeddingNumber AND c.StaffEmail=b.Email AND d.Company=b.Company";
            $groupby = " GROUP BY a.WeddingNumber";
            $having = " HAVING SUM(d.HourlyRate) > " . $_GET['selectArgument'];

            $result = executePlainSQL($select . $from . $where . $groupby . $having);

            printResult($result);
        }

        function handleSelectGroupByNestedRequest() {
            global $db_conn;

            if (filter_var($_GET['selectArgument'], FILTER_VALIDATE_INT) == false) {
                print_r("INPUT MUST BE A NUMBER.");
                return;
            }

            $select = "SELECT a.WeddingNumber as \"Wedding ID\", COUNT(*) as \"Number of Guests Bringing Plus Ones\"";
            $from = " FROM WeddingsBookFor a, Guests b, Attends c";
            $where = " WHERE a.WeddingNumber=c.WeddingNumber AND c.GuestEmail=b.Email AND b.Email IN (
                SELECT d.GuestEmail FROM PlusOnesBring d
            )";
            $groupby = " GROUP BY a.WeddingNumber";
            $having = " HAVING COUNT(*) >= " . $_GET['selectArgument'];

            $result = executePlainSQL($select . $from . $where . $groupby . $having);

            printResult($result);
        }

        function handleDivision() {
            global $db_conn;

            $select = "SELECT * ";

            $from = " FROM Staff S";
            $where = " WHERE NOT EXISTS ((SELECT *
                FROM Staff)
                MINUS
                (SELECT S.Email, S.Company, S.FirstName, S.LastName
                FROM WeddingsBookFor B, WorksAt W
                WHERE B.WeddingNumber = W.WeddingNumber AND W.StaffEmail = S.Email))";
            
            $result = executePlainSQL($select . $from . $where);

            printResult($result);
        }

        function sanitizeArguments() {
            $attributeStr = $_GET['selectAttributes1'];
            
            if ($_GET['selectAttributes2'] != "" && 
            $_GET['selectAttributes2'] != $_GET['selectAttributes1']) {
                $attributeStr = $attributeStr . "," . $_GET['selectAttributes2'];
            }
            if ($_GET['selectAttributes3'] != "" && 
            $_GET['selectAttributes3'] != $_GET['selectAttributes1'] &&
            $_GET['selectAttributes3'] != $_GET['selectAttributes2']) {
                $attributeStr = $attributeStr . "," . $_GET['selectAttributes3'];
            }
            if ($_GET['selectAttributes4'] != "" && 
            $_GET['selectAttributes4'] != $_GET['selectAttributes1'] &&
            $_GET['selectAttributes4'] != $_GET['selectAttributes2'] &&
            $_GET['selectAttributes4'] != $_GET['selectAttributes3']) {
                $attributeStr = $attributeStr . "," . $_GET['selectAttributes4'];
            }
            $_GET['selectAttributes'] = $attributeStr;
            return true;
        }

        // HANDLE ALL GET ROUTES
        // A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
        function handleGETRequest() {
            if (connectToDB()) {
                if (array_key_exists('selectGroupByRequest', $_GET)) {
                    handleSelectGroupByRequest();
                } else if (array_key_exists('selectJoinRequest', $_GET)) {
                    handleSelectJoinRequest();
                } else if (array_key_exists('divisionRequest', $_GET)) {
                    handleDivision();
                } else if (array_key_exists('selectGroupByHavingRequest', $_GET)) {
                    handleSelectGroupByHavingRequest();
                } else if (array_key_exists('selectGroupByNestedRequest', $_GET)) {
                    handleSelectGroupByNestedRequest();
                }

                disconnectFromDB();
            }
        }

        if (isset($_GET['selectGroupByRequest']) || isset($_GET['selectGroupByNestedRequest']) || isset($_GET['selectGroupByHavingRequest']) || isset($_GET['selectJoinRequest']) || isset($_GET['divisionRequest'])) {
            if (sanitizeArguments()) {
                handleGETRequest();
            }
        }

        ?>
    </body>
</html>