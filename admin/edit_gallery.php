<?php
include 'db_connection.php';

$id = $_GET['id'] ?? 0;
$query = "SELECT * FROM gallery WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$gallery_item = $result->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $group_title = $_POST['group_title'];
    $description = $_POST['description'];

    $update_query = "UPDATE gallery SET group_title = ?, description = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("ssi", $group_title, $description, $id);
    
    if ($stmt->execute()) {
        header("Location: manage_gallery.php");
    }
}
?>

<?php include 'header.php'; ?>

<div class="container mt-4">
    <h2>Edit Gallery Item</h2>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Group Title</label>
            <input type="text" class="form-control" name="group_title" value="<?php echo $gallery_item['group_title']; ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea class="form-control" name="description" required><?php echo $gallery_item['description']; ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>

<?php include 'footer.php'; ?>
