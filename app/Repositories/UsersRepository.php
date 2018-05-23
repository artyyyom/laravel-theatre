<?php

namespace App\Repositories;

use App\Repositories\Repository;

use App\User;

class UsersRepository extends Repository {

	public function __construct(User $user) {
		$this->model = $user;
	}
}