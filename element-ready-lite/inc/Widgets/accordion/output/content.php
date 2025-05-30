<?php

// Add render attributes for the accordion container
$this->add_render_attribute('element__ready__adv__accordion', 'class', 'element__ready__adv__accordion');
$this->add_render_attribute('element__ready__adv__accordion', 'id', 'element__ready__adv__accordion-' . esc_attr($this->get_id()));

?>
<div <?php echo wp_kses_post($this->get_render_attribute_string('element__ready__adv__accordion')); ?>
    data-accordion-id="<?php echo esc_attr(sanitize_text_field($this->get_id())); ?>"
    data-accordion-type="<?php echo esc_attr(!empty($settings['element_ready_accordion_type']) ? sanitize_text_field($settings['element_ready_accordion_type']) : 'accordion'); ?>"
    data-toggle-speed="<?php echo esc_attr(!empty($settings['element_ready_accordion_toggle_speed']) ? sanitize_text_field($settings['element_ready_accordion_toggle_speed']) : '300'); ?>">


    <?php

    // Loop through accordion tabs
    foreach ($settings['element_ready_adv_accordion_tab'] as $index => $tab) :

        $tab_count               = $index + 1;
        $tab_title_setting_key   = $this->get_repeater_setting_key('element_ready_adv_accordion_tab_title', 'element_ready_adv_accordion_tab', $index);
        $tab_content_setting_key = $this->get_repeater_setting_key('element_ready_adv_accordion_tab_content', 'element_ready_adv_accordion_tab', $index);

        $tab_title_class         = ['elementor-tab-title', 'element__ready__accordion__header'];
        $tab_content_class       = ['element__ready__accordion__content', 'clearfix'];

        // Check if the tab should be active by default
        if ($tab['element_ready_adv_accordion_tab_default_active'] == 'yes') {
            $tab_title_class[]   = 'active-default';
            $tab_content_class[] = 'active-default';
        }

        // Add render attributes for tab titles and content
        $this->add_render_attribute($tab_title_setting_key, [
            'id'            => 'elementor-tab-title-' . $id_int . $tab_count,
            'class'         => $tab_title_class,
            'tabindex'      => $id_int . $tab_count,
            'data-tab'      => $tab_count,
        ]);

        $this->add_render_attribute($tab_content_setting_key, [
            'id'              => 'elementor-tab-content-' . $id_int . $tab_count,
            'class'           => $tab_content_class,
            'data-tab'        => $tab_count,
        ]);

    ?>
        <div class="element__ready__accordion__list">

            <div <?php echo wp_kses_post($this->get_render_attribute_string($tab_title_setting_key)); ?>>
                <span class="element__ready__accordion__title__icon">
                    <?php if ($tab['element_ready_accordion_show_tab_icon'] === 'yes') : ?>
                        <i class="<?php echo esc_attr($tab['element_ready_accordion_tab_title_icon']); ?> element__ready__accordion__icon"></i>
                    <?php endif; ?>
                    <?php echo wp_kses_post($tab['element_ready_adv_accordion_tab_title']); ?>
                </span>
                <?php if ($settings['element_ready_accordion_show_icon'] === 'yes') : ?>
                    <i class="<?php echo esc_attr($settings['element_ready_adv_accordion_toggle_icon']); ?> toggle__icon"></i>
                <?php endif; ?>
            </div>

            <div <?php echo wp_kses_post($this->get_render_attribute_string($tab_content_setting_key)); ?>>
                <?php if ('content' === $tab['element_ready_accordion_text_type']) : ?>
                    <div><?php echo do_shortcode(wp_kses_post($tab['element_ready_adv_accordion_tab_content'])); ?></div>
                <?php elseif ('template' === $tab['element_ready_accordion_text_type']) : ?>
                    <?php
                    if (!empty($tab['element_ready_primary_templates'])) {
                        $element_ready_template_id = $tab['element_ready_primary_templates'];

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
                                echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display($element_ready_template_id, true);
                            }
                        }
                    }
                    ?>
                <?php endif; ?>
            </div>

        </div>
    <?php endforeach; ?>
</div>