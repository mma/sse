<?php
class Sse {
	
	static $args = array();
	static $sections = array();

	static function setSection($opt_name,array $settings){	
		self::$sections[$opt_name][$settings["id"]] = $settings;
	}
	
	static function processField(array $field){
			
			$class_name = "Sse_".$field["type"];
			
			$input= new $class_name($field);
			
			$input->display();
			
	}
	
	static function setArgs($opt_name,array $args){
		self::$args[$opt_name] = $args;
	}
	
	static function setDefault(array $options,$option_name){
		
		$data = array();
		
		$add = 0;
		
		foreach($options as $option){
			foreach($option['fields'] as $value){
				if(isset($value['default'])){
					$data[$value['id']] = $value['default'];
				}
			}
		}

		$db_option = get_option($option_name);
		
		if(empty($db_option)){
			add_option($option_name,$data);
		}else{
			foreach($data as $k=>$v){
				if (!array_key_exists($k, $db_option)) {
					$db_option[$k] = $v;
					$add++;
				}
			}
			
			if($add != 0){
				update_option($option_name,$db_option);
			}
		}

	}
	
	static function init(){
		add_action('admin_menu', array( "Sse", 'add_admin_menu'));
		add_action('wp_ajax_sse_save_options', array( "Sse", 'sse_save_options'));
	}
	
	
	static function load_admin_js(){
		add_action( 'admin_enqueue_scripts', array("Sse",'load_custom_wp_admin_style' ));
	}
	
	static function load_custom_wp_admin_style() {
        wp_register_style( 'custom_wp_admin_css_sse', plugin_dir_url( __FILE__ ).'style.css', false, '1.0.0' );
        wp_enqueue_style( 'custom_wp_admin_css_sse' );
		wp_register_style( 'spectrum-css', plugin_dir_url( __FILE__ ).'vendor/spectrum.css', false, '1.0.0' );
		wp_enqueue_style( 'spectrum-css' );
		wp_register_style( 'select-2-css', plugin_dir_url( __FILE__ ).'vendor/select2.min.css', false, '1.0.0' );
		wp_enqueue_style( 'select-2-css' );
		wp_register_style( 'jAlert-sse', plugin_dir_url( __FILE__ ).'vendor/jAlert-v4.css', false, '1.0.0' );
		wp_enqueue_style( 'jAlert-sse' );
		wp_enqueue_script( 'spectrum-js', plugin_dir_url( __FILE__ ).'vendor/spectrum.js', false );
		wp_enqueue_script( 'sse-javascript-1', plugin_dir_url( __FILE__ ).'helpers.js', false );
		wp_enqueue_script( 'select-2-js', plugin_dir_url( __FILE__ ).'vendor/select2.full.min.js', false );
		wp_enqueue_script( 'jAlert-sse', plugin_dir_url( __FILE__ ).'vendor/jAlert-v4.min.js', false );
		wp_enqueue_script( 'jAlert-functions-sse', plugin_dir_url( __FILE__ ).'vendor/jAlert-functions.min.js', false );
	}

	
	static function render_page(){
		$page = $_GET['page'];
		if(isset($_GET['section'])){
			$section = $_GET['section'];
		}else{
			$section = NULL;
		}
		
		
		if(self::$sections[$page] != NULL){
			
			if($section == NULL && key(self::$sections[$page]) != NULL){
				$section = key(self::$sections[$page]);
			}
		}
		if(self::$sections[$page][$section] == NULL){
			echo 'Invalid section';
			exit();
		}
		
		if(self::$sections[$page] != null){
			
			self::setDefault(self::$sections[$page],$page);
			
			do_action('sse_header_'.$page);
			
			echo '<div class="wrap">';
			echo '<h2 class="nav-tab-wrapper">';
			
	
			
			foreach(self::$sections[$page] as $sec){
				
				if($sec["id"] == $section){
					$class="nav-tab-active";
				}else{
					$class="";
				}
				
				?>

					<a data-section="<?php echo esc_attr($sec['id']); ?>" href="<?php echo "?page=".esc_attr($page)."&section=".esc_attr($sec["id"]) ?>" class="nav-tab <?php echo esc_attr($class) ?> <?php echo esc_attr($sec["id"])?>"><?php echo esc_html($sec["title"])?></a>

				<?php
			}
			
			echo '</h2>';

			if(!empty(self::$sections[$page][$section]['html'])){
				if(file_exists(self::$sections[$page][$section]['html'])){
					echo '<div class="form-settings">';
					require(self::$sections[$page][$section]['html']);
					echo '</div>';
					do_action('sse_footer_'.$page);
				}
				return;
			}
			
			echo '<form class="form-settings" method="post">';
			
			$values = get_option($page);
			
			foreach(self::$sections[$page][$section]["fields"] as $field){
				
				$field["value"] = $values[$field["id"]];

				//required multi level
				$level = 0;
				$show = 0;
				if(isset($field['required'])){
					if(is_array($field["required"][0])){
						foreach($field["required"] as $required){
							
							if($values[$required[0]] == false){
								$show++;
							}
							
							
							$level++;
						}
					}else if(is_string($field["required"][0])){
						
							if($values[$field["required"][0]] == false){
								$show++;
							}
							$level++;
					}
				}
				if($show == 0){
						$class="";
					}else{
						$class="hide-this-pls";
				}
				
				if($level == 0){
					$class="";
				}
				$margin = $level * 20;
				?>
				
				<div style="margin-left:<?php echo esc_attr($margin)?>px" data-level="<?php echo esc_attr($level) ?>" class="inline-field settings-level-<?php echo esc_attr($level) ?> <?php echo esc_attr($field["type"])?> <?php echo esc_attr($class) ?>">
					<?php self::processField($field); ?>
					<hr>
				</div>
				
				
				
			<?php } ?>
			<?php if(!empty(self::$sections[$page][$section]["fields"])){ ?>
				<div class="submit" style="clear: both;display:inline-block">
				  <input id="submit-update" type="submit" name="Submit" class="button-primary" value="Update Settings">
				  <div id="settings-spinner" class="spinner"></div>
				</div>
				<input id="page" type="hidden" value="<?php echo esc_attr($page) ?>"></input>
				<input id="wordpress-token" type="hidden" value="<?php echo wp_create_nonce('sse-update-settings'); ?>"></input>
			   </form>
			</div>
			<?php
			
			do_action('sse_footer_'.$page);
			}
		}

	}

	static function sse_save_options() {
		
		if(!is_admin()){
			wp_die();
		}
		
		check_ajax_referer( 'sse-update-settings', 'security' );
		
		
		$page = $_POST['page'];
		
		if(self::$args[$page] == NULL){
			$response = array(
				'value' => 0,
				'message' => 'Invalid page.'
			);
			
			echo json_encode($response);
			wp_die();
		}
		
		if(self::$sections[$page][$_POST['section']] == NULL){
			$response = array(
				'value' => 0,
				'message' => 'Invalid section.'
			);
			
			echo json_encode($response);
			wp_die();
		}
		
		$capability = self::$args[$page]['capability'];

		if(!current_user_can( $capability )){
			wp_die();
		}
	
		$db_options = get_option($page);
		
		$fields = self::$sections[$page][$_POST['section']]['fields'];
		
		$type = array_column($fields,'type','id');
		
		foreach($_POST['data'] as $k=>$v){
				
			$class_name = "Sse_".$type[$k];
			$test = call_user_func(array($class_name, 'verify'), $v);
			
			
			$_POST['data'][$k] = $test;
		}
		
		$test = array_merge($db_options,$_POST['data']);
		
		update_option($page,$test);
		
		$response = array(
			'value' => 1,
			'message' => 'Settings updated.'
		);
		
		echo json_encode($response);


		wp_die(); // this is required to terminate immediately and return a proper response
	}
	
	
	static function add_admin_menu(){

		foreach(self::$args as $arg){
			$page = add_menu_page( 
				$arg["page-title"],
				$arg["menu-title"],
				$arg["capability"],
				$arg["menu-slug"],
				'Sse::render_page',
				$arg["icon"],
				$arg["position"]
			);
			add_action( 'load-' . $page, array("Sse",'load_admin_js') );
	
		}
	}
}

Sse::init();