<?php
/**
 * Created by PhpStorm.
 * User: HP15
 * Date: 9/8/2019
 * Time: 11:29 م
 */

namespace App\Repository;
// models
use App\Facades\FileFacade;
use App\User;

class UserRepository
{

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function __call($name, $arguments)
    {
        return $this->user->$name(...$arguments);
    }


    public function add($request) {
        $data = $request->validated();
        $data['image_id'] = FileFacade::storeImageId($request->image, null, null , true);
        $data['password'] = bcrypt($request->password);
        $this->user->create($data);
    }

    public function update($request , $user) {
        $data = $request->validated();
        $data['image_id'] = FileFacade::storeImageId($request->image,$user, 'image_id' , false);
        if($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);
    }

}