<?php

namespace App\Repositories;

use App\Models\User;

interface UserRepositoryInterface
{

    public function store(array $data);
    public function update(User $user, array $data);
    public function destroy(User $user);
}
