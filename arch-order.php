<?php
/**
* Plugin Name: Arch Order
* Plugin URI:  https://github.com/m-e-h
* Description: A radical new plugin for WordPress!
* Version:     0.1.0
* Author:      Marty Helmick
* Author URI:  https://github.com/m-e-h
* Donate link: https://github.com/m-e-h
* License:     GPLv2
* Text Domain: arch-order
* Domain Path: /languages
*
* @link https://github.com/m-e-h
*
* @package Arch Order
* @version 0.1.0
*/

/**
* Main initiation class
*
* @since  0.1.0
*/
final class Arch_Order {

	/**
	* Directory path to the plugin folder.
	*
	* @since  1.0.0
	* @access public
	* @var    string
	*/
	public $dir_path = '';

	/**
	* Directory URI to the plugin folder.
	*
	* @since  1.0.0
	* @access public
	* @var    string
	*/
	public $dir_uri = '';

	/**
	* Plugin CSS directory URI.
	*
	* @since  1.0.0
	* @access public
	* @var    string
	*/
	public $css_uri = '';

	/**
	* Plugin JS directory URI.
	*
	* @since  1.0.0
	* @access public
	* @var    string
	*/
	public $js_uri = '';

	/**
	* Plugin Image directory URI.
	*
	* @since  1.0.0
	* @access public
	* @var    string
	*/
	public $img_uri = '';

	/**
	* Google maps api key.
	*
	* @since  1.0.0
	* @access public
	* @var    string
	*/
	public $arch_page = '';

	/**
	* Singleton instance of plugin
	*
	* @var Arch_Order
	* @since  0.1.0
	*/
	protected static $instance = null;

	/**
	* Creates or returns an instance of this class.
	*
	* @since  0.1.0
	* @return Arch_Order A single instance of this class.
	*/
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
			self::$instance->includes();
		}

		return self::$instance;
	}

	/**
	* Sets up our plugin
	*
	* @since  0.1.0
	*/
	protected function __construct() {
		$this->basename = plugin_basename( __FILE__ );
		$this->dir_uri 	= plugin_dir_url( __FILE__ );
		$this->dir_path = plugin_dir_path( __FILE__ );

		// Plugin directory URIs.
		$this->css_uri 	= trailingslashit( $this->dir_uri . 'assets/css' );
		$this->js_uri  	= trailingslashit( $this->dir_uri . 'assets/js' );
		$this->img_uri  = trailingslashit( $this->dir_uri . 'assets/images' );
	}

	/**
	* Loads include and admin files for the plugin.
	*
	* @since  1.0.0
	* @access private
	* @return void
	*/
	private function includes() {
		require_once $this->dir_path . 'inc/post-types.php';
		require_once $this->dir_path . 'inc/functions.php';
	}

	/**
	* Add hooks and filters
	*
	* @since  0.1.0
	* @return void
	*/
	public function hooks() {
		register_activation_hook( __FILE__, array( $this, '_activate' ) );
		register_deactivation_hook( __FILE__, array( $this, '_deactivate' ) );

		// Add admin pages.
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );

		// Enqueue scripts.
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );

		// Load Vue templates.
		//add_action( 'admin_footer', array( $this, 'load_templates' ) );

		add_action( 'init', array( $this, 'init' ) );
	}

	/**
	* Activate the plugin
	*
	* @since  0.1.0
	* @return void
	*/
	public function _activate() {
		department_post_type();

		// Make sure any rewrite functionality has been loaded.
		flush_rewrite_rules();
	}

	/**
	* Deactivate the plugin
	* Uninstall routines should be in uninstall.php
	*
	* @since  0.1.0
	* @return void
	*/
	public function _deactivate() {
		flush_rewrite_rules();
	}

	/**
	* Adds admin page.
	*
	* @since  1.0.0
	* @access public
	* @return void
	*/
	public function admin_menu() {

		$this->arch_page = add_submenu_page(
			'edit.php?post_type=department',
			esc_html__( 'Arch Order', 'ao' ),
			esc_html__( 'Arch Order', 'ao' ),
			'manage_options',
			'arch-order',
			array( $this, 'arch_page' )
		);
	}

	/**
	* Register scripts and styles.
	*
	* @since  1.0.0
	* @access public
	* @return void
	*/
	public function admin_scripts( $hook ) {

		if ( $this->arch_page === $hook ) {

			wp_enqueue_script( 'vuejs', $this->js_uri . 'vue.js', array(), '', true );
			wp_enqueue_script( 'vue-router', $this->js_uri . 'vue-router.js', array(), '', true );
			wp_enqueue_script( 'axios', $this->js_uri . 'axios.min.js', array(), '', true );

			// wp_enqueue_script( 'object-fit', $this->js_uri . 'objectFitPolyfill.basic.min.js', array(), '', true );

			wp_enqueue_script( 'main', $this->js_uri . 'main.js', array(), '', true );

			wp_enqueue_style( 'arch-style', $this->css_uri . 'ao-admin.css', false, false );
		}
	}

	/**
	* Loads Vue.js templates.
	*
	* @since  1.0.0
	* @access public
	* @return void
	*/
	public function load_templates() {
		?>
		<script type="text/html" id="tmpl-arch-page">
			<?php require_once( $this->dir_path . 'tmpl/arch-page.php' ); ?>
		</script>
		<?php }

		/**
		* Outputs the tools sub-menu page.
		*
		* @since  1.0.0
		* @access public
		* @return void
		*/
	public function arch_page() {
		?>

		<!-- <div class="white-wrap">
			<h1>Hello</h1>
			<div id="app">

				<router-view></router-view>

			</div>
		</div> -->



		<div id="app" class="arch-wrap">
			<h1>Post Table</h1>
			<div id="app" class="o-grid p-minus">
				<template v-for="post in posts">
					<div class="postbox c-card o-cell u-flex u-flex-col h6">
						<div v-if="post.thumb_url" class="card-image-wrap">
						<img v-bind:src="post.thumb_url" class="card-image u-1of1">
						</div>
					    <div class="card-block mt-auto u-1of1">
							<h2 class="card-title h6 m-0 p-3">{{post.title.rendered}}</h2>
					    </div>
					    <div class="card-footer u-1of1 p-minus">
					      <div class="post-author mb-1">{{post.author_name}}</div>
						  <div class="post-date mb-1">{{post.posted_on}}</div>

						  <div v-for="category in post.cats" class="post-cat badge mb-1 p-minus">{{category.name}}</div>
					    </div>
					</div>
				</template>
			</div>
			<pre>{{ $data }}</pre>
		</div>

		<?php }

			/**
			* Init hooks
			*
			* @since  0.1.0
			* @return void
			*/
	public function init() {
		// bail early if requirements aren't met
		if ( ! $this->check_requirements() ) {
			return;
		}

		// initialize plugin classes
		//$this->plugin_classes();
	}

			/**
			* Check if the plugin meets requirements and
			* disable it if they are not present.
			*
			* @since  0.1.0
			* @return boolean result of meets_requirements
			*/
	public function check_requirements() {
		// bail early if pluginmeets requirements
		if ( $this->meets_requirements() ) {
			return true;
		}

		// Add a dashboard notice.
		add_action( 'all_admin_notices', array( $this, 'requirements_not_met_notice' ) );

		// Deactivate our plugin.
		add_action( 'admin_init', array( $this, 'deactivate_me' ) );

		return false;
	}

			/**
			* Deactivates this plugin, hook this function on admin_init.
			*
			* @since  0.1.0
			* @return void
			*/
	public function deactivate_me() {
		// Check for deactivate_plugins to prevent calling too early.
		if ( function_exists( 'deactivate_plugins' ) ) {
			deactivate_plugins( $this->basename );
		}
	}

			/**
			* Check that all plugin requirements are met
			*
			* @since  0.1.0
			* @return boolean True if requirements are met.
			*/
	public function meets_requirements() {
		// Do checks for required classes / functions
		// function_exists('') & class_exists('').
		// We have met all requirements.
		// Add detailed messages to $this->activation_errors array
		return true;
	}

			/**
			* Adds a notice to the dashboard if plugin requirements not met
			*
			* @since  0.1.0
			* @return void
			*/
	public function requirements_not_met_notice() {
		// compile default message
		$default_message = sprintf(
			__( 'Arch Order is missing requirements and has been <a href="%s">deactivated</a>. Please make sure all requirements are available.', 'arch-order' ),
			admin_url( 'plugins.php' )
		);

		// default details to null
		$details = null;

		// add details if any exist
		if ( ! empty( $this->activation_errors ) && is_array( $this->activation_errors ) ) {
			$details = '<small>' . implode( '</small><br /><small>', $this->activation_errors ) . '</small>';
		}

		// output errors
		?>
		<div id="message" class="error">
			<p><?php echo $default_message; ?></p>
			<?php echo $details; ?>
				</div>
				<?php
	}
}

		/**
		* Grab the Arch_Order object and return it.
		* Wrapper for Arch_Order::get_instance()
		*
		* @since  0.1.0
		* @return Arch_Order  Singleton instance of plugin class.
		*/
function ao_plugin() {
	return Arch_Order::get_instance();
}

		// Kick it off.
		add_action( 'plugins_loaded', array( ao_plugin(), 'hooks' ) );
