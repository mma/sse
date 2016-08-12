<?php

final class Sse_checkbox extends Sse_basic{
	
	protected $options = array();
	
	public function __construct(array $fields){
		parent::__construct($fields);
	}
	
	public function display(){
		$max = count($this->options);
		
		?>
		
		<h4 class="field-title"><?php echo esc_html($this->title) ?></h4>
		
		<?php foreach($this->options as $k=>$v){ ?>
		
			<span><?php echo esc_html($v) ?></span>
			<input class="<?php echo esc_attr($this->id) ?>" value="<?php echo esc_attr($k) ?>" <?php echo ($this->value[$k]) ? "checked":false; ?> type="checkbox" name="<?php echo esc_attr($this->id) ?>"> </input>
			<br>
		<?php } ?>
		
		
		<span class="field-subtitle"> <?php  echo esc_html($this->subtitle) ?></span>
		<p class="field-desc"> <?php echo esc_html($this->desc) ?> </p>
		
		
		
		<?php
	}
	
	static public function verify($values){
		
		foreach($values as $k=>$v){
			$values[$k] = filter_var($v, FILTER_VALIDATE_BOOLEAN,FILTER_NULL_ON_FAILURE);
		}
		return $values;
	}

}