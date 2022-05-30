<?php
/**
 * Zakra functions and definitions
 *
 * @link    https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package zakra
 */

if ( ! function_exists( 'zakra_setup' ) ) :
	// Sets up theme defaults and registers support for various WordPress features.
	function zakra_setup() {
		// Make theme available for translation.
		load_theme_textdomain( 'zakra', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// Let WordPress manage the document title.
		add_theme_support( 'title-tag' );

		// Enable support for Post Thumbnails on posts and pages.
		add_theme_support( 'post-thumbnails' );

		// Register menu.
		register_nav_menus(
			array(
				'menu-primary' => esc_html__( 'Primary', 'zakra' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'width'       => 170,
				'height'      => 60,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);

		// Custom background support.
		add_theme_support( 'custom-background' );

		// Gutenberg Wide/fullwidth support.
		add_theme_support( 'align-wide' );

		// Add support for Block Styles.
		add_theme_support( 'wp-block-styles' );

		// AMP support.
		if ( defined( 'AMP__VERSION' ) && ( ! version_compare( AMP__VERSION, '1.0.0', '<' ) ) ) {
			add_theme_support(
				'amp',
				apply_filters(
					'zakra_amp_support_filter',
					array(
						'paired' => true,
					)
				)
			);
		}
	}
endif;
add_action( 'after_setup_theme', 'zakra_setup' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function zakra_widgets_init() {
	$sidebars = apply_filters(
		'zakra_sidebars_args',
		array(
			'sidebar-right'            => esc_html__( 'Sidebar Right', 'zakra' ),
			'sidebar-left'             => esc_html__( 'Sidebar Left', 'zakra' ),
			'header-top-left-sidebar'  => esc_html__( 'Header Top Bar Left Sidebar', 'zakra' ),
			'header-top-right-sidebar' => esc_html__( 'Header Top Bar Right Sidebar', 'zakra' ),
			'footer-sidebar-1'         => esc_html__( 'Footer One', 'zakra' ),
			'footer-sidebar-2'         => esc_html__( 'Footer Two', 'zakra' ),
			'footer-sidebar-3'         => esc_html__( 'Footer Three', 'zakra' ),
			'footer-sidebar-4'         => esc_html__( 'Footer Four', 'zakra' ),
			'footer-bar-left-sidebar'  => esc_html__( 'Footer Bottom Bar Left Sidebar', 'zakra' ),
			'footer-bar-right-sidebar' => esc_html__( 'Footer Bottom Bar Right Sidebar', 'zakra' ),
		)
	);

	if ( zakra_is_woocommerce_active() ) {
		$sidebars['wc-left-sidebar']  = esc_html__( 'WooCommerce Left Sidebar', 'zakra' );
		$sidebars['wc-right-sidebar'] = esc_html__( 'WooCommerce Right Sidebar', 'zakra' );
	}

	foreach ( $sidebars as $id => $name ) {
		register_sidebar(
			apply_filters(
				'zakra_sidebars_widget_args',
				array(
					'id'            => $id,
					'name'          => $name,
					'description'   => esc_html__( 'Add widgets here.', 'zakra' ),
					'before_widget' => '<section id="%1$s" class="widget %2$s">',
					'after_widget'  => '</section>',
					'before_title'  => '<h2 class="widget-title">',
					'after_title'   => '</h2>',
				)
			)
		);
	}
}

add_action( 'widgets_init', 'zakra_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function zakra_scripts() {
	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

	/**
	 * Styles.
	 */
	// Font Awesome 4.
	wp_register_style( 'font-awesome', get_template_directory_uri() . '/assets/lib/font-awesome/css/font-awesome' . $suffix . '.css', false, '4.7.0' );
	wp_enqueue_style( 'font-awesome' );

	// Theme style.
	wp_register_style( 'zakra-style', get_stylesheet_uri() );
	wp_enqueue_style( 'zakra-style' );

	// Support RTL.
	wp_style_add_data( 'zakra-style', 'rtl', 'replace' );

	/**
	 * Inline CSS for this theme.
	 */
	add_filter( 'zakra_dynamic_theme_css', array( 'Zakra_Dynamic_CSS', 'render_output' ) );

	// Enqueue required Google font for the theme.
	Zakra_Generate_Fonts::render_fonts();

	// Generate dynamic CSS to add inline styles for the theme.
	$theme_dynamic_css = apply_filters( 'zakra_dynamic_theme_css', '' );

	if ( zakra_is_zakra_pro_active() ) {
		wp_add_inline_style( 'zakra-pro', $theme_dynamic_css );
	} else {
		wp_add_inline_style( 'zakra-style', $theme_dynamic_css );
	}

	// Do not load scripts if AMP.
	if ( zakra_is_amp() ) {
		return;
	}

	/**
	 * Scripts.
	 */
	wp_enqueue_script( 'zakra-navigation', get_template_directory_uri() . '/assets/js/navigation' . $suffix . '.js', array(), '20151215', true );
	wp_enqueue_script( 'zakra-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix' . $suffix . '.js', array(), '20151215', true );

	// Theme JavaScript.
	wp_enqueue_script( 'zakra-custom', get_template_directory_uri() . '/assets/js/zakra-custom' . $suffix . '.js', array(), false, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

}
add_action( 'wp_enqueue_scripts', 'zakra_scripts' );

/**
 * Enqueue block editor styles.
 *
 * @since Zakra 1.4.3
 */
function zakra_block_editor_styles() {
	wp_enqueue_style( 'zakra-block-editor-styles', get_template_directory_uri() . '/style-editor-block.css' );
}
add_action( 'enqueue_block_editor_assets', 'zakra_block_editor_styles', 1, 1 );

/**
 * Define constants.
 */
define( 'ZAKRA_PARENT_DIR', get_template_directory() );
define( 'ZAKRA_PARENT_URI', get_template_directory_uri() );
define( 'ZAKRA_PARENT_INC_DIR', ZAKRA_PARENT_DIR . '/inc' );
define( 'ZAKRA_PARENT_INC_URI', ZAKRA_PARENT_URI . '/inc' );
define( 'ZAKRA_PARENT_INC_ICON_URI', ZAKRA_PARENT_URI . '/assets/img/icons' );
define( 'ZAKRA_PARENT_CUSTOMIZER_DIR', ZAKRA_PARENT_INC_DIR . '/customizer' );

// Theme version.
$zakra_theme = wp_get_theme( 'zakra' );
define( 'ZAKRA_THEME_VERSION', $zakra_theme->get( 'Version' ) );

// AMP support files.
if ( defined( 'AMP__VERSION' ) && ( ! version_compare( AMP__VERSION, '1.0.0', '<' ) ) ) {
	require_once ZAKRA_PARENT_INC_DIR . '/compatibility/amp/class-zakra-amp.php';
}

/**
 * Include files.
 */
require ZAKRA_PARENT_INC_DIR . '/helpers.php';
require ZAKRA_PARENT_INC_DIR . '/custom-header.php';
require ZAKRA_PARENT_INC_DIR . '/class-zakra-dynamic-filter.php';
require ZAKRA_PARENT_INC_DIR . '/template-tags.php';
require ZAKRA_PARENT_INC_DIR . '/template-functions.php';
require ZAKRA_PARENT_INC_DIR . '/customizer/class-zakra-customizer.php';
require ZAKRA_PARENT_INC_DIR . '/class-zakra-css-classes.php';
require ZAKRA_PARENT_INC_DIR . '/class-zakra-dynamic-css.php';
require ZAKRA_PARENT_INC_DIR . '/class-zakra-migration.php';

// Load Jetpack compatibility file.
if ( defined( 'JETPACK__VERSION' ) ) {
	require ZAKRA_PARENT_INC_DIR . '/class-zakra-jetpack.php';
}

// WooCommerce hooks and functions.
if ( class_exists( 'WooCommerce' ) ) {
	require ZAKRA_PARENT_INC_DIR . '/compatibility/woocommerce/class-zakra-woocommerce.php';
}

// Load hooks.
require ZAKRA_PARENT_INC_DIR . '/hooks/hooks.php';
require ZAKRA_PARENT_INC_DIR . '/hooks/header.php';
require ZAKRA_PARENT_INC_DIR . '/hooks/footer.php';
require ZAKRA_PARENT_INC_DIR . '/hooks/content.php';
require ZAKRA_PARENT_INC_DIR . '/hooks/customize.php';

// Breadcrumbs class.
require_once ZAKRA_PARENT_INC_DIR . '/class-breadcrumb-trail.php';

// Elementor Pro compatibility.
require_once ZAKRA_PARENT_INC_DIR . '/compatibility/elementor/class-zakra-elementor-pro.php';

// Admin screen.
if ( is_admin() ) {
	// Meta boxes.
	require ZAKRA_PARENT_INC_DIR . '/meta-boxes/class-zakra-meta-box-page-settings.php';
	require ZAKRA_PARENT_INC_DIR . '/meta-boxes/class-zakra-meta-box.php';

	// Theme options page.
	require ZAKRA_PARENT_INC_DIR . '/admin/class-zakra-admin.php';
	require ZAKRA_PARENT_INC_DIR . '/admin/class-zakra-notice.php';
	require ZAKRA_PARENT_INC_DIR . '/admin/class-zakra-welcome-notice.php';
	require ZAKRA_PARENT_INC_DIR . '/admin/class-zakra-upgrade-notice.php';
	require ZAKRA_PARENT_INC_DIR . '/admin/class-zakra-dashboard.php';
	require ZAKRA_PARENT_INC_DIR . '/admin/class-zakra-theme-review-notice.php';
	require ZAKRA_PARENT_INC_DIR . '/admin/class-zakra-demo-import-migration-notice.php';
	require ZAKRA_PARENT_INC_DIR . '/admin/class-zakra-pro-minimum-version-notice.php';
}

// Set default content width.
if ( ! isset( $content_width ) ) {
	$content_width = 812;
}

// Calculate $content_width value according to layout options from Customizer and meta boxes.
function zakra_content_width_rdr() {
	global $content_width;

	// Get layout type.
	$layout_type     = zakra_get_layout_type();
	$layouts_sidebar = array( 'tg-site-layout--left', 'tg-site-layout--right' );

	/**
	 * Calculate content width.
	 */
	// Get required values from Customizer.
	$container_width_arr = get_theme_mod( 'zakra_general_container_width', 1160 );

	$content_width_arr = get_theme_mod( 'zakra_general_content_width', 70 );

	// Calculate Padding to reduce.
	$container_style = get_theme_mod( 'zakra_general_container_style', 'tg-container--wide' );

	$content_padding = ( 'tg-container--separate' === $container_style ) ? 120 : 60;

	if ( in_array( $layout_type, $layouts_sidebar, true ) ) {
		$content_width = ( ( (int) $container_width_arr * (int) $content_width_arr ) / 100 ) - $content_padding;
	} else {
		$content_width = (int) $container_width_arr - $content_padding;
	}

}
add_action( 'template_redirect', 'zakra_content_width_rdr' );

function filter_shortcode(){

$tag_terms = get_terms( array(
    'taxonomy' => 'post_tag',
    'hide_empty' => true,
) );
$cat_terms = get_terms( array(
    'taxonomy' => 'category',
    'hide_empty' => true,
) ); 

$post_type = get_terms( array(
    'taxonomy' => 'post_types',
    'hide_empty' => true,
) ); 

?>

<div class="filter_bar_outer"><form id="filter_form_id">
	<div class="filter_bar">		
	<div class="filter_bar_tag">
		<select name="tag_name">
		<option disabled selected>Select Tag</option>
		<?php foreach($tag_terms as $tag_term){
			echo '<option value="'.$tag_term->slug.'">'.$tag_term->name.'</option>';
		}
		?>	
		</select>
	</div>

	<div class="filter_bar_cat">
		<select name="cat_name">
		<option disabled selected>Select Category</option>
		<?php foreach($cat_terms as $cat_term){
			echo '<option value="'.$cat_term->slug.'">'.$cat_term->name.'</option>';
		}
		?>	
		</select>
	</div>
	
	<div class="filter_bar_type">
		<select name="type_name">
		<option disabled selected>Select Type</option>
		<?php foreach($post_type as $post_types){
			echo '<option value="'.$post_types->slug.'">'.$post_types->name.'</option>';
		}
		?>	
		</select>
	</div>

	<div class="filter_bar_search">
		 <input type="text" name="filter_bar_search" placeholder="Search...">
	</div>

	</div></form></div>

	<div class="show_error"></div>
<?php	echo '<div class="filter_outer_grid">';
echo '<div class="filter_outer_grid_inside">';
$args = array(
	'post_type'=> 'post',
	'post_status' => 'publish',
	'posts_per_page' => -1 // this will retrive all the post that is published 
	);
	$result = new WP_Query( $args );
if ( $result-> have_posts() ) :
 while ( $result->have_posts() ) : $result->the_post(); ?>
<div class="">
	<?php the_post_thumbnail(); ?>	
<h3><?php the_title(); ?></h3>
	</div>
<?php endwhile; 
endif; wp_reset_postdata(); 
echo '</div></div>';
}
add_shortcode('filter_shortcode', 'filter_shortcode');


function form_filter_submit(){
	$tag_name = $_POST['tag_name'];
	$cat_name = $_POST['cat_name'];
	$type_name = $_POST['type_name'];
	$filter_bar_search = $_POST['filter_bar_search'];
	//print_r($form_values);
	echo '<div class="filter_outer_grid_inside">';
	
	if( isset( $tag_name ) ){
		$query_filter['tax_query'][] = array(
			'taxonomy' => 'post_tag',
			'field'    => 'slug',
			'terms'    => $tag_name
		);
	}

	if( isset( $cat_name ) ){
		$query_filter['tax_query'][] = array(
			'taxonomy' => 'category',
			'field'    => 'slug',
			'terms'    => $cat_name
		);
	}

	if( isset( $type_name ) ){
		$query_filter['tax_query'][] = array(
			'taxonomy' => 'post_types',
			'field'    => 'slug',
			'terms'    => $type_name
		);
	}

	if(isset( $tag_name ) && isset( $cat_name )){
		$query_filter['tax_query'][] = array(
			'relation' => 'AND',
			array(
				'taxonomy' => 'post_tag',
				'field'    => 'slug',
				'terms'    => $tag_name
			),
			array(
				'taxonomy' => 'category',
				'field'    => 'slug',
				'terms'    => $cat_name
			)		
			);
	}

	if(isset( $tag_name ) && isset( $type_name )){
		$query_filter['tax_query'][] = array(
			'relation' => 'AND',
			array(
				'taxonomy' => 'post_tag',
				'field'    => 'slug',
				'terms'    => $tag_name
			),
			array(
				'taxonomy' => 'post_types',
				'field'    => 'slug',
				'terms'    => $type_name
			)		
			);
	}

	if(isset( $cat_name ) && isset( $type_name )){
		$query_filter['tax_query'][] = array(
			'relation' => 'AND',
			array(
				'taxonomy' => 'category',
				'field'    => 'slug',
				'terms'    => $cat_name
			),
			array(
				'taxonomy' => 'post_types',
				'field'    => 'slug',
				'terms'    => $type_name
			)		
			);
	}

	if(isset( $cat_name ) && isset( $type_name ) && isset( $tag_name )){
		$query_filter['tax_query'][] = array(
			'relation' => 'AND',
			array(
				'taxonomy' => 'category',
				'field'    => 'slug',
				'terms'    => $cat_name
			),
			array(
				'taxonomy' => 'post_types',
				'field'    => 'slug',
				'terms'    => $type_name
			),
			array(
				'taxonomy' => 'post_tag',
				'field'    => 'slug',
				'terms'    => $tag_name
			)			
			);
	}
	
	$args = array(
		'post_type'=> 'post',
		'post_status' => 'publish',
		'posts_per_page' => -1,	
		'tax_query' => $query_filter,
		's' => $filter_bar_search
		);
	$result = new WP_Query( $args );
	if ( $result-> have_posts() ) {
	 while ( $result->have_posts() ) : $result->the_post(); ?>
	<div class="">
		<?php the_post_thumbnail(); ?>	
	<h3><?php the_title(); ?></h3>
		</div>
	<?php endwhile; 
	}
	else {    
		echo '<h2>No Post Found</h2>';
	}
	wp_reset_postdata(); 
	echo '</div>';
	
	die;
}

add_action('wp_ajax_form_filter_submit', 'form_filter_submit');
add_action('wp_ajax_nopriv_form_filter_submit', 'form_filter_submit');

 

function add_taxonomy_post(){
	$labels = array(
		'menu_name' => __( 'Type' ),
	  ); 
	register_taxonomy('post_types','post',array(
		'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
	  ));
}
add_action('init', 'add_taxonomy_post');