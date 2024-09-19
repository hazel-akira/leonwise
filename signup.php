<?php



/*
include 'connect.php';

// Retrieve form data
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

// SQL query to insert data into the database
$sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";

// Execute the query
if ($conn->query($sql) === TRUE) {\ZN
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close connection
$conn->close();

*/

// signup.php

// Database connection credentials
$host = 'localhost';  // Replace with your host
$dbname = 'church_db';  // Replace with your database name
$username = 'root';  // Replace with your MySQL username
$password = '';  // Replace with your MySQL password

// Create a connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirmPassword']);

    // Validate inputs
    if (empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
        echo "All fields are required!";
    } elseif ($password !== $confirmPassword) {
        echo "Passwords do not match!";
    } else {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // SQL query to insert data
        $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashedPassword')";

        if ($conn->query($sql) === TRUE) {
            echo "Registration successful!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();



// Database connection credentials
$host = 'localhost';  //  hostname
$dbname = 'church_db';  //  database name
$dbUsername = 'root';  //  MySQL username
$dbPassword = '';  //  MySQL password

// Infobip API credentials
$infobipApiKey = 'e152bd47fcf95ad1beb21b7790004959-7e155db6-f2ed-4ba9-b359-7d75802e3958';  //  Infobip API key
$infobipBaseUrl = 'https://jjdmq4.api.infobip.com';  //  Infobip base URL
$sender = 'ChurchApp';  // Sender name for the SMS

// Create a connection
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirmPassword']);

    // Validate inputs
    if (empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
        echo "All fields are required!";
    } elseif ($password !== $confirmPassword) {
        echo "Passwords do not match!";
    } else {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // SQL query to insert data
        $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashedPassword')";

        if ($conn->query($sql) === TRUE) {
            echo "Registration successful!";

            // Prepare to send SMS
            $message = 'Hello ' . $username . ', welcome to the church community!';
            $recipientPhone = '0743385942';  // Replace with the user's phone number

            // Send SMS using Infobip
            $smsData = [
                'from' => $sender,
                'to' => $recipientPhone,
                'text' => $message,
            ];

            // cURL to send SMS
            $ch = curl_init($infobipBaseUrl . '/sms/2/text/advanced');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: App ' . $infobipApiKey,
                'Content-Type: application/json',
                'Accept: application/json'
            ]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['messages' => [$smsData]]));

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            if ($httpCode == 200) {
                echo " SMS sent successfully!";
            } else {
                echo "Failed to send SMS: " . curl_error($ch);
            }

            curl_close($ch);
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>
