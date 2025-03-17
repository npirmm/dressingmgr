<?php
include 'db.php';

if (isset($_GET['id'])) {
    $itemId = $_GET['id'];
    $item = getWardrobeItemById($itemId);
} else {
    // Redirect to the home page if no item ID is provided
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Item</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>View Item</h1>
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
        <section id="item-details">
            <h2><?php echo htmlspecialchars($item['name']); ?></h2>
            <p>Type: <?php echo htmlspecialchars($item['type']); ?></p>
            <p>Color: <?php echo htmlspecialchars($item['color']); ?></p>
            <p>Material: <?php echo htmlspecialchars($item['material']); ?></p>
            <p>Size: <?php echo htmlspecialchars($item['size']); ?></p>
            <h3>Photos</h3>
            <div id="item-photos">
                <?php foreach ($item['photos'] as $photo): ?>
                    <img src="<?php echo htmlspecialchars($photo['photo']); ?>" alt="Item Photo">
                <?php endforeach; ?>
            </div>
            <h3>Linked Events</h3>
            <ul id="linked-events">
                <?php
                $events = getEventsByItemId($itemId);
                foreach ($events as $event): ?>
                    <li><?php echo htmlspecialchars($event['name']); ?> - <?php echo htmlspecialchars($event['date']); ?></li>
                <?php endforeach; ?>
            </ul>
        </section>
    </main>
</body>
</html>
