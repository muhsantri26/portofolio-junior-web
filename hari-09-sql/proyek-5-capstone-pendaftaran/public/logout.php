<?php
declare(strict_types=1);
require_once __DIR__ . '/../src/bootstrap.php';

unset($_SESSION['admin_login']);
setFlash("anda telah logout");
redirect('login.php');