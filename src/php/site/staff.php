<html>
    <head>
        <title>WedUP</title>
        <link rel="stylesheet" href="style.php">
    </head>
    <body>
        <form action="staff.php">
            <h3>Wedding Information</h3>
            <label for="wedding">Select wedding to add staff to:</label>
            <select id="wedding" name="wedding" required>
                <option value="Wedding1">Wedding 1</option>
                <option value="Wedding2">Wedding 2</option>
                <option value="Wedding3">Wedding 3</option>
            </select>
            <hr>
            <h3>Staff Information</h3>
            <label for="stafffname">First name:</label>
            <input type="text" id="stafffname" name="stafffname" required>
            <label for="stafflname">Last name:</label>
            <input type="text" id="stafflname" name="stafflname" required><br>
            <label for="staffemail">Email:</label>
            <input type="email" id="staffemail" name="staffemail" required>
            <label for="staffcompany">Company:</label>
            <select id="company" name="company" required>
                <option value="Company1">Company 1</option>
                <option value="Company2">Company 2</option>
                <option value="Company3">Company 3</option>
            </select>
            <hr>
            <input type="submit" value="Submit" name="insertSubmit"></p>
        </form>
    </body>
</html>