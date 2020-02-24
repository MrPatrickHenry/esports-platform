<?php

use Illuminate\Database\Seeder;

class TrackingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tracking')->insert([
            'files_id' => '62',
            'user_id' => '2',
            'impression' => '1',
            'click'=>'1',
            'userDevice'=>'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:71.0) Gecko/20100101 Firefox/71.0,Region:Utah,City:Salt Lake City',
            'ipaddress'=>'166.70.97.107'
        ]);
    }
}
