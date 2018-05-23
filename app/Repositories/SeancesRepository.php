<?php

namespace App\Repositories;

use App\Repositories\Repository;

use App\Seance;

class SeancesRepository extends Repository {

	public function __construct(Seance $seance) {
		$this->model = $seance;
	}
}