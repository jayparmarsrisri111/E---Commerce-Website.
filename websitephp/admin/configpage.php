<?php
    mysqli_report(MYSQLI_REPORT_OFF);
    $databaseHost = 'localhost';
    $databaseName = 'marinetraders';
    $databaseUsername = 'root';
    $databasePassword = '';

    $mysqli = @mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName);

    if (!$mysqli) {
        die("<!DOCTYPE html><html><head><title>Database Error</title><style>body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f8f9fa; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; } .error-container { background: white; padding: 40px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); text-align: center; max-width: 500px; } .error-icon { font-size: 50px; color: #dc3545; margin-bottom: 20px; } h2 { color: #343a40; margin-top: 0; } p { color: #6c757d; line-height: 1.5; } .btn-refresh { display: inline-block; margin-top: 20px; padding: 10px 20px; background: #667eea; color: white; text-decoration: none; border-radius: 5px; font-weight: 600; }</style></head><body><div class='error-container'><div class='error-icon'>&#9888;&#65039;</div><h2>Database Connection Error</h2><p>Our system could not connect to the database.</p><p><strong>Note for Admin</strong>: It seems the MySQL Server is not running. Please open your <strong>XAMPP Control Panel</strong> and start the <strong>MySQL</strong> module.</p><p style='font-size: 12px; margin-top: 15px;'>Technical Details: " . mysqli_connect_error() . "</p><a href='' class='btn-refresh'>Try Again</a></div></body></html>");
    }
?>