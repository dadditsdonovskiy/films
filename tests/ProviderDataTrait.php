<?php
/**
 * Copyright © 2021 GBKSOFT. Web and Mobile Software Development.
 * See LICENSE.txt for license details.
 */
declare(strict_types=1);

namespace Tests;

use Illuminate\Support\Str;

trait ProviderDataTrait
{
    /**
     * Get test class suffix
     * @return string
     */
    protected function getTestClassSuffix(): string
    {
        return 'Test';
    }

    protected function getProviderData(?string $type = null): array
    {
        $callClass = static::class;
        $basePath = dirname((new \ReflectionClass(static::class))->getFileName());

        $baseName = self::basename($callClass);
        $testClassSuffix = $this->getTestClassSuffix();
        if (Str::endsWith($baseName, $testClassSuffix)) {
            $baseName = substr($baseName, 0, - strlen($testClassSuffix));
        }
        $data = require $basePath . '/providers/' . self::camel2id($baseName) . '.php';
        return $type !== null ? $data[$type] : $data;
    }

    /**
     * Returns the trailing name component of a path.
     * This method is similar to the php function `basename()` except that it will
     * treat both \ and / as directory separators, independent of the operating system.
     * This method was mainly created to work on php namespaces. When working with real
     * file paths, php's `basename()` should work fine for you.
     * Note: this method is not aware of the actual filesystem, or path components such as "..".
     *
     * @param string $path A path string.
     * @param string $suffix If the name component ends in suffix this will also be cut off.
     * @return string the trailing name component of the given path.
     * @see https://secure.php.net/manual/en/function.basename.php
     */
    public static function basename($path, $suffix = '')
    {
        if (($len = mb_strlen($suffix)) > 0 && mb_substr($path, -$len) === $suffix) {
            $path = mb_substr($path, 0, -$len);
        }
        $path = rtrim(str_replace('\\', '/', $path), '/\\');
        if (($pos = mb_strrpos($path, '/')) !== false) {
            return mb_substr($path, $pos + 1);
        }

        return $path;
    }

    /**
     * Converts a CamelCase name into an ID in lowercase.
     * Words in the ID may be concatenated using the specified character (defaults to '-').
     * For example, 'PostTag' will be converted to 'post-tag'.
     * @param string $name the string to be converted
     * @param string $separator the character used to concatenate the words in the ID
     * @param bool|string $strict whether to insert a separator between two consecutive uppercase chars, defaults to false
     * @return string the resulting ID
     */
    public static function camel2id($name, $separator = '-', $strict = false)
    {
        $regex = $strict ? '/\p{Lu}/u' : '/(?<!\p{Lu})\p{Lu}/u';
        if ($separator === '_') {
            return mb_strtolower(trim(preg_replace($regex, '_\0', $name), '_'), 'UTF-8');
        }

        return mb_strtolower(trim(str_replace('_', $separator, preg_replace($regex, $separator . '\0', $name)), $separator), 'UTF-8');
    }
}
