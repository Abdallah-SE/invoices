<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
/**
* Run the database seeds.
*
* @return void
*/
public function run()
{
    $permissions = [
        'invoices',
        'invoices_list',
        'paid_invoices_list',
        'unpaid_invoices_list',
        'partial_paid_invoices_list',
        'trashed_invoices',
    ];

    foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
    
}