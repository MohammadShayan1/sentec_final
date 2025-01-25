<?php
session_start();

// Set the session timeout duration (in seconds)
$timeout_duration = 600; // 10 minutes

// Check if the session is set
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

// Check if the session has been active longer than the timeout duration
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout_duration) {
    // If the session has timed out, destroy the session
    session_unset();
    session_destroy();
    header("Location: admin_login.php");
    exit();
}

// Update the last activity time
$_SESSION['last_activity'] = time();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SENTEC | Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }
        .sidebar {
            background: #343a40;
            color: white;
            padding: 20px;
            position: fixed;
            height: 100%;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }
        .sidebar a:hover {
            background: #495057;
        }
        .main-content {
            margin-left: 260px;
            padding: 20px;
            width: calc(100% - 260px);
            overflow-y: auto;
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }
            .main-content {
                margin-left: 200px;
                width: calc(100% - 200px);
            }
        }
        @media (max-width: 576px) {
            .sidebar {
                width: 150px;
            }
            .main-content {
                margin-left: 150px;
                width: calc(100% - 150px);
            }
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h4 class="text-center">Admin Panel</h4>
    <a href="index">🏠 Dashboard</a>
    <a href="manage_team">👥 Team Management</a> 
    <a href="add_event">📅 Manage Event</a> 
    <a href="manage_gallery">🖼 Manage Gallery</a>
    <a href="admin_partners">🤝 Manage Partners</a>
    <a href="logout.php" class="bg-danger text-white">🚪 Logout</a>
</div>

<div class="main-content">

