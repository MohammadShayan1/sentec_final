<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

include 'db_connection.php';

// Fetch the event to edit
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $event_id = intval($_GET['id']); // Ensures the ID is an integer
    $query = "SELECT * FROM events WHERE id = ?";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param('i', $event_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $event = $result->fetch_assoc();

        if (!$event) {
            echo "<p>Event not found.</p>";
            exit();
        }
    } else {
        die("Failed to prepare query: " . $conn->error);
    }
} else {
    header("Location: index.php");
    exit();
}

// Update event if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_title = trim($_POST['event_title']);
    $event_description = trim($_POST['event_description']);
    $event_date = trim($_POST['event_date']);

    if (!empty($event_title) && !empty($event_description) && !empty($event_date)) {
        // Prepare and execute update query
        $update_query = "UPDATE events SET title = ?, description = ?, event_date = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_query);

        if ($update_stmt) {
            $update_stmt->bind_param('sssi', $event_title, $event_description, $event_date, $event_id);
            if ($update_stmt->execute()) {
                header("Location: admin_dashboard.php");
                exit();
            } else {
                echo "<p class='text-danger'>Error updating event: " . $update_stmt->error . "</p>";
            }
        } else {
            die("Failed to prepare update query: " . $conn->error);
        }
    } else {
        echo "<p class='text-danger'>All fields are required.</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white text-center">
            <h2 class="mb-0">Edit Event</h2>
        </div>
        <div class="card-body p-4">
            <form method="POST">
                <!-- Event Title -->
                <div class="mb-4">
                    <label for="event_title" class="form-label fw-bold">Event Title</label>
                    <input type="text" class="form-control rounded-pill" id="event_title" name="event_title" 
                           value="<?php echo htmlspecialchars($event['title'], ENT_QUOTES, 'UTF-8'); ?>" 
                           placeholder="Enter the event title" 
                           required>
                </div>
                
                <!-- Event Description -->
                <div class="mb-4">
                    <label for="event_description" class="form-label fw-bold">Event Description</label>
                    <textarea class="form-control rounded" id="event_description" name="event_description" rows="5" 
                              placeholder="Describe the event" 
                              required><?php echo htmlspecialchars($event['description'], ENT_QUOTES, 'UTF-8'); ?></textarea>
                </div>
                
                <!-- Event Date -->
                <div class="mb-4">
                    <label for="event_date" class="form-label fw-bold">Event Date</label>
                    <input type="datetime-local" class="form-control rounded-pill" id="event_date" name="event_date" 
                           value="<?php echo date("Y-m-d\TH:i", strtotime($event['event_date'])); ?>" 
                           required>
                </div>
                
                <!-- Submit Button -->
                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5">
                        Update Event
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
