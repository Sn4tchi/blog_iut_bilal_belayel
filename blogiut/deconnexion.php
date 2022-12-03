<?php
require_once 'config/init.conf.php';

setcookie('sid', '', -1);

header('Location: index.php'); 

exit();
?>