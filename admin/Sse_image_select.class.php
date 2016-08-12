<?php

final class Sse_image_select extends Sse_basic {
	
	protected $options = array();
	
	public function __construct(array $fields){
		parent::__construct($fields);
	}
	
	public function display(){
		$max = count($this->options);

		?>
		
		<h4 class="field-title"><?php echo esc_html($this->title) ?></h4>
		
		<?php foreach($this->options as $k=>$v){ ?>
		
		<div class="inline-image">
			<img class="image" alt="<?php echo esc_attr($v['alt']) ?>" src="<?php echo esc_url($v["img"]) ?>">
			<input value="<?php echo esc_attr($k) ?>" <?php echo ($k == $this->value) ? "checked":false; ?> class="select-image" type="radio" name="<?php echo esc_attr($this->id) ?>""> </input>
		</div>	
		<?php } ?>
		
		
		<span class="field-subtitle"> <?php  echo esc_html($this->subtitle) ?></span>
		<p class="field-desc"> <?php echo esc_html($this->desc) ?> </p>
		
		
		
		<?php
	}
	
	static function verify($value){
		return sanitize_key($value);
	}
}