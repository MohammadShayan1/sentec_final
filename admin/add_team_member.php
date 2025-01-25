<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $name = $_POST['name'];
    $designation = $_POST['designation'];
    $category = $_POST['category'];
    $linkedin = $_POST['linkedin'] ?? null;

    // Validate name, designation, and category
    if (empty($name) || empty($designation) || empty($category)) {
        echo "Name, designation, and category are required.";
        exit;
    }

    // Handle Image Upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image_name = basename($_FILES['image']['name']);
        $image_tmp = $_FILES['image']['tmp_name'];
        $target_dir = "../images/uploads/team/";

        // Create directory if not exists
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true); // Recursive creation with write permissions
        }

        // Validate file type (only allow images)
        $allowed_types = ['image/jpeg', 'image/png', 'image/webp'];
        $file_type = mime_content_type($image_tmp);

        if (!in_array($file_type, $allowed_types)) {
            echo "Invalid file type. Only JPG, PNG, and WEBP are allowed.";
            exit;
        }

        // Generate unique filename to avoid collisions
        $unique_filename = uniqid() . "_" . $image_name;
        $target_file = $target_dir . $unique_filename;

        // Move the uploaded file
        if (move_uploaded_file($image_tmp, $target_file)) {
            $image = "images/uploads/team/" . $unique_filename; // Save relative path in the database
        } else {
            echo "Error uploading the image.";
            exit;
        }
    } else {
        echo "Image upload is required.";
        exit;
    }

    // Prepare SQL statement to insert team member
    $query = "INSERT INTO team_members (name, designation, category, image, linkedin) VALUES (?, ?, ?, ?, ?)";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("sssss", $name, $designation, $category, $image, $linkedin);

        // Execute the query and check for success
        if ($stmt->execute()) {
            header("Location: manage_team.php?success=Member added successfully");
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error preparing the query: " . $conn->error;
    }
}

$conn->close();
?>
