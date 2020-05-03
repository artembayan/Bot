<?php

function clean($value) {
    $value = trim($value);
    $value = stripslashes($value);
    $value = strip_tags($value);
    $value = htmlspecialchars($value);
    return $value;
}

function check_length($value, $max) {
    $result = (mb_strlen($value, 'UTF-8') < $max);
    return !$result;
}
?>