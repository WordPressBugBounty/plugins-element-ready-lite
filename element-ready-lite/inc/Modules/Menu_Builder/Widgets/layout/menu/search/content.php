   <!--====== SEARCH PART START ======-->
   <div class="element-ready-search-box">
       <div class="element-ready-search-header">
           <h5 class="search-title">
               <?php if ($settings['header_search_logo']['url'] != ''): ?>
                   <img src="<?php echo esc_url($settings['header_search_logo']['url']); ?>"
                       alt="<?php echo esc_attr__('logo', 'element-ready-lite'); ?>">
               <?php endif; ?>
           </h5> <!-- search title -->
           <div class="search-close text-right">
               <button class="search-close-btn">
                   <?php if ($settings['header_search_text'] != ''): ?>
                       <?php echo esc_html($settings['header_search_text']); ?>
                   <?php endif; ?>
                   <span></span>
                   <span></span>
               </button>
           </div> <!-- search close -->
       </div> <!-- search header -->
       <div class="element-ready-search-body">
           <?php if ($settings['custom_search_templte'] != 'yes'): ?>
               <div class="element-ready-search-form">
                   <form method="get" action="<?php echo esc_url(home_url('/')) ?>">
                       <input type="search" value="<?php get_search_query(); ?>" name="s"
                           placeholder=" <?php echo esc_attr__('search here', 'element-ready-lite'); ?> ">
                       <button>
                           <?php \Elementor\Icons_Manager::render_icon($settings['header_search_icon'], ['aria-hidden' => 'true']); ?>
                       </button>
                   </form>
               </div>
           <?php else: ?>
               <?php

                if (!empty($settings['popup_search_template_id'])) {
                    $element_ready_template_id = $settings['popup_search_template_id'];

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
                    } else {
                        echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display($settings['popup_search_template_id']);
                    }
                }

                ?>
           <?php endif; ?>
       </div> <!-- search body -->
   </div>
   <!--====== SEARCH PART ENDS ======-->