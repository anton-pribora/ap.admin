<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace Replica;

use ApCode\Database\DatabaseInterface;

class ReplicaExporter
{
    private $db;
    
    public function __construct(DatabaseInterface $db)
    {
        $this->db = $db;
    }
    
    public function update(ReplicaRecordInterface $record)
    {
        foreach ($record->replicaTables() as $table) {
            /* @var $table ReplicaTable */
            $table->apply($this->db);
        }
    }
    
    public function delete(ReplicaRecordInterface $record)
    {
        foreach ($record->replicaTables() as $table) {
            /* @var $table ReplicaTable */
            $table->delete($this->db);
        }
    }
}