<?php

namespace App\Repositories;

use App\Repositories\Repository;
use App\Performance;

class PerformancesRepository extends Repository {

	public function __construct(Performance $performance) {
		$this->model = $performance;
	}
}