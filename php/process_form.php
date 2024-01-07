<?php
// Replace these variables with your actual RDS details
$host = 'database11.c6xl214voloz.ap-southeast-1.rds.amazonaws.com';
$username = 'admin';
$password = '12345678';
$database = 'database11';

// Create a connection
$conn = new mysqli($host, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$tableExists = false;
$result = $conn->query("SHOW TABLES LIKE '$contact_me'");
if ($result->num_rows > 0) {
    $tableExists = true;
}

// If the table doesn't exist, create it
if (!$tableExists) {
    // SQL statement to create the table
    $sql = "CREATE TABLE $contact_me (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        subject VARCHAR(255) NOT NULL,
        message TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

    // Execute the SQL statement
    if ($conn->query($sql) === TRUE) {
        echo "Table created successfully";
    } else {
        echo "Error creating table: " . $conn->error;
    }
} else {
    echo "Table already exists";
}

// Check if form data is received
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Insert data into the database
    $sql = "INSERT INTO contact_me (name, email, subject, message) VALUES ('$name', '$email', '$subject', '$message')";

    if ($conn->query($sql) === TRUE) {
        echo "Data inserted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the connection
$conn->close();
?>
