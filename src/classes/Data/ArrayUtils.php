<?php

namespace Data;

class ArrayUtils
{
    public static function makeFlat(array $array, array $keyFields = [])
    {
        $result = [];

        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $intersect = array_intersect($keyFields, array_keys($value));
                if ($intersect) {
                    $prefix = $value[current($intersect)];
                } else {
                    $prefix = $key;
                }

                foreach (self::makeFlat($value, $keyFields) as $subKey => $subValue) {
                    $result["{$prefix}.{$subKey}"] = $subValue;
                }
            } else {
                $result[$key] = $value;
            }
        }

        return $result;
    }

    public static function calcChanges(array $oldArray, array $newArray, array $keyFields = [])
    {
        $changes = [];

        $oldArray = self::makeFlat($oldArray, $keyFields);
        $newArray = self::makeFlat($newArray, $keyFields);

        foreach ($oldArray as $key => $value) {
            if (array_key_exists($key, $newArray)) {
                if ($oldArray[$key] != $newArray[$key]) {
                    $changes[$key] = [
                        'type' => '*',
                        'old'  => $oldArray[$key],
                        'new'  => $newArray[$key],
                    ];
                }

                unset($newArray[$key]);
            } else {
                $changes[$key] = [
                    'type' => '-',
                    'old'  => $oldArray[$key],
                    'new'  => null,
                ];
            }
        }

        foreach ($newArray as $key => $value) {
            $changes[$key] = [
                'type' => '+',
                'old'  => null,
                'new'  => $value
            ];
        }

        return $changes;
    }

    public static function changesToTextArray($changes)
    {
        $textChanges = [];

        // Преобразуем изменения в более читабельный вид
        foreach ($changes as $key => ['old' => $old, 'new' => $new]) {
            $textChanges[] = $key . ": " . json_encode($old, JSON_UNESCAPED_UNICODE) . " => " . json_encode($new, JSON_UNESCAPED_UNICODE);
        }

        return $textChanges;
    }
}
