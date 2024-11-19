<?php
// Load environment variables
$env = parse_ini_file(__DIR__ . '/../.env');
foreach ($env as $key => $value) {
    putenv("$key=$value");
}

// Set upload limits
ini_set('upload_max_filesize', getenv('MAX_UPLOAD_SIZE'));
ini_set('post_max_size', getenv('MAX_UPLOAD_SIZE'));

// Required files
require_once 'config/config.php';
require_once 'includes/auth.php';
require_once 'includes/db_functions.php';
require_once 'includes/file_functions.php';
require_once 'includes/project_functions.php';