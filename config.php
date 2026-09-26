<?php
// Change this hash if you change the password.
// Default password for first login: Admin@12345
define('ADMIN_PASSWORD_SHA256', '6f2cb9dd8f4b65e24e1c3f3fa5bc57982349237f11abceacd45bbcb74d621c25');
define('DATA_FILE', __DIR__ . '/data.json');
define('INQUIRIES_FILE', __DIR__ . '/inquiries.json');
session_start();
