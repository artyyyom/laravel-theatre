<?php

namespace App\Repositories;

use App\Repositories\Repository;

use App\Unit;

class UnitsRepository extends Repository {

	public function __construct(Unit $unit) {
		$this->model = $unit;
	}
}