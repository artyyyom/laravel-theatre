<?php

namespace App\Repositories;

use App\Repositories\Repository;

use App\Category_Place;

class CategoryPlacesRepository extends Repository {

	public function __construct(Category_Place $category_place) {
		$this->model = $category_place;
	}
}