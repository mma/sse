<?php
final class Sse_number extends Sse_basic {

	protected $minim;
	protected $maxim;
	
	public function __construct(array $fields){
		parent::__construct($fields);
	}
	
	public function display(){
		?>
		<h4 class="field-title"><?php echo esc_html($this->title) ?></h4>
		<input value="<?php echo esc_attr($this->value) ?>" type="number" 
			<?php  if(isset($this->maxim)){echo "max=".esc_attr($this->maxim)."";} ?> 
			<?php  if(isset($this->minim)){echo "min=".esc_attr($this->minim)."";} ?> 
			name="<?php echo  esc_attr($this->id) ?>"
			></input>
		<span class="field-subtitle"> <?php  echo esc_html($this->subtitle) ?></span>
		<p class="field-desc"> <?php echo esc_html($this->desc) ?> </p>
		
		<?php
	}
	
	static function verify($value){
		return intval($value);
	}
}