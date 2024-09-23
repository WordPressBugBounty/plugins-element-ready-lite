<?php 

namespace Element_Ready\Api\Callbacks;

abstract Class Custom_Taxonomy {
    public $taxonomies = [];
    public function init( $type, $singular_label, $plural_label, $post_types, $settings = array() ){
        $default_settings = array(
            'labels' => array(
                'name'                  => $plural_label,
                'singular_name'         => $singular_label,
                /* translators: %s: singular label */
                'add_new_item'          => sprintf( esc_html__( 'New %s Name', 'element-ready-lite' ), $singular_label ),
                /* translators: %s: singular label */
                'new_item_name'         => sprintf( esc_html__( 'Add New %s', 'element-ready-lite' ), $singular_label ),
                /* translators: %s: singular label */
                'edit_item'             => sprintf( esc_html__( 'Edit %s', 'element-ready-lite' ), $singular_label ),
                /* translators: %s: singular label */
                'update_item'           => sprintf( esc_html__( 'Update %s', 'element-ready-lite' ), $singular_label ),
                /* translators: %s: plural label */
                'add_or_remove_items'   => sprintf( esc_html__( 'Add or remove %s', 'element-ready-lite' ), strtolower( $plural_label ) ),
                /* translators: %s: plural label */
                'search_items'          => sprintf( esc_html__( 'Search %s', 'element-ready-lite' ), $plural_label ),
                /* translators: %s: plural label */
                'popular_items'         => sprintf( esc_html__( 'Popular %s', 'element-ready-lite' ), $plural_label ),
                /* translators: %s: plural label */
                'all_items'             => sprintf( esc_html__( 'All %s', 'element-ready-lite' ), $plural_label ),
                /* translators: %s: singular label */
                'parent_item'           => sprintf( esc_html__( 'Parent %s', 'element-ready-lite' ), $singular_label ),
                /* translators: %s: plural label */
                'choose_from_most_used' => sprintf( esc_html__( 'Choose from the most used %s', 'element-ready-lite' ), strtolower( $plural_label ) ),
                 /* translators: %s: singular label */
                'parent_item_colon'     => sprintf( esc_html__( 'Parent %s', 'element-ready-lite' ), $singular_label ),
                'menu_name'             => $singular_label
            ),
            'public'            => true,
            'show_in_nav_menus' => true,
            'show_admin_column' => false,
            'hierarchical'      => true,
            'show_tagcloud'     => false,
            'show_ui'           => true,
            'rewrite'           => array(
                'slug' => sanitize_title_with_dashes( $plural_label )
            )
        );
    
        $this->taxonomies[$type]['post_types'] = $post_types;
        $this->taxonomies[$type]['args']       = array_merge( $default_settings, $settings );
    }
    

    public function register_taxonomy(){

        foreach($this->taxonomies as $key => $value) {
            register_taxonomy($key, $value['post_types'], $value['args']);
        }

    }
}

