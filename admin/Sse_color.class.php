<?php

final class Sse_color extends Sse_basic {
	
	public function __construct(array $fields){
		parent::__construct($fields);
	}
	
	public function display(){
		
		?>
		
		<h4 class="field-title"><?php echo esc_html($this->title)?></h4>

		<input class="sse-color-field" value="<?php echo esc_attr($this->value) ?>" type="text" id="<?php echo esc_attr($this->id) ?>" name="<?php echo esc_attr($this->id) ?>"> </input>
		<span class="field-subtitle"> <?php  echo esc_html($this->subtitle) ?></span>
		<p class="field-desc"> <?php echo esc_html($this->desc) ?> </p>
		
		<?php
	}
	
	static function verify($color){
		// 3 or 6 hex digits, or the empty string.
		if ( preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
			return $color;
		}else{
			return '';
		}
	}
}