<?php
// 1. Disable displaying errors to the public
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);

// 2. Enable logging to a file
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/logs/php_errors.log');

// 3. Global Exception Handler
set_exception_handler(function ($exception) {
    // Log the detailed error
    error_log("Uncaught Exception: " . $exception->getMessage() . " in " . $exception->getFile() . " on line " . $exception->getLine());
    
    // Show a clean, generic message to the user
    http_response_code(500);
    echo "<h1>500 Internal Server Error</h1>";
    echo "An unexpected error occurred. Please try again later.";
    exit();
});

// 4. Custom Error Handler for non-fatal notices/warnings
set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    if (!(error_reporting() & $errno)) return false;
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
});
