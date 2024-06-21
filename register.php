<?php
// Database connection details
$serverName = "serverhello2.database.windows.net"; // replace with your server name
$connectionOptions = array(
    "Database" => "dbname2", // replace with your database name
    "Uid" => "serverhello2", // replace with your username
    "PWD" => "Explore@450450" // replace with your password
);

// Establish the connection
$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get form data and sanitize
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    // Validate form data
    if ($username && $email && $password) {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // SQL query to insert data into the Users table
        $tsql = "INSERT INTO Users (Username, Email, Password) VALUES (?, ?, ?)";
        $params = array($username, $email, $hashedPassword);

        // Execute the query
        $stmt = sqlsrv_query($conn, $tsql, $params);

        // Check for errors in the query execution
        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            echo "Registration successful!";
        }

        // Free statement resources
        sqlsrv_free_stmt($stmt);
    } else {
        echo "Please fill in all fields.";
    }
}

// Close the connection
sqlsrv_close($conn);
?>
