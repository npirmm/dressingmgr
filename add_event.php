<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Event</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Add Event</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="add_item.php">Add Item</a></li>
                <li><a href="search.php">Search</a></li>
                <li><a href="add_event.php">Add Event</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section id="add-event">
            <h2>Add New Event</h2>
            <form id="add-event-form" action="add_event.php" method="post">
                <label for="event-name">Event Name:</label>
                <input type="text" id="event-name" name="event_name" required>
                
                <label for="event-date">Event Date:</label>
                <input type="date" id="event-date" name="event_date" required>
                
                <label for="event-description">Event Description:</label>
                <textarea id="event-description" name="event_description" required></textarea>
                
                <button type="submit">Add Event</button>
            </form>
        </section>
    </main>
</body>
</html>

<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eventName = $_POST['event_name'];
    $eventDate = $_POST['event_date'];
    $eventDescription = $_POST['event_description'];

    if (empty($eventName) || empty($eventDate) || empty($eventDescription)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit;
    }

    addEvent($eventName, $eventDate, $eventDescription);
    echo json_encode(['success' => true, 'message' => 'Event added successfully.']);
}
?>
