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

// Home > \App\Designs > Create

Breadcrumbs::for('admin.designs.create', function (BreadcrumbsGenerator $trail) {
    $trail->parent('admin.designs.index');
    $trail->push(__('Tạo'), route('admin.designs.create'));
});

// Home > \App\Designs > [admin] > Edit
Breadcrumbs::for('admin.designs.edit', function (BreadcrumbsGenerator $trail, \App\Designs $design) {
    $trail->parent('admin.designs.index');
    $trail->push($design->name, '#');
    $trail->push(__('Chỉnh sửa'), route('admin.designs.edit', $design));
});

/*
|--------------------------------------------------------------------------
| Application Breadcrumbs
|--------------------------------------------------------------------------
*/


// Home > Posts
Breadcrumbs::for('admin.posts.index', function (BreadcrumbsGenerator $trail) {
    $trail->parent('admin.posts.index');
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

// Home > Staffs
Breadcrumbs::for('admin.staffs.index', function (BreadcrumbsGenerator $trail) {
    $trail->parent('admin.designs.index');
    $trail->push(__('Nhân viên'), route('admin.staffs.index'), ['icon' => 'fal fa-edit']);
});

// Home > Staffs > Create

Breadcrumbs::for('admin.staffs.create', function (BreadcrumbsGenerator $trail) {
    $trail->parent('admin.staffs.index');
    $trail->push(__('Tạo'), route('admin.staffs.create'));
});

// Home > Staffs > [admin] > Edit
Breadcrumbs::for('admin.staffs.edit', function (BreadcrumbsGenerator $trail, \App\Staffs $staff) {
    $trail->parent('admin.staffs.index');
    $trail->push($staff->name, '#');
    $trail->push(__('Chỉnh sửa'), route('admin.staffs.edit', $staff));
});

// Home > Brands
Breadcrumbs::for('admin.brands.index', function (BreadcrumbsGenerator $trail) {
    $trail->parent('admin.designs.index');
    $trail->push(__('Xưởng'), route('admin.brands.index'), ['icon' => 'fal fa-edit']);
});

// Home > Brands > Create

Breadcrumbs::for('admin.brands.create', function (BreadcrumbsGenerator $trail) {
    $trail->parent('admin.brands.index');
    $trail->push(__('Tạo'), route('admin.brands.create'));
});

// Home > Brands > [admin] > Edit
Breadcrumbs::for('admin.brands.edit', function (BreadcrumbsGenerator $trail, \App\Brands $brand) {
    $trail->parent('admin.brands.index');
    $trail->push($brand->name, '#');
    $trail->push(__('Chỉnh sửa'), route('admin.brands.edit', $brand));
});

// Home > \App\Produces
Breadcrumbs::for('admin.produces.index', function (BreadcrumbsGenerator $trail) {
    $trail->parent('admin.designs.index');
    $trail->push(__('Nguyên liệu'), route('admin.produces.index'), ['icon' => 'fal fa-edit']);
});

// Home > \App\Produces > Create

Breadcrumbs::for('admin.produces.create', function (BreadcrumbsGenerator $trail) {
    $trail->parent('admin.produces.index');
    $trail->push(__('Tạo'), route('admin.produces.create'));
});

// Home > \App\Produces > [admin] > Edit
Breadcrumbs::for('admin.produces.edit', function (BreadcrumbsGenerator $trail, \App\Produces $produce) {
    $trail->parent('admin.produces.index');
    $trail->push($produce->name, '#');
    $trail->push(__('Chỉnh sửa'), route('admin.produces.edit', $produce));
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
