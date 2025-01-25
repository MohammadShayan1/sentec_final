<?php
include 'db_connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $delete_query = "DELETE FROM team_members WHERE id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: manage_team.php?success=Member deleted successfully");
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
} else {
    header("Location: manage_team.php?error=Invalid request");
}
?>
