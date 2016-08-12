<?php

final class Sse_text extends Sse_basic {
	
	public function __construct(array $fields){
		parent::__construct($fields);
	}
	
	public function display(){
		
		?>
		
		<h4 class="field-title"><?php echo esc_html($this->title) ?></h4>

		<input value="<?php  echo esc_attr($this->value); ?>" type="text" name="<?php echo esc_attr($this->id) ?>"> </input>

		<span class="field-subtitle"> <?php  echo esc_html($this->subtitle) ?></span>
		<p class="field-desc"> <?php echo esc_html($this->desc) ?> </p>
		
		
		
		<?php
	}
	
	static function verify($value){
		return sanitize_text_field($value);
	}
}