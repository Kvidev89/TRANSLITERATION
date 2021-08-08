<?php

declare(strict_types=1);

namespace Kvidev89\Transliteration\UkrEng;

class Cabmin2010 {

    private array $translateDirSource = [
        'а', 'б', 'в', 'г', 'ґ', 'д', 'е', 'є', 'ж', 'з',
        'и', 'і', 'ї', 'й', 'к', 'л', 'м', 'н', 'о', 'п',
        'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ',
        'ю', 'я',
        'А', 'Б', 'В', 'Г', 'Ґ', 'Д', 'Е', 'Є', 'Ж', 'З',
        'И', 'І', 'Ї', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П',
        'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ',
        'Ю', 'Я',
    ];
    
    private array $translateDirDestination = [
        'a', 'b', 'v', 'h', 'g', 'd', 'e', 'ie', 'zh', 'z',
        'y', 'i', 'i', 'i', 'k', 'l', 'm', 'n', 'o', 'p',
        'r', 's', 't', 'u', 'f', 'kh', 'ts', 'ch', 'sh', 'shch',
        'іu', 'ia',
        'A', 'B', 'V', 'H', 'G', 'D', 'E', 'Ie', 'Zh', 'Z',
        'Y', 'I', 'I', 'I', 'K', 'L', 'M', 'N', 'O', 'P',
        'R', 'S', 'T', 'U', 'F', 'Kh', 'Ts', 'Ch', 'Sh', 'Shch',
        'Iu', 'Ia',
    ];
    
    private array $translateDirSourceFirstSymbol = [
        'є', 'ї', 'й', 'ю', 'я',
        'Є', 'Ї', 'Й', 'Ю', 'Я',
    ];
    
    private array $translateDirDestinationFirstSymbol = [
        'ye', 'yi', 'y', 'yu', 'ya',
        'Ye', 'Yi', 'Y', 'Yu', 'Ya',
    ];
    
    private array $ignoreSymbol = [
        'ь', 'Ь', '\'', '’', 'ʼ',
    ];
    
    private array $zghSymbolSource = [
        'зг', 'Зг', 'зГ', 'ЗГ',
    ];
    
    private array $zghSymbolDestinaition = [
        'zgh', 'Zgh', 'zGh', 'ZGH',
    ];

    /**
     * 
     * @param string $wordRaw
     * @return string
     */
    public function transliterate(string $wordRaw): string
    {
        $translated = '';
        
        $wordSourceZghReplaced = str_replace($this->zghSymbolSource, $this->zghSymbolDestinaition, $wordRaw);
        
        $wordSourceList = $this->strSplitUnicode($wordSourceZghReplaced);
        
        foreach ($wordSourceList AS $key => $value) {
            if (in_array($value, $this->ignoreSymbol)) {
                continue;
            }
            if (0 === $key AND in_array($value, $this->translateDirSourceFirstSymbol)) {
                $translated .= str_ireplace($this->translateDirSourceFirstSymbol, $this->translateDirDestinationFirstSymbol, $value);
            } else {
                $translated .= str_ireplace($this->translateDirSource, $this->translateDirDestination, $value);
            }
        }
        
        return $translated;
    }
    
    private function strSplitUnicode(string $str, int $l = 0) 
    {
        if ($l > 0) {
            $ret = [];
            $len = mb_strlen($str);
            for ($i = 0; $i < $len; $i += $l) {
                $ret[] = mb_substr($str, $i, $l);
            }
            return $ret;
        }
        return preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY);
    }
}
