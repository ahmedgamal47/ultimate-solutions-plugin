<?php
// Make sure we don't expose any info if called directly
if (!function_exists('add_action')) {
    exit;
}

//**************************************************/
// create custom post type function
//**************************************************/

function create_custom_posttype()
{

    register_post_type(
        'custom',
        array(
            'labels' => array(
                'name' => __('Employers'),
                'singular_name' => __('Employer')
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => false,
            'show_in_rest' => true,
            'rest_controller_class' => 'Custom_Controller_Class',
            'supports' => array('title')

        )
    );
}
add_action('init', 'create_custom_posttype');


//**************************************************/
// create custom metabox function
//**************************************************/


function add_custom_meta_box()
{
    add_meta_box(
        'custom_info',
        __('Custom Information', 'textdomain'),
        'custom_metabox_callback',
        'custom',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_custom_meta_box');


//**************************************************/
// custom metabox callback function (display)
//**************************************************/


function custom_metabox_callback($post)
{
    $employerNumber = get_post_meta($post->ID, 'employerNumber', true);
    $employerName = get_post_meta($post->ID, 'employerName', true);
    $employerDate = get_post_meta($post->ID, 'employerDate', true);
    $employerSalary = get_post_meta($post->ID, 'employerSalary', true);
    
?>
    <label for="employerNumber">Employer Number:</label>
    <input type="number" name="employerNumber" class="regular-text large-text" value="<?php echo $employerNumber ?>">
    <br>

    <label for="employerName">Employer Name:</label>
    <input type="text" name="employerName" class="regular-text large-text" value="<?php echo $employerName ?>">
    <br>

    <label for="employerDate">Hire Date:</label>
    <input type="text" id="datepicker" name="employerDate" class="regular-text large-text" value="<?php echo $employerDate ?>">
    <br>

    <label for="employerSalary">Salary:</label>
    <input type="text" name="employerSalary" class="regular-text large-text" value="<?php echo $employerSalary ?>">
    <br>

<?php
wp_nonce_field( 'save_custom_info', 'custom_info_nonce' );
}


//**************************************************/
// custom metabox save function
//**************************************************/

function custom_save_meta_box( $post_id ) {
    if(!empty($_POST['post_title'])){
        if ( ! isset( $_POST['custom_info_nonce'] )
            || ! wp_verify_nonce( $_POST['custom_info_nonce'], 'save_custom_info' )
        ) {
            print 'Sorry, you can\'t access this page.';
            exit;
        }

        update_post_meta($post_id, 'employerNumber', $_POST['employerNumber']);
        update_post_meta($post_id, 'employerName', $_POST['employerName']);
        update_post_meta($post_id, 'employerDate', $_POST['employerDate']);
        update_post_meta($post_id, 'employerSalary', $_POST['employerSalary']);
    }
}
add_action( 'save_post_custom', 'custom_save_meta_box');