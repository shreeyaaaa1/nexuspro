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
require_once dirname(__FILE__) . '/../config/config.php';
require_once dirname(__FILE__) . '/auth.php';
require_once dirname(__FILE__) . '/db_functions.php';
require_once dirname(__FILE__) . '/file_functions.php';
require_once dirname(__FILE__) . '/project_functions.php';