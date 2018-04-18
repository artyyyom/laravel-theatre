<?php

namespace App\Repositories;

use App\Repositories\Repository;

use App\Position;

class PositionsRepository extends Repository {

	public function __construct(Position $position) {
		$this->model = $position;
	}
}