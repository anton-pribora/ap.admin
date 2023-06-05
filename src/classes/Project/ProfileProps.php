<?php

namespace Project;

trait ProfileProps
{
    public function id()
    {
        return $this->data['id'] ?? null;
    }

    public function setId($value)
    {
        $this->data['id'] = $value;
        return $this;
    }

    public function type()
    {
        return $this->data['type'] ?? null;
    }

    public function setType($value)
    {
        $this->data['type'] = $value;
        return $this;
    }

    public function del()
    {
        return $this->data['del'] ?? null;
    }

    public function setDel($value)
    {
        $this->data['del'] = $value;
        return $this;
    }

    public function firstName()
    {
        return $this->meta('name.first');
    }

    public function setFirstName($value)
    {
        $this->setMeta('name.first', $value);
        return $this;
    }

    public function lastName()
    {
        return $this->meta('name.last');
    }

    public function setLastName($value)
    {
        $this->setMeta('name.last', $value);
        return $this;
    }

    public function middleName()
    {
        return $this->meta('name.middle');
    }

    public function setMiddleName($value)
    {
        $this->setMeta('name.middle', $value);
        return $this;
    }

    public function post()
    {
        return $this->meta('post');
    }

    public function setPost($value)
    {
        $this->setMeta('post', $value);
        return $this;
    }

    public function name()
    {
        return $this->shortName();
    }

    public function shortName()
    {
        return join(' ', array_filter(array_map('trim', [(string) $this->lastName(), (string) $this->firstName()])));
    }

    public function fullName()
    {
        return join(' ', array_filter(array_map('trim', [(string) $this->lastName(), (string) $this->firstName(), (string) $this->middleName()])));
    }

    public function photoId()
    {
        return $this->meta('photo');
    }

    public function setPhotoId($value)
    {
        $this->setMeta('photo', $value);
        return $this;
    }

    public function photo()
    {
        return File::getInstance($this->photoId());
    }

    public function comment()
    {
        return $this->meta('comment');
    }

    public function setComment($value)
    {
         $this->setMeta('comment', $value);
         return $this;
    }

    public function credential()
    {
        $credential = ProfileCredentialRepository::findOne(['profileId' => $this->id()]);

        if (!$credential) {
            $credential = new ProfileCredential();
            $credential->setProfileId($this->id());
        }

        return $credential;
    }
}
