<html>
    <head>
        <title>WedUP</title>
        <link rel="stylesheet" href="style.php">
    </head>
    <body>
        <a href="main_page.php" class="side-button">Main Menu</a>
        <form method="POST" action="add_wedding.php">
            <input type="hidden" id="addWeddingRequest" name="addWeddingRequest">
            <h2>Wedding Information</h2>

            <label for="weddingDate">Wedding date:</label>
            <input type="date" name="weddingDate" required></p>
            <label for="weddingVenue">Wedding venue:</label>
            <select name="weddingVenue" required>
                <option value="601 Smithe St">The Orpheum</option>
                <option value="6301 Crescent Rd">UBC Rose Garden</option>
                <option value="5251 Oak St">VanDusen Botanical Garden</option>
                <option value="845 Avison Way">Vancouver Aquarium</option>
                <option value="405 Spray Ave">Fairmont Banff Springs</option>
            </select>
            <hr>
            <h2>Bride Information</h2>
            <label for="brideFirstName">First name:</label>
            <input type="text" name="brideFirstName" required>
            <label for="brideLastName">Last name:</label>
            <input type="text" name="brideLastName" required></p>
            <label for="brideEmail">Email:</label>
            <input type="email" name="brideEmail" required>
            <label for="brideBouquet">Bouquet style:</label>
            <select name="brideBouquet">
                <option value="cascade">Cascade</option>
                <option value="posy">Posy</option>
                <option value="hand-tied">Hand-tied</option>
                <option value="round">Round</option>
                <option value="pomander">Pomander</option>
                <option value="composite">Composite</option>
                <option value="nosegay">Nosegay</option>
            </select>
            <hr>
            <h2>Groom Information</h2>
            <label for="groomFirstName">First name:</label>
            <input type="text" name="groomFirstName" required>
            <label for="groomLastName">Last name:</label>
            <input type="text" name="groomLastName" required></p>
            <label for="groomEmail">Email:</label>
            <input type="email" name="groomEmail" required>
            <hr>
            <h2>Officiant Information</h2>
            <label for="officiantFirstName">First name:</label>
            <input type="text" name="officiantFirstName" required>
            <label for="officiantLastName">Last name:</label>
            <input type="text" name="officiantLastName" required></p>
            <label for="officiantEmail">Email:</label>
            <input type="email" name="officiantEmail" required>
            <label for="officiantCompany">Company:</label>
            <select name="officiantCompany">
                <option value="Casablanca Co.">Casablanca Co.</option>
                <option value="Titanic Studio">Titanic Studio</option>
                <option value="La La Land Ltd.">La La Land Ltd.</option>
                <option value="Paramount">Paramount</option>
                <option value="Forrest Gump and Co.">Forrest Gump and Co.</option>
                <option value="Up Services">LUp Services</option>
            </select>
            <label for="isPriest">Priest:</label>
            <select name="isPriest">
                <option value="yes">Yes</option>
                <option value="no">No</option>
            </select>
            <hr>
            <input type="submit" value="Submit" name="addWedding"></p>
        </form>
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
        function executeBoundSQL($cmdstr, $list) {
        /* Sometimes the same statement will be executed several times with different values for the variables involved in the query.
        In this case you don't need to create the statement several times. Bound variables cause a statement to only be
        parsed once and you can reuse the statement. This is also very useful in protecting against SQL injection.
        See the sample code below for how this function is used */

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
                    $e = OCI_Error($statement); // For OCIExecute errors, pass the statementhandle
                    echo htmlentities($e['message']);
                    echo "<br>";
                    $success = False;
                }
            }
        }

        // HANDLE ALL POST ROUTES
        // A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
        function handlePOSTRequest() {
            if (connectToDB()) {
                if (array_key_exists('addWeddingRequest', $_POST)) {
                    handleAddWedding();
                } else if (array_key_exists('resetTablesRequest', $_POST)) {
                    handleResetRequest();
                } else if (array_key_exists('updateQueryRequest', $_POST)) {
                    handleUpdateRequest();
                } else if (array_key_exists('insertWeddingBookRequest', $_POST)) {
                    handleInsertWeddingBook();
                } else if (array_key_exists('deleteQueryRequest', $_POST)) {
                    handleDeleteRequest();
                } else if (array_key_exists('insertGuestsRequest', $_POST)) {
                    handleInsertGuests();
                } else if (array_key_exists('insertGroomsMarryRequest', $_POST)) {
                    handleInsertGroomsMarry();
                } else if (array_key_exists('insertBridesHoldsRequest', $_POST)) {
                    handleInsertBridesHolds();
                } else if (array_key_exists('insertPlusOnesBringRequest', $_POST)) {
                    handleInsertPlusOnesBring();
                } 
                
                disconnectFromDB();
            }
        }

        if (isset($_POST['reset']) || isset($_POST['updateSubmit']) || isset($_POST['addWedding']) || isset($_POST['deleteSubmit']) || isset($_POST['insertGuest']) || isset($_POST['insertPlusOnesBring'])) {
            handlePOSTRequest();
        } else if (isset($_GET['countTupleRequest']) || isset($_GET['selectRequest'])) {
            handleGETRequest();
        }

        function handleAddWedding() {
            global $db_conn;

            $tuple = array (
                ":bind1" => null,
				":bind2" => $_POST['weddingVenue'],
				":bind3" => $_POST["weddingDate"]
            );
            $alltuples = array (
                $tuple
            );
            executeBoundSQL("INSERT into WeddingsBookFor values (:bind1, :bind2, TO_DATE(:bind3, 'YYYY-MM-DD'))", $alltuples);
            OCICommit($db_conn);

            $tuple = array (
                ":bind1" => $_POST['brideEmail'],
                ":bind2" => $_POST['brideFirstName'],
				":bind3" => $_POST['brideLastName'],
				":bind4" => $_POST['brideBouquet']
            );
            $alltuples = array (
                $tuple
            );
            executeBoundSQL("insert into BridesHolds values (:bind1, :bind2, :bind3, :bind4)", $alltuples);
            OCICommit($db_conn);

            $result = executePlainSQL("SELECT max(WeddingNumber) FROM WeddingsBookFor");
            $row = OCI_Fetch_Array($result, OCI_BOTH);
            $tuple = array (
                ":bind1" => $_POST['groomEmail'],
                ":bind2" => $_POST['groomFirstName'],
				":bind3" => $_POST['groomLastName'],
				":bind4" => $_POST['brideEmail'],
				":bind5" => $row[0]
            );
            $alltuples = array (
                $tuple
            );
            executeBoundSQL("insert into GroomsMarry values (:bind1, :bind2, :bind3, :bind4, :bind5)", $alltuples);

            $tuple = array (
                ":bind1" => $_POST['officiantEmail'],
                ":bind2" => $_POST['officiantCompany'],
				":bind3" => $_POST['officiantFirstName'],
				":bind4" => $_POST['officiantLastName']
            );
            $alltuples = array (
                $tuple
            );
            executeBoundSQL("insert into Staff values (:bind1, :bind2, :bind3, :bind4)", $alltuples);
            OCICommit($db_conn);

            echo '<script>alert("Successfully added!")</script>';
        }
        ?>
    </body>
</html>