<?php

namespace  Murdej\ActiveRow;

class DBSelect extends DBCollection// \Nette\Object implements \Iterator, \ArrayAccess, \Countable
{
	public $selection;
	
	function __construct($repo, $selection = null)
	{
		$this->repository = $repo;
		$this->selection = $selection ? $selection : $repo->newTable();
		$order = $this->repository->tableInfo->defaultOrder;
		if ($order) $this->order($order);
	}
		
	public function order($columns)
	{
		$this->selection->order($columns);
		return $this;
	}

	public function getSelection()
	{
		return $this->selection;
	}
	
	public function where()
	{
		$args = func_get_args();
		if (count($args) == 1 && is_array($args[0]))
		{
			foreach ($args[0] as $key => $value) 
			{
				if (is_int($key))
					$this->selection->where($value);
				else
					$this->selection->where($key, $value);
			}
		} else call_user_func_array([$this->selection, 'where'], $args);
		return $this;
	}

	public function whereOr(...$args)
	{
		$this->selection->whereOr(...$args);
		/*$args = func_get_args();
		if (count($args) == 1 && is_array($args[0]))
		{
			foreach ($args[0] as $key => $value) 
			{
				if (is_int($key))
					$this->selection->where($value);
				else
					$this->selection->where([$key => $value]);
			}
		} else call_user_func_array([$this->selection, 'whereOr'], $args);
		return $this;*/
	}
	
	public function limit($limit, $offset = null)
	{
		$this->selection->limit($limit, $offset);
		return $this;
	}

	public function sum()
	{
		return call_user_func_array([$this->selection, 'sum'], func_get_args());
	}
	
	public function delete()
	{
		return call_user_func_array([$this->selection, 'delete'], func_get_args());
	}

	public function max()
	{
		return call_user_func_array([$this->selection, 'max'], func_get_args());
	}

	public function toArray()
	{
		$res = [];
		foreach($this as $i => $el) $res[$i] = $el;
		
		return $res;
	}
	
	public function getAsRows()
	{
		return $this->seletion;
	}
}