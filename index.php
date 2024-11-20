<?php
    // Include the database connection script
    include('databaseconn.php');

    $sql = "SELECT id, name, email FROM users";

    // Check if the connection is still open
    if ($conn) {
        $result = $conn->query($sql);

        // Check if there are any results
        if ($result->num_rows > 0) {
            // Output data for each row
            $users = [];
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
            $result->free();  // Free result set
        } else {
            $users = [];
        }
    } else {
        die("Database connection failed.");
    }

    // Close the database connection after the query is complete
    // $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Data Table</title>
</head>
<body>
    <h1>User Data</h1>

    <!-- Table to display users from the database -->
    <h2>Users List</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <?php
                if (count($users) > 0) {
                    foreach ($users as $user) {
                        echo "<tr>
                                <td>" . $user["id"] . "</td>
                                <td>" . $user["name"] . "</td>
                                <td>" . $user["email"] . "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No results found</td></tr>";
                }
            ?>
        </tbody>
    </table>

    <!-- Form to add new users -->
    <h2>Add New User</h2>
    <form action="index.php" method="POST">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <input type="submit" value="Add User">
    </form>

    <?php
    // Process the form when it is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Collect and sanitize form data
        $name = htmlspecialchars($_POST['name']);
        $email = htmlspecialchars($_POST['email']);

        // Re-establish the database connection
        include('databaseconn.php');

        // SQL query to insert the new user into the database
        $sql = "INSERT INTO users (name, email) VALUES ('$name', '$email')";

        // Execute the query
        if ($conn->query($sql) === TRUE) {
            echo "<p>New user added successfully. <a href='index.php'>Refresh to see the changes</a></p>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Close the database connection after form processing
        $conn->close();
    }
    ?>
</body>
</html>
