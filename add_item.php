<?php
include 'db.php';

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

    // Add the new wardrobe item to the database
    addWardrobeItem($name, $type, $color, $material, $size, $photos);

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
    <title>Add New Item</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Add New Item</h1>
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
        <section id="add-item">
            <h2>Add New Item</h2>
            <form id="add-item-form" action="add_item.php" method="post" enctype="multipart/form-data">
                <label for="item-name">Item Name:</label>
                <input type="text" id="item-name" name="item_name" required>
                
                <label for="item-type">Item Type:</label>
                <select id="item-type" name="item_type" required>
                    <option value="clothing">Clothing</option>
                    <option value="shoes">Shoes</option>
                    <option value="accessories">Accessories</option>
                    <option value="jewelry">Jewelry</option>
                </select>
                
                <label for="item-color">Color:</label>
                <input type="text" id="item-color" name="item_color" required>
                
                <label for="item-material">Material:</label>
                <input type="text" id="item-material" name="item_material" required>
                
                <label for="item-size">Size:</label>
                <input type="text" id="item-size" name="item_size" required>
                
                <label for="item-photos">Photos:</label>
                <input type="file" id="item-photos" name="item_photos[]" multiple required>
                
                <button type="submit">Add Item</button>
            </form>
        </section>
    </main>
</body>
</html>
