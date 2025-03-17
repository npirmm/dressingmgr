<?php
// Define user roles and permissions
$roles = [
    'admin' => [
        'add_item',
        'edit_item',
        'delete_item',
        'view_item',
        'add_event',
        'edit_event',
        'delete_event',
        'view_event',
        'search_items',
        'manage_permissions'
    ],
    'user' => [
        'add_item',
        'edit_item',
        'view_item',
        'add_event',
        'view_event',
        'search_items'
    ],
    'guest' => [
        'view_item',
        'view_event',
        'search_items'
    ]
];

// Check user permissions
function checkPermission($role, $permission) {
    global $roles;
    return in_array($permission, $roles[$role]);
}

// Handle errors and display appropriate messages
function handleError($message) {
    echo json_encode(['success' => false, 'message' => $message]);
    exit;
}

// Manage user roles and permissions
function managePermissions($action, $role, $permission = null) {
    global $roles;

    switch ($action) {
        case 'add_permission':
            if (!in_array($permission, $roles[$role])) {
                $roles[$role][] = $permission;
            }
            break;
        case 'remove_permission':
            if (($key = array_search($permission, $roles[$role])) !== false) {
                unset($roles[$role][$key]);
            }
            break;
        case 'create_role':
            if (!isset($roles[$role])) {
                $roles[$role] = [];
            }
            break;
        case 'delete_role':
            if (isset($roles[$role])) {
                unset($roles[$role]);
            }
            break;
        default:
            handleError('Invalid action.');
    }
}
?>
