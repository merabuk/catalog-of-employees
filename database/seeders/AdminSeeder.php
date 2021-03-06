<?php

namespace Database\Seeders;

use App\Models\Position;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\ImageModel;
use Image;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRoleId = Role::getRoleBySlug('admin')->id;
        for ($i=1; $i < 4; $i++) {
            $admin = new User();
            $admin->name = 'Admin'.$i;
            $admin->position_id = null;
            $admin->date_of_employment = now();
            $admin->phone = '+38095000000'.$i;
            $admin->email = 'admin'.$i.'@gmail.com';
            $admin->email_verified_at = now();
            $admin->password = Hash::make('password');
            $admin->remember_token = Str::random(10);
            $admin->salary = 500;
            $admin->head_id = null;
            $admin->admin_created_id = $i;
            $admin->admin_updated_id = $i;
            $admin->role_id = $adminRoleId;
            $admin->save();
            $imageName = Str::random(40);
            $imagePath = 'images/'.$imageName.'.jpg';
            $fullPath = public_path('storage/'.$imagePath);
            Image::make(public_path('images/cosmocat.jpg'))
                    ->fit(300)
                    ->save($fullPath, 80);
            $image = new ImageModel();
            $image->path = $imagePath;
            $image->user_id = $admin->id;
            $image->save();
        }
    }
}
