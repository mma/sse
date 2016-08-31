<?php
final class Sse
{
    private static $args = [];
    private static $sections = [];

    public static function setSection($opt_name, array $settings)
    {
        self::$sections[$opt_name][$settings['id']] = $settings;
    }

    private static function processField(array $field)
    {
        $class_name = 'Sse_'.$field['type'];

        $input = new $class_name($field);

        $input->display();
    }

    public static function setArgs($opt_name, array $args)
    {
        self::$args[$opt_name] = $args;
    }

    private static function setDefault(array $options, $option_name)
    {
        $data = [];

        $add = 0;

        foreach ($options as $option) {
            foreach ($option['fields'] as $value) {
                if (isset($value['default'])) {
                    $data[$value['id']] = $value['default'];
                }
            }
        }

        $db_option = get_option($option_name);

        if (empty($db_option)) {
            add_option($option_name, $data);
        } else {
            foreach ($data as $k => $v) {
                if (!array_key_exists($k, $db_option)) {
                    $db_option[$k] = $v;
                    $add++;
                }
            }

            if ($add != 0) {
                update_option($option_name, $db_option);
            }
        }
    }

    public static function init()
    {
        add_action('admin_menu', ['Sse', 'add_admin_menu']);
        add_action('wp_ajax_sse_save_options', ['Sse', 'sse_save_options']);
    }

    public static function load_admin_js()
    {
        add_action('admin_enqueue_scripts', ['Sse', 'load_custom_wp_admin_style']);
    }

    public static function load_custom_wp_admin_style()
    {
        wp_register_style('custom_wp_admin_css_sse', plugin_dir_url(__FILE__).'style.css', false, '1.0.0');
        wp_enqueue_style('custom_wp_admin_css_sse');
        wp_register_style('select-2-css', plugin_dir_url(__FILE__).'vendor/select2.min.css', false, '1.0.0');
        wp_enqueue_style('select-2-css');
        wp_register_style('jAlert-sse', plugin_dir_url(__FILE__).'vendor/jAlert-v4.css', false, '1.0.0');
        wp_enqueue_style('jAlert-sse');
        /// WP COLOR PICKER
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('wp-color-picker');
        /****/
        wp_enqueue_script('sse-javascript-1', plugin_dir_url(__FILE__).'helpers.js', true);
        wp_enqueue_script('select-2-js', plugin_dir_url(__FILE__).'vendor/select2.full.min.js', false);
        wp_enqueue_script('jAlert-sse', plugin_dir_url(__FILE__).'vendor/jAlert-v4.min.js', false);
        wp_enqueue_script('jAlert-functions-sse', plugin_dir_url(__FILE__).'vendor/jAlert-functions.min.js', false);
    }

    private static function navigation($page, $section)
    {
        echo '<div class="wrap">';

        echo '<h2 class="nav-tab-wrapper">';

        foreach (self::$sections[$page] as $sec) {
            if ($sec['id'] == $section) {
                $class = 'nav-tab-active';
            } else {
                $class = '';
            } ?>

				<a data-section="<?php echo esc_attr($sec['id']); ?>" href="<?php echo '?page='.esc_attr($page).'&section='.esc_attr($sec['id']) ?>" class="nav-tab <?php echo esc_attr($class) ?> <?php echo esc_attr($sec['id'])?>"><?php echo esc_html($sec['title'])?></a>
			<?php

        }

        echo '</h2>';
    }

    private static function update_button($page, $section)
    {
        ?>
			<?php if (!empty(self::$sections[$page][$section]['fields'])) {
            ?>
				<div class="submit" style="clear: both;display:inline-block">
				  <input id="submit-update" type="submit" name="Submit" class="button-primary" value="Update Settings">
				  <div id="settings-spinner" class="spinner"></div>
				</div>
				<input id="page" type="hidden" value="<?php echo esc_attr($page) ?>"></input>
				<input id="wordpress-token" type="hidden" value="<?php echo wp_create_nonce('sse-update-settings'); ?>"></input>
			   </form>
			</div>
			<?php

        }
    }

    private static function nested_options($values, array $field)
    {
        $level = 0;
        $show = 0;
        if (isset($field['required'])) {
            if (is_array($field['required'][0])) {
                foreach ($field['required'] as $required) {
                    if ($values[$required[0]] == false) {
                        $show++;
                    }
                    $level++;
                }
            } elseif (is_string($field['required'][0])) {
                if ($values[$field['required'][0]] == false) {
                    $show++;
                }
                $level++;
            }
        }

        if ($show == 0) {
            $class = '';
        } else {
            $class = 'hide-this-pls';
        }

        if ($level == 0) {
            $class = '';
        }
        $margin = $level * 20;

        return [
            'level'  => $level,
            'class'  => $class,
            'margin' => $margin,
        ];
    }

    private static function include_file($page, $section)
    {
        if (!empty(self::$sections[$page][$section]['html'])) {
            if (file_exists(self::$sections[$page][$section]['html'])) {
                echo '<div class="form-settings">';
                require self::$sections[$page][$section]['html'];
                echo '</div>';
                do_action('sse_footer_'.$page);
            }
            exit();
        }
    }

    public static function render_page()
    {
        $page = $_GET['page'];
        if (isset($_GET['section'])) {
            $section = $_GET['section'];
        } else {
            $section = null;
        }


        if (self::$sections[$page] != null) {
            if ($section == null && key(self::$sections[$page]) != null) {
                $section = key(self::$sections[$page]);
            }
        }
        if (!isset(self::$sections[$page][$section])) {
            echo 'Invalid section';
            exit();
        }

        if (self::$sections[$page] != null) {
            self::setDefault(self::$sections[$page], $page);

            do_action('sse_header_'.$page);

            self::navigation($page, $section);

            /* include html file if needed for documentation ,faq, etc and exit() */
            self::include_file($page, $section);

            echo '<form class="form-settings" method="post">';

            $values = get_option($page);

            foreach (self::$sections[$page][$section]['fields'] as $field) {
                if (isset($values[$field['id']])) {
                    $field['value'] = $values[$field['id']];
                }

                $options = self::nested_options($values, $field);

                $class = $options['class'];
                $margin = $options['margin'];
                $level = $options['level']; ?>
				
				<div style="margin-left:<?php echo esc_attr($margin)?>px" data-level="<?php echo esc_attr($level) ?>" class="inline-field settings-level-<?php echo esc_attr($level) ?> <?php echo esc_attr($field['type'])?> <?php echo esc_attr($class) ?>">
					<?php self::processField($field); ?>
					<hr>
				</div>
				
				
				
			<?php 
            }

            /* Show form update button */
            self::update_button($page, $section);

            do_action('sse_footer_'.$page);
        }
    }

    public static function sse_save_options()
    {
        if (!is_admin()) {
            wp_die();
        }

        check_ajax_referer('sse-update-settings', 'security');


        $page = $_POST['page'];

        if (self::$args[$page] == null) {
            $response = [
                'value'   => 0,
                'message' => 'Invalid page.',
            ];

            echo json_encode($response);
            wp_die();
        }

        if (self::$sections[$page][$_POST['section']] == null) {
            $response = [
                'value'   => 0,
                'message' => 'Invalid section.',
            ];

            echo json_encode($response);
            wp_die();
        }

        $capability = self::$args[$page]['capability'];

        if (!current_user_can($capability)) {
            wp_die();
        }

        $db_options = get_option($page);

        $fields = self::$sections[$page][$_POST['section']]['fields'];

        $type = array_column($fields, 'type', 'id');

        foreach ($_POST['data'] as $k => $v) {
            $class_name = 'Sse_'.$type[$k];
            $test = call_user_func([$class_name, 'verify'], $v);


            $_POST['data'][$k] = $test;
        }

        $test = array_merge($db_options, $_POST['data']);

        update_option($page, $test);

        $response = [
            'value'   => 1,
            'message' => 'Settings updated.',
        ];

        echo json_encode($response);


        wp_die(); // this is required to terminate immediately and return a proper response
    }

    public static function add_admin_menu()
    {
        foreach (self::$args as $arg) {
            $page = add_menu_page(
                $arg['page-title'],
                $arg['menu-title'],
                $arg['capability'],
                $arg['menu-slug'],
                'Sse::render_page',
                $arg['icon'],
                $arg['position']
            );
            add_action('load-'.$page, ['Sse', 'load_admin_js']);
        }
    }
}

Sse::init();
