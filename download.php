<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: /login.php'); // Redirect if not logged in
    exit();
}

if (isset($_SESSION['requested_file'])) {
    // echo $_SESSION['requested_file'];
    $file = realpath($_SESSION['requested_file']);

    // Check if the file exists and is readable
    if (file_exists($file) ) {
        // Set headers to force download
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($file).'"');
        // header('Expires: 0');
        // header('Cache-Control: must-revalidate');
        // header('Pragma: public');
        // header('Content-Length: ' . filesize($file));
        
        // Clear the output buffer
        // ob_clean();
        // flush();
        
        // Read the file and send it to the output
        readfile($file);
        exit;
    } else {
        // Handle error: file doesn't exist or is not readable
        echo "File does not exist or is not readable.";
    }
} else {
    echo "No file specified.";
}
?>