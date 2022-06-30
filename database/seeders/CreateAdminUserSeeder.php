<?php
namespace Database\Seeders; 
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class CreateAdminUserSeeder extends Seeder
{
/**
* Run the database seeds.
*
* @return void
*/
public function run(){
    
    $user = User::create([
    'name' => 'Abdallah Mahmoud',
    'email' => 'superadmin2@abdocoder.com',
    'password' => bcrypt('password'),
    'role_name' => ['super-admin'],
    'status' => 'active',
    ]);
    
    $role = Role::create(['name' => 'super-admin']);
    $permissions = Permission::pluck('id','id')->all();
    
    $role->givePermissionTo(Permission::all());
        
    $user->assignRole([$role->id]);
    
    
     $user2 = User::create([
    'name' => 'xyz Mahmoud',
    'email' => 'xyz@abdocoder.com',
    'password' => bcrypt('password'),
    'role_name' => ['writer'],
    'status' => 'active',
    ]);
    
    $role2 = Role::create(['name' => 'writer']);
    
    $role2->givePermissionTo('paid_invoices_list');
    
    ///// $role = Role::create(['name' => 'moderator'])->givePermissionTo(['publish articles', 'unpublish articles']);
    
    $user2->assignRole([$role2->id]);
    }
}