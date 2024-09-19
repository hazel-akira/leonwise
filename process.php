<?php
    use Infobip\Configuration;
    use Infobip\Api\SmsApi;
    use Infobip\Model\SmsDestination;
    use Infobip\Model\SmsTextualMessage;
    use Infobip\Model\SmsAdvancedTextualRequest;
    
    require __DIR__ . "/vendor/autoload.php";
    
    // Capture form data
    $name = $_POST["name"];
    $phone = $_POST["phone"];
    $event = $_POST["event"];
    
    // Infobip API configuration
    $apiURL = "https://jjdmq4.api.infobip.com"; // Add 'https://'
    $apiKey = "e152bd47fcf95ad1beb21b7790004959-7e155db6-f2ed-4ba9-b359-7d75802e3958";
    
    $configuration = new Configuration(host: $apiURL, apiKey: $apiKey);
    $api = new SmsApi($configuration);
    
    // Define event names
    $eventNames = [
        '1' => 'Church Festival',
        '2' => 'Christmas Eve',
        '3' => 'New Year\'s Service',
        '4' => 'Easter Sunday'
    ];
    
    // Retrieve selected event name
    $eventName = isset($eventNames[$event]) ? $eventNames[$event] : 'Event';
    
    // Prepare message
    $destination = new SmsDestination(to: $phone);
    $messageText = "Hello $name, you have successfully registered for the $eventName at FBCK Church.";
    $smsMessage = new SmsTextualMessage(
        destinations: [$destination],
        text: $messageText,
        from: "FBCK Church"
    );
    
    // Send SMS
    try {
        $api->sendSmsMessage(new SmsAdvancedTextualRequest(messages: [$smsMessage]));
        echo "SMS sent successfully!";
    } catch (Exception $e) {
        echo "Error sending SMS: " . $e->getMessage();
    }

/*send SMS Message
$request = new SmsAdvancedTextualRequest(messages:[$theMessage]);
$response=$api ->sendSmsMessage($request);
echo "sms message sent";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['name']) && !empty($_POST['phone']) && !empty($_POST['event'])) {
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $event_id = $_POST['event'];

        // Fetch event name based on event_id
        $sql = "SELECT event_name FROM events WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $event_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $event = $result->fetch_assoc();
        $stmt->close();

        if ($event) {
            $event_name = $event['event_name'];

            // Insert the registration details into the database
            $stmt = $conn->prepare("INSERT INTO registrations (name, phone, event_name) VALUES (?, ?, ?)");
            $stmt->bind_param("sis", $name, $phone, $event_name);
            if ($stmt->execute()) {
                sendSMSReminder($phone, $event_name); // Send SMS reminder
                echo "Successfully registered!";
            } else {
                echo "Registration failed: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Invalid event selected.";
        }
    } else {
        echo "Required fields are missing.";
    }
}

$conn->close();

function sendSMSReminder($phone, $event_name) {
    $apiKey = 'e152bd47fcf95ad1beb21b7790004959-7e155db6-f2ed-4ba9-b359-7d75802e3958'; // Infobip API key
    $infobipUrl = 'https://jjdmq4.api.infobip.com'; //  Infobip SMS API URL

    // Prepare SMS message
    $data = array(
        'messages' => array(
            array(
                'from' => 'YourChurch',
                'destinations' => array(
                    array('to' => $phone)
                ),
                'text' => "Reminder: You have registered for $event_name. See you there!"
            )
        )
    );

    $options = array(
        'http' => array(
            'header'  => "Content-Type: application/json\r\nAuthorization: App $apiKey",
            'method'  => 'POST',
            'content' => json_encode($data),
        )
    );

    $context  = stream_context_create($options);
    $result = file_get_contents($infobipUrl, false, $context);

    if ($result === FALSE) {
        echo "SMS sending failed.";
    } else {
        echo "SMS sent successfully.";
    }
}*/
?>
