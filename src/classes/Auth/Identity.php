<?php

namespace Auth;

class Identity
{
    private $activeEntryId;
    private $activeEntryName;
    private $activeEntryType;

    private $entries = [];

    public function setEntry($type, $id, $name)
    {
        $this->entries[$type] = [$id, $name];
    }

    public function require($type)
    {
        if (isset($this->entries[$type])) {
            $this->activeEntryType = $type;
            [$this->activeEntryId, $this->activeEntryName] = $this->entries[$type];
            $this->{$type .'Id'} = $this->activeEntryId;

            return true;
        }

        return false;
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
        return $this->entries[$this->activeEntryType] ?? null;
    }

    public function logout()
    {
        if ($this->activeEntryType) {
            unset($this->entries[$this->activeEntryType]);
        }
    }

    public function getPermit($section, ...$params)
    {
        return Module('permissions')->execute("{$this->activeEntryType}.{$section}", $this->getActiveEntry(), ...$params);
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
