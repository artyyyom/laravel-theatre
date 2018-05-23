<?php

namespace App\Repositories;

use App\Repositories\Repository;

use App\Ticket;

class TicketsRepository extends Repository {

	public function __construct(Ticket $ticket) {
		$this->model = $ticket;
	}
}