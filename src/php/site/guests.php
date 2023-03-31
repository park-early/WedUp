<html>
    <head>
        <title>WedUP</title>
        <link rel="stylesheet" href="style.php">
    </head>
    <body>
        <form action="guests.php">
            <h3>Wedding Information</h3>
            <label for="wedding">Select wedding to add guest to:</label>
            <select id="wedding" name="wedding" required>
                <option value="Wedding1">Wedding 1</option>
                <option value="Wedding2">Wedding 2</option>
                <option value="Wedding3">Wedding 3</option>
            </select>
            <hr>
            <h3>Guest Information</h3>
            <label for="guestfname">First name:</label>
            <input type="text" id="guestfname" name="guestfname" required>
            <label for="guestlname">Last name:</label>
            <input type="text" id="guestlname" name="guestlname" required><br>
            <label for="guestemail">Email:</label>
            <input type="email" id="guestemail" name="guestemail" required>
            <hr>
            <h3>Plus-One Information (Optional)</h3>
            <label for="plusonefname">First name:</label>
            <input type="text" id="plusonefname" name="plusonefname">
            <label for="plusonelname">Last name:</label>
            <input type="text" id="plusonelname" name="plusonelname"><br>
            <label for="plusoneemail">Email:</label>
            <input type="email" id="plusoneemail" name="plusoneemail">
            <hr>
            <input type="submit" value="Submit" name="insertSubmit"></p>
        </form>
    </body>
</html>