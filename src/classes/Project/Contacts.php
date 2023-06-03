<?php

namespace Project;

trait Contacts
{
    public function getEmails()
    {
        $result = [];

        foreach ($this->contactsRaw() as $contact) {
            if ($contact['type'] === 'email') {
                $result[] = $contact['value'];
            }
        }

        return array_unique($result);
    }

    public function email()
    {
        return $this->getContact('email');
    }

    public function phone()
    {
        return $this->getContact('phone');
    }

    public function getContact($type)
    {
        foreach ($this->contactsRaw() as $contact) {
            if ($contact['type'] === $type && ($contact['primary'] ?? false)) {
                return $contact['value'];
            }
        }

        foreach ($this->contactsRaw() as $contact) {
            if ($contact['type'] === $type) {
                return $contact['value'];
            }
        }

        return null;
    }

    public function getPhones()
    {
        $result = [];

        foreach ($this->contactsRaw() as $contact) {
            if ($contact['type'] === 'phone') {
                $result[] = $contact['value'];
            }
        }

        return array_unique($result);
    }

    public function contactsRaw()
    {
        return $this->meta('contacts', []);
    }

    public function setContactsRaw(array $contacts)
    {
        $sorted = [];

        // Сортируем значения контактов, иначе невозможно потом по ним будет искать в базе
        foreach ($contacts as $key => $value) {
            if (is_array($value)) {
                ksort($value);
            }

            $sorted[$key] = $value;
        }

        $this->setMeta('contacts', $sorted);
        return $this;
    }
}
