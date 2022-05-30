<?php 

if(isset($_POST['filter_form_submit'])){

    global $wpdb;
         $tablename = $wpdb->prefix.'post_job';

        $wpdb->insert( $tablename, array(
            'form_sec_id' => '<script>alert()</script>', 
            'form_sec_label' => $_POST['post'],
            'form_sec_placeholder' => $_POST['publishfrom'], 
            'form_sec_name' => $_POST['publishupto'],
            'form_sec_require' => $_POST['qualification1']
        ),
            array( '%s', '%s', '%s', '%s', '%s') 
        );


echo $_POST['filter_form_submit'];
}