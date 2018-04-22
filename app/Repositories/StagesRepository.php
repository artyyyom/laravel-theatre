<?php

namespace App\Repositories;

use App\Repositories\Repository;

use App\Stage;

class StagesRepository extends Repository {

	public function __construct(Stage $stage) {
		$this->model = $stage;
	}
}