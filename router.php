<?php
// Router for PHP built-in server to handle clean URLs
$uri = $_SERVER['REQUEST_URI'];

// Remove query string
$uri = parse_url($uri, PHP_URL_PATH);

// Define routes
$routes = [
    '/' => 'index.php',
    '/app' => 'app.php',
    '/about' => 'about.php',
    '/services' => 'services.php',
    '/contact' => 'contact.php',
    '/privacy' => 'privacy.php',
    '/blog' => 'https://fontmerge.online/blog/'
];

// Check if route exists
if (isset($routes[$uri])) {
    // If it's an external URL, redirect
    if (strpos($routes[$uri], 'http') === 0) {
        header('Location: ' . $routes[$uri]);
        exit;
    }
    // Include the PHP file
    include $routes[$uri];
    return true;
}

// If no route matches, try to serve the file directly
$file = __DIR__ . $uri;
if (file_exists($file) && is_file($file)) {
    return false; // Let the server handle it
}

// 404 - redirect to index
include 'index.php';
return true;
?> 