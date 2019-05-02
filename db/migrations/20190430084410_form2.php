<?php

use Phinx\Migration\AbstractMigration;

class Form2 extends AbstractMigration
{

    public function up()
    {
        $forms2 = $this->table('forms2');

        $forms2->addColumn('title', 'char', ['limit' => 64])
            ->addColumn('content', 'text')
            ->addColumn('created_at', 'timestamp')
            ->create();
    }

    public function down()
    {
        $this->table('forms2')->drop()->save();
    }
}
