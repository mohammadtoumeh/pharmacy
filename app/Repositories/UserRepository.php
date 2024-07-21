<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository implements UserRepositoryInterface
{

    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function store(array $data)
    {
        try {
            $this->user->phone = $data['phone'];
            $this->user->password = $data['password'];
            $this->user->user_type = $data['user_type'];

            $this->user->save();

            if(isset($data['roles']))
                $this->user->roles()->attach($data['roles']);

            return $this->user;
        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }

    public function update(User $user, array $data)
    {
        $user->update([
            'phone' => $data['phone'] ?? $user->phone,
            'password' => $data['password'] ?? $user->password
        ]);

        if(isset($data['roles']))
            $user->roles()->sync($data['roles']);
        else
            $user->roles()->detach();
    }

    public function destroy(User $user)
    {
        $user->delete();
    }
}
