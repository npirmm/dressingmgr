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
    $name = $_POST['item_name'];
    $type = $_POST['item_type'];
    $color = $_POST['item_color'];
    $material = $_POST['item_material'];
    $size = $_POST['item_size'];
    $photos = [];

    // Handle file uploads
    foreach ($_FILES['item_photos']['tmp_name'] as $key => $tmp_name) {
        $file_name = $_FILES['item_photos']['name'][$key];
        $file_tmp = $_FILES['item_photos']['tmp_name'][$key];
        $file_type = $_FILES['item_photos']['type'][$key];
        $file_ext = strtolower(end(explode('.', $_FILES['item_photos']['name'][$key])));

        $extensions = array("jpeg", "jpg", "png");

        if (in_array($file_ext, $extensions) === false) {
            $errors[] = "Extension not allowed, please choose a JPEG or PNG file.";
        }

        if (empty($errors) == true) {
            move_uploaded_file($file_tmp, "photos/" . $file_name);
            $photos[] = "photos/" . $file_name;
        } else {
            print_r($errors);
        }
    }

    // Update the wardrobe item in the database
    updateWardrobeItem($itemId, $name, $type, $color, $material, $size, $photos);

    // Redirect to the home page
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Item</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Edit Item</h1>
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
        <section id="edit-item">
            <h2>Edit Item</h2>
            <form id="edit-item-form" action="edit_item.php?id=<?php echo $itemId; ?>" method="post" enctype="multipart/form-data">
                <label for="item-name">Item Name:</label>
                <input type="text" id="item-name" name="item_name" value="<?php echo htmlspecialchars($item['name']); ?>" required>
                
                <label for="item-type">Item Type:</label>
                <select id="item-type" name="item_type" required>
                    <option value="clothing" <?php if ($item['type'] == 'clothing') echo 'selected'; ?>>Clothing</option>
                    <option value="shoes" <?php if ($item['type'] == 'shoes') echo 'selected'; ?>>Shoes</option>
                    <option value="accessories" <?php if ($item['type'] == 'accessories') echo 'selected'; ?>>Accessories</option>
                    <option value="jewelry" <?php if ($item['type'] == 'jewelry') echo 'selected'; ?>>Jewelry</option>
                </select>
                
                <label for="item-color">Color:</label>
                <input type="text" id="item-color" name="item_color" value="<?php echo htmlspecialchars($item['color']); ?>" required>
                
                <label for="item-material">Material:</label>
                <input type="text" id="item-material" name="item_material" value="<?php echo htmlspecialchars($item['material']); ?>" required>
                
                <label for="item-size">Size:</label>
                <input type="text" id="item-size" name="item_size" value="<?php echo htmlspecialchars($item['size']); ?>" required>
                
                <label for="item-photos">Photos:</label>
                <input type="file" id="item-photos" name="item_photos[]" multiple>
                
                <button type="submit">Update Item</button>
            </form>
        </section>
    </main>
</body>
</html>
