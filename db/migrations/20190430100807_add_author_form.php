<?php

use Phinx\Migration\AbstractMigration;

class AddAuthorForm extends AbstractMigration
{
    public function change()
    {
        $forms2 = $this->table('forms2');

        $forms2->addColumn('authorName', 'string')
            ->save();
    }
}
