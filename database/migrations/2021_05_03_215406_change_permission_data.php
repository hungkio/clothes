<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domain\Acl\Models\Permission;

class ChangePermissionData extends Migration
{
    public function up()
    {
        $permissions_remove = [
            [
                'name' => 'taxons.view',
                'en' => ['display_name' => 'View Taxon'],
                'vi' => ['display_name' => 'Xem danh mục'],
            ],
            [
                'name' => 'taxons.create',
                'en' => ['display_name' => 'Create Taxon'],
                'vi' => ['display_name' => 'Thêm danh mục'],
            ],
            [
                'name' => 'taxons.update',
                'en' => ['display_name' => 'Update Taxon'],
                'vi' => ['display_name' => 'Cập nhật danh mục'],
            ],
            [
                'name' => 'taxons.delete',
                'en' => ['display_name' => 'Delete Taxon'],
                'vi' => ['display_name' => 'Xóa danh mục'],
            ],
        ];

        $permissions_add = [

            [
                'name' => 'menus.delete',
                'en' => ['display_name' => 'Delete Menu'],
                'vi' => ['display_name' => 'Xóa Menu'],
            ],
        ];

        foreach ($permissions_remove as $permission) {
            Permission::where('name', $permission['name'])->delete();
        }

        foreach ($permissions_add as $permission) {
            Permission::create($permission);
        }
    }

    public function down()
    {
        $permissions_remove = [
            [
                'name' => 'taxons.view',
                'en' => ['display_name' => 'View Taxon'],
                'vi' => ['display_name' => 'Xem danh mục'],
            ],
            [
                'name' => 'taxons.create',
                'en' => ['display_name' => 'Create Taxon'],
                'vi' => ['display_name' => 'Thêm danh mục'],
            ],
            [
                'name' => 'taxons.update',
                'en' => ['display_name' => 'Update Taxon'],
                'vi' => ['display_name' => 'Cập nhật danh mục'],
            ],
            [
                'name' => 'taxons.delete',
                'en' => ['display_name' => 'Delete Taxon'],
                'vi' => ['display_name' => 'Xóa danh mục'],
            ],
        ];

        $permissions_add = [

            [
                'name' => 'menus.delete',
                'en' => ['display_name' => 'Delete Menu'],
                'vi' => ['display_name' => 'Xóa Menu'],
            ],
        ];

        foreach ($permissions_add as $permission) {
            Permission::where('name', $permission['name'])->delete();
        }

        foreach ($permissions_remove as $permission) {
            Permission::create($permission);
        }
    }

}
