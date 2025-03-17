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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Event</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>View Event</h1>
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
        <section id="event-details">
            <h2><?php echo htmlspecialchars($event['name']); ?></h2>
            <p>Date: <?php echo htmlspecialchars($event['date']); ?></p>
            <p>Description: <?php echo htmlspecialchars($event['description']); ?></p>
            <h3>Linked Wardrobe Items</h3>
            <ul id="linked-items">
                <?php
                $items = getWardrobeItemsByEventId($eventId);
                foreach ($items as $item): ?>
                    <li><?php echo htmlspecialchars($item['name']); ?> - <?php echo htmlspecialchars($item['type']); ?></li>
                <?php endforeach; ?>
            </ul>
        </section>
    </main>
</body>
</html>
