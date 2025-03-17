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
    if (isset($_POST['confirm_delete'])) {
        // Delete the event from the database
        deleteEvent($eventId);

        // Update links between wardrobe items and events
        updateLinksBetweenWardrobeItemsAndEvents($eventId);

        // Redirect to the home page
        header('Location: index.php');
        exit();
    } else {
        // Redirect to the view event page if deletion is not confirmed
        header('Location: view_event.php?id=' . $eventId);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Event</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Delete Event</h1>
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
        <section id="delete-event">
            <h2>Delete Event</h2>
            <p>Are you sure you want to delete the event "<?php echo htmlspecialchars($event['name']); ?>"?</p>
            <form id="delete-event-form" action="delete_event.php?id=<?php echo $eventId; ?>" method="post">
                <button type="submit" name="confirm_delete">Yes, delete</button>
                <a href="view_event.php?id=<?php echo $eventId; ?>">Cancel</a>
            </form>
        </section>
    </main>
</body>
</html>
