<div class="off_canvars_overlay">
</div>
<div class="offcanvas_menu">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="offcanvas_menu_wrapper">
                    <div class="offcanvas_menu_wrapper-shell">
                        <div class="canvas_close">
                            <a href="javascript:void(0)"><i class="fa fa-times"></i></a>
                        </div>
                        <div class="bar_open_close">
                            <span>
                                <?php wp_kses_post(\Elementor\Icons_Manager::render_icon($settings['offcanvas_menu_icon'], ['aria-hidden' => 'true']));  ?>
                                <?php echo esc_html($settings['offcanvas_text'] ?? ''); ?>
                            </span>
                        </div>
                        <div class="element-ready-ele-template-content-wrapper">
                            <?php

                            if (!empty($settings['offcanvas_template_id'])) {
                                $element_ready_template_id = $settings['offcanvas_template_id'];

                                // Fetch template to verify its status
                                $template_post = get_post($element_ready_template_id);
                                if ($template_post) {
                                    $template_status = $template_post->post_status;
                                    $is_allowed = true;
                                    switch ($template_status) {
                                        case 'private':
                                            $is_allowed = current_user_can('read_private_posts');
                                            break;
                                        case 'draft':
                                        case 'pending':
                                            $is_allowed = current_user_can('administrator') || current_user_can('editor');
                                            break;
                                    }
                                    if ($is_allowed) {
                                        echo wp_kses_post(\Elementor\Plugin::instance()->frontend->get_builder_content_for_display($element_ready_template_id, true));
                                    }
                                } else {
                                    echo wp_kses_post(\Elementor\Plugin::instance()->frontend->get_builder_content_for_display($settings['offcanvas_template_id']));
                                }
                            }



                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>