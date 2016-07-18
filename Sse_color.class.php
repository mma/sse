<?php

class Sse_color extends Sse_Basic {
	
	//protected $fields = array();
	
	protected $check;
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
		
		<h4 class="field-title"><?php echo esc_html($this->title)?></h4>

		<input type="text" id="<?php echo esc_attr($this->id) ?>" name="<?php echo esc_attr($this->id) ?>""> </input>
		<script>
		jQuery("#<?php echo esc_js($this->id)?>").spectrum({
				color: "<?php echo esc_js($this->value) ?>",
				preferredFormat: "hex",
				showInput: true
			});
		</script>
		<span class="field-subtitle"> <?php  echo esc_html($this->subtitle) ?></span>
		<p class="field-desc"> <?php echo esc_html($this->desc) ?> </p>
		
		
		
		<?php
	}
}