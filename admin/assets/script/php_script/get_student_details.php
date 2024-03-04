<?php
// Include your database connection file
include '../../../render/connection.php';

// Check if user_id is set in the POST request
if(isset($_POST['userId'])) {
    // Sanitize the input to prevent SQL injection
    $userId = $conn->real_escape_string($_POST['userId']);

    // SQL query to fetch user details and book transactions based on user_id
    $sql = "SELECT u.*, bt.* FROM users u LEFT JOIN booktransaction bt ON user_id = user_id WHERE user_id = '$userId'";
    $result = $conn->query($sql);

    // Check if the query was successful
    if ($result) {
        // Check if there is at least one row returned
        if ($result->num_rows > 0) {
            // Fetch the user details
            $row = $result->fetch_assoc();

            // Format the "Created" date and time
            $created_date = date("F d, Y", strtotime($row["user_created"])); // Format date as "January 22, 2001"
            $created_time = date("h:i A", strtotime($row["user_created"])); // Format time in 12-hour format

            // Output the user details in HTML format
            echo "<p><strong>Given Name:</strong> " . $row["user_givenName"] . "</p>";
            echo "<p><strong>Family Name:</strong> " . $row["user_familyName"] . "</p>";
            echo "<p><strong>Username:</strong> " . $row["user_username"] . "</p>";
            echo "<p><strong>Email:</strong> " . $row["user_email"] . "</p>";
            echo "<p><strong>Course:</strong> " . $row["user_student_course"] . "</p>";
            echo "<p><strong>Year:</strong> " . $row["user_student_year"] . "</p>";
            echo "<p><strong>Section:</strong> " . $row["user_student_section"] . "</p>";
            echo "<p><strong>Student Number:</strong> " . $row["user_student_number"] . "</p>";
            echo "<p><strong>Member Type:</strong> " . $row["user_member_type"] . "</p>";
            echo "<p><strong>Created:</strong> " . $created_date . " at " . $created_time . "</p>";

            // Output book transaction details
            echo "<h3 class='pt-3'>Book Transactions</h3><hr>";
            // Loop through book transactions
            while ($row = $result->fetch_assoc()) {
                echo "<p><strong>Book Title:</strong> " . $row["bookTitle"] . "</p>";
                echo "<p><strong>Pickup Date:</strong> " . date("F d, Y", strtotime($row["pickupDate"])) . "</p>";
                echo "<p><strong>Return Date:</strong> " . date("F d, Y", strtotime($row["returnDate"])) . "</p>";
                echo "<hr>";
            }
        } else {
            echo "User not found or multiple users found with the same ID.";
        }
    } else {
        // Display an error message if the query fails
        echo "Error: " . $conn->error;
    }
} else {
    echo "User ID is not set.";
}
?>
