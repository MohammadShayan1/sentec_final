<?php
include 'header.php';
include 'db_connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch current data for the team member
    $query = "SELECT * FROM team_members WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $member = $result->fetch_assoc();

    if (!$member) {
        echo "<p>Member not found.</p>";
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $designation = $_POST['designation'];
    $category = $_POST['category'];
    $image_url = $_POST['image_url'];
    $facebook = $_POST['facebook'] ?? null;
    $twitter = $_POST['twitter'] ?? null;
    $instagram = $_POST['instagram'] ?? null;

    $update_query = "UPDATE team_members SET name = ?, designation = ?, category = ?, image_url = ?, facebook = ?, twitter = ?, instagram = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("sssssssi", $name, $designation, $category, $image_url, $facebook, $twitter, $instagram, $id);

    if ($stmt->execute()) {
        header("Location: manage_team.php?success=Member updated successfully");
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
}
?>

<h2>Edit Team Member</h2>

<form action="edit_team_member.php" method="POST">
    <input type="hidden" name="id" value="<?= htmlspecialchars($member['id']) ?>">
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" name="name" id="name" class="form-control" value="<?= htmlspecialchars($member['name']) ?>" required>
    </div>
    <div class="mb-3">
        <label for="designation" class="form-label">Designation</label>
        <input type="text" name="designation" id="designation" class="form-control" value="<?= htmlspecialchars($member['designation']) ?>" required>
    </div>
    <div class="mb-3">
        <label for="category" class="form-label">Category</label>
        <select name="category" id="category" class="form-select" required>
            <option value="Executive Committee" <?= $member['category'] === 'Executive Committee' ? 'selected' : '' ?>>Executive Committee</option>
            <option value="Directors" <?= $member['category'] === 'Directors' ? 'selected' : '' ?>>Directors</option>
            <option value="Co-Directors" <?= $member['category'] === 'Co-Directors' ? 'selected' : '' ?>>Co-Directors</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="image_url" class="form-label">Image URL</label>
        <input type="url" name="image_url" id="image_url" class="form-control" value="<?= htmlspecialchars($member['image_url']) ?>" required>
    </div>
    <div class="mb-3">
        <label for="facebook" class="form-label">Facebook URL</label>
        <input type="url" name="facebook" id="facebook" class="form-control" value="<?= htmlspecialchars($member['facebook']) ?>">
    </div>
    <div class="mb-3">
        <label for="twitter" class="form-label">Twitter URL</label>
        <input type="url" name="twitter" id="twitter" class="form-control" value="<?= htmlspecialchars($member['twitter']) ?>">
    </div>
    <div class="mb-3">
        <label for="instagram" class="form-label">Instagram URL</label>
        <input type="url" name="instagram" id="instagram" class="form-control" value="<?= htmlspecialchars($member['instagram']) ?>">
    </div>
    <button type="submit" class="btn btn-primary w-100">Update Member</button>
</form>

<?php include 'footer.php'; ?>
