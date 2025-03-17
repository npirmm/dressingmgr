document.addEventListener('DOMContentLoaded', () => {
    const addItemForm = document.getElementById('add-item-form');
    const itemList = document.getElementById('item-list');
    const searchForm = document.getElementById('search-form');

    // Handle form submission and validation
    addItemForm.addEventListener('submit', (event) => {
        event.preventDefault();
        const formData = new FormData(addItemForm);
        fetch('add_item.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                addItemForm.reset();
                updateItemList();
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    });

    // Display and update the list of wardrobe items
    function updateItemList() {
        fetch('get_items.php')
        .then(response => response.json())
        .then(data => {
            itemList.innerHTML = '';
            data.items.forEach(item => {
                const listItem = document.createElement('li');
                listItem.textContent = `${item.name} - ${item.type} - ${item.color} - ${item.material} - ${item.size}`;
                itemList.appendChild(listItem);
            });
        })
        .catch(error => console.error('Error:', error));
    }

    // Handle searching for wardrobe items based on criteria
    searchForm.addEventListener('submit', (event) => {
        event.preventDefault();
        const formData = new FormData(searchForm);
        fetch('search.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            itemList.innerHTML = '';
            data.items.forEach(item => {
                const listItem = document.createElement('li');
                listItem.textContent = `${item.name} - ${item.type} - ${item.color} - ${item.material} - ${item.size}`;
                itemList.appendChild(listItem);
            });
        })
        .catch(error => console.error('Error:', error));
    });

    // Handle linking wardrobe items to events
    function linkItemToEvent(itemId, eventId) {
        fetch('link_item_event.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ item_id: itemId, event_id: eventId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Item linked to event successfully');
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    }

    // Initial update of the item list
    updateItemList();
});
