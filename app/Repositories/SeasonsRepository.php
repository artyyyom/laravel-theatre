<?php

namespace App\Repositories;

use App\Repositories\Repository;

use App\Season;

class SeasonsRepository extends Repository {

	public function __construct(Season $season) {
		$this->model = $season;
	}
}