<?php

if (!function_exists('format_currency')) {
    /**
     * Format amount as Sri Lankan Rupees
     *
     * @param float $amount
     * @param bool $showSymbol
     * @return string
     */
    function format_currency($amount, $showSymbol = true)
    {
        $formatted = number_format($amount, 2);
        return $showSymbol ? "Rs. {$formatted}" : $formatted;
    }
}

if (!function_exists('currency_symbol')) {
    /**
     * Get the currency symbol
     *
     * @return string
     */
    function currency_symbol()
    {
        return 'Rs.';
    }
}

if (!function_exists('currency_code')) {
    /**
     * Get the currency code
     *
     * @return string
     */
    function currency_code()
    {
        return 'LKR';
    }
}
