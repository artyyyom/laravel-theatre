<?php

namespace App\Repositories;

use App\Repositories\Repository;

use App\Employee;

class EmployeesRepository extends Repository {

	public function __construct(Employee $employee) {
		$this->model = $employee;
	}
}