<?php 

/* 
    plugin name: WP Filter
    description: Dynamic Ajax Filter for all posts
    version: 1.0.0
    author: WP Filter Team
*/

function wp_filter_custom(){
    add_menu_page( 
       'WP Filter',
        'WP Filter',
        'manage_options',
        'wp_filter_slug',
        'wp_filter_fn',
        'dashicons-filter',
        65
    ); 
}
add_action( 'admin_menu', 'wp_filter_custom' );


function wp_filter_scripts() {
    wp_enqueue_style( 'custom',  plugin_dir_url( __FILE__ ).'inc/css/custom.css' );
    wp_enqueue_script( 'custom', plugin_dir_url( __FILE__ ).'/inc/js/custom.js', array(), '1.0.0', true );
}
add_action( 'init', 'wp_filter_scripts' );

function wp_filter_fn(){
    echo '<div class="wrap"><h1>Drag & Drop Form</h1>'; ?>
    <?php 
    require_once(plugin_dir_path( __FILE__ ).'templates/drag_drop.php');
    require_once(plugin_dir_path( __FILE__ ).'form_data/form_data.php'); 
    echo '</div>';
}

register_activation_hook( __FILE__, 'create_table_filter');
register_deactivation_hook( __FILE__, 'delete_table_filter' );

function create_table_filter() {
  //$charset_collate = $wpdb->get_charset_collate();
  global $wpdb;
  $table_name = $wpdb->prefix . 'filter_table';
  $sql = "CREATE TABLE `$table_name` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `form_sec_id` int(11) NOT NULL,
  `form_sec_label` varchar(255) NOT NULL,
  `form_sec_placeholder` varchar(255) NOT NULL,
  `form_sec_name` varchar(255) NOT NULL,
  'form_select_value' varchar(255) NOT NULL,
  `form_sec_require` varchar(255),
  `form_sec_type` varchar(255) NOT NULL,
  `filter_option` varchar(2000),
  `filter_value` varchar(2000),
  PRIMARY KEY(id)
  ) ENGINE=MyISAM DEFAULT CHARSET=latin1;
  ";
  if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
  }
}

function delete_table_filter() {
    global $wpdb;
    $table_name = $wpdb->prefix.'filter_table';
    $sql = "DROP TABLE IF EXISTS $table_name";
    $wpdb->query($sql);
}

function form_data_function(){
     global $wpdb;
     $listId = explode(',' , $_POST['form_output']);
     $form_checked = explode(',' , $_POST['form_checked']);
     $form_type = explode(',' , $_POST['form_type']);
     $option_label = serialize(explode(',' , $_POST['option_label']));
     $option_value = serialize(explode(',' , $_POST['option_value']));
     
     $table = $wpdb->prefix . "filter_table";            
    

     //echo Unserialize($option_label);

     foreach($listId as $i => $listIds){
        // foreach($option_label as $j => $option_labels){
        //     echo  $option_lab[$j];
        //     }
        $result = $wpdb->get_row("SELECT * FROM $table WHERE form_sec_id = $listIds");

        if($result>0){
            echo 'Value Exist in DB';
        }
        else{
            echo 'Value Not Exist';
           
            $formtype_value = ($form_type == 'text') ? $_POST["text_$listIds"] :  '';
            $form_select_value = (!($form_type == 'text')) ? $_POST["select_$listIds"] :  '';
            echo $form_select_value;
            $wpdb->insert($table , array(
                'form_sec_id' => $listIds,
                'form_sec_label' => $_POST["label_$listIds"],
                'form_sec_placeholder' => $formtype_value,
                'form_sec_name' => $_POST["text_$listIds"],
                'form_select_value' => $form_select_value,
                'form_sec_require'=> $form_checked[$i],
                'form_sec_type' => $form_type[$i],
                'filter_option' => $option_label,
                'filter_value' => $option_value,
             ));
        }

         
         
     }

     die();
}
add_action('wp_ajax_form_data_function', 'form_data_function');
add_action('wp_ajax_nopriv_form_data_function', 'form_data_function');









function form_delete_function(){
    global $wpdb;
    $did = $_POST['did'];
    $table = $wpdb->prefix.'filter_table';
    $wpdb->delete( $table, array( 'form_sec_id' => $did ) );
    die();
}
add_action('wp_ajax_form_delete_function', 'form_delete_function');
add_action('wp_ajax_nopriv_form_delete_function', 'form_delete_function');


////////////////////////////////

add_action( 'admin_menu', 'stp_api_add_admin_menu' );
add_action( 'admin_init', 'stp_api_settings_init' );

function stp_api_add_admin_menu(  ) {
    add_submenu_page('wp_filter_slug', 'Settings', 'Settings', 'manage_options', 'settings-api-page', 'stp_api_options_page' );
}

function stp_api_settings_init(  ) {
    register_setting( 'filter_slug', 'stp_api_settings' );
    add_settings_section(
        'filter_slug_section',
        '',
        'stp_api_settings_section_callback',
        'filter_slug'
    );


    add_settings_field(
        'stp_api_select_field_1',
        'Post Type',
        'filter_post_type',
        'filter_slug',
        'filter_slug_section'
    );
 
}

function filter_post_type(  ) {
    $options = get_option( 'stp_api_settings' );
    $post_type = get_post_types($args = array(
        'public'   => true,
     ));
     //print_r($post_type);
     echo "<select name='stp_api_settings[stp_api_select_field_1]'>";
    foreach($post_type as $i => $post_types){
       // echo $post_types; ?>
        <option value='<?php echo $i ?>' <?php selected( $options['stp_api_select_field_1'], $i ); ?>><?php echo $post_types ?></option>
       <?php 
    };
    echo "</select>";
    ?>
     

<?php
}



function stp_api_settings_section_callback(  ) {
   // echo __( 'This Section Description', 'wordpress' );
}

function stp_api_options_page(  ) {
    ?>
    <form action='options.php' method='post'>

        <h1>Settings Page</h1>

        <?php
        settings_fields( 'filter_slug' );
        do_settings_sections( 'filter_slug' );
        submit_button();
        ?>

    </form>
    <?php
}