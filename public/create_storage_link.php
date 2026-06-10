<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$target = '/home/uzu7kgd05u96/ceu-trainers.com/storage/app/public';
$link   = '/home/uzu7kgd05u96/ceu-trainers.com/public/storage';

echo "Target: $target <br>";
echo "Link: $link <br><br>";

if (is_link($link) || file_exists($link)) {
    unlink($link);
    echo "Old storage removed<br>";
}

if (symlink($target, $link)) {
    echo "Storage link created successfully";
} else {
    echo "<pre>";
    print_r(error_get_last());
    echo "</pre>";
}
?>