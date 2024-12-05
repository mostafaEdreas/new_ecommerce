<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    public function run()
    {
        // Permissions
        $permissions = [
            'menus', 'menu-items', 'sliders', 'home-sliders', 'intro-sliders',
            'offers-sliders', 'home-images', 'gallery-images', 'gallery-videos',
            'about', 'editAbout', 'aboutStrucs', 'blogs', 'blog-categories',
            'blog-items', 'categories', 'attributes', 'brands', 'colors',
            'products', 'countries', 'regions', 'areas', 'services', 'pages',
            'coupons', 'branches', 'store-info', 'orders', 'reports', 'seo',
            'settings', 'shipping', 'deliveries', 'payment-methods', 'winners',
            'users', 'admins', 'roles', 'permissions', 'configrations', 'languages',
            'website-content', 'shipping-methods', 'store_info', 'installment_partners',
            'contact-us', 'counters', 'testimonials', 'teams'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Admin Role
        $adminRole = Role::create(['name' => 'admin']);

        // Assign all permissions to admin
        $adminRole->givePermissionTo(Permission::all());
        User::find(1)->assignRole('admin') ;
    }
}
