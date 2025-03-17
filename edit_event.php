<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Edit Event</h1>
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
        <section id="edit-event">
            <h2>Edit Event</h2>
            <form id="edit-event-form" action="edit_event.php?id=<?php echo $eventId; ?>" method="post">
                <label for="event-name">Event Name:</label>
                <input type="text" id="event-name" name="event_name" value="<?php echo htmlspecialchars($event['name']); ?>" required>
                
                <label for="event-date">Event Date:</label>
                <input type="date" id="event-date" name="event_date" value="<?php echo htmlspecialchars($event['date']); ?>" required>
                
                <label for="event-description">Event Description:</label>
                <textarea id="event-description" name="event_description" required><?php echo htmlspecialchars($event['description']); ?></textarea>
                
                <button type="submit">Update Event</button>
            </form>
        </section>
    </main>
</body>
</html>

<?php
include 'db.php';

if (isset($_GET['id'])) {
    $eventId = $_GET['id'];
    $event = getEventById($eventId);
} else {
    // Redirect to the home page if no event ID is provided
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $eventName = $_POST['event_name'];
    $eventDate = $_POST['event_date'];
    $eventDescription = $_POST['event_description'];

    if (empty($eventName) || empty($eventDate) || empty($eventDescription)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit;
    }

    // Update the event in the database
    updateEvent($eventId, $eventName, $eventDate, $eventDescription);

    // Redirect to the view event page
    header('Location: view_event.php?id=' . $eventId);
    exit();
}
?>
