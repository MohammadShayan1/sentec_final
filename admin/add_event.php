<?php
include 'db_connection.php';
$message = ""; // Store success or error messages

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $category = trim($_POST['category']);
    $event_date = $_POST['event_date'];

    $target_dir = "../images/upload/event/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $image_name = basename($_FILES['image']['name']);
    $image_ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
    $allowed_types = ['jpg', 'jpeg', 'png', 'webp'];

    if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        $message = "<div class='alert alert-danger'>Error uploading file: " . $_FILES['image']['error'] . "</div>";
    } elseif (!in_array($image_ext, $allowed_types)) {
        $message = "<div class='alert alert-danger'>Only JPG, JPEG, PNG & WEBP files are allowed.</div>";
    } else {
        $new_image_name = uniqid("event_", true) . "." . $image_ext;
        $image_relative_path = "images/upload/event/" . $new_image_name;
        $target_file = $target_dir . $new_image_name;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $sql = "INSERT INTO events (title, description, category, event_date, image_url) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssss", $title, $description, $category, $event_date, $image_relative_path);

            if ($stmt->execute()) {
                $message = "<div class='alert alert-success'>New event added successfully!</div>";
            } else {
                $message = "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
            }

            $stmt->close();
        } else {
            $message = "<div class='alert alert-danger'>Failed to upload image.</div>";
        }
    }
}

$conn->close();
?>


<?php include 'header.php'; ?> <!-- Include Header -->

<div class="container mt-4">
    <h2 class="mb-4">Add Event</h2>

    <?php echo $message; ?>

    <form action="add_event.php" method="POST" enctype="multipart/form-data" class="shadow p-4 bg-white rounded">
        <div class="mb-3">
            <label for="title" class="form-label">Event Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Event Description</label>
            <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">Event Category</label>
            <input type="text" class="form-control" id="category" name="category" required>
        </div>

        <div class="mb-3">
            <label for="event_date" class="form-label">Event Date</label>
            <input type="date" class="form-control" id="event_date" name="event_date" required>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Event Image</label>
            <input type="file" class="form-control" id="image" name="image" required accept=".jpg, .jpeg, .png, .webp">
        </div>

        <button type="submit" class="btn btn-primary w-100">Add Event</button>
    </form>
</div>

<?php include 'footer.php'; ?> <!-- Include Footer -->
