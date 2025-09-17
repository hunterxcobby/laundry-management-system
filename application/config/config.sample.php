<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| MAIN CONFIGURATION - SAMPLE FILE
| -------------------------------------------------------------------
| 
| INSTRUCTIONS:
| 1. Copy this file to config.php 
| 2. Update the base_url and other settings below
| 3. Set your encryption key for security
| 4. Never commit the actual config.php file to version control
|
*/

// Base Site URL - UPDATE THIS
$config['base_url'] = 'http://localhost:8000/';

$config['index_page'] = 'index.php';
$config['uri_protocol']	= 'REQUEST_URI';
$config['url_suffix'] = '';
$config['language']	= 'english';
$config['charset'] = 'UTF-8';

// Security Settings - GENERATE YOUR OWN ENCRYPTION KEY
$config['encryption_key'] = 'your_32_character_encryption_key_here';

// Session Configuration
$config['sess_driver'] = 'database';
$config['sess_cookie_name'] = 'ci_session';
$config['sess_expiration'] = 7200;
$config['sess_save_path'] = 'ci_sessions';
$config['sess_match_ip'] = FALSE;
$config['sess_time_to_update'] = 300;
$config['sess_regenerate_destroy'] = FALSE;

// Cookie Settings
$config['cookie_prefix']	= '';
$config['cookie_domain']	= '';
$config['cookie_path']		= '/';
$config['cookie_secure']	= FALSE;
$config['cookie_httponly'] 	= FALSE;

// Cross Site Request Forgery Protection
$config['csrf_protection'] = FALSE;
$config['csrf_token_name'] = 'csrf_test_name';
$config['csrf_cookie_name'] = 'csrf_cookie_name';
$config['csrf_expire'] = 7200;
$config['csrf_regenerate'] = TRUE;
$config['csrf_exclude_uris'] = array();

// Output Compression
$config['compress_output'] = FALSE;

// Logging
$config['log_threshold'] = 0;
$config['log_path'] = '';
$config['log_file_extension'] = '';
$config['log_file_permissions'] = 0644;
$config['log_date_format'] = 'Y-m-d H:i:s';

// Error Views
$config['error_views_path'] = '';

// Cache Settings
$config['cache_path'] = '';
$config['cache_query_string'] = FALSE;

// Profiler
$config['enable_profiler'] = FALSE;

// File Permissions
$config['file_write_mode'] = 0666;
$config['dir_write_mode'] = 0777;

// File Streams
$config['fopen_write_create_destructive'] = FALSE;
$config['fopen_read_write_create_destructive'] = FALSE;
$config['fopen_write_create'] = FALSE;
$config['fopen_read_write_create'] = FALSE;
$config['fopen_write_append'] = FALSE;
$config['fopen_read_write_append'] = FALSE;
$config['fopen_read'] = FALSE;

// Display errors - should be FALSE in production
$config['display_errors'] = TRUE;

// Allow PHP tags in templates
$config['allow_php_tag'] = FALSE;