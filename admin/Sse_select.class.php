<?php

final class Sse_select extends Sse_basic {
	
	protected $options = array();
	protected $data;
	protected $multi;
	
	public function __construct(array $fields){
		parent::__construct($fields);
	}
	
	public function display(){
		$max = count($this->options);
		
		if($this->data == "category"){
			$this->output = get_categories();
		}else if($this->data == "post_types"){
			
			$args = array(
			   'public' => true,
			);

			$output = 'objects'; // names or objects
		
			$this->output = get_post_types( $args, $output );
		}
		
		?>
		
		<h4 class="field-title"><?php echo esc_html($this->title) ?></h4>
		
		<?php 
		
		if(isset($this->data) && ($this->data == "category" || $this->data == "post_types")){
			
			if($this->multi){
				echo "<select name=".esc_attr($this->id)." multiple>";
			}else{
				echo "<select name=".esc_attr($this->id).">";
			}
			if($this->data == "category"){
				foreach($this->output as $categori){

					if($this->value != null && in_array($categori->slug,$this->value)){
						$selected = 'selected';
					}else{
						$selected = '';
					}
					echo "<option value=\"".esc_attr($categori->slug)."\" ".esc_attr($selected).">".esc_html($categori->name)."</option>";
				}
			}else{
				foreach($this->output as $post_type){
					
					if($this->value != null  && in_array($post_type->name,$this->value)){
						$selected = 'selected';
					}else{
						$selected = '';
					}
					echo "<option value=\"".esc_attr($post_type->name)."\" ".esc_attr($selected).">".esc_html($post_type->labels->name)."</option>";
				}
			}

				echo "</select>";
		}
		
		?>
		
		<?php foreach($this->options as $k=>$v){ ?>
		
			<span><?php echo esc_html($v) ?></span>
			<input value="<?php echo esc_attr($k) ?>"<?php echo ($k == $this->value) ? "checked":false; ?> type="radio" name="<?php echo esc_attr($this->id) ?>""> </input>
			
		<?php } ?>
		
		
		<span class="field-subtitle"> <?php  echo esc_html($this->subtitle) ?></span>
		<p class="field-desc"> <?php echo esc_html($this->desc) ?> </p>
		
		
		
		<?php
	}
	
	static function verify($value){
		if(is_string($value)){
			return sanitize_key($value);
		}else{
			foreach($value as $k=>$v){
				$value[$k] = sanitize_key($v);
			}
		}
		return $value;
	}
}