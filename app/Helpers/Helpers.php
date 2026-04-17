<?php

use App\Models\Headline;
use App\Models\Setting;
use App\Models\Template;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

if (! function_exists('isDebug')) {
    /**
     * Encrypt model ID
     */
    function isDebug()
    {
        return config('app.debug');
    }
}

if (! function_exists('encryptID')) {
    /**
     * Encrypt model ID
     */
    function encryptID($id)
    {
        return Crypt::encryptString((int) $id);
    }
}

if (! function_exists('decryptID')) {
    /**
     * Decrypt model ID
     */
    function decryptID($encryptedId)
    {
        try {
            return (int) Crypt::decryptString($encryptedId);
        } catch (DecryptException $e) {
            return null; // bisa juga abort(404, 'Invalid ID');
        }
    }
}


if (! function_exists('formatCurrency')) {
    /**
     * Format angka menjadi currency string.
     */
    function formatCurrency(
        float|int|string $number,
        // string $prefix = 'Rp',
        string $prefix = '',
        string $decimalSeparator = ',',
        string $thousandSeparator = '.',
        int $decimals = 0
    ): string {
        $num = is_numeric($number) ? (float) $number : 0.0;

        $formatted = number_format($num, $decimals, $decimalSeparator, $thousandSeparator);

        // Pastikan ada spasi setelah prefix kalau perlu
        return trim($prefix.(Str::endsWith($prefix, ' ') ? '' : ' ').$formatted);
    }
}

if (! function_exists('parseCurrency')) {
    /**
     * Parse formatted currency string menjadi float.
     */
    function parseCurrency(
        ?string $formatted,
        string $decimalSeparator = ',',
        string $thousandSeparator = '.'
    ): float {
        if (empty($formatted)) {
            return 0.0;
        }

        // Hapus semua karakter kecuali angka, tanda minus, pemisah, dan koma/titik
        $value = preg_replace('/[^0-9\-\.,]/', '', $formatted);

        // Hapus pemisah ribuan
        $value = str_replace($thousandSeparator, '', $value);

        // Ganti pemisah desimal dengan titik (standar float)
        if ($decimalSeparator !== '.') {
            $value = str_replace($decimalSeparator, '.', $value);
        }

        return (float) $value;
    }
}

if (! function_exists('numberToRoman')) {
    /**
     * Convert number to Roman numeral.
     */
    function numberToRoman(int $number): string
    {
        $map = [
            1000 => 'M',
            900 => 'CM',
            500 => 'D',
            400 => 'CD',
            100 => 'C',
            90 => 'XC',
            50 => 'L',
            40 => 'XL',
            10 => 'X',
            9 => 'IX',
            5 => 'V',
            4 => 'IV',
            1 => 'I',
        ];

        $result = '';

        foreach ($map as $value => $roman) {
            while ($number >= $value) {
                $result .= $roman;
                $number -= $value;
            }
        }

        return $result;
    }
}

if (! function_exists('getSetting')) {
    /**
     * Get setting value by keyword.
     *
     * @param string $keyword Setting keyword
     * @param mixed $default Default value if setting not found
     * @return mixed
     */
    function getSetting(string $keyword, $default = null)
    {
        $setting = Setting::where('keyword', $keyword)->first();

        return $setting ? $setting->value : $default;
    }
}

if (! function_exists('getTemplate')) {
    /**
     * Get template content by keyword.
     * In edit mode (?edit-template=1 + authenticated), returns an editable wrapper.
     *
     * @param string $keyword Template keyword
     * @param mixed $default Default content if template not found
     * @return mixed
     */
    function getTemplate(string $keyword, $default = null)
    {
        $template = Template::where('keyword', $keyword)->first();
        $content = $template ? $template->content : $default;

        // Check edit mode: user authenticated + URL has edit-template parameter
        $isEditMode = request()->has('edit-template') && auth()->check();

        if ($isEditMode) {
            // Auto-create template if it doesn't exist
            if (!$template && $default !== null) {
                $template = Template::create([
                    'keyword' => $keyword,
                    'content' => $default,
                    'is_active' => true,
                    'created_by' => auth()->id(),
                    'updated_by' => auth()->id(),
                ]);
                $content = $default;
            }

            $escapedKeyword = e($keyword);
            $escapedContent = e($content ?? '');

            return '<span class="tpl-editable" data-keyword="' . $escapedKeyword . '">'
                . '<span class="tpl-content">' . ($content ?? '') . '</span>'
                . '<button type="button" class="tpl-edit-btn" data-keyword="' . $escapedKeyword . '" data-content="' . $escapedContent . '" title="Edit: ' . $escapedKeyword . '">'
                . '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>'
                . '</button>'
                . '</span>';
        }

        return $content;
    }
}

if (! function_exists('formatDate')) {
    /**
     * Format date to string.
     *
     * @param \DateTime|string|int|null $date Date to format
     * @param string $format Date format (default: d/m/Y)
     * @return string
     */
    function formatDate($date, string $format = 'd/m/Y'): string
    {
        if (empty($date)) {
            return '';
        }

        try {
            $carbon = \Carbon\Carbon::parse($date);
            return $carbon->format($format);
        } catch (\Exception $e) {
            return $date;
        }
    }
}

if (! function_exists('formatDateTime')) {
    /**
     * Format datetime to string.
     *
     * @param \DateTime|string|int|null $datetime Datetime to format
     * @param string $format Datetime format (default: d/m/Y H:i)
     * @return string
     */
    function formatDateTime($datetime, string $format = 'd/m/Y H:i'): string
    {
        if (empty($datetime)) {
            return '';
        }

        try {
            $carbon = \Carbon\Carbon::parse($datetime);
            return $carbon->format($format);
        } catch (\Exception $e) {
            return $datetime;
        }
    }
}

if (! function_exists('initialName')) {
    function initialName(string $name, int $limit = 2): string
    {
        return collect(preg_split('/\s+/', trim($name)))
            ->take($limit)
            ->map(fn ($w) => mb_strtoupper(mb_substr($w, 0, 1)))
            ->implode('');
    }
}

if (! function_exists('getHeadline')) {
    function getHeadline()
    {
        return Headline::where('is_active', 1)->limit(10)->latest()->get();
    }
}

if (! function_exists('shortNumber')) {
    /**
     * Format number to short format (K, M, B, etc.)
     *
     * @param int|float $number
     * @param int $precision
     * @return string
     */
    function shortNumber(int|float $number, int $precision = 1): string
    {
        if ($number < 1000) {
            return (string) $number;
        }

        $units = ['', 'K', 'M', 'B', 'T'];
        $power = $number > 0 ? floor(log($number, 1000)) : 0;
        $power = min($power, count($units) - 1);

        $shortValue = $number / pow(1000, $power);

        // If it's a whole number or precision is 0, don't show decimal
        if ($shortValue == (int) $shortValue || $precision === 0) {
            return (int) $shortValue.$units[$power];
        }

        return round($shortValue, $precision).$units[$power];
    }
}

