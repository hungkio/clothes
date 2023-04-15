<?php

use Illuminate\Database\Seeder;
use App\Domain\Post\Models\Post;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Post::create([
            'user_id' => 1,
            'title' => 'Sản phẩm đầu tiên',
            'description' => 'Mô tả cho sản phẩm đầu tiên',
            'status' => \App\Enums\PostState::Active,
            'slug' => 'bai-viet-dau-tien',
            'body' => 'Nội dung của sản phẩm đầu tiên',
        ]);
    }
}
