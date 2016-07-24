<?php

abstract class Sse_Basic {
	
	protected $title;
	protected $desc;
	protected $id;
	protected $subtitle;
	protected $value;
	protected $type;
	
	protected function __construct(array $fields){
		foreach($fields as $k=>$v){
			$this->$k = $v;
		}
	}
	
	abstract protected function display();
	abstract static protected function verify($value);
}