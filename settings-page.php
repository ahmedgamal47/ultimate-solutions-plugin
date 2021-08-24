<?php

//**************************************************/
// create settings page function
//**************************************************/

function custom_add_settings_page()
{
    add_submenu_page('edit.php?post_type=custom', 'Settings Page', 'Settings Page', 'manage_options', 'settings-page-ag', 'settings_page_callback');
}
add_action('admin_menu', 'custom_add_settings_page');

//**************************************************/
// settings page callback function
//**************************************************/

function settings_page_callback()
{
?>
    <h1 class="wp-heading-inline">Settings Page</h1>
    <form action="<?php echo admin_url('admin-ajax.php') ?>" method="POST">
        <button class="button button-primary button-large">Sync Data</button>
        <input type="hidden" name="action" value="sync_data">
    </form>
<?php
}

//**************************************************/
// action ajax function
//**************************************************/

add_action('wp_ajax_sync_data', 'sync_data');
function sync_data()
{
    $response = wp_remote_get('https://ultimate-demos.com/task/wp-json/app/employers');
    $data = json_decode($response['body'])->employers;
    foreach ($data as $newPost) {
        $info = [
            'post_type' => 'custom',
            'post_status' => 'publish',
            'post_title' => $newPost->employerName,
            'meta_input' => [
                'employerNumber' => $newPost->employerNumber,
                'employerName' => $newPost->employerName,
                'employerDate' => $newPost->employerDate,
            ]
        ];

        $query_args = [
            'post_type' => 'custom',
            'meta_key'   => 'employerNumber',
            'meta_value' => $newPost->employerNumber
        ];
        $query = new WP_Query($query_args);
        if ($query->found_posts == 0) {
            wp_insert_post($info, false, false);
        }
    }

    wp_redirect('/wp-admin/edit.php?post_type=custom');
    exit;
}