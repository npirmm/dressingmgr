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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['confirm']) && $_POST['confirm'] == 'yes') {
        // Delete the wardrobe item from the database
        deleteWardrobeItem($itemId);

        // Redirect to the home page
        header('Location: index.php');
        exit();
    } else {
        // Redirect to the home page if deletion is not confirmed
        header('Location: index.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Item</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Delete Item</h1>
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
        <section id="delete-item">
            <h2>Are you sure you want to delete this item?</h2>
            <p>Item Name: <?php echo htmlspecialchars($item['name']); ?></p>
            <p>Type: <?php echo htmlspecialchars($item['type']); ?></p>
            <p>Color: <?php echo htmlspecialchars($item['color']); ?></p>
            <p>Material: <?php echo htmlspecialchars($item['material']); ?></p>
            <p>Size: <?php echo htmlspecialchars($item['size']); ?></p>
            <form id="delete-item-form" action="delete_item.php?id=<?php echo $itemId; ?>" method="post">
                <button type="submit" name="confirm" value="yes">Yes, delete it</button>
                <button type="submit" name="confirm" value="no">No, keep it</button>
            </form>
        </section>
    </main>
</body>
</html>
