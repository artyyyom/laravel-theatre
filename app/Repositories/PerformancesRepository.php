<?php

namespace App\Repositories;

use App\Repositories\Repository;
use App\Performance;

class PerformancesRepository extends Repository {

	protected $hidden = [
    	'created_at',
    	'updated_at'
    ];
	public function __construct(Performance $performance) {
		$this->model = $performance;
	}
}