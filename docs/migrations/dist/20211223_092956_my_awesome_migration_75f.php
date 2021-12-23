<?php

namespace migrations;

require_once(__DIR__ . '/../lib.inc.php');

// my awesome migration
Db()->query('create table test (data varchar(255))');
