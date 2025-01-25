<?php
include 'header.php';
include 'db_connection.php'; // Database connection
?>

<h2 class="mb-4">Manage Team Members</h2>

<!-- Add Team Member Form -->
<div class="card mb-4">
    <div class="card-body">
        <h4 class="card-title">Add New Team Member</h4>
        <form action="add_team_member.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="designation" class="form-label">Designation</label>
                <input type="text" name="designation" id="designation" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select name="category" id="category" class="form-select" required>
                    <option value="Presiding Board">Presiding Board</option>
                    <option value="Executive Committee">Executive Committee</option>
                    <option value="Directorate">Directorate</option>
                    <option value="Co-Directorate">Co-Directorate</option>
                    <option value="Alumni">Alumni</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Profile Image</label>
                <input type="file" name="image" id="image" class="form-control" accept="image/*" required>
            </div>
            <div class="mb-3">
                <label for="linkedin" class="form-label">LinkedIn URL</label>
                <input type="url" name="linkedin" id="linkedin" class="form-control">
            </div>
            <button type="submit" class="btn btn-success w-100">Add Member</button>
        </form>
    </div>
</div>

<!-- Display Current Team Members -->
<h3 class="mt-4 text-center">Current Team Members</h3>
<div class="row justify-content-center">
    <?php
    $members = $conn->query("SELECT * FROM team_members ORDER BY FIELD(category, 'Presiding Board','Executive Committee', 'Directorates', 'Co-Directorates', 'Alumni'), id ASC");
    while ($member = $members->fetch_assoc()):
    ?>
        <div class="col-md-6 mb-3 d-flex justify-content-center">
            <div class="card" style="max-width: 300px;">
                <div class="card-body text-center">
                    <img src="../<?= htmlspecialchars($member['image']) ?>" alt="<?= htmlspecialchars($member['name']) ?>" class="img-fluid mb-3 w-50 mx-auto">
                    <h5><?= htmlspecialchars($member['name']) ?> (<?= htmlspecialchars($member['category']) ?>)</h5>
                    <p><?= htmlspecialchars($member['designation']) ?></p>
                    <p><strong>LinkedIn:</strong> <?= htmlspecialchars($member['linkedin'] ?? 'N/A') ?></p>
                    <a href="edit_team_member.php?id=<?= $member['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="delete_team_member.php?id=<?= $member['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
</div>

<?php
$conn->close();
include 'footer.php';
?>
