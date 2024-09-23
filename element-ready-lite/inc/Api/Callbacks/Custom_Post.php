<?php 

namespace Element_Ready\Api\Callbacks;

abstract Class Custom_Post{

    public function init( $type, $singular_label, $plural_label, $settings = array() ){
        $default_settings = array(
            'labels' => array(
                'name'               => $plural_label,
                'singular_name'      => $singular_label,
                /* translators: %s: singular label */
                'add_new_item'       => sprintf( esc_html__( 'Add New %s', 'element-ready-lite' ), $singular_label ),
                /* translators: %s: singular label */
                'edit_item'          => sprintf( esc_html__( 'Edit %s', 'element-ready-lite' ), $singular_label ),
                /* translators: %s: singular label */
                'new_item'           => sprintf( esc_html__( 'New %s', 'element-ready-lite' ), $singular_label ),
                /* translators: %s: singular label */
                'view_item'          => sprintf( esc_html__( 'View %s', 'element-ready-lite' ), $singular_label ),
                /* translators: %s: plural label */
                'search_items'       => sprintf( esc_html__( 'Search %s', 'element-ready-lite' ), $plural_label ),
                 /* translators: %s: plural label */
                'not_found'          => sprintf( esc_html__( 'No %s found', 'element-ready-lite' ), $plural_label ),
                /* translators: %s: plural label */
                'not_found_in_trash' => sprintf( esc_html__( 'No %s found in trash', 'element-ready-lite' ), $plural_label ),
                /* translators: %s: plural label */
                'parent_item_colon'  => sprintf( esc_html__( 'Parent %s', 'element-ready-lite' ), $singular_label ),
                'menu_name'          => $plural_label
            ),
            'public'        => true,
            'has_archive'   => true,
            'menu_icon'     => '',
            'menu_position' => 20,
            'supports'      => array(
                'title',
                'editor',
                'thumbnail'
            ),
            'rewrite' => array(
                'slug' => sanitize_title_with_dashes( $plural_label )
            )
        );
    
        $this->posts[$type] = array_merge( $default_settings, $settings );
    }
    

    public function register_custom_post(){

        foreach($this->posts as $key => $value) {
            register_post_type($key, $value);
            flush_rewrite_rules( false );
        }

    }
}
