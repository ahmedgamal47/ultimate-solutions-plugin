<?php

//**************************************************/
// custom rest api controller class
//**************************************************/

class Custom_Controller_Class extends WP_REST_Controller
{
    public function __construct()
    {
        add_action('rest_api_init', array($this, 'register_routes'));
    }

    //register_routes
    public function register_routes()
    {
        $namespace = 'api';
        $base = 'employer';
        // /wp-json/api/employer
        
        register_rest_route(
            $namespace,
            '/' . $base,
            array(
                array(
                    'methods'  => 'GET',
                    'callback' => array($this, 'get_items'),
                ),
            )
        );
    }

    //get_items
    public function get_items($request)
    {
        $args = array(
            'post_type' => 'custom',
            'post_per_page' => -1,
        );
        $posts = get_posts($args);

        $data = array();

        if (empty($posts)) {
            return rest_ensure_response($data);
        }

        foreach ($posts as $post) {
            $response = $this->prepare_item_for_response($post, $request);
            $data[] = $this->prepare_item_for_response($post, $request);
        }

        return rest_ensure_response($data);
    }

    // customize response to desire
    public function prepare_item_for_response($post, $request)
    {
        $post_data = array();

        //$post_data['id'] = (int) $post->ID;
        $post_data['employerNumber'] = get_post_meta($post->ID, 'employerNumber', true);
        $post_data['employerName'] = get_post_meta($post->ID, 'employerName', true);
        $post_data['employerDate'] = get_post_meta($post->ID, 'employerDate', true);
        $post_data['employerSalary'] = get_post_meta($post->ID, 'employerSalary', true);


        return $post_data;
    }
}