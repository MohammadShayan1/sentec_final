<?php
include 'db_connection.php';

$success = $error = "";

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $group_title = $_POST['group_title'];
    $description = $_POST['description'];

    // Handle Main Image Upload
    $main_image = $_FILES['main_image'];
    $main_image_name = $main_image['name'];
    $main_image_tmp = $main_image['tmp_name'];

    $main_image_new_name = uniqid('main_', true) . '.' . pathinfo($main_image_name, PATHINFO_EXTENSION);
    $main_image_destination = '../images/uploads/' . $main_image_new_name;

    // Handle Additional Image Uploads
    $additional_images = [];
    foreach ($_FILES['additional_images']['name'] as $key => $image_name) {
        $image_tmp = $_FILES['additional_images']['tmp_name'][$key];

        $image_new_name = uniqid('additional_', true) . '.' . pathinfo($image_name, PATHINFO_EXTENSION);
        $image_destination = '../images/uploads/' . $image_new_name;

        if (move_uploaded_file($image_tmp, $image_destination)) {
            $additional_images[] = $image_destination;
        }
    }

    // Move the main image
    if (move_uploaded_file($main_image_tmp, $main_image_destination)) {
        $additional_images_str = implode(',', $additional_images);

        // Check if the connection is established
        if ($conn) {
            $query = "INSERT INTO gallery (group_title, description, main_image_url, additional_image_url) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($query);

            if ($stmt === false) {
                die("Error preparing the query: " . $conn->error);
            }

            $stmt->bind_param("ssss", $group_title, $description, $main_image_destination, $additional_images_str);

            if ($stmt->execute()) {
                $success = "Gallery item added successfully!";
            } else {
                $error = "Failed to add gallery item.";
            }

            // Close the statement
            $stmt->close();
        } else {
            $error = "Failed to connect to the database.";
        }
    } else {
        $error = "Error uploading main image.";
    }
}

// Fetch all gallery items
$gallery_items = $conn->query("SELECT * FROM gallery ORDER BY id DESC");

?>

<?php include 'header.php'; ?> <!-- Include Sidebar & Header -->

<div class="container mt-4">
    <h2 class="mb-4">Manage Gallery</h2>

    <!-- Tabs for Add & View -->
    <ul class="nav nav-tabs" id="galleryTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="add-tab" data-bs-toggle="tab" data-bs-target="#add" type="button">Add Gallery Item</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="view-tab" data-bs-toggle="tab" data-bs-target="#view" type="button">View All Gallery Items</button>
        </li>
    </ul>

    <div class="tab-content mt-3" id="galleryTabContent">
        <!-- Add Gallery Item Form -->
        <div class="tab-pane fade show active" id="add" role="tabpanel">
            <?php if ($success) echo "<div class='alert alert-success'>$success</div>"; ?>
            <?php if ($error) echo "<div class='alert alert-danger'>$error</div>"; ?>

            <form method="POST" enctype="multipart/form-data" class="shadow p-4 bg-white rounded">
                <div class="mb-3">
                    <label for="group_title" class="form-label">Group Title</label>
                    <input type="text" class="form-control" id="group_title" name="group_title" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="main_image" class="form-label">Main Image</label>
                    <input type="file" class="form-control" id="main_image" name="main_image" accept="image/*" required>
                </div>
                <div class="mb-3">
                    <label for="additional_images" class="form-label">Additional Images</label>
                    <input type="file" class="form-control" id="additional_images" name="additional_images[]" accept="image/*" multiple>
                </div>
                <button type="submit" class="btn btn-primary w-100">Add Gallery Item</button>
            </form>
        </div>

        <!-- View All Gallery Items -->
        <div class="tab-pane fade" id="view" role="tabpanel">
            <div class="table-responsive">
                <table class="table table-bordered table-hover mt-3">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Group Title</th>
                            <th>Main Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($item = $gallery_items->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $item['id']; ?></td>
                                <td><?php echo $item['group_title']; ?></td>
                                <td>
                                    <?php 
                                    // Check if main_image exists before displaying
                                    if (!empty($item['main_image'])): ?>
                                        <img src="<?php echo $item['main_image']; ?>" alt="Main Image" width="100">
                                    <?php else: ?>
                                        <span>No Image</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="edit_gallery.php?id=<?php echo $item['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="delete_gallery.php?id=<?php echo $item['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?> <!-- Include Footer -->
