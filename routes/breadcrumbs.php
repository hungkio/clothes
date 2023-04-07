<?php

declare(strict_types=1);

use App\Domain\Acl\Models\Role;
use App\Domain\Admin\Models\Admin;
use App\Domain\Post\Models\Post;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use Spatie\Activitylog\Models\Activity;

// Home
Breadcrumbs::for('admin.designs.index', function (BreadcrumbsGenerator $trail) {
    $trail->push(__('Trang chủ'), route('admin.designs.index'), ['icon' => 'fal fa-home']);
});

/*
|--------------------------------------------------------------------------
| Application Breadcrumbs
|--------------------------------------------------------------------------
*/


// Home > Posts
Breadcrumbs::for('admin.posts.index', function (BreadcrumbsGenerator $trail) {
    $trail->parent('admin.designs.index');
    $trail->push(__('Bài viết'), route('admin.posts.index'), ['icon' => 'fal fa-edit']);
});

// Home > Posts > Create

Breadcrumbs::for('admin.posts.create', function (BreadcrumbsGenerator $trail) {
    $trail->parent('admin.posts.index');
    $trail->push(__('Tạo'), route('admin.posts.create'));
});

// Home > Posts > [admin] > Edit
Breadcrumbs::for('admin.posts.edit', function (BreadcrumbsGenerator $trail, Post $post) {
    $trail->parent('admin.posts.index');
    $trail->push($post->title, '#');
    $trail->push(__('Chỉnh sửa'), route('admin.posts.edit', $post));
});

/*
|--------------------------------------------------------------------------
| System Breadcrumbs
|--------------------------------------------------------------------------
*/

// Home > Admins
Breadcrumbs::for('admin.admins.index', function (BreadcrumbsGenerator $trail) {
    $trail->parent('admin.designs.index');
    $trail->push(__('Tài khoản'), route('admin.admins.index'), ['icon' => 'fal fa-user']);
});

// Home > Admins > Create

Breadcrumbs::for('admin.admins.create', function (BreadcrumbsGenerator $trail) {
    $trail->parent('admin.admins.index');
    $trail->push(__('Tạo'), route('admin.admins.create'));
});

// Home > Admins > [admin] > Edit
Breadcrumbs::for('admin.admins.edit', function (BreadcrumbsGenerator $trail, Admin $admin) {
    $trail->parent('admin.admins.index');
    $trail->push($admin->email, '#');
    $trail->push(__('Chỉnh sửa'), route('admin.admins.edit', $admin));
});
