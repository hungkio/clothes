<?php

use App\Domain\Acl\Models\Permission;
use Illuminate\Database\Migrations\Migration;

class AddPagePostBannerPermissionsTable extends Migration
{
    public function up()
    {
        $permissions = [
            [
                'name' => 'pages.view',
                'en' => ['display_name' => 'View Page'],
                'vi' => ['display_name' => 'Xem trang'],
            ],
            [
                'name' => 'pages.create',
                'en' => ['display_name' => 'Create Page'],
                'vi' => ['display_name' => 'Thêm trang'],
            ],
            [
                'name' => 'pages.update',
                'en' => ['display_name' => 'Update Page'],
                'vi' => ['display_name' => 'Cập nhật trang'],
            ],
            [
                'name' => 'pages.delete',
                'en' => ['display_name' => 'Delete Page'],
                'vi' => ['display_name' => 'Xóa trang'],
            ],

            [
                'name' => 'products.view',
                'en' => ['display_name' => 'View Post'],
                'vi' => ['display_name' => 'Xem sản phẩm'],
            ],
            [
                'name' => 'products.create',
                'en' => ['display_name' => 'Create Post'],
                'vi' => ['display_name' => 'Thêm sản phẩm'],
            ],
            [
                'name' => 'products.update',
                'en' => ['display_name' => 'Update Post'],
                'vi' => ['display_name' => 'Cập nhật sản phẩm'],
            ],
            [
                'name' => 'products.delete',
                'en' => ['display_name' => 'Delete Post'],
                'vi' => ['display_name' => 'Xóa sản phẩm'],
            ],

            [
                'name' => 'banners.view',
                'en' => ['display_name' => 'View Banner'],
                'vi' => ['display_name' => 'Xem banner'],
            ],
            [
                'name' => 'banners.create',
                'en' => ['display_name' => 'Create Banner'],
                'vi' => ['display_name' => 'Thêm banner'],
            ],
            [
                'name' => 'banners.update',
                'en' => ['display_name' => 'Update Banner'],
                'vi' => ['display_name' => 'Cập nhật banner'],
            ],
            [
                'name' => 'banners.delete',
                'en' => ['display_name' => 'Delete Banner'],
                'vi' => ['display_name' => 'Xóa banner'],
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }

    public function down()
    {
        $permissions = [
            [
                'name' => 'pages.view',
                'en' => ['display_name' => 'View Page'],
                'vi' => ['display_name' => 'Xem trang'],
            ],
            [
                'name' => 'pages.create',
                'en' => ['display_name' => 'Create Page'],
                'vi' => ['display_name' => 'Thêm trang'],
            ],
            [
                'name' => 'pages.update',
                'en' => ['display_name' => 'Update Page'],
                'vi' => ['display_name' => 'Cập nhật trang'],
            ],
            [
                'name' => 'pages.delete',
                'en' => ['display_name' => 'Delete Page'],
                'vi' => ['display_name' => 'Xóa trang'],
            ],

            [
                'name' => 'products.view',
                'en' => ['display_name' => 'View Post'],
                'vi' => ['display_name' => 'Xem sản phẩm'],
            ],
            [
                'name' => 'products.create',
                'en' => ['display_name' => 'Create Post'],
                'vi' => ['display_name' => 'Thêm sản phẩm'],
            ],
            [
                'name' => 'products.update',
                'en' => ['display_name' => 'Update Post'],
                'vi' => ['display_name' => 'Cập nhật sản phẩm'],
            ],
            [
                'name' => 'products.delete',
                'en' => ['display_name' => 'Delete Post'],
                'vi' => ['display_name' => 'Xóa sản phẩm'],
            ],

            [
                'name' => 'banners.view',
                'en' => ['display_name' => 'View Banner'],
                'vi' => ['display_name' => 'Xem banner'],
            ],
            [
                'name' => 'banners.create',
                'en' => ['display_name' => 'Create Banner'],
                'vi' => ['display_name' => 'Thêm banner'],
            ],
            [
                'name' => 'banners.update',
                'en' => ['display_name' => 'Update Banner'],
                'vi' => ['display_name' => 'Cập nhật banner'],
            ],
            [
                'name' => 'banners.delete',
                'en' => ['display_name' => 'Delete Banner'],
                'vi' => ['display_name' => 'Xóa banner'],
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::where('name', $permission['name'])->delete();
        }
    }
}
