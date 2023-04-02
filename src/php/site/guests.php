<html>
    <head>
        <title>WedUP</title>
        <link rel="stylesheet" href="style.php">
    </head>
    <body>
        <a href="main_page.php" class="side-button">Main Menu</a>
        <form action="guests.php">
            <h2>Wedding Information</h2>
            <label for="wedding">Select wedding to add guest to:</label>
            <select id="wedding" name="wedding" required>
                <option value="Wedding1">Wedding 1</option>
                <option value="Wedding2">Wedding 2</option>
                <option value="Wedding3">Wedding 3</option>
            </select>
            <hr>
            <h2>Guest Information</h2>
            <label for="guestfname">First name:</label>
            <input type="text" id="guestfname" name="guestfname" required>
            <label for="guestlname">Last name:</label>
            <input type="text" id="guestlname" name="guestlname" required></p>
            <label for="guestemail">Email:</label>
            <input type="email" id="guestemail" name="guestemail" required>
            <hr>
            <h2>Plus-One Information (Optional)</h2>
            <label for="plusonefname">First name:</label>
            <input type="text" id="plusonefname" name="plusonefname">
            <label for="plusonelname">Last name:</label>
            <input type="text" id="plusonelname" name="plusonelname"></p>
            <label for="plusoneemail">Email:</label>
            <input type="email" id="plusoneemail" name="plusoneemail">
            <hr>
            <input type="submit" value="Submit" name="insertSubmit"></p>
        </form>
    </body>
</html>