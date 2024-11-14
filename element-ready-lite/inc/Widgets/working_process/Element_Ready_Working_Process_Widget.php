<?php

namespace Element_Ready\Widgets\working_process;

use Elementor\Widget_Base;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use \Elementor\Controls_Manager;


if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Element_Ready_Working_Process_Widget extends Widget_Base
{

    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);

        wp_register_style('er-working_process', ELEMENT_READY_ROOT_CSS . 'widgets/er-working-process.css');
        wp_register_script('er-working_process', ELEMENT_READY_ROOT_JS . 'widgets/er-working-process.js', ['jquery']);
    }


    public function get_name()
    {
        return 'er_working_process_widget';
    }

    public function get_title()
    {
        return __('ER Working Process', 'element-ready-lite');
    }

    public function get_icon()
    {
        return 'eicon-form-vertical';
    }

    public function get_categories()
    {
        return ['element-ready-addons'];
    }

    public function get_keywords()
    {
        return ['Working Process', 'services'];
    }


    public function get_script_depends()
    {


        return [
            'er-working_process',
        ];
    }
    public function get_style_depends()
    {


        return [
            'er-working_process',
        ];
    }


    protected function register_controls()
    {

        /*---------------------------
            CONTENT SECTION
        -----------------------------*/
        $this->start_controls_section(
            'my_section',
            [
                'label' => esc_html__('Working Process', 'element-ready-lite'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );




        $repeater = new Repeater();

        $repeater->add_control(
            'item_title',
            [
                'label' => esc_html__('Step Title', 'element-ready-lite'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'item_icon',
            [
                'label'     => esc_html__('SVG / Font Icons', 'element-ready-lite'),
                'type'      => Controls_Manager::ICONS,
                'separator'   => 'before',
                'default' => [
                    'value' => 'fas fa-star',
                    'library' => 'solid',
                ],
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'item_hover_icon',
            [
                'label'     => esc_html__('Hover SVG / Font Icons', 'element-ready-lite'),
                'type'      => Controls_Manager::ICONS,
                'separator'   => 'before',
                'default' => [
                    'value' => 'fas fa-star',
                    'library' => 'solid',
                ],
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'item_heading',
            [
                'label' => esc_html__('Heading', 'element-ready-lite'),
                'type' => Controls_Manager::TEXTAREA,
                'ai' => [
                    'type' => 'text',
                ],
                'dynamic' => [
                    'active' => true,
                ],
                'placeholder' => esc_html__('Enter your heading', 'element-ready-lite'),
                'default' => esc_html__('Add Your heading text here', 'element-ready-lite'),
            ]
        );

        $repeater->add_control(
            'item_link',
            [
                'label' => esc_html__('Link', 'element-ready-lite'),
                'type' => Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    'url' => '',
                ],
            ]
        );


        $this->add_control(
            'w_process_elements',
            [
                'label' => esc_html__('Elements', 'element-ready-lite'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'item_title' => esc_html__('Step 1', 'element-ready-lite'),
                    ],
                    [
                        'item_title' => esc_html__('Step 2', 'element-ready-lite'),
                    ],
                ],
                'title_field' => '{{{ item_title }}}',
            ]
        );


        $this->end_controls_section();


        /*---------------------------
        LINE PROGRESS BAR STYLE SECTION
        -----------------------------*/
        $this->start_controls_section(
            'line_pb_style_section',
            [
                'label' => esc_html__('Line Progress Bar', 'element-ready-lite'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'line_pb_height',
            [
                'label' => esc_html__('Height', 'element-ready-lite'),
                'type' => Controls_Manager::SLIDER,

                'selectors' => [
                    '{{WRAPPER}} .erwp-progress-bar, {{WRAPPER}} .erwp-progress-container:before' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'line_pb_postion',
            [
                'label' => esc_html__('Postion', 'element-ready-lite'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .erwp-progress-bar, {{WRAPPER}} .erwp-progress-container:before' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'line_pb_color',
            [
                'label'  => esc_html__('Bar Color', 'element-ready-lite'),
                'type'   => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .erwp-progress-container:before' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'line_pb_hover_color',
            [
                'label'  => esc_html__('Bar Hover Color', 'element-ready-lite'),
                'type'   => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .erwp-progress-bar' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();
        /*-------------------------------
        LINE PROGRESS BAR STYLE SECTION END
        ---------------------------------*/


        /*---------------------------
        EACH ITEM STYLE SECTION
        -----------------------------*/
        $this->start_controls_section(
            'each_style_section',
            [
                'label' => esc_html__('Each Item', 'element-ready-lite'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'icon_align',
            [
                'label'   => __('Alignment', 'element-ready-lite'),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'element-ready-lite'),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'element-ready-lite'),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'element-ready-lite'),
                        'icon'  => 'fa fa-align-right',
                    ],
                    'justify' => [
                        'title' => __('Justify', 'element-ready-lite'),
                        'icon'  => 'fa fa-align-justify',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .erwp-single-item' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'area_padding',
            [
                'type' => Controls_Manager::DIMENSIONS,
                'label' => esc_html__('Padding', 'element-ready-lite'),
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .erwp-single-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();
        /*-------------------------------
        EACH ITEM STYLE SECTION END
        ---------------------------------*/

        /*---------------------------
           STAP TITILE STYLE SECTION
        -----------------------------*/
        $this->start_controls_section(
            'step_style_section',
            [
                'label' => esc_html__('Step Title', 'element-ready-lite'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'  => esc_html__('Text Color', 'element-ready-lite'),
                'type'   => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .erwp-single-item span' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_hover_color',
            [
                'label'  => esc_html__('Text Hover Color', 'element-ready-lite'),
                'type'   => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .erwp-single-item:hover span' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_border_color',
            [
                'label'  => esc_html__('Border Color', 'element-ready-lite'),
                'type'   => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .erwp-single-item span' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_border__hover_color',
            [
                'label'  => esc_html__('Border Hover Color', 'element-ready-lite'),
                'type'   => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .erwp-single-item:hover span' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'typography_title',
                'selector' => '{{WRAPPER}} .erwp-single-item span',
            ]
        );
        $this->add_responsive_control(
            'title_padding',
            [
                'type' => Controls_Manager::DIMENSIONS,
                'label' => esc_html__('Padding', 'element-ready-lite'),
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .erwp-single-item span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


        $this->end_controls_section();
        /*------------------------------
           STAP TITILE STYLE SECTION END
        --------------------------------*/


        /*---------------------------
        SVG / FONT ICONS STYLE SECTION
        -----------------------------*/
        $this->start_controls_section(
            'icon_style_section',
            [
                'label' => esc_html__('SVG / Font Icons', 'element-ready-lite'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs(
            'icon_style_tabs'
        );

        // normel
        $this->start_controls_tab(
            'icon_style_tab',
            [
                'label' => esc_html__('Normal', 'element-ready-lite'),
            ]
        );
        $this->add_control(
            'icon_font_color',
            [
                'label'  => esc_html__('Font Color', 'element-ready-lite'),
                'type'   => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .erwp-single-item .erwp-icon i' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_svg_fill_color',
            [
                'label'  => esc_html__('SVG Fill Color', 'element-ready-lite'),
                'type'   => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .erwp-single-item .erwp-icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_svg_stroke_color',
            [
                'label'  => esc_html__('SVG Stroke Color', 'element-ready-lite'),
                'type'   => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .erwp-single-item .erwp-icon svg' => 'stroke: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'icon_background',
                'label' => esc_html__('Background', 'element-ready-lite'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .erwp-single-item .erwp-icon',
            ]
        );

        $this->end_controls_tab();

        // Hover
        $this->start_controls_tab(
            'icon_hover_style_tab',
            [
                'label' => esc_html__('Hover', 'element-ready-lite'),
            ]
        );
        $this->add_control(
            'icon_hover_font_color',
            [
                'label'  => esc_html__('Font Color', 'element-ready-lite'),
                'type'   => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .erwp-single-item:hover .erwp-icon i' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_hover_svg_fill_color',
            [
                'label'  => esc_html__('SVG Fill Color', 'element-ready-lite'),
                'type'   => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .erwp-single-item:hover .erwp-icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_hover_svg_stroke_color',
            [
                'label'  => esc_html__('SVG Stroke Color', 'element-ready-lite'),
                'type'   => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .erwp-single-item:hover .erwp-icon svg' => 'stroke: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'icon_hover_background',
                'label' => esc_html__('Background', 'element-ready-lite'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .erwp-single-item:hover .erwp-icon',
            ]
        );

        $this->end_controls_tab();

        // Active
        $this->start_controls_tab(
            'icon_active_style_tab',
            [
                'label' => esc_html__('Active', 'element-ready-lite'),
            ]
        );
        $this->add_control(
            'icon_active_font_color',
            [
                'label'  => esc_html__('Font Color', 'element-ready-lite'),
                'type'   => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .erwp-single-item:hover + .erwp-single-item .erwp-icon i' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_active_svg_fill_color',
            [
                'label'  => esc_html__('SVG Fill Color', 'element-ready-lite'),
                'type'   => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .erwp-single-item:hover + .erwp-single-item .erwp-icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_active_svg_stroke_color',
            [
                'label'  => esc_html__('SVG Stroke Color', 'element-ready-lite'),
                'type'   => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .erwp-single-item:hover + .erwp-single-item .erwp-icon svg' => 'stroke: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'icon_active_background',
                'label' => esc_html__('Background', 'element-ready-lite'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .erwp-single-item:hover + .erwp-single-item .erwp-icon',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();


        $this->add_control(
            'icon_others_heading',
            [
                'label'     => esc_html__('Other Style', 'element-ready-lite'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'icon_area_size',
            [
                'label' => esc_html__('Area Size', 'element-ready-lite'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                        'step' => 2,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .erwp-single-item .erwp-icon' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};;line-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__('Size / SVG Width', 'element-ready-lite'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                        'step' => 2,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .erwp-single-item .erwp-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .erwp-single-item .erwp-icon svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'icon_height_size',
            [
                'label' => esc_html__('Size / SVG Height', 'element-ready-lite'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                        'step' => 2,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .erwp-single-item .erwp-icon svg' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'icon_border_radius',
            [
                'type' => Controls_Manager::DIMENSIONS,
                'label' => esc_html__('Border Radius', 'element-ready-lite'),
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .erwp-single-item .erwp-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'icon_margin',
            [
                'type' => Controls_Manager::DIMENSIONS,
                'label' => esc_html__('Margin', 'element-ready-lite'),
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .erwp-single-item .erwp-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'icon_padding',
            [
                'type' => Controls_Manager::DIMENSIONS,
                'label' => esc_html__('Padding', 'element-ready-lite'),
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .erwp-single-item .erwp-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


        $this->end_controls_section();
        /*------------------------------
        SVG / FONT ICONS SECTION END
        --------------------------------*/


        /*---------------------------
           HEADING STYLE SECTION
        -----------------------------*/
        $this->start_controls_section(
            'step_heading_section',
            [
                'label' => esc_html__('Heading', 'element-ready-lite'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'heading_color',
            [
                'label'  => esc_html__('Text Color', 'element-ready-lite'),
                'type'   => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .erwp-single-item h2' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'heading_hover_color',
            [
                'label'  => esc_html__('Text Hover Color', 'element-ready-lite'),
                'type'   => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .erwp-single-item:hover h2' => 'color: {{VALUE}};',
                ],
            ]
        );


        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'typography_heading',
                'selector' => '{{WRAPPER}} .erwp-single-item h2',
            ]
        );
        $this->add_responsive_control(
            'heading_margin',
            [
                'type' => Controls_Manager::DIMENSIONS,
                'label' => esc_html__('Margin', 'element-ready-lite'),
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .erwp-single-item h2' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'heading_padding',
            [
                'type' => Controls_Manager::DIMENSIONS,
                'label' => esc_html__('Padding', 'element-ready-lite'),
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .erwp-single-item h2' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


        $this->end_controls_section();
        /*------------------------------
           STAP TITILE STYLE SECTION END
        --------------------------------*/
    }

    protected function render()
    {

        $settings = $this->get_settings_for_display();
        $w_process_elements = $settings['w_process_elements'] ?? [];

        if (!empty($w_process_elements)) :
?>
            <div class="erwp-progress-container">
                <div class="erwp-progress-bar"></div>
                <div class="erwp-elements">
                    <?php foreach ($w_process_elements as $element) :
                        $item_title = $element['item_title'] ?? '';
                        $item_icon = $element['item_icon'] ?? false;
                        $item_hover_icon = $element['item_hover_icon'] ?? false;
                        $item_heading = $element['item_heading'] ?? '';
                        $item_link = $element['item_link'] ?? '';
                        if (!empty($item_link['url'])) {
                            $this->add_render_attribute('item_link', 'href', esc_url($item_link['url']));

                            if ($item_link['is_external']) {
                                $this->add_render_attribute('item_link', 'target', '_blank');
                            }

                            if ($item_link['nofollow']) {
                                $this->add_render_attribute('item_link', 'rel', 'nofollow');
                            }
                        }
                    ?>
                        <div class="erwp-single-item">
                            <?php if (!empty($item_link['url'])) : ?>
                                <a <?php $this->print_render_attribute_string('item_link'); ?>>
                                <?php endif; ?>
                                <?php if (!empty($item_title)) : ?>
                                    <span><?php echo esc_html($item_title); ?></span>
                                <?php endif; ?>
                                <div class="clearfix"></div>
                                <?php if (!empty($item_icon)) : ?>
                                    <div class="erwp-icon <?php echo !empty($item_hover_icon) ? esc_attr('has_hover') : ''; ?>">
                                        <div class="erwp-icon-normal">
                                            <?php \Elementor\Icons_Manager::render_icon($item_icon, ['aria-hidden' => 'true']); ?></div>
                                        <div class="erwp-icon-hover">
                                            <?php \Elementor\Icons_Manager::render_icon($item_hover_icon, ['aria-hidden' => 'true']); ?></div>
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($item_heading)) : ?>
                                    <h2><?php echo esc_html($item_heading); ?></h2>
                                <?php endif; ?>
                                <?php if (!empty($item_link['url'])) : ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
<?php
        endif;
    }
}
