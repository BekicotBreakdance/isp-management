<?php
session_start();
// Destroy session and redirect to login
session_unset();
session_destroy();
header('Location: /isp-management/templates/auth/login.html');
exit;
