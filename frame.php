<?php
/**
* Plugin Name: Frame
* Plugin URI: http://github.com/AlexAlexandru/
* Version: 1
* Author: AlexAlexandru
* Author URI: https://github.com/AlexAlexandru
* License: GPL2
* Domain Path: /languages
*/
if ( ! defined( 'ABSPATH' ) ) exit;//exit if accessed directly

require(plugin_dir_path( __FILE__ ).'Sse.php');
require(plugin_dir_path( __FILE__ ).'Sse_basic.class.php');
require(plugin_dir_path( __FILE__ ).'Sse_checkbox.class.php');
require(plugin_dir_path( __FILE__ ).'Sse_number.class.php');
require(plugin_dir_path( __FILE__ ).'Sse_switch.class.php');
require(plugin_dir_path( __FILE__ ).'Sse_select.class.php');
require(plugin_dir_path( __FILE__ ).'Sse_image_select.class.php');
require(plugin_dir_path( __FILE__ ).'Sse_color.class.php');
require(plugin_dir_path( __FILE__ ).'Sse_text.class.php');

$args = array(
"page-title"=>"test",
"menu-title"=>"test",
"capability"=>'manage_options',
"menu-slug"=>"ratingds",
"icon"=>"dashicons-admin-generic",
"position"=>"80"


);
$args1 = array(

"page-title"=>"test",
"menu-title"=>"test",
"capability"=>'manage_options',
"menu-slug"=>"rating",
"icon"=>"dashicons-admin-generic",
"position"=>"80"

);
Sse::init();
Sse::setArgs("aaa",$args);
Sse::setArgs("rating",$args1);
$dir = plugin_dir_url( __FILE__ );
$test = array(
        'title'  => __( 'Settings for posts and pages', $domain ),
        'id'     => 'basic',
        'desc'   => __( 'Here you can customize the settings only for posts and pages.For comments go to Settings for Comments.', $domain ),
        'fields' => array(
             array(
			'id'       => 'v-switch-posts',
			'type'     => 'switch', 
			'title'    => __('Turn on like or dislike for posts or pages', $domain),
			'default'  => true,
			),array(
				'id'       => 'v_button_visibility',
				'type'     => 'checkbox',
				'required' => array('v-switch-posts','equals','1'),
				'title'    => __('Buttons position', $domain), 
				'subtitle' => __('Where should the buttons appear?', $domain),
				'desc'     => __('You can check them both if you want.', $domain),
			 
				//Must provide key => value pairs for multi checkbox options
				'options'  => array(
					'1' => __('Before content',$domain),
					'2' => __('After content',$domain),
				),
			 
				//See how default has changed? you also don't need to specify opts that are 0.
				'default' => array(
					'1' => '1',
					'2' => '0', 
				)
			),array(
				'id'       => 'v_test',
				'type'     => 'checkbox',
				'required' => array('v-switch-posts','equals','1'),
				'title'    => __('Buttons position', $domain), 
				'subtitle' => __('Where should the buttons appear?', $domain),
				'desc'     => __('You can check them both if you want.', $domain),
			 
				//Must provide key => value pairs for multi checkbox options
				'options'  => array(
					'da' => __('Before content',$domain),
					'nu' => __('After content',$domain),
				),
			 
				//See how default has changed? you also don't need to specify opts that are 0.
				'default' => array(
					'da' => '1',
					'nu' => '0', 
				)
			),array(
				'id'       => 'vortex-button-align',
				'type'     => 'select',
				'required' => array('v-switch-posts','equals','1'),
				'title'    => __('Buttons alignment',$domain), 
				'options'  => array(
					'1' => __('Left',$domain),
					'2' => __('Center',$domain),
					'3' => __('Right',$domain)
				),
				'default'  => '1',
			),array(
				'id'       => 'vortex-button-aligdn',
				'type'     => 'select',
				'required' => array('v-switch-posts','equals','1'),
				'title'    => __('Buttons alignment',$domain), 
				'options'  => array(
					'da' => __('Left',$domain),
					'nu' => __('dadada',$domain),
					'3' => __('Right',$domain)
				),
				'default'  => 'nu',
			),array(
				'id'       => 'v_button_show',
				'type'     => 'checkbox',
				'required' => array('v-switch-posts','equals','1'),
				'title'    => __('Display buttons on:', $domain), 
				'subtitle' => __('Select where the buttons should be displayed.', $domain),
				'desc'	   =>__('Custom post type single must be checked for bbPress support.Posts Index refers to that page where your post(s) show up with an excerpt and a read more button.',$domain),
			 
				//Must provide key => value pairs for multi checkbox options
				'options'  => array(
					'1' => __('Pages',$domain),
					'2' => __('Posts Index',$domain),
					'3' => __('Single post',$domain),
					'4' => __('Custom post type Index',$domain),
					'5' => __('Custom post type single',$domain),
				),
			 
				//See how default has changed? you also don't need to specify opts that are 0.
				'default' => array(
					'1' => '0', 
					'2' => '1', 
					'3' => '1',
					'4' => '0',
					'5' => '0',
				)
			),array(
				'id'       => 'v_button_style',
				'type'     => 'image_select',
				'required' => array('v-switch-posts','equals','1'),
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
			),array(
			'id'       => 'v-switch-columns',
			'type'     => 'switch', 
			'required' => array('v-switch-posts','equals','1'),
			'title'    => __('Likes & Dislikes in columns', $domain),
			'subtitle' => __('Show the number of likes and dislikes at "All Posts" in custom columns.',$domain),
			'default'  => false,
			),array(
			'id'       => 'v-switch-dislike',
			'type'     => 'switch', 
			'required' => array('v-switch-posts','equals','1'),
			'title'    => __('Disable dislike', $domain),
			'subtitle' => __('Turn on this if you want like button only.',$domain),
			'default'  => false,
			)/*,array(
			'id'       => 'v-switch-tooltip',
			'type'     => 'switch', 
			'required' => array('v-switch-posts','equals','1'),
			'title'    => __('Enable tooltips', $domain),
			'default'  => false,
			)*/,array(
			'id'       => 'v-switch-anon',
			'type'     => 'switch',
			'required' => array('v-switch-posts','equals','1'),
			'title'    => __('Anonymous users', $domain),
			'subtitle' => __('If you want to allow anonymous users to vote turn this on.',$domain),
			'desc'	   => __('If you allow anonymous users to like or dislike , results may not be 100% accurate meaning that a person could like or dislike twice or more because it\'s impossible for this plugin to track anonymous users over the internet.The IP of the user is stored also a cookie is seted in the browser.If he changes the IP and deletes the cookie he can vote again.',$domain),
			'default'  => false,
			),array(
			'id'       => 'v-switch-anon-counter',
			'type'     => 'switch',
			'required' => array('v-switch-posts','equals','1'),
			'title'    => __('Anonymous counter',$domain),
			'subtitle' => __('Hide the counter(number of likes or dislikes) for anonymous users.',$domain),
			'default'  => false,
			),array(
				'id'          => 'vortex-buttons-size',
				'type'        => 'number',
				'required' => array('v-switch-posts','equals','1'),
				'title'       => __('Buttons size', $domain),
				'subtitle'    => __('Here you can change the buttons size in pixels.', $domain),
				'default'     => "16"
			),array(
				'id'       => 'v_default_color',
				'type'     => 'color',
				'required' => array('v-switch-posts','equals','1'),
				'output'   => array('.vortex-p-like, .vortex-p-dislike'),
				'title'    => __('Default color', $domain), 
				'subtitle' => __('Default color of buttons', $domain),
				'validate' => 'color',
				'default'  => '#828384',
			),array(
				'id'       => 'v_like_color',
				'type'     => 'color',
				'required' => array('v-switch-posts','equals','1'),
				'title'    => __('Like button ',$domain),
				'output'   => array('.vortex-p-like:hover'),
				'subtitle' => __('Like button mouse over color', $domain),
				'validate' => 'color',
				'default'  => '#4898D6',
			),array(
				'id'       => 'v_like_active_color',
				'type'     => 'color',
				'required' => array('v-switch-posts','equals','1'),
				'output'   => array('.vortex-p-like-active'),
				'title'    => __('Like button ', $domain), 
				'subtitle' => __('Like button active color', $domain),
				'validate' => 'color',
				'default'  => '#1B7FCC',
			),array(
				'id'       => 'v_dislike_color',
				'type'     => 'color',
				'required' => array('v-switch-posts','equals','1'),
				'output'   => array('.vortex-p-dislike:hover'),
				'title'    => __('Dislike button ', $domain), 
				'subtitle' => __('Dislike button mouse over color', $domain),
				'validate' => 'color',
				'default'  => '#0a0101',
			),array(
				'id'       => 'v_dislike_active_color',
				'type'     => 'color',
				'required' => array('v-switch-posts','equals','1'),
				'output'   => array('.vortex-p-dislike-active'),
				'title'    => __('Dislike button ', $domain), 
				'subtitle' => __('Dislike button active color', $domain),
				'validate' => 'color',
				'default'  => '#0a0101',
			),array(
			'id'       => 'v_exclude_category',
			'type'     => 'select',
			'required' => array('v-switch-posts','equals','1'),
			'multi'	   => true,
			'title'    => __('Exclude categories', $domain), 
			'subtitle' => __('Here you can exclude categories where you DON\'T want the buttons to show. ',$domain),
			'desc'	   => __('Only categories that have at least 1 post will be shown.',$domain),
			'data'	   => 'category',
			),array(
			'id'       => 'v_exclude_post_types-p',
			'type'     => 'select',
			'required' => array('v-switch-posts','equals','1'),
			'multi'	   => true,
			'title'    => __('Exclude post types', $domain), 
			'subtitle' => __('Here you can exclude post types where you DON\'T want the buttons, custom columns and the box to show. ',$domain),
			'data'	   => 'post_types',
			),array(
				'id'       => 'v_start_post_like',
				'type'     => 'number',
				'required' => array('v-switch-posts','equals','1'),
				'title'    => __('Number of likes by default', $domain),
				'subtitle' => __('Number of likes by default to new post.', $domain),
				'default'  => '0'
			),array(
				'id'       => 'v_start_post_dislike',
				'type'     => 'number',
				'required' => array('v-switch-posts','equals','1'),
				'title'    => __('Number of dislikes by default', $domain),
				'subtitle' => __('Number of dislikes by default to new post.', $domain),
				'default'  => '0'
			),array(
				'id'       => 'v_custom_text',
				'type'     => 'switch', 
				'required' => array('v-switch-posts','equals','1'),
				'title'    => __('Custom text', $domain),
				'subtitle' => __('Display custom text when user is voting', $domain),
				'default'  => false,
			),array(
				'id'       => 'v_custom_text_post_like',
				'type'     => 'text', 
				'validate' => 'no_html',
				'required' => array(array('v-switch-posts','equals','1'),array('v_custom_text','equals','1')),
				'title'    => __('Custom text for like', $domain),
				'default'  => 'Thank you for voting',
			),array(
				'id'       => 'v_custom_text_post_dislike',
				'type'     => 'text',
				'validate' => 'no_html',
				'required' => array(array('v-switch-posts','equals','1'),array('v_custom_text','equals','1')),
				'title'    => __('Custom text for dislike', $domain),
				'default'  => 'Thank you for voting',
			),array(
				'id'       => 'v_custom_text_post_keep',
				'type'     => 'switch',
				'required' => array(array('v-switch-posts','equals','1'),array('v_custom_text','equals','1')),
				'title'    => __('Keep custom text', $domain),
				'subtitle' => __('When a user voted and refreshes the page keep showing the custom text for the vote and don\'t display the counter',$domain),
				'default'  => false,
			),array(
				'id'       => 'v_enable_bbpress',
				'type'     => 'switch',
				'required' => array('v-switch-posts','equals','1'),
				'title'    => __('Enable bbPress support', $domain),
				'subtitle' => __('Custom post type single must be checked for bbPress support.',$domain),
				'default'  => false,
			),array(
				'id'       => 'v_enable_buddybpress',
				'type'     => 'switch',
				'required' => array('v-switch-posts','equals','1'),
				'title'    => __('Enable buddyPress support', $domain),
				'subtitle' => __('Enable support for buddyPress activities.',$domain),
				'default'  => false,
			),array(
				'id'       => 'v_enable_delete',
				'type'     => 'switch',
				'required' => array('v-switch-posts','equals','1'),
				'title'    => __('Enable Auto delete post', $domain),
				'default'  => false,
			),array(
				'id'       => 'v_delete_number',
				'type'     => 'number',
				'required' => array(array('v-switch-posts','equals','1'),array('v_enable_delete','equals','1')),
				'title'    => __('Number of dislikes:', $domain),
				'subtitle' => __('Auto delete post at a given number of dislikes', $domain),
				'default'  => '10'
			),array(
			'id'       => 'v-switch-fdfddf',
			'type'     => 'switch', 
			'title'    => __('You see this', $domain),
			'default'  => false,
			),array(
			'id'       => 'numberr',
			'type'     => 'number', 
			'title'    => __('You see this', $domain),
			'default'  => "3",
			),array(
			'id'       => 'numberdssdadr',
			'type'     => 'number', 
			'title'    => __('You see this', $domain),
			'default'  => "3",
			),array(
			'id'       => 'numberdssdasdfasdfdr',
			'type'     => 'number', 
			'title'    => __('You see this', $domain),
			'default'  => "3",
			),array(
			'id'       => 'hEELELEL',
			'type'     => 'number', 
			'title'    => __('Hello', $domain),
			'default'  => "3",
			),array(
			'id'       => 'hEELdddd',
			'type'     => 'number', 
			'title'    => __('Hello', $domain),
			'default'  => "9",
			),array(
			'id'       => 'asdasdsa',
			'type'     => 'number', 
			'title'    => __('Hello', $domain),
			'default'  => "220",
			)
		)
);

$test2 = array(
        'title'  => __( 'Settigns for comments', $domain ),
        'id'     => 'test',
        'desc'   => __( 'Here you can customize the settings only for posts and pages.For comments go to Settings for Comments.', $domain ),
        'fields' => array(
           array(
			'id'       => 'v-switch-postsss',
			'type'     => 'number', 
			'title'    => __('Turn on like or dislike for posts or pages', $domain),
			'default'  => false,
			)
		)
);
Sse::setSection("rating",$test);
Sse::setSection("rating",$test2);

?>