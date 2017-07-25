<?php

use Illuminate\Database\Seeder;

class FakeDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LocaleSeeder::class);
        $this->call(BannerSettingSeed::class);
        $this->call(LocationSeeder::class);
        $this->call(ReligionSeeder::class);
        $this->call(ArticleSeeder::class);
        $this->call(TagSeeder::class);
        $this->call(MenuSeeder::class);
        $this->call(MailTemplateSeeder::class);
        $this->call(ArticleRankSeeder::class);
    }
}
