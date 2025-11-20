<?php

if (!function_exists('currency_symbol')) {
    function currency_symbol($currency = null)
    {
        if ($currency === null) {
            $user = auth()->user();
            $currency = $user ? $user->currency : 'IDR';
        }
        
        return match($currency) {
            'IDR' => 'Rp',
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            'JPY' => '¥',
            'SGD' => 'S$',
            'MYR' => 'RM',
            default => 'Rp',
        };
    }
}

if (!function_exists('format_currency')) {
    function format_currency($amount, $currency = null)
    {
        if ($currency === null) {
            $user = auth()->user();
            $currency = $user ? $user->currency : 'IDR';
        }
        
        $symbol = currency_symbol($currency);
        
        return $symbol . ' ' . number_format($amount, 0, ',', '.');
    }
}
