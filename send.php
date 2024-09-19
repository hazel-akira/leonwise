<?php
// Include database connection
include('db_connection.php'); // Ensure you have this file with proper DB connection setup

// Infobip API credentials
$api_key = 'e152bd47fcf95ad1beb21b7790004959-7e155db6-f2ed-4ba9-b359-7d75802e3958'; // Replace with your actual Infobip API key
$infobip_url = 'https://jjdmq4.api.infobip.com'; // Replace with the actual Infobip URL for SMS

// Current date
$current_date = date('Y-m-d');

// Get tomorrow's date for sending reminders a day before the event
$tomorrow = date('Y-m-d', strtotime($current_date . ' +1 day'));

// Fetch events scheduled for tomorrow and the members registered for those events
$query = "SELECT members.phone, events.event_name, events.event_date 
          FROM members 
          JOIN registrations ON members.id = registrations.member_id
          JOIN events ON events.id = registrations.event_id
          WHERE events.event_date = '$tomorrow'";

$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $phone = $row['phone'];  // Member's phone number
        $event_name = $row['event_name'];  // Event name
        $event_date = $row['event_date'];  // Event date

        // SMS message content
        $message = "Reminder: You have registered for the event '$event_name' happening on $event_date. Please don't forget!";

        // Prepare data for Infobip API
        $data = array(
            'from' => 'ChurchEvent',
            'to' => $phone,
            'text' => $message
        );

        // Send SMS using Infobip API
        $options = array(
            'http' => array(
                'header'  => "Content-Type: application/json\r\n" .
                             "Authorization: App $api_key\r\n",
                'method'  => 'POST',
                'content' => json_encode($data),
            ),
        );

        $context = stream_context_create($options);
        $result = file_get_contents($infobip_url, false, $context);

        // Check if SMS was successfully sent
        if ($result === FALSE) {
            echo "Failed to send SMS to $phone.\n";
        } else {
            echo "SMS reminder sent to $phone for event '$event_name'.\n";
        }
    }
} else {
    echo "No events scheduled for tomorrow.\n";
}

?>
