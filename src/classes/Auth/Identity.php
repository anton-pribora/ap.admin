<?php

namespace Auth;

use Project\ProfileRepository;

class Identity
{
    private $activeEntryId;
    private $activeEntryName;
    private $activeEntryType;
    private $activeEntryObject;

    private $entries = [];

    public function setEntry($type, $id, $name)
    {
        $this->entries[$type] = [$id, $name];
    }

    public function getEntry($type)
    {
        return $this->entries[$type] ?? null;
    }

    public function require($types)
    {
        $this->activeEntryId     = null;
        $this->activeEntryType   = null;
        $this->activeEntryName   = null;
        $this->activeEntryObject = null;

        foreach ((array) $types as $type) {
            if (isset($this->entries[$type])) {
                // Подгружаем объекты в зависимости от типа
                $this->activeEntryObject = match ($type) {
                    'consultant' => ProfileRepository::findOne(['id' => $this->entries[$type][0] ?: PHP_INT_MIN]),
                    'console'    => ConsoleBot::getInstance(),
                };

                if ($this->activeEntryObject) {
                    $this->activeEntryType = $type;
                    $this->activeEntryId   = $this->entries[$type][0];
                    $this->activeEntryName = $this->entries[$type][1];
                    break;
                }
            }
        }

        return (bool) $this->activeEntryObject;
    }

    public function getName()
    {
        return $this->activeEntryName;
    }

    public function getId()
    {
        return $this->activeEntryId ? "{$this->activeEntryType}:{$this->activeEntryId}" : '';
    }

    public function getActiveEntry()
    {
        return $this->activeEntryObject;
    }

    public function logout()
    {
        if ($this->activeEntryType) {
            unset($this->entries[$this->activeEntryType]);
        }
    }

    public function getPermit($section, ...$params)
    {
        $action = "{$this->activeEntryType}.{$section}";

        if (Module('permissions')->canExecute($action)) {
            return Module('permissions')->execute($action, $this->getActiveEntry(), ...$params);
        }

        return null;
    }

    public function valid()
    {
        return $this->activeEntryId > 0;
    }

    public function isEmpty()
    {
        return !$this->entries;
    }

    public function __sleep()
    {
        return ['entries'];
    }
}
