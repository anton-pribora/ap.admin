<?php

// Настройка биллетов
ApCode\Billet\BilletRepository::addStorage(new ApCode\Billet\Storage\Memory());
ApCode\Billet\BilletRepository::addStorage(new ApCode\Billet\Storage\Database(Db()));