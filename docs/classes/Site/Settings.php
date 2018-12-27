<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace Site;

class Settings
{
    public function has($key)
    {
        $res = Db()->query('SELECT "value" FROM "site_settings" WHERE "key" = ? LIMIT 1', [$key]);
        
        return $res->affected() > 0;
    }
    
    public function get($key, $default = NULL)
    {
        $res = Db()->query('SELECT "value" FROM "site_settings" WHERE "key" = ? LIMIT 1', [$key]);
        
        if ($res->affected()) {
            return json_decode_array($res->fetchValue());
        } else {
            $this->set($key, $default);
        }
        
        return $default;
    }
    
    public function set($key, $value)
    {
        $value = json_encode_array($value);
        
        if ($this->has($key)) {
            Db()->query('UPDATE "site_settings" SET "value" = ? WHERE "key" = ?', [$value, $key]);
        } else {
            Db()->query('INSERT INTO "site_settings" ("key", "value") VALUES (?, ?)', [$key, $value]);
        }
    }
}