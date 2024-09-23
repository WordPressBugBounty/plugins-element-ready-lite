<?php

namespace Element_Ready\Modules\Menu_Builder\Base;

class Offcanvas_Nav_Walker extends \Walker_Nav_Menu
{
    /**
     * Starts the list before the elements are added.
     *
     * @see Walker::start_lvl()
     *
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     */
    public $elementor_settings = [
        'menu_list_item_cls'     => '',
        'before_menu_drop_icon'  => '',
        'menu_drop_icon'         => '',
        'submenu_indicator_icon' => '',
        'mega_menu_cls'          => '',
        'layout'                 => ''
    ];
    function __construct($settings = [])
    {

        if (is_array($settings)) {
            $this->elementor_settings = $settings;
        }
    }
    public function start_lvl(&$output, $depth = 0, $args = array())
    {
        $indent = str_repeat("\t", $depth);
        $sub_menu_cls = 'element-ready-dropdown element-ready-submenu-section ';
        $sub_menu_cls .= isset($this->elementor_settings['sub_menu_ul_cls']) ? $this->elementor_settings['sub_menu_ul_cls'] : '';
        $output .= "\n$indent<ul class=\" $sub_menu_cls\">\n";
    }
    /**
     * Ends the list of after the elements are added.
     *
     * @see Walker::end_lvl()
     *
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     */
    public function end_lvl(&$output, $depth = 0, $args = array())
    {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }
    /**
     * Start the element output.
     *
     * @see Walker::start_el()
     *
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item   Menu item data object.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     * @param int    $id     Current item ID.
     */
    public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = ' menu-item-' . $item->ID;
        $item_meta = $this->get_item_meta($item->ID);
        if ($depth === 0) {

            if ($item_meta['is_mega_menu'] == 'yes' && class_exists('Elementor\Plugin')) {
                $classes[] = 'element-ready-mega-menu-item';
            }

            if (isset($this->elementor_settings['first_li_menu_pointer']) && $this->elementor_settings['first_li_menu_pointer'] != '') {
                $classes[] = $this->elementor_settings['first_li_menu_pointer'];
            }
            if (isset($this->elementor_settings['first_li_menu_hover_pointer']) && $this->elementor_settings['first_li_menu_hover_pointer'] != '') {
                $classes[] = $this->elementor_settings['first_li_menu_hover_pointer'];
            }

            $is_mega_menu = get_post_meta($item->ID, 'element_ready_mega_menu_post_item_mega_menu_enable', true);
            if ($is_mega_menu == 'on' || $is_mega_menu == 'yes') {
                $classes[] = 'er-mega-menu-builder';
            }
        }
        /**
         * Filter the CSS class(es) applied to a menu item's list item element.
         *
         * @since 3.0.0
         * @since 4.1.0 The `$depth` parameter was added.
         *
         * @param array  $classes The CSS classes that are applied to the menu item's `<li>` element.
         * @param object $item    The current menu item.
         * @param array  $args    An array of {@see wp_nav_menu()} arguments.
         * @param int    $depth   Depth of menu item. Used for padding.
         */
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
        // New
        $class_names .= isset($this->elementor_settings['menu_list_item_cls']) ? ' ' . $this->elementor_settings['menu_list_item_cls'] : ' ';
        $class_names .= ' nav-item has-sub';

        if (in_array('menu-item-has-children', $classes)) {
            if ($depth == 0) {
                $class_names .= " dropdown";
            } else {
                $class_names .= " dropdown-submenu ";
            }
        }
        if (in_array('current-menu-item', $classes)) {
            $class_names .= ' active';
        }
        //
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';


        $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';

        $output .= $indent . '<li' . $id . $class_names . '>';
        $atts = array();
        $atts['title']  = !empty($item->attr_title) ? $item->attr_title : '';
        $atts['target'] = !empty($item->target)     ? $item->target     : '';
        $atts['rel']    = !empty($item->xfn)        ? $item->xfn        : '';
        $atts['href']   = !empty($item->url)        ? $item->url        : '';
        // New
        if ($depth === 0) {
            $atts['class'] = 'nav-link';
        }
        if ($depth === 0 && in_array('menu-item-has-children', $classes)) {
            $atts['class']       .= ' has-child dropdown__toggle';
            $atts['data-toggle']  = 'dropdown';
        }
        if ($depth > 0) {
            $manual_class = array_values($classes)[0] . ' ' . 'dropdown_items';
            $atts['class'] = $manual_class;
        }
        if (is_array($item->classes) && in_array('current-menu-item', $item->classes)) {
            $atts['class'] .= ' active';
        }
        // print_r($item);
        //
        /**
         * Filter the HTML attributes applied to a menu item's anchor element.
         *
         * @since 3.6.0
         * @since 4.1.0 The `$depth` parameter was added.
         *
         * @param array $atts {
         *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
         *
         *     @type string $title  Title attribute.
         *     @type string $target Target attribute.
         *     @type string $rel    The rel attribute.
         *     @type string $href   The href attribute.
         * }
         * @param object $item  The current menu item.
         * @param array  $args  An array of {@see wp_nav_menu()} arguments.
         * @param int    $depth Depth of menu item. Used for padding.
         */
        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);
        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }
        $item_output = !empty($args->before);
        // New
        /*
        if ($depth === 0 && in_array('menu-item-has-children', $classes)) {
            $item_output .= '<a class="nav-link dropdown-toggle"' . $attributes .'data-toggle="dropdown">';
        } elseif ($depth === 0) {
            $item_output .= '<a class="nav-link"' . $attributes .'>';
        } else {
            $item_output .= '<a class="dropdown-item"' . $attributes .'>';
        }
        */
        //
        $item_output .= '<a' . $attributes . '>';

        if ($depth === 0 && in_array('menu-item-has-children', $classes)) {

            if (isset($this->elementor_settings['before_menu_drop_icon']) && $this->elementor_settings['before_menu_drop_icon'] != '') {
                $class_b_icon = $this->elementor_settings['before_menu_drop_icon'];
                $item_output .= sprintf('<i class="%1$s element-ready-d-icon-before"></i>', $class_b_icon);
            }
        } elseif ($depth === 0 && isset($item_meta['is_mega_menu']) && $item_meta['is_mega_menu'] == 'yes') {

            if (isset($this->elementor_settings['before_menu_drop_icon']) && $this->elementor_settings['before_menu_drop_icon'] != '') {
                $class_b_icon = $this->elementor_settings['before_menu_drop_icon'];
                $item_output .= sprintf('<i class="%1$s element-ready-d-icon-before"></i>', $class_b_icon);
            }
        }


        if (isset($this->elementor_settings['layout']) && $this->elementor_settings['layout'] == 'style1') {
            $item_output .= '<span>';
        }
        /** This filter is documented in wp-includes/post-template.php */
        $item_output .= !empty($args->link_before) . apply_filters('the_title', $item->title, $item->ID) . !empty($args->link_after);
        if (isset($this->elementor_settings['layout']) && $this->elementor_settings['layout'] == 'style1') {
            $item_output .= '</span>';
        }
        if ($depth === 0 && in_array('menu-item-has-children', $classes)) {

            if (isset($this->elementor_settings['menu_drop_icon']) && $this->elementor_settings['menu_drop_icon'] != '') {
                $class_icon = $this->elementor_settings['menu_drop_icon'];
                $item_output .= sprintf('<i class="%1$s element-ready-d-icon-after"></i>', $class_icon);
            }
        } elseif ($depth === 0 && isset($item_meta['is_mega_menu']) && $item_meta['is_mega_menu'] == 'yes') {

            if (isset($this->elementor_settings['menu_drop_icon']) && $this->elementor_settings['menu_drop_icon'] != '') {
                $class_icon = $this->elementor_settings['menu_drop_icon'];
                $item_output .= sprintf('<i class="%1$s element-ready-d-icon-after"></i>', $class_icon);
            }
        }

        if ($depth > 0 && $args->walker->has_children == true) {

            if (isset($this->elementor_settings['submenu_indicator_icon']) && $this->elementor_settings['submenu_indicator_icon'] != '') {
                $class_b_icon = $this->elementor_settings['submenu_indicator_icon'];
                $item_output .= sprintf('<i class="%1$s element-ready-d-icon-before"></i>', $class_b_icon);
            }
        }

        // badge
        if (get_post_meta($item->ID, '_element_ready_menu_item_badge', true) != '') {

            $badge_color     = get_post_meta($item->ID, '_element_ready_menu_item_badge_color', true);

            $badge_bgcolor   = get_post_meta($item->ID, '_element_ready_menu_item_badge_bgcolor', true);
            if ($badge_bgcolor == '#000000') {
                $badge_bgcolor = '';
            }
            if ($badge_color == '#000000') {
                $badge_color = '';
            }
            $badge_bgcolor_s = '';
            $badge_color_s   = '';
            if ($badge_color != '') {
                $badge_color_s = "color:{$badge_color}";
            }
            if ($badge_bgcolor != '') {
                $badge_bgcolor_s = ";background-color:{$badge_bgcolor}";
            }
            $badge_style  = "style={$badge_color_s}{$badge_bgcolor_s}";
            $item_output .= sprintf(
                '<span class="badge badge-manu" %2$s> %1$s </span>',
                get_post_meta($item->ID, '_element_ready_menu_item_badge', true),
                $badge_style
            );
        }
        // end badge
        $item_output .= '</a>';

        $item_output .= !empty($args->after);
        /**
         * Filter a menu item's starting output.
         *
         * The menu item's starting output only includes `$args->before`, the opening `<a>`,
         * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
         * no filter for modifying the opening and closing `<li>` for a menu item.
         *
         * @since 3.0.0
         *
         * @param string $item_output The menu item's starting HTML output.
         * @param object $item        Menu item data object.
         * @param int    $depth       Depth of menu item. Used for padding.
         * @param array  $args        An array of {@see wp_nav_menu()} arguments.
         */
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
    /**
     * Ends the element output, if needed.
     *
     * @see Walker::end_el()
     *
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item   Page data object. Not used.
     * @param int    $depth  Depth of page. Not Used.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     */
    public function end_el(&$output, $item, $depth = 0, $args = array())
    {
        if ($depth === 0) {

            $output .= $this->element_content($item);
            $output .= "</li>\n";
        }
    }
    public function get_item_meta($item_id)
    {

        $is_mega_menu                     = get_post_meta($item_id, 'element_ready_mega_menu_post_item_mega_menu_enable', true);
        $is_off_canvas                    = get_post_meta($item_id, 'element_ready_mega_menu_post_item_mega_offcanvas_enable', true);
        $is_mobile_menu                   = get_post_meta($item_id, 'element_ready_mega_menu_post_item_mega_is_mobile_menu', true);
        $content_id                       = get_post_meta($item_id, 'element_ready_mega_menu_post_item_mega_content_id', true);
        $submenu_content_type             = get_post_meta($item_id, 'element_ready_mobile_submenu_content_type', true);
        $megamenu_width_type              = get_post_meta($item_id, 'element_ready_megamenu_width_type', true);
        $vertical_megamenu_position       = get_post_meta($item_id, 'element_ready_vertical_megamenu_position_type', true);


        $default = [

            "menu_id"                    => null,
            "is_mobile_mega_menu"        => $is_mobile_menu,
            "is_mega_menu"               => $is_mega_menu,
            "is_off_canvas"              => $is_off_canvas,
            "submenu_content_type"       => $submenu_content_type,
            "megamenu_width_type"        => $megamenu_width_type,
            "vertical_megamenu_position" => $vertical_megamenu_position,
            "content_id"                 => $content_id,

        ];

        return $default;
    }
    public function element_content($item)
    {

        $content = '';
        if ($this->elementor_settings['mega_menu_content'] == 'yes') {

            $item_meta = $this->get_item_meta($item->ID);

            if (($item_meta['is_mega_menu'] == 'on' || $item_meta['is_mega_menu'] == 'yes') && class_exists('Elementor\Plugin')) {

                $builder_post_title = 'dynamic-content-megamenu-menu-item' . $item->ID;
                $builder_post       = new \WP_Query(array(
                    'post_type' => 'element_ready_content',
                    'post_title' => $builder_post_title,
                    'post_status' => 'publish',
                    'posts_per_page' => 1,
                ));
                $mega_menu_cls      = 'mega-menu element-ready-megamenu-section ' . $this->elementor_settings['mega_menu_cls'];
                $content .= sprintf('<div class="%s">', $mega_menu_cls);
                if ($item_meta['content_id'] != '') {
                    $elementor = \Elementor\Plugin::instance();
                    $content .= $elementor->frontend->get_builder_content_for_display($item_meta['content_id']);
                } else {
                    $content .= esc_html__('No content found', 'element-ready-lite');
                }

                $content .= '</div>';
            } // end if

        } else {

            if ($this->elementor_settings['enable_meta_content'] == 'yes') {

                $content =  sprintf(' <div class="fsmenu--scrolling-text">
                        <span>%1$s</span><span>%1$s</span><span>%1$s</span><span>%1$s</span><span>%1$s</span>
                    </div>', $item->title);

                if (get_post_meta($item->ID, '_element_ready_menu_item_image', true) != '') {

                    $content .= sprintf('<div class="fsmenu--link-img">
                        <div class="fsmenu--img-container">
                            <img src="%1$s" alt="%2$s">
                        </div>
                    </div>', wp_get_attachment_url(get_post_meta($item->ID, '_element_ready_menu_item_image', true)), $item->title);
                }
            }
        }

        return $content;
    }
    /**
     * Menu Fallback
     * =============
     * If this function is assigned to the wp_nav_menu's fallback_cb variable
     * and a manu has not been assigned to the theme location in the WordPress
     * menu manager the function with display nothing to a non-logged in user,
     * and will add a link to the WordPress menu manager if logged in as an admin.
     *
     * @param array $args passed from the wp_nav_menu function.
     *
     */
    public static function fallback($args)
    {

        if (current_user_can('manage_options')) {
            extract($args);
            $fb_output = null;
            if ($container) {
                $fb_output = '<' . $container;
                if ($container_id) {
                    $fb_output .= ' id="' . $container_id . '"';
                }
                if ($container_class) {
                    $fb_output .= ' class="menu-fallback ' . $container_class . '"';
                }
                $fb_output .= '>';
            }
            $fb_output .= '<ul';
            if ($menu_id) {
                $fb_output .= ' id="' . $menu_id . '"';
            }
            if ($menu_class) {
                $fb_output .= ' class="' . $menu_class . '"';
            }
            $fb_output .= '>';
            $fb_output .= '<li><a href="' . esc_url(admin_url('nav-menus.php')) . '">Add a menu</a></li>';
            $fb_output .= '</ul>';
            if ($container) {
                $fb_output .= '</' . $container . '>';
            }
            echo wp_kses_post($fb_output);
        }
    }
}
