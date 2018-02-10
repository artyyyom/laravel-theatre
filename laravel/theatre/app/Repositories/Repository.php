<?php

namespace  App\Repositories;

abstract class Repository {

	protected $model = FALSE;
	
	public function get($select = '*', $take = FALSE, $where = FALSE) {
		$builder = $this->model->select($select);

		if($take) 
			$builder->take($take);

		if($where)
			$builder->where($where[0], $where[1], $where[2]);

		return $builder->get();
	}

	public function one($alias,$attr = array()) {
		$result = $this->model->where('id', $alias)->first();
		return $result;
	}
}