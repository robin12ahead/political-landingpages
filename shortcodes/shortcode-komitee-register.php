<?php

/*---------------------------------------------------------------------------
Shortcode to add frontend form to crete new komitee post
---------------------------------------------------------------------------*/

// add the shortcode function
add_shortcode( 'komitee-anmeldung', 'shortcode_komitee_anmeldung' );
function shortcode_komitee_anmeldung( $atts ) { 

    ob_start();

    // Attributes
    $atts = shortcode_atts( array(
        'submit_text' => 'Jetzt Anmelden!',
        'updated_message' => 'Vielen Dank für Ihre Anmeldung! Ihre Angaben werden nun von uns überprüft.',
    ), $atts, 'komitee-anmeldung' );
    
    acf_form(array(
        'post_id'       => 'new_post',
        'new_post'      => array(
            'post_type'     => 'komitee',
            'post_status'   => 'pending',
            'tax_input'    => array(
                'komitee_category' => "3"
            ),
        ),
        'post_title' => false,
        'post_content' => false,
        'field_groups' => array("group_6688079b68c3e"),
        'fields' => array("field_66880973f2bb8", "field_66880a99871ad", "field_669508a490052", "field_66963eaf87738"),
        'updated_message' => $atts['updated_message'],
        // 'return' => '',
        'submit_value'  => $atts['submit_text'],
        'honeypot' => true,
        'form' => true,
        'uploader' => 'basic',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'html_before_fields' => '<div class="shortcode_komitee-register">',
        'html_after_fields' => '</div>',
    ));
    
    $html = ob_get_contents(); 
    ob_end_clean();
    return $html;
}

/*---------------------------------------------------------------------------
update the post after saving
---------------------------------------------------------------------------*/

add_action('acf/save_post', 'update_komitee_post', 20);
function update_komitee_post($post_id){

    // only proceed if the post type is komitee
    $post_type = get_post_type($post_id);
    if ($post_type != 'komitee') {
        return;
    }

    $flag = get_post_meta($post_id, 'my_flag_field', true);
    if ($flag == 'already done') {
      // this is not a new post
      return;
    }
    // set flag
    update_post_meta($post_id, 'my_flag_field', 'already done');

    /*--------------------------------------------
    Update Komitee post meta
    --------------------------------------------*/

    // Get the data from a field
    $general_info = get_field('allgemeine_angaben', $post_id);
    $new_title = $general_info['first_name'] . ' ' . $general_info['last_name'];

    // Set the post data
    $new_post = array(
        'ID'           => $post_id,
        'post_title'   => $new_title,
    );

    // Remove the hook to avoid infinite loop. Please make sure that it has
    // the same priority (20)
    remove_action('acf/save_post', 'update_komitee_post', 20);

    // Update the post
    wp_update_post( $new_post );
    
    if (!is_admin()) {
        wp_set_post_terms( $post_id, 3, 'komitee_category' );
    }

    // Add the hook back
    add_action('acf/save_post', 'update_komitee_post', 20);

    /*---------------------------------------------------------------------------
    Send Notification Email to admin
    ---------------------------------------------------------------------------*/

    $optionsEmails = get_field('options_emails', 'option');

    if ($optionsEmails['send_email_new_comitee_member'] == true) {
            
        // Get Info
        $post_title = get_the_title( $post_id );
        $post_url = get_the_permalink( $post_id );
        // $post_edit_link = get_edit_post_link($post_id);
        $post_edit_link = get_site_url() . '/wp-admin/post.php?post=' . $post_id . '&action=edit'; // custom edit link

        $general_info = get_field('allgemeine_angaben', $post_id);
        $full_name = $general_info['first_name'] . ' ' . $general_info['last_name'];
        
        // Email Settings
        if ( $optionsEmails['receiver_new_comitee_member'] ) {
            $to = $optionsEmails['receiver_new_comitee_member'];
        } else {
            $to = get_option('admin_email');
        }
        $headers = array('Content-Type: text/html; charset=UTF-8', 'From: ' . get_bloginfo( 'name' ) . ' <admin@gratis-studium-nein.ch>');//make it HTML
        $subject = __('Neue Komitee-Anmeldung');

        // Message
        $body = "<h1>Neue Komitee-Anmeldung </h1>
                <p>Anfrage von: </p>
                <h3>{$general_info['anrede']} {$full_name}</h3>
                </br>
                <p>Die Anfrage muss nun überprüft und freigegeben werden: </p>
                <b><a href='{$post_edit_link}'>Anfrage jetzt prüfen</a></b>
                " ;

        // Send email to admin.
        wp_mail( $to, $subject, $body, $headers );

    }
  
}

// // set default type
// add_filter('acf/load_field/key=field_66880b8f3b07a', 'set_tax_default');
// function set_tax_default($field) {
// 	$field['default_value'] = 3;
// 	return $field;
// }

/*---------------------------------------------------------------------------
Send Notification Email to admin
---------------------------------------------------------------------------*/

// // Send email to admin
// add_action( 'acf/save_post', 'komitee_send_admin_email', 10, 3 );
// function komitee_send_admin_email( $post_id ){

//     // only proceed if the post type is komitee
//     $post_type = get_post_type($post_id);
//     if ($post_type != 'komitee') {
//     return;
//     }

//     $flag = get_post_meta($post_id, 'my_flag_field', true);
//     if ($flag == 'already done') {
//       // this is not a new post
//       return;
//     }
//     // set flag
//     update_post_meta($post_id, 'my_flag_field', 'already done');


//     // Get Info
//     $post_title = get_the_title( $post_id );
//     $post_url = get_the_permalink( $post_id );
//     // $post_edit_link = get_edit_post_link($post_id);
//     $post_edit_link = get_site_url() . '/wp-admin/post.php?post=' . $post_id . '&action=edit'; // custom edit link

//     $general_info = get_field('allgemeine_angaben', $post_id);
//     $full_name = $general_info['first_name'] . ' ' . $general_info['last_name'];
    
//     // Email Settings
//     // $to = get_option('admin_email');
//     $to = 'stipendienreferendum@gmail.com';
//     $headers = array('Content-Type: text/html; charset=UTF-8', 'From: ' . get_bloginfo( 'name' ) . ' <admin@gratis-studium-nein.ch>');//make it HTML
// 	$subject = __('Neue Komitee-Anmeldung');

//     // Message
//     $body = "<h1>Neue Komitee-Anmeldung </h1>
//             <p>Anfrage von: </p>
//             <h3>{$general_info['anrede']} {$full_name}</h3>
//             </br>
//             <p>Die Anfrage muss nun überprüft und freigegeben werden: </p>
//             <b><a href='{$post_edit_link}'>Anfrage jetzt prüfen</a></b>
//             " ;

// 	// Send email to admin.
// 	wp_mail( $to, $subject, $body, $headers );

// }