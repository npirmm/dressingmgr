<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "wardrobe_manager";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to add a new wardrobe item
function addWardrobeItem($name, $type, $color, $material, $size, $photos) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO wardrobe_items (name, type, color, material, size) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $type, $color, $material, $size);
    $stmt->execute();
    $itemId = $stmt->insert_id;
    $stmt->close();

    foreach ($photos as $photo) {
        $stmt = $conn->prepare("INSERT INTO item_photos (item_id, photo) VALUES (?, ?)");
        $stmt->bind_param("is", $itemId, $photo);
        $stmt->execute();
        $stmt->close();
    }
}

// Function to get all wardrobe items
function getWardrobeItems() {
    global $conn;
    $result = $conn->query("SELECT * FROM wardrobe_items");
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Function to get a wardrobe item by ID
function getWardrobeItemById($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM wardrobe_items WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $item = $result->fetch_assoc();
    $stmt->close();

    $stmt = $conn->prepare("SELECT * FROM item_photos WHERE item_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $item['photos'] = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    return $item;
}

// Function to update a wardrobe item
function updateWardrobeItem($id, $name, $type, $color, $material, $size, $photos) {
    global $conn;
    $stmt = $conn->prepare("UPDATE wardrobe_items SET name = ?, type = ?, color = ?, material = ?, size = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $name, $type, $color, $material, $size, $id);
    $stmt->execute();
    $stmt->close();

    $stmt = $conn->prepare("DELETE FROM item_photos WHERE item_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    foreach ($photos as $photo) {
        $stmt = $conn->prepare("INSERT INTO item_photos (item_id, photo) VALUES (?, ?)");
        $stmt->bind_param("is", $id, $photo);
        $stmt->execute();
        $stmt->close();
    }
}

// Function to delete a wardrobe item
function deleteWardrobeItem($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM wardrobe_items WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    $stmt = $conn->prepare("DELETE FROM item_photos WHERE item_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

// Function to add a new event
function addEvent($name, $date, $description) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO events (name, date, description) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $date, $description);
    $stmt->execute();
    $stmt->close();
}

// Function to get all events
function getEvents() {
    global $conn;
    $result = $conn->query("SELECT * FROM events");
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Function to get an event by ID
function getEventById($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM events WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $event = $result->fetch_assoc();
    $stmt->close();

    return $event;
}

// Function to update an event
function updateEvent($id, $name, $date, $description) {
    global $conn;
    $stmt = $conn->prepare("UPDATE events SET name = ?, date = ?, description = ? WHERE id = ?");
    $stmt->bind_param("sssi", $name, $date, $description, $id);
    $stmt->execute();
    $stmt->close();
}

// Function to delete an event
function deleteEvent($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM events WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

// Function to search wardrobe items based on criteria
function searchWardrobeItems($criteria) {
    global $conn;
    $query = "SELECT * FROM wardrobe_items WHERE name LIKE ? OR type LIKE ? OR color LIKE ? OR material LIKE ? OR size LIKE ?";
    $stmt = $conn->prepare($query);
    $criteria = "%$criteria%";
    $stmt->bind_param("sssss", $criteria, $criteria, $criteria, $criteria, $criteria);
    $stmt->execute();
    $result = $stmt->get_result();
    $items = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    return $items;
}
?>
