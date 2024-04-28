<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Category;
use App\Models\OrderStatus;
use App\Models\DeliveryType;
use App\Models\RestaurantStatus;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DeliveryType::create([
            'name' => 'Pickup',
        ]);

        DeliveryType::create([
            'name' => 'Delivery',
        ]);

        Category::create([
            'name' => 'Desert',
        ]);

        Category::create([
            'name' => 'Asian',
        ]);

        Category::create([
            'name' => 'Western',
        ]);

        Category::create([
            'name' => 'Melayu',
        ]);

        Category::create([
            'name' => 'Arab',
        ]);

        $admin_role = Role::create([
            'name' => 'admin', 
            'guard_name' => 
            'web'
        ]);

        $manager_role = Role::create([
            'name' => 'Manager', 
            'guard_name' => 
            'web'
        ]);

        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin@1234')
        ]);

        $admin->roles()->attach($admin_role, ['model_type' => 'App\Models\User']);

        $manager = User::create([
            'name' => 'manager',
            'email' => 'manager@gmail.com',
            'password' => Hash::make('manager@1234')
        ]);

        $manager->roles()->attach($manager_role, ['model_type' => 'App\Models\User']);

        OrderStatus::create([
            'name' => 'Pending',
        ]);

        OrderStatus::create([
            'name' => 'Accepted',
        ]);

        OrderStatus::create([
            'name' => 'Rejected',
        ]);

        OrderStatus::create([
            'name' => 'Completed',
        ]);

        RestaurantStatus::create([
            'category' => 'Status',
            'name' => 'Enabled',
        ]);

        RestaurantStatus::create([
            'category' => 'Status',
            'name' => 'Disabled / Banned',
        ]);

        RestaurantStatus::create([
            'category' => 'Approval',
            'name' => 'Approved',
        ]);

        RestaurantStatus::create([
            'category' => 'Approval',
            'name' => 'Rejected',
        ]);

        RestaurantStatus::create([
            'category' => 'Status',
            'name' => 'Pending',
        ]);

        RestaurantStatus::create([
            'category' => 'Approval',
            'name' => 'Pending',
        ]);
    }
}
