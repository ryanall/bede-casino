<?php

use Illuminate\Database\Seeder;

use BedeCasino\Casino;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $casinos = [
           ['name' => 'Genting Casino Newcastle','longitude' => '-1.617780','latitude' => '54.978252','opening_times' => 'Open 24/7','web_address' => 'http://www.gentingcasinos.co.uk/casino/newcastle','created_at' => '2016-04-01 15:15:41','updated_at' => '2016-04-01 15:49:31'],
           ['name' => 'Aspers Casino Newcastle','longitude' => '-1.619229','latitude' => '54.972894','opening_times' => 'Open 24 hours','web_address' => 'http://www.aspersnewcastle.co.uk/','created_at' => '2016-04-01 15:15:41','updated_at' => '2016-04-01 15:09:23'],
           ['name' => 'Grosvenor Casino Newcastle','longitude' => '-1.624302','latitude' => '54.966608','opening_times' => 'Open 24 hours','web_address' => 'https://www.grosvenorcasinos.com/local-casinos/newcastle','created_at' => '2016-04-01 15:15:41','updated_at' => '2016-04-01 15:13:04'],
           ['name' => 'Grosvenor Casino Stockton','longitude' => '-1.312913','latitude' => '54.561414','opening_times' => 'Open 24 hours except Christmas Day','web_address' => 'https://www.grosvenorcasinos.com/local-casinos/stockton','created_at' => '2016-04-01 15:15:41','updated_at' => '2016-04-01 14:50:07'],
           ['name' => 'Grosvenor Casino Sunderland','longitude' => '-1.379551','latitude' => '54.908468','opening_times' => 'Open 24/7','web_address' => 'https://www.grosvenorcasinos.com/local-casinos/sunderland','created_at' => '2016-04-01 15:15:41','updated_at' => '2016-04-01 15:15:41'],
        ];

        foreach ($casinos as $casino) {
            Casino::firstOrCreate($casino);
            $this->command->info('Added "' . $casino['name'] . '" to database');
        }
    }
}
