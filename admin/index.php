<?php
include 'header.php';
include 'db_connection.php';

// Update past events if the event date has passed
$conn->query("UPDATE events SET status = 'past' WHERE event_date < NOW() AND status = 'upcoming'");

// Fetch upcoming and past events
$upcoming_events = $conn->query("SELECT * FROM events WHERE status = 'upcoming' ORDER BY event_date ASC");
$past_events = $conn->query("SELECT * FROM events WHERE status = 'past' ORDER BY event_date DESC");
?>

<h2 class="mb-4">Admin Dashboard</h2>

<div class="row mb-4">
    <div class="col-md-6">
        <a href="add_gallery.php" class="btn btn-primary w-100">Add Gallery Item</a>
    </div>
    <div class="col-md-6">
        <a href="add_event.php" class="btn btn-success w-100">Add Upcoming Event</a>
    </div>
</div>

<h3 class="mt-4 text-primary">Upcoming Events</h3>
<div class="row">
    <?php while ($event = $upcoming_events->fetch_assoc()): ?>
        <div class="col-md-6">
            <div class="card event-card p-3">
                <h5 class="card-title"><?php echo $event['title']; ?></h5>
                <p class="text-muted"><?php echo date("F j, Y, g:i a", strtotime($event['event_date'])); ?></p>
                <a href="edit_event.php?id=<?php echo $event['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="delete_event.php?id=<?php echo $event['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
            </div>
        </div>
    <?php endwhile; ?>
</div>

<h3 class="mt-5 text-secondary">Past Events</h3>
<div class="row">
    <?php while ($event = $past_events->fetch_assoc()): ?>
        <div class="col-md-6">
            <div class="card event-card p-3 bg-light">
                <h5 class="card-title"><?php echo $event['event_title']; ?></h5>
                <p class="text-muted"><?php echo date("F j, Y, g:i a", strtotime($event['event_date'])); ?></p>
                <a href="edit_event.php?id=<?php echo $event['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="delete_event.php?id=<?php echo $event['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
            </div>
        </div>
    <?php endwhile; ?>
</div>

<?php include 'footer.php'; ?>
