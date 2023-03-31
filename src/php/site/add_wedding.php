<html>
    <head>
        <title>WedUP</title>
        <link rel="stylesheet" href="style.php">
    </head>
    <body>
        <a href="main_page.php" class="side-button">Main Menu</a>
        <form action="add_wedding.php">
            <h2>Wedding Information</h2>
            <label for="date">Wedding date:</label>
            <input type="date" id="wedding" name="wedding" required><br>
            <label for="venue">Wedding venue:</label>
            <select id="venue" name="venue" required>
                <option value="Venue1">Venue 1</option>
                <option value="Venue2">Venue 2</option>
                <option value="Venue3">Venue 3</option>
            </select>
            <hr>
            <h2>Bride Information</h2>
            <label for="bridefname">First name:</label>
            <input type="text" id="bridefname" name="bridefname" required>
            <label for="bridelname">Last name:</label>
            <input type="text" id="bridelname" name="bridelname" required><br>
            <label for="brideemail">Email:</label>
            <input type="email" id="brideemail" name="brideemail" required>
            <hr>
            <h2>Groom Information</h2>
            <label for="groomfname">First name:</label>
            <input type="text" id="groomfname" name="groomfname" required>
            <label for="groomlname">Last name:</label>
            <input type="text" id="groomlname" name="groomlname" required><br>
            <label for="groomemail">Email:</label>
            <input type="email" id="groomemail" name="groomemail" required>
            <hr>
            <h2>Officiant Information</h2>
            <label for="officiantfname">First name:</label>
            <input type="text" id="officiantfname" name="officiantfname" required>
            <label for="officiantlname">Last name:</label>
            <input type="text" id="officiantlname" name="officiantlname" required><br>
            <label for="officiantemail">Email:</label>
            <input type="email" id="officiantemail" name="officiantmail" required></p>
            <hr>
            <input type="submit" value="Submit" name="insertSubmit"></p>
        </form>
    </body>
</html>