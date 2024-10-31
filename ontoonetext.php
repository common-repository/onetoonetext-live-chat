<?php
/**
 * @package OnetoOnetext Chat PLugin 
 * @version 1.1
 */
/*
Plugin Name: OnetoOnetext Chat PLugin
Plugin URI: http://www.onetoonetext.com
Description: OnetoOnetext is a must have live chat software for any business that wants to provide live chat support. We believe businesses can improve their sales by providing live chat software on their websites.
Author: OnetoOnetext	
Version: 1.0
Author URI: http://www.onetoonetext.com/
*/

class onetoone
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'Settings Admin', 
            'OnetoOnetext', // Add Code to make the Menu to Display on Settings Menu
            'manage_options', 
            'onetoonetext_options', 
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option( 'onetoonetext_options' );
        ?>
        <div class="wrap">
            <?php screen_icon(); ?>
            <h2>OnetoOnetext Chat Plugin Settings</h2>           
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'onetoonetext_option_group' );   
                do_settings_sections( 'onetoonetext_options' );
                submit_button(); 
            ?>
            </form>
            <p>If you don't have an Account Please click here to <a href="http://www.onetoonetext.com/index.php?do=index&id=wordpress" target="_blank">Register</a> - <a href="http://www.onetoonetext.com/index.php?do=index&id=wordpress" target="_blank"> http://www.onetoonetext.com/ </a> <br> <br> OnetoOnetext is a must have live chat software for any business that wants to provide live chat support. We believe businesses can improve their sales by providing live chat software on their websites. 
<br><br>
To Get Account Number check this Url <a href="http://www.onetoonetext.com/faq.html" target="_blank">FAQ </a>
<br><br>

With Our Software both businesses and customers can benefit. Consumers usually visit a website several times before they make a purchase. They want to be sure of what they are purchasing, and if an online retailer can alleviate that fear by providing a live person to answer questions, they can increase their conversion rate significantly.
<br><br>
OnetoOnetext -Live Chat Software may also be used as a marketing tool to promote your website by pro-actively asking site visitors if they require help or assistance. It is the user friendly live chat software that increases online sales and improves customer service. Sign up for a Free Trial today and Improve Sales and Conversion rates on your website by pro-actively assisting your visitors by installing our OnetoOnetext Software. By Installing OnetoOnetext You can track Your Website Visitors Activity in Real Time and Allows your website visitors to chat with operators within your business as they are browsing.</p>
        </div>
        <?php  
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {        
        register_setting(
            'onetoonetext_option_group', // Option group
            'onetoonetext_options', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'setting_section_id', // ID
            'My Settings', // Title
            array( $this, 'print_section_info' ), // Callback
            'onetoonetext_options' // Page
        );  

        add_settings_field(
            'account_no', // ID
            'OnetoOnetext Account no', // Title 
            array( $this, 'account_no_callback' ), // Callback
            'onetoonetext_options', // Page
            'setting_section_id' // Section           
        );      

     
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
		if( !empty( $input['account_no'] ) )
            $input['account_no'] = sanitize_text_field( $input['account_no'] );


        return $input;
    }

    /** 
     * Print the Section text
     */
    public function print_section_info()
    {
        print 'Enter your settings below:';
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function account_no_callback()
    {
        printf(
            '<input type="text" id="account_no" name="onetoonetext_options[account_no]" value="%s" />',
            esc_attr( $this->options['account_no'])
        );
    }


}

function addCodeJs() {
	
	$values = get_option('onetoonetext_options');

	echo '<div id="output" ></div>
		  <div id="ajid" style="display:none;">'.$values['account_no'].'</div>
		  <script type="text/javascript" src="http://services.onetoonetext.com/chat/onetoonetext.js"></script>';
		  
		
}

function your_plugin_settings_link($links) { 
  $settings_link = '<a href="options-general.php?page=onetoonetext_options">Settings</a>'; 
  array_unshift($links, $settings_link); 
  return $links; 
}

if( is_admin() ){
	
    $onetoonetext_settings_page = new onetoone();
	
	// Add settings link on plugin page
	$plugin = plugin_basename(__FILE__); 
	add_filter("plugin_action_links_$plugin", 'your_plugin_settings_link' );
	
}else{
	add_action('wp_footer', 'addCodeJs');		
}