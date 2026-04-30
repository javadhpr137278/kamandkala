<?php

// app/Helpers/jdateHelper.php

use Hekmatinasser\Verta\Verta;

if (!function_exists('jdate')) {
    /**
     * تبدیل تاریخ میلادی به شمسی
     *
     * @param mixed $date
     * @param string $format
     * @return string
     */
    function jdate($date = null, $format = 'Y/m/d')
    {
        try {
            if ($date === null) {
                return Verta::now()->format($format);
            }

            if ($date instanceof \DateTime || $date instanceof \Carbon\Carbon) {
                return Verta::instance($date)->format($format);
            }

            if (is_string($date)) {
                // اگر تاریخ شمسی است
                if (preg_match('/[۰-۹]/', $date)) {
                    $date = persianToEnglishNumbers($date);
                }
                return Verta::parse($date)->format($format);
            }

            return Verta::now()->format($format);
        } catch (\Exception $e) {
            return $date ?? now()->format('Y/m/d');
        }
    }
}

if (!function_exists('persianToEnglishNumbers')) {
    function persianToEnglishNumbers($string)
    {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        return str_replace($persian, $english, $string);
    }
}

if (!function_exists('englishToPersianNumbers')) {
    function englishToPersianNumbers($string)
    {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        return str_replace($english, $persian, (string)$string);
    }
}
