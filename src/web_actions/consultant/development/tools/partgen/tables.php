<?php

try {
    ReturnJson(Db()->query('show tables')->fetchColumn());
} catch (Exception $exception) {
    ReturnJsonError('db_error', $exception->getMessage());
}
