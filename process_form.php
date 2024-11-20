<?php
// process_form.php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include the database connection
    include('databaseconn.php');

    // Collect and sanitize form data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);

    // SQL query to insert the new user into the database
    $sql = "INSERT INTO users (name, email) VALUES ('$name', '$email')";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully. <a href='index.html'>Go back to the table</a>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>
