# Migrations

At first, you have to create a new migration. 

```
% ./new.php my awesome migration
New migration 20211223_092956_my_awesome_migration_75f.php
```

Edit your migration (in folder `dist/`) add some sql queries using db_query() or db_pdo().

When the migration is finished apply it using apply.php:

```
% ./apply.php 
Apply migration 20211223_092956_my_awesome_migration_75f.php
```

If you want to see all migrations use list.php:

```
% ./list.php 
Applied             Migration
2021-12-23 07:30:55 20211223_092956_my_awesome_migration_75f.php
```

## Example

Typical migration file:

```php
<?php

namespace migrations;

require_once(__DIR__ . '/../lib.inc.php');

// my awesome migration
Db()->query('create table test (data varchar(255))');

```