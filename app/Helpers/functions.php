<?php

function escape_like($string)
{
    $search = ['%', '_', '&'];
    $replace = ['\%', '\_', '\&'];

    return str_replace($search, $replace, $string);
}
