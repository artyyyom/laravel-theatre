<?php

namespace App\Repositories;

use App\Repositories\Repository;

use App\Row_Place;

class RowsPlacesRepository extends Repository {

	public function __construct(Row_Place $row_place) {
		$this->model = $row_place;
	}
}