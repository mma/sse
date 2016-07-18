<?php

class Sse_select extends Sse_Basic {
	
	//protected $fields = array();
	protected $options = array();
	protected $data;
	protected $output = array();
	protected $multi;
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
		
		<h4 class="field-title"><?php echo $this->title ?></h4>
		
		<?php 
		
		if(isset($this->data) && ($this->data == "category" || $this->data == "post_types")){
			
			if($this->multi){
				echo "<select name=".$this->id." multiple>";
			}else{
				echo "<select>";
			}
			if($this->data == "category"){
				foreach($this->output as $categori){
					if(in_array($categori->name,$this->value)){
						$selected = 'selected';
					}else{
						$selected = '';
					}
					echo "<option ".$selected.">".$categori->name."</option>";
				}
			}else{
				foreach($this->output as $post_type){
					
					if(in_array($post_type->labels->name,$this->value)){
						$selected = 'selected';
					}else{
						$selected = '';
					}
					echo "<option ".$selected.">".$post_type->labels->name."</option>";
				}
			}

				echo "</select>";
		}
		
		?>
		
		<?php foreach($this->options as $k=>$v){ ?>
		
			<span><?php echo $v ?></span>
			<input value="<?php echo $k ?>"<?php echo ($k == $this->value) ? "checked":false; ?> type="radio" name="<?php echo $this->id ?>""> </input>
			
		<?php } ?>
		
		
		<span class="field-subtitle"> <?php  echo $this->subtitle ?></span>
		<p class="field-desc"> <?php echo $this->desc ?> </p>
		
		
		
		<?php
	}
}