<?php

function setFlash($key, $value) {
    $_SESSION['flash'][$key] = $value;
}

function getFlash($key) {
    if (!isset($_SESSION['flash'][$key])) {
        return null;
    }

    $value = $_SESSION['flash'][$key];
    unset($_SESSION['flash'][$key]); // se autodestruye
    return $value;
}