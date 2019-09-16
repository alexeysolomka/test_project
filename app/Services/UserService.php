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
        switch (auth()->user()->role->name)
        {
            case 'admin': {
                $user = User::find($userId);
                break;
            }
            case 'moderator': {
                $user = User::find($userId);
                if($user->role->name != 'admin' && $user->role->name != 'moderator') break;
            }
            default: {
                return response('Unauthorized Action', 403);
            }
        }

        return $user;
    }

    public function uploadAvatar($userEmail, $image)
    {
        $imgData = $this->resizeImage($image, 300, 50);
        $name = str_slug($userEmail) . '_' . time();
        $folder = '/uploads/images/';
        $path = public_path() . '/storage/uploads/images';

        if(!realpath($path))
        {
            mkdir($path, 0700, true);
        }

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
