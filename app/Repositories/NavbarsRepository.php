<?php

namespace App\Repositories;

use App\Repositories\Repository;

use App\Navbar;

class NavbarsRepository extends Repository {

	public function __construct(Navbar $navbar) {
		$this->model = $navbar;
	}
}