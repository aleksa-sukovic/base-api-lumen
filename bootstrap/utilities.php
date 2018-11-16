<?php

if (!function_exists('jd')) {
    function jd($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
        die;
    }
}
