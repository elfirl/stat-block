<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://resultsrepeat.com
 * @since      1.0.0
 *
 * @package    Rrdf_Rc
 * @subpackage Rrdf_Rc/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Rrdf_Rc
 * @subpackage Rrdf_Rc/admin
 * @author     Results Repeat <support@resultsrepeat.com>
 */
class Rrdf_Rc_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

        add_shortcode( 'datafeed_rentcafe', array( $this, 'rrdf_shortcode' ) );

    }

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Rrdf_Rc_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Rrdf_Rc_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/rrdf-rc-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Rrdf_Rc_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Rrdf_Rc_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/rrdf-rc-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
     * Register the administratin menu for this plugin into the WordPress Dashboard menu.
     *
     * @since   1.0.0
     */
	public function add_plugin_admin_menu () {
        /*
         * Add a settings page for this plugin to the Settings menu.
         *
         * NOTE:  Alternative menu locations are available via WordPress administration menu functions.
         *
         *        Administration Menus: http://codex.wordpress.org/Administration_Menus
         *
         */
        // add_menu_page( 'Rent Cafe Property Feed Settings', 'Property Feed', 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page'), $position = 26, $icon_url = plugins_url( 'assets/dashicon.png', __FILE__ )
        // );
        add_menu_page( 'Rent Cafe Property Feed Settings', 'Property Feed', 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page' ), $icon_url = plugins_url( 'assets/dashicon.png', __FILE__ ), $position = 26
        );

    }

    /**
     * Add settings action link to the plugins page.
     *
     * @since   1.0.0
     */
    public function add_action_links( $links ) {
        /*
         * Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
         */
        $settings_link = array(
            '<a href="' . admin_url( 'admin.php?page=' . $this->plugin_name ) . '">'. __('Settings', $this->plugin_name ) . '</a>',
        );
        return array_merge( $settings_link, $links );
    }

    /**
     * Render the settings page for this plugin.
     *
     * @since   1.0.0
     */
    public function display_plugin_setup_page() {
        include_once( 'partials/rrdf-rc-admin-display.php' );
    }

    /**
     * Save/Update function
     */
    // Todo add callback for the validate function
    public function options_update() {
        register_setting( $this->plugin_name, $this->plugin_name, array( $this, 'validate' ) );
    }

    /**
     * Validate Options page Inputs
     *
     * @since 1.0.0
     */

    public function validate( $input ) {
        $valid = array();

        $valid['contact_page'] = sanitize_text_field($input['contact_page']);
        $valid['api_key'] = esc_html( $input['api_key'] );

        return $valid;
    }

    /**
     * Shortcode output
     *
     * @since 1.0.0
    */

    function get_sqft( $r ) {
        if( $r->MinimumSQFT == $r->MaximumSQFT ){
            return $r->MaximumSQFT . ' SqFt';
        } else {
            return $r->MinimumSQFT . ' - ' . $r->MaximumSQFT . ' SqFt';
        }
    }

    function get_pricing( $r ) {
        if( $r->MinimumRent == '-1' ) {
            return 'No Available Units';
        } elseif( $r->MinimumRent != '-1' && $r->MinimumRent == $r->MaximumRent ) {
            return '$' . $r->MinimumRent;
        } else {
            return '$' . $r->MinimumRent . ' - $' . $r->MaximumRent;
        }
    }

    function get_button( $r, $button_url ) {
        if ( $r->MinimumRent == '-1' ) {
            return $this->get_button_url( $button_url );
        } else {
            return '<a class="rr-available-button" href="' . $r->AvailabilityURL . '">Check Availability</a>';
        }
    }

    function get_button_url( $button_url ) {
        if ( $button_url ) {
            return '<a class="rr-available-button" href="' . $button_url . '">Contact Us</a>';
        } else {
            return '<a class="rr-available-button" disabled>Call for Availability</a>';
        }
    }

    public function rrdf_shortcode( $atts ) {
        extract( shortcode_atts( array(
            'property_id' => '',
            'display_format' => '',
            'content_type' => '',
        ), $atts ) );

        $options = get_option( $this->plugin_name );
        $api_key = $options['api_key'];
        $button_url = $options['contact_page'];

        if( $content_type == 'images' ) {
            $request = 'https://api.rentcafe.com/rentcafeapi.aspx?requestType=images&type=propertyImages&APIToken=' . $api_key . '&propertyId=' . $property_id;
        } elseif( $content_type == 'amenities' ) {
            $request = 'https://api.rentcafe.com/rentcafeapi.aspx?requestType=property&type=amenities&APIToken=' . $api_key . '&propertyId=' . $property_id; 
        } else {
            $request = 'https://api.rentcafe.com/rentcafeapi.aspx?requestType=floorplan&APIToken=' . $api_key . '&propertyId=' . $property_id;
        }

        $request_decode = json_decode( file_get_contents( $request ) );

        if( property_exists( $request_decode[0], 'Error' ) ) {
            return 'No details found';
        } elseif ( $content_type == 'images' ) {
            return $this->display_images_grid( $request_decode );
        } elseif ( $content_type == 'amenities' ) {
            return $this->display_amenities ( $request_decode );
        } else {
            if( $display_format != 'table' ) {
                return $this->display_availability_cards( $request_decode, $button_url );
            } else {
                return $this->display_availability_table( $request_decode, $button_url );
            }
        }
    }

    function display_images_grid( $request_decode ) {

        $html_output = '<div class="rr-image-grid">';

        foreach( $request_decode as $r ) {
            $image_url = $r->ImageURL;
            $image_alt = $r->AltText;
            $html_output .= '<img class="rr-image-grid-thumbnail" src="' . $image_url . '" alt="' . $image_alt . '">';
        }

        $html_output .= '</div>';
        return $html_output;

    }

    function display_amenities( $request_decode ) {

        $html_output = '<ul>';

        foreach( $request_decode as $r ) {
            $amenity_name = $r->CustomAmenityName;
            $featured_amenity = $r->FeaturedAmenity;

            $html_output .= '<li>'. $amenity_name . '</li>';
        }

        $html_output .= '</ul>';
        return $html_output;
    }

    function display_availability_cards( $request_decode, $button_url ) {

        $html_output = '<div class="rr-pricing-grid-wrapper"><div class="rr-pricing-grid">';

        foreach( $request_decode as $r ) {

            $model_name = $r->FloorplanName;
            $img_string = '<img class="rr-pricing-grid-thumbnail" src="" alt="' . $model_name . ' floor plan image." >';
            $number_of_beds = $r->Beds;
            $number_of_baths = $r->Baths;

            if( $r->FloorplanImageURL ) {
                $floor_plan_image = explode( ',', $r->FloorplanImageURL );
                $img_string = '<img class="rr-pricing-grid-thumbnail" src="' . $floor_plan_image[0] . '" alt="' . $r->FloorplanImageAltText . '">';
            } else {
                $img_string = '<img class="rr-pricing-grid-thumbnail" src="' . plugin_dir_url( __FILE__ ) . "assets/image-coming-soon.jpg" . '" alt="' . $r->FloorplanImageAltText . '">';
            }

            $html_output .= '<div class="rr-pricing-grid-block"><div class="rr-pricing-grid-floorplan">' . $img_string . '</div>';
            $html_output .= '<div class="rr-pricing-grid-block-content">';
            $html_output .= '<div class="rr-model-name">' . $model_name . '</div>';
            $html_output .= '<ul><li>' . $number_of_beds . ' Bedroom</li><li>' . $number_of_baths . ' Bath</li></ul>';
            $html_output .= '<p class="rr-pricing-grid-sq-ft">' . $this->get_sqft($r) . '</p>';
            $html_output .= '<p class="rr-pricing-grid-block-rent">' . $this->get_pricing($r) . '</p>';
            $html_output .=  $this->get_button($r, $button_url);
            $html_output .= '</div></div>';

        }
        $html_output .= '</div></div>';
        return $html_output;
    }

    function display_availability_table( $request_decode, $button_url ) {

        $html_output = '<table class="rr-pricing-table">';
        $html_output .= '<thead><tr>';
        $html_output .= '<th scope="col">View</th>';
        $html_output .= '<th scope="col">Model</th>';
        $html_output .= '<th scope="col">Bedrooms</th>';
        $html_output .= '<th scope="col">Baths</th>';
        $html_output .= '<th scope="col">Sq Ft</th>';
        $html_output .= '<th scope="col">Rent</th>';
        $html_output .= '<th scope="col">Availability</th>';
        $html_output .= '</tr></thead>';

        foreach( $request_decode as $r ) {

            $model_name = $r->FloorplanName;
            $img_string = '<img class="rr-pricing-grid-thumbnail" src="" alt="' . $model_name . ' floor plan image." >';
            $number_of_beds = $r->Beds;
            $number_of_baths = $r->Baths;

            if( $r->FloorplanImageURL ) {
                $floor_plan_image = explode( ',', $r->FloorplanImageURL );
                $img_string = '<img class="rr-pricing-table-thumbnail" src="' . $floor_plan_image[0] . '" alt="' . $r->FloorplanImageAltText . '">';
            } else {
                $img_string = '<img class="rr-pricing-table-thumbnail" src="' . plugin_dir_url( __FILE__ ) . "assets/image-coming-soon.jpg" . '" alt="' . $r->FloorplanImageAltText . '">';
            }

            $html_output .= '<tr><td scope="row">' . $img_string . '</td>';
            $html_output .= '<td>' . $model_name . '</td>';
            $html_output .= '<td>' . $number_of_beds . '</td>';
            $html_output .= '<td>' . $number_of_baths .'</td>';
            $html_output .= '<td>' . $this->get_sqft($r) . '</td>';
            $html_output .= '<td>' . $this->get_pricing($r) . '</td>';
            $html_output .= '<td>' . $this->get_button($r, $button_url) . '</td></tr>';
        }
        $html_output .= '</table>';
        return $html_output;
    }
}