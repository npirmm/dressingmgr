<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $criteria = $_POST['criteria'];
    $items = searchWardrobeItems($criteria);
    echo json_encode(['items' => $items]);
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Wardrobe Items</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Search Wardrobe Items</h1>
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
        <section id="search">
            <h2>Search for Wardrobe Items</h2>
            <form id="search-form" action="search.php" method="post">
                <label for="criteria">Search Criteria:</label>
                <input type="text" id="criteria" name="criteria" required>
                <button type="submit">Search</button>
            </form>
            <ul id="search-results">
                <!-- Search results will be displayed here -->
            </ul>
        </section>
    </main>
    <script>
        document.getElementById('search-form').addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(this);
            fetch('search.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                const searchResults = document.getElementById('search-results');
                searchResults.innerHTML = '';
                data.items.forEach(item => {
                    const listItem = document.createElement('li');
                    listItem.textContent = `${item.name} - ${item.type} - ${item.color} - ${item.material} - ${item.size}`;
                    searchResults.appendChild(listItem);
                });
            })
            .catch(error => console.error('Error:', error));
        });
    </script>
</body>
</html>
<?php
}
?>
