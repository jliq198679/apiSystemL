<?php


namespace App\Services;


use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class UsersService
{
    public function list($rol)
    {
        $users = User::query()->whereJsonContains('roles',$rol)->get();
        return $users;
    }

    public function store($input)
    {
        if(isset($input['password']))
            Arr::set($input,'password',Hash::make('password'));
        return User::query()->create($input);
    }

    public function show($id)
    {
        return User::find($id);
    }

    public function update(User $user,$input)
    {
        if(isset($input['password']))
            Arr::set($input,'password',Hash::make('password'));
        return User::query()->where('id',$user->id)->update($input);
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function destroy(User $user)
    {
        return User::query()->where('id',$user->id)->delete();
    }




}
