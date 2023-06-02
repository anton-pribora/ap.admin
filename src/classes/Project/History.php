<?php

namespace Project;

trait History
{
    public static function historySection()
    {
        return self::tableName();
    }

    public function historyProfileId()
    {
        return 0;
    }

    public function historyCompanyId()
    {
        return 0;
    }

    public function addHistory($text, $meta = null)
    {
        if (!$this->id()) {
            trigger_error('У записи отсутствует идентификатор! Сохраняйте новые объекты перед добавлением истории.', E_USER_WARNING);
        }

        HistoryAdd(
            section:   $this->historySection(),
            text:      $text,
            recordId:  $this->id(),
            profileId: $this->historyProfileId(),
            companyId: $this->historyCompanyId(),
            meta:      $meta
        );
    }
}
