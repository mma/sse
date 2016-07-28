### SSE - Simple settings framework for Wp plugins developers
Ain't got time to spend on a settings page and want to focus on the plugin itself?Than Sse should do the job for simple and medium complexity plugins.
Screenshots in the screenshots folder.
##### Getting started
Copy the admin folder in your plugin then simply do 
```PHP
require_once(plugin_dir_path( __FILE__ ).'admin/autoload.php');
```
That's all that is.Now let's get into the config file.
Config file is where you are going to specify want fields you want and the default values.
Supported fields type are:
- number
- text
- color
- image_select
- switch (basily a checkbox)
- checkbox(here you can use multiple checkbox)
- select(simple radio buttons or select wp categories or wp posttypes)

If you want to activate the demo mode do
```PHP
require_once(plugin_dir_path( __FILE__ ).'admin/demo.php');
```

To create a settings page we have to follow those simple stepts:
First chose and option name , something unique
```PHP
$opt_name = 'my_awesome_plugin';
```

Now lets add the page to the WordPress menu
```PHP
$args = array(
	"page-title"=>"coolsettings",
	"menu-title"=>"Cool settings",
	"capability"=>'manage_options',
	"menu-slug"=>$opt_name,
	"icon"=>"dashicons-admin-generic",
	"position"=>"81" // set your owm possition
);


Sse::setArgs($opt_name,$args);
```

By now we should have our page in the WordPress menu but is all empty.Let's add our options:
```PHP
$domain = 'myplugindomain';
$tab1 = array(
        'title'  => __( 'Settings for my plugin', $domain ),
        'id'     => 'basic',
        'desc'   => __( 'Here you can customize the settings only for posts and pages.For comments go to Settings for Comments.', $domain ),
        'fields' => array(
             array(
			'id'       => 'v-switch-posts',
			'type'     => 'switch', 
			'title'    => __('Turn on like or dislsdadasor pages', $domain),
			'default'  => true,
			),
		)
);
Sse::setSection($opt_name,$tab1);
```

Above we have just added a tab with one field switch.The id of the fields must be unique.Let's explore the rest of the fields and their option.
I gues the switch type is pretty simple.Defaults can be true or false.

Checkbox field type
```PHP
			,array(
				'id'       => 'v_test',
				'type'     => 'checkbox',
				'title'    => __('Buttons position', $domain), 
				'subtitle' => __('Where should the buttons appear?', $domain),
				'desc'     => __('You can check them both if you want.', $domain),
			 
				//Must provide key => value pairs for multi checkbox options
				'options'  => array(
					'1' => __('Before content',$domain),
					'2' => __('After content',$domain),
				),
				'default' => array(
					'1' => '1',
					'2' => '0', 
				)
			)
```

For checkbox we can also have the options like this
```PHP
				'options'  => array(
					'before' => __('Before content',$domain),
					'after' =>  __('After content',$domain),
				),
				'default' => array(
					'before' => '1',
					'after' => '0', 
				)
```

Now next to the select type(radio buttons)
```PHP
			,array(
				'id'       => 'vortex-button-align',
				'type'     => 'select',
				'title'    => __('Buttons alignment',$domain), 
				//Must provide key => value pairs for multi checkbox options
				'options'  => array(
					'1' => __('Left',$domain),
					'2' => __('Center',$domain),
					'3' => __('Right',$domain)
				),
				// instead of 1 we could also use left and then set default to left
				'default'  => '1',
			)
			
```			
Simple enought.Color field.
```PHP
			,array(
				'id'       => 'v_default_color',
				'type'     => 'color',
				'title'    => __('Default color', $domain), 
				'subtitle' => __('Default color of buttons', $domain),
				'default'  => '#828384',
				//default value must be HEX
			)
```
Text field 
```PHP
			,array(
				'id'       => 'v_custom_text_post_dislike',
				'type'     => 'text',
				'title'    => __('Custom text for dislike', $domain),
				'default'  => 'Thank you for voting',
			)
			
```
			
Number
```PHP
			,array(
				'id'       => 'v_delete_number',
				'type'     => 'number',
				'title'    => __('Number of dislikes:', $domain),
				'subtitle' => __('Auto delete post at a given number of dislikes', $domain),
				'default'  => '10',
				'minim'     => 4, //not necesary
				'maxim'		=> 440, //not necesary
			)
```
	
Image select 
```PHP
$dir = plugin_dir_url( __FILE__ );
$style = 'Image select alt';
			,array(
				'id'       => 'v_button_style',
				'type'     => 'image_select',
				'title'    => __('Buttons style', $domain), 
				'subtitle' => __('Here you can change the icons of the buttons.', $domain),
				'options'  => array(
						'1'      => array(
							'alt'   => ''.$style.' 1', 
							'img'   => $dir.'images/1.png'
						),
						'da'      => array(
							'alt'   => ''.$style.' 2', 
							'img'   => $dir.'images/2.png'
						),
						'3'      => array(
							'alt'   => ''.$style.' 3', 
							'img'   => $dir.'images/3.png'
						),
						'4'      => array(
							'alt'   => ''.$style.' 4', 
							'img'   => $dir.'images/4.png'
						),
						'5'      => array(
							'alt'   => ''.$style.' 5', 
							'img'   => $dir.'images/5.png'
						),
						'6'      => array(
							'alt'  => ''.$style.' 6', 
							'img'   => $dir.'images/6.png'
						),
						'7'      => array(
							'alt'   => ''.$style.' 7', 
							'img'   => $dir.'images/7.png'
						),
						'8'      => array(
							'alt'   => ''.$style.' 8', 
							'img'   => $dir.'images/8.png'
						),
						'9'      => array(
							'alt'   => ''.$style.' 9', 
							'img'   => $dir.'images/9.png'
						),
						'10'      => array(
							'alt'   => ''.$style.' 10', 
							'img'   => $dir.'images/10.png'
						),
						'11'      => array(
							'alt'  => ''.$style.' 11', 
							'img'  => $dir.'images/11.png'
						),
						'12'      => array(
							'alt'   => ''.$style.' 12', 
							'img'   => $dir.'images/12.png'
						),
						'13'      => array(
							'alt'   => ''.$style.' 13', 
							'img'   => $dir.'images/13.png'
						),
						'14'      => array(
							'alt'   => ''.$style.' 14', 
							'img'   => $dir.'images/14.png'
						)
					),
				'default' => '1'
			)
```

Also for select we have category select 

```PHP
		,array(
			'id'       => 'v_exclude_category',
			'type'     => 'select',
			'multi'	   => true, // false for 1 option only
			'title'    => __('Exclude categories', $domain), 
			'subtitle' => __('Here you can exclude categories where you DON\'T want the buttons to show. ',$domain),
			'desc'	   => __('Only categories that have at least 1 post will be shown.',$domain),
			'data'	   => 'category',
		)
			//this is show all categoryes with  >= 1 post

```

And post type select

```PHP

		,array(
			'id'       => 'v_exclude_post_types-p',
			'type'     => 'select',
			'multi'	   => true, //false for 1 option only
			'title'    => __('Exclude post types', $domain), 
			'subtitle' => __('Here you can exclude post types where you DON\'T want the buttons, custom columns and the box to show. ',$domain),
			'data'	   => 'post_types',
		)
```

Also nested options are support but only the switch type can be the parent

```PHP

		,array(
			'id'       => 'v_exclude_post_types-p',
			'type'     => 'select',
			'multi'	   => true, //false for 1 option only
			'title'    => __('Exclude post types', $domain), 
			'subtitle' => __('Here you can exclude post types where you DON\'T want the buttons, custom columns and the box to show. ',$domain),
			'data'	   => 'post_types',
			'required' => array('v-switch-posts'),
			//for multiple levels of nesting use
			//'required' => array(array('v-switch-posts'),array('v_custom_text')),
			//when the switch is true the options will appear
			//only use the id's of switch field type the rest are not supported
		)
```

For more customization we can add your own html before and after the options.

```PHP
function my_custom_donate_button(){
				echo '<a style="display:block;margin:0 auto;width:200px;" href="http://example.com/donate">Click here to donate</a>';
				}
add_action('sse_footer_'.$opt_name,'my_custom_donate_button');
//add_action('sse_header_'.$opt_name,'my_custom_donate_button');
```

Cool but how to acces those options and use them in my plugin?Simple

```PHP

$options = get_option($opt_name);
//var_dump($options);
//all the options are stored in this array acces them with the id 
```
With setArgs we set the page and with setSection we set a section or a tab.