<?php

abstract class Sse_Basic {
	
	protected $title;
	protected $desc;
	protected $id;
	protected $subtitle;
	
	abstract protected function display();
}
