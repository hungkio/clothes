<?php

use App\Domain\Acl\Models\Permission;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPermissionClients extends Migration
{
    public function up()
    {
        $permissions = [
            [
                'name' => 'contacts.view',
                'en' => ['display_name' => 'View Contacts'],
                'vi' => ['display_name' => 'Xem danh sách liên hệ'],
            ],
            [
                'name' => 'log-search.view',
                'en' => ['display_name' => 'View Log Search'],
                'vi' => ['display_name' => 'Xem lịch sử tìm kiếm'],
            ],

            [
                'name' => 'subscribe-email.view',
                'en' => ['display_name' => 'View Subscribe Email'],
                'vi' => ['display_name' => 'Xem danh sách đăng ký nhận tin'],
            ],
            [
                'name' => 'mail-settings.view',
                'en' => ['display_name' => 'View Mail Setting'],
                'vi' => ['display_name' => 'Xem cài đặt chiến dịch gửi Mail'],
            ],
            [
                'name' => 'mail-settings.create',
                'en' => ['display_name' => 'Create Mail Setting'],
                'vi' => ['display_name' => 'Tạo chiến dịch gửi Mail'],
            ],
            [
                'name' => 'mail-settings.update',
                'en' => ['display_name' => 'Update Mail Setting'],
                'vi' => ['display_name' => 'Cập nhật chiến dịch gửi Mail'],
            ],
            [
                'name' => 'mail-settings.delete',
                'en' => ['display_name' => 'Delete Mail Setting'],
                'vi' => ['display_name' => 'Xóa chiến dịch gửi Mail'],
            ],
            [
                'name' => 'mail-settings.send',
                'en' => ['display_name' => 'Send Mail Setting'],
                'vi' => ['display_name' => 'Gửi chiến dịch Mail'],
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
                'name' => 'contacts.view',
                'en' => ['display_name' => 'View Contacts'],
                'vi' => ['display_name' => 'Xem danh sách liên hệ'],
            ],
            [
                'name' => 'log-search.view',
                'en' => ['display_name' => 'View Log Search'],
                'vi' => ['display_name' => 'Xem lịch sử tìm kiếm'],
            ],

            [
                'name' => 'subscribe-email.view',
                'en' => ['display_name' => 'View Subscribe Email'],
                'vi' => ['display_name' => 'Xem danh sách đăng ký nhận tin'],
            ],
            [
                'name' => 'mail-settings.view',
                'en' => ['display_name' => 'View Mail Setting'],
                'vi' => ['display_name' => 'Xem cài đặt chiến dịch gửi Mail'],
            ],
            [
                'name' => 'mail-settings.create',
                'en' => ['display_name' => 'Create Mail Setting'],
                'vi' => ['display_name' => 'Tạo chiến dịch gửi Mail'],
            ],
            [
                'name' => 'mail-settings.update',
                'en' => ['display_name' => 'Update Mail Setting'],
                'vi' => ['display_name' => 'Cập nhật chiến dịch gửi Mail'],
            ],
            [
                'name' => 'mail-settings.delete',
                'en' => ['display_name' => 'Delete Mail Setting'],
                'vi' => ['display_name' => 'Xóa chiến dịch gửi Mail'],
            ],
            [
                'name' => 'mail-settings.send',
                'en' => ['display_name' => 'Send Mail Setting'],
                'vi' => ['display_name' => 'Gửi chiến dịch Mail'],
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::where('name', $permission['name'])->delete();
        }
    }
}
