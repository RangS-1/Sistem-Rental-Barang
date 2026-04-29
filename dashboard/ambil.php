<?php
// Harusnya pake init.php ya -_-
spl_autoload_register(function ($class) {
    include 'class/' . $class . '.php';
});
?>