<?php


use Faker\Factory;
use Phinx\Seed\AbstractSeed;

class Forms2 extends AbstractSeed
{
    public function run()
    {
        $faker = Faker\Factory::create();
        $data = [];

        for ($i = 0; $i < 1000; $i++){
            $data[$i] = [
                'title' => $faker->sentence($nbWords = 2),
                'content' => $faker->text(),
            ];
        }
        $this->table('forms2')->insert($data)->save();
    }
}
