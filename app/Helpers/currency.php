<?php

if (!function_exists('currency_symbol')) {
    function currency_symbol($currency = null)
    {
        // Always return Rupiah
        return 'Rp';
    }
}

if (!function_exists('format_currency')) {
    function format_currency($amount, $currency = null)
    {
        // Always format as Rupiah
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}
