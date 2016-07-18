<?php
class Sse_number extends Sse_Basic {
	
	//protected $fields = array();
	protected $minim;
	protected $maxim;
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
		<p class="field-title"><?php echo $this->title ?></p>
		<input value="<?php echo $this->value ?>" type="number" <?php  if(isset($this->maxim)){echo "max=\"$this->maxim\"";} ?> <?php  if(isset($this->minim)){echo "min=\"$this->minim\"";} ?> name="<?php echo  $this->id ?>"> </input>
		<span class="field-subtitle"> <?php  echo $this->subtitle ?></span>
		<p class="field-desc"> <?php echo $this->desc ?> </p>
		
		<?php
	}
}