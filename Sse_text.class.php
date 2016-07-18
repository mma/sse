<?php

class Sse_text extends Sse_Basic {
	
	//protected $fields = array();
	protected $value;
	
	function __toString(){
		return $this->title;
	}
	
	public function __construct(array $fields){
		foreach($fields as $k=>$v){
			$this->$k = $v;
			
		}
	}
	
	public function display(){
		
		?>
		
		<h4 class="field-title"><?php echo $this->title ?></h4>

		<input value="<?php  echo $this->value ?>" type="text" name="<?php echo $this->id ?>""> </input>

		<span class="field-subtitle"> <?php  echo $this->subtitle ?></span>
		<p class="field-desc"> <?php echo $this->desc ?> </p>
		
		
		
		<?php
	}
}