<?php
//TODO: MVC convertion (looking in my computer codes collection)
namespace Main;
use Sub\Strategy\ClassBlack;
use Sub\Strategy\ClassBlue;
use Sub\Strategy\ClassGreen;
use Sub\Strategy\ClassRed;
use Sub\Strategy\Strategy_Context;

if (!function_exists('__return_false')) {
    require_once(ABSPATH . '/wp-includes/functions.php');
}

define('SIMPLE_LINK_PATH', plugin_dir_path(__FILE__));

require_once(SIMPLE_LINK_PATH . 'strategy-classes.php');

if (!class_exists('ABS_Paste_Link_Plugin')):
    abstract class ABS_Paste_Link_Plugin
    {
        abstract public function init();

        abstract public function add_link_shortcode($add_link_shortcode);

    }
endif;

if (!class_exists('Paste_Link_Plugin')):
    final class Paste_Link_Plugin extends ABS_Paste_Link_Plugin
    {

        private $classoptionplugin_options;
        /**
         * @var
         * Singleton
         * Singleton on WP Plugin implementation inspired with
         * https://gist.github.com/goncaloneves/e0f07a8db17b06c2f968
         */


        private static $_instance;

        public static function instance(): Paste_Link_Plugin
        {
            if (is_null(self::$_instance)) {
                self::$_instance = new self;
            }
            return self::$_instance;
        }


        /**
         * Constructor.
         */
        public function __construct()
        {
            $this->actions();
        }

        private function actions()
        {
            add_action('plugins_loaded', array($this, 'init'));

        }


        public function init()
        {
            //register admin menu
            add_action('admin_menu', array($this, 'paste_link_add_admin_menu'));
            //options init
            add_action('admin_init', array($this, 'paste_link_settings_init'));
            //shortcode
            add_shortcode('paste', array($this, 'add_link_shortcode'));
            //options table
            $this->classoptionplugin_options = get_option('plug_settings');
        }


        public function add_link_shortcode($add_link_shortcode)
        {

            $this->classoptionplugin_options = get_option('plug_settings');//sprubowac ususnac te linie

            $color = $this->classoptionplugin_options['plug_select_field_0'];


            switch ($color) {
                case '1'://red
                    $context = new Strategy_Context(new ClassRed());
                    $add_link_shortcode = $context->mutual_method();
                    break;
                case '2'://blue
                    $context = new Strategy_Context(new ClassRed());
                    $context->setStrategy(new ClassBlue());
                    $add_link_shortcode = $context->mutual_method();
                    break;
                case '3'://green
                    $context = new Strategy_Context(new ClassRed());
                    $context->setStrategy(new ClassGreen());
                    $add_link_shortcode = $context->mutual_method();
                    break;
                case '4'://black
                    $context = new Strategy_Context(new ClassRed());
                    $context->setStrategy(new ClassBlack());
                    $add_link_shortcode = $context->mutual_method();
                    break;
            }


            return $add_link_shortcode;
        }


        /**
         * sposob dodawania shortcoda na gutenberg: najpierw dodaj widget  shortcode gutenbera  potem wklj [paste] i zachowaj
         */


        public function paste_link_add_admin_menu()
        {

            add_menu_page('Paste Link',
                'Paste Link',
                'manage_options',
                'paste-link',
                array($this, 'paste_link_options_page'), // function
                'dashicons-admin-generic', // icon_url
                3 // position
            );

        }

        public function paste_link_options_page()
        {
            $this->classoptionplugin_options = get_option('plug_settings');
            ?>
            <div class='wrap'>
                <?php settings_errors(); ?>
                <form action='options.php' method='post'>
                    <?php
                    settings_fields('pluginPage');
                    do_settings_sections('pluginPage');
                    submit_button();
                    ?>
                </form>
            </div>
            <?php
        }


        public function paste_link_settings_init()
        {

            register_setting('pluginPage', 'plug_settings');

            add_settings_section(
                'plug_pluginPage_section',
                __('Your section description', 'polish'),
                '__return_false',
                'pluginPage'
            );

            add_settings_field(
                'plug_select_field_0',
                __('Settings field description', 'polish'),
                array($this, 'plug_select_field_0_render'),
                'pluginPage',
                'plug_pluginPage_section'
            );
            add_settings_field(
                'input_text_field_0',
                'Wklej tutaj swój link url',
                array($this, 'callback_text_field_0_render'),
                'pluginPage',
                'plug_pluginPage_section'
            );
        }


        function plug_select_field_0_render()
        {
            ?>
            <select name='plug_settings[plug_select_field_0]'>
                <option value='1' <?php selected($this->classoptionplugin_options['plug_select_field_0'], 1); ?>>red
                    color
                </option>
                <option value='2' <?php selected($this->classoptionplugin_options['plug_select_field_0'], 2); ?>>blue
                    color
                </option>
                <option value='3' <?php selected($this->classoptionplugin_options['plug_select_field_0'], 3); ?>>green
                    color
                </option>
                <option value='4' <?php selected($this->classoptionplugin_options['plug_select_field_0'], 4); ?>>black
                    color
                </option>
            </select>

            <?php

        }

        function callback_text_field_0_render()
        {
            ?>
            <textarea name='plug_settings[input_text_field_0]'
                      value='<?php echo $this->classoptionplugin_options['input_text_field_0']; ?>'><?php echo esc_url($this->classoptionplugin_options['input_text_field_0']); ?></textarea>
            <?php

        }

    }
endif;
?>