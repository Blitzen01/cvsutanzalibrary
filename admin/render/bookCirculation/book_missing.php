<?php
    include '../../render/connection.php';
    include '../../assets/cdn/cdn_links.php';
    include '../../assets/fonts/fonts.php';

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $libraryId = $_GET['libraryId'];
        $name = $_GET['name'];
        $course = $_GET['course'];
        $email = $_GET['email'];
        $accessNo = $_GET['accessNo'];
        $title = $_GET['title'];
        $callno = $_GET['callno'];
        $pickupDate = $_GET['pickupDate'];
        $returnDate = $_GET['returnDate'];
        $fine = $_GET['fine'];
        
        // Insert the data into the booktransaction table when the button is clicked
        insertIntoBookTransaction($conn, $id, $libraryId, $name, $course, $email, $accessNo, $title, $callno, $pickupDate, $returnDate, $fine);
    }

    // Function to insert data into the booktransaction table
    function insertIntoBookTransaction($conn, $id, $libraryId, $name, $course, $email, $accessNo, $title, $callno, $pickupDate, $returnDate, $fine)
    {
        $sql = "INSERT INTO booktransaction (id, libraryid, name, courseSection, email, bookAccessNo, bookTitle, bookCallNo, pickupDate, returnDate, remarks, fine) 
                VALUES ('$id', '$libraryId', '$name', '$course', '$email', '$accessNo', '$title', '$callno', '$pickupDate', '$returnDate', 'Missing', '$fine')";

        if ($conn->query($sql) === TRUE) {
            // Delete the record from the bookreserve table
            $deleteSql = "DELETE FROM bookborrowed WHERE id = '$id'";
            if ($conn->query($deleteSql) === TRUE) {
                $redirectUrl = "../../admin/circulation.php#bookReservation";
                // Redirect back to the previous window using window.location
                echo '<script type="text/javascript">';
                echo 'window.location.href = "' . $redirectUrl . '";';
                echo '</script>';
            } else {
                echo "Error deleting record from bookreserve: " . $conn->error;
            }
        } else {
            echo "Error inserting record into bookborrowed: " . $conn->error;
        }
    }

    if (isset($_POST['insert_button'])) {

    }

    // Close the database connection
    $conn->close();
?>