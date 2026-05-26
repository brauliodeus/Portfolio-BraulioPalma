<?php
require 'includes/db.php';
$data = json_decode('{"id": 1, "is_locked": 0}');
if (!empty($data->id) && isset($data->is_locked)) {
    echo "PATCH validation passed.\n";
} else {
    echo "PATCH validation failed!\n";
}
