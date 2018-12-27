<?php

Timer('system')->start();

Module('errors')->executeOnce('init.php');
Module('auth')->executeOnce('init.php');
