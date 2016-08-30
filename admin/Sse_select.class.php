<?php

final class Sse_select extends Sse_basic {
	
	protected $options = array();
	protected $data;
	protected $multi;
	protected $output = array();
	
	public function __construct(array $fields) {
		parent::__construct($fields);
	}
	
	private function getName($item ,$data = 0) {
		if($this->data == "category"){
			if($data == 1){
				return $item->slug;
			}else{
				return $item->name;
			}
		}
		
		if($data == 1){
			return $item->name;
		}else{
			return $item->labels->name;
		}
		
	}
	
	public function display() {
		
		if ($this->data == "category") {
			$this->output = get_categories();
		}else if ($this->data == "post_types") {
			
			$args = array(
			   'public' => true,
			);

			$output = 'objects'; // names or objects
		
			$this->output = get_post_types($args, $output);
		}
		
		?>
		
		<h4 class="field-title"><?php echo esc_html($this->title) ?></h4>
		
		<?php 
		
		if (isset($this->data) && ($this->data == "category" || $this->data == "post_types")) {
			
			if ($this->multi) {
				echo "<select name=".esc_attr($this->id)." multiple>";
			}else {
				echo "<select name=".esc_attr($this->id).">";
			}

			foreach ($this->output as $item) {

				if ($this->value != null && in_array($this->getName($item,1), $this->value)) {
					$selected = 'selected';
				}else {
					$selected = '';
				}
				echo "<option value=\"".esc_attr($this->getName($item,1))."\" ".esc_attr($selected).">".esc_html($this->getName($item))."</option>";
			}
			
			echo "</select>";
		}
		
		?>
		
		<?php foreach ($this->options as $k=>$v) { ?>
		
			<span><?php echo esc_html($v) ?></span>
			<input value="<?php echo esc_attr($k) ?>"<?php echo ($k == $this->value) ? "checked" : false; ?> type="radio" name="<?php echo esc_attr($this->id) ?>""> </input>
			
		<?php } ?>
		
		
		<span class="field-subtitle"> <?php  echo esc_html($this->subtitle) ?></span>
		<p class="field-desc"> <?php echo esc_html($this->desc) ?> </p>
		
		
		
		<?php
	}
	
	public static function verify($value) {
		if (is_string($value)) {
			return sanitize_key($value);
		}else {
			foreach ($value as $k=>$v) {
				$value[$k] = sanitize_key($v);
			}
		}
		return $value;
	}
}