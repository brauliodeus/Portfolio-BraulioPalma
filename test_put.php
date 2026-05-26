<?php
require 'includes/db.php';
$id = 1;

try {
    $checkStmt = $pdo->prepare("SELECT is_locked FROM projects WHERE id = :id");
    $checkStmt->bindValue(':id', $id);
    $checkStmt->execute();
    $proj = $checkStmt->fetch();

    if ($proj && $proj['is_locked']) {
        echo "LOCKED\n";
    } else {
        echo "NOT LOCKED\n";
    }

    $stmt = $pdo->prepare("UPDATE projects SET title = :title WHERE id = :id");
    $stmt->bindValue(':title', 'Test');
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    echo "OK\n";
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
