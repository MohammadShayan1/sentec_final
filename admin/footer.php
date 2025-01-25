 <!-- End of Main Content -->

<footer class="text-center py-3 mt-4">
    <p>&copy; <?php echo date("Y"); ?> Admin Dashboard | <span class="d-block d-lg-inline">
            Developed by
            <a class="text-primary fw-bold text-decoration-none" href="https://mohammadshayan.me">Mohammad Shayan</a>.
        </span></p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    let timeout;

    // Function to log out the user after inactivity
    function logout() {
        window.location = "admin_logout.php"; // Redirect to logout page
    }

    // Reset the timeout whenever there's user activity
    function resetTimeout() {
        clearTimeout(timeout);
        timeout = setTimeout(logout, 600000); // 10 minutes timeout (600000 ms)
    }

    // Set event listeners to detect user activity
    document.addEventListener('mousemove', resetTimeout);
    document.addEventListener('keydown', resetTimeout);
    document.addEventListener('click', resetTimeout);

    // Initial timeout set when the page loads
    resetTimeout();
</script>
</body>

</html>