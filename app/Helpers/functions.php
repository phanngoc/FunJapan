<?php

function escape_like($string)
{
    $search = ['%', '_', '&'];
    $replace = ['\%', '\_', '\&'];

    return str_replace($search, $replace, $string);
}

function clean($string)
{
    $string = str_replace(' ', '-', $string);

    return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
}
