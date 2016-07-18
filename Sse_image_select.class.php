<?php

class Sse_image_select extends Sse_Basic {
	
	//protected $fields = array();
	
	protected $check;
	protected $options = array();
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
		$max = count($this->options);

		?>
		
		<h4 class="field-title"><?php echo $this->title ?></h4>
		
		<?php foreach($this->options as $k=>$v){ ?>
		
		<div class="inline-image">
			<img class="image" alt="<?php echo $v['alt'] ?>" src="<?php echo $v["img"] ?>">
			<input value="<?php echo $k ?>" <?php echo ($k == $this->value) ? "checked":false; ?> class="select-image" type="radio" name="<?php echo $this->id ?>""> </input>
		</div>	
		<?php } ?>
		
		
		<span class="field-subtitle"> <?php  echo $this->subtitle ?></span>
		<p class="field-desc"> <?php echo $this->desc ?> </p>
		
		
		
		<?php
	}
}