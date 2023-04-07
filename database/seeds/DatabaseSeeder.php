<?php

use App\Domain\Admin\Models\Admin;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionSeeder::class);
        $this->call(TaxonomySeeder::class);
        $this->call(PostSeeder::class);
        $this->call(PageSeeder::class);
        $this->call(MenuSeeder::class);
        factory(Admin::class, 50)->create();
    }
}
