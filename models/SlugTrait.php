<?php

namespace app\models;

use Yii;
use yii\helpers\Inflector;

trait SlugTrait
{
    public function generateUniqueSlug($title)
    {
        // Транслитерация кириллицы в латиницу
        $transliteratedTitle = $this->transliterate($title);

        // Создание slug из транслитерированного заголовка
        $slug = Inflector::slug($transliteratedTitle);
        $baseSlug = $slug;
        $counter = 1;

        // Проверка уникальности slug
        while (static::find()->where(['slug' => $slug])->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    private function transliterate($string)
    {
        $transliterationTable = [
            'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D',
            'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh', 'З' => 'Z', 'И' => 'I',
            'Й' => 'Y', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N',
            'О' => 'O', 'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T',
            'У' => 'U', 'Ф' => 'F', 'Х' => 'Kh', 'Ц' => 'Ts', 'Ч' => 'Ch',
            'Ш' => 'Sh', 'Щ' => 'Shch', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '',
            'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya',
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd',
            'е' => 'e', 'ё' => 'yo', 'ж' => 'zh', 'з' => 'z', 'и' => 'i',
            'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n',
            'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't',
            'у' => 'u', 'ф' => 'f', 'х' => 'kh', 'ц' => 'ts', 'ч' => 'ch',
            'ш' => 'sh', 'щ' => 'shch', 'ъ' => '', 'ы' => 'y', 'ь' => '',
            'э' => 'e', 'ю' => 'yu', 'я' => 'ya',
            // Дополнительные символы
            ' ' => '-', '.' => '', ',' => '', '!' => '', '?' => '',
            ':' => '', ';' => '', '"' => '', "'" => '', '(' => '',
            ')' => '', '[' => '', ']' => '', '{' => '', '}' => '',
            // Удаляем все символы, которые не буквы или цифры
        ];

        return strtr($string, $transliterationTable);
    }
}
