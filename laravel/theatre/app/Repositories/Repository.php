<?php

namespace  App\Repositories;

abstract class Repository {

	protected $model = FALSE;
	
	public function get($select = '*', $take = FALSE, $where = FALSE) {
		try {
			$builder = $this->model->select($select);

			if($take) 
				$builder->take($take);

			if($where)
				$builder->where($where[0], $where[1], $where[2]);
			
			$builder = $builder->get();

			return $builder;
		}
		catch(\Exception $e) {
			return null;
		}
		
	}

	public function one($id,$attr = array()) {
		$result = $this->model->where('id', $id)->get();
		return $result;
	}
}