<?php


namespace App\Services;


use App\Repositories\RoleRepository;
use App\Traits\UploadTrait;
use App\User;

class UserService
{
    use UploadTrait;

    private $roleRepository;

    public function __construct()
    {
        $this->roleRepository = app(RoleRepository::class);
    }

    public function getUserRoles()
    {
        $roles = [];
        if(auth()->user()->role_id == 1)
        {
            $roles = $this->roleRepository->getAll();
        }

        return $roles;
    }

    public function getUserForEdit($userId)
    {
        switch (auth()->user()->role_id)
        {
            case 1: {
                $user = User::find($userId);
                break;
            }
            case 2: {
                $user = User::find($userId);
                if($user->role_id != 1) break;
            }
            default: {
                $user = auth()->user();
            }
        }

        return $user;
    }

    public function uploadAvatar($userEmail, $image)
    {
        $imgData = $this->resizeImage($image, 300, 50);
        $name = str_slug($userEmail) . '_' . time();
        $folder = '/uploads/images/';
        $filePath = $folder . $name . '_resized.' . $image->getClientOriginalExtension();
        $newFilePath = '/storage/uploads/images/resized_' . $name . time() . '.' . $image->getClientOriginalExtension();

        switch ($image->getClientOriginalExtension())
        {
            case "png":
                imagepng($imgData, public_path() . $newFilePath);
                break;
            case "jpeg":
            case "jpg":
                imagejpeg($imgData, public_path() . $newFilePath);
                break;
            case "gif":
                imagegif($imgData, public_path() . $newFilePath);
                break;
            default:
                imagejpeg($imgData, public_path() . $newFilePath);
                break;
        }

        $this->uploadOne($image, $folder, 'public', $name);

        return $newFilePath;
    }

    public function deleteImageIfExist($userId)
    {
        $user = User::find($userId);

        if($user->avatar)
        {
            unlink(public_path() . $user->avatar);
            $user->avatar = null;

            return $user->save();
        }

        return false;
    }
}