<?php

function formatDateTime($date, $format = "Y-m-d H:i:s")
{
    if ($date === null || $date === "" ) {
        return null;
    }

    if ($date instanceof DateTime) {
        return $date->format($format);
    }

    try {
        $dt = new DateTime($date);
        return $dt->format($format);
    } catch (Exception $e) {
        return null;
    }
}


function escapeString($str)
{
    if ($str === null) {
        return null;
    }

    $str = trim($str);
    $str = str_replace("'", "''", $str);
    $str = preg_replace('/[^\PC\s]/u', '', $str);

    return $str;
}

function num($v) {
    if ($v === "" || $v === null) return null;
    return preg_replace('/[^0-9.\-]/', '', $v);
}

function toNumericOrNull($value) {
    // trim spaces
    $value = trim($value);

    // jika kosong → NULL
    if ($value === "" || $value === null) {
        return NULL;
    }

    // jika mengandung karakter selain angka, minus, titik → invalid → NULL
    if (!preg_match('/^-?[0-9]+(\.[0-9]+)?$/', $value)) {
        return NULL;
    }

    // jika valid numeric → kembalikan dalam bentuk numeric
    return $value; // convert otomatis ke int/float
}