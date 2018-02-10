<?php

namespace App\Repositories;

use App\Repositories\Repository;

use App\Actor;

class ActorsRepository extends Repository {

	public function __construct(Actor $actor) {
		$this->model = $actor;
	}
}