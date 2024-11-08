<?php
/**
 * Elementor rsgallery Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */

use Elementor\Group_Control_Css_Filter;
use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Utils;

defined( 'ABSPATH' ) || die();

class Rsaddon_Elementor_pro_Course_Category_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve rsgallery widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'rs-course-category';
	}		

	/**
	 * Get widget title.
	 *
	 * Retrieve rsgallery widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'RS Course Category', 'rsaddon' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve rsgallery widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'glyph-icon flaticon-network';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the rsgallery widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
        return [ 'rsaddon_category' ];
    }

	/**
	 * Register rsgallery widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {
	
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'rsaddon' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);		

		$this->add_control(
            'cat_grid_style',
            [
				'label'   => esc_html__( 'Select Style', 'rsaddon' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'style1',				
				'options' => [
					'style1' => 'Style 1',
					'style2' => 'Style 2',							
					'style3' => 'Style 3',							
					'style4' => 'Style 4',							
					'style5' => 'Style 5',							
				],											
			]
        );       

		$this->add_control(
			'cat',
			[
				'label'   => esc_html__( 'Category', 'rsaddon' ),
				'type'    => Controls_Manager::SELECT2,						
				'options' => $this->course_category(),
				'multiple' => true,	
				'separator' => 'before',					
			]
		);	

		$this->add_control(
		    'esc_show_hide',
		    [
		        'label' => esc_html__( 'Show Description', 'prelements' ),
		        'type' => Controls_Manager::SWITCHER,
		        'default' => 'yes',
		        'options' => [
		            'label_on' => esc_html__( 'Show', 'prelements' ),
		            'label_off' => esc_html__( 'Hide', 'prelements' ),
		        ], 
		        'condition' => [
		            'cat_grid_style' => 'style3'
		        ],               
		    ]
		); 

		$this->add_control(
		    'count_show_hide',
		    [
		        'label' => esc_html__( 'Show Count', 'prelements' ),
		        'type' => Controls_Manager::SWITCHER,
		        'default' => 'yes',
		        'options' => [
		            'label_on' => esc_html__( 'Show', 'prelements' ),
		            'label_off' => esc_html__( 'Hide', 'prelements' ),
		        ],
		        'condition' => [
		            'cat_grid_style' => 'style3'
		        ],                
		    ]
		);

		$this->add_control(
		    'cate_bg_color',
		    [
		        'label' => esc_html__( 'Background Color', 'rsaddon' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .rs-cate-slider .categories-items .cate-images' => 'background-color: {{VALUE}};',
		        ],
		        'condition' => [
		            'cat_grid_style' => 'style3'
		        ],
		    ]
		); 		

		$this->add_responsive_control(
            'align_cate',
            [
                'label' => esc_html__( 'Alignment', 'rsaddon' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'rsaddon' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'rsaddon' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'rsaddon' ),
                        'icon' => 'fa fa-align-right',
                    ],
                    'justify' => [
                        'title' => esc_html__( 'Justify', 'rsaddon' ),
                        'icon' => 'fa fa-align-justify',
                    ],
                ],
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .rs-cate-slider .categories-items .cate-images .contents' => 'text-align: {{VALUE}}'
                ],
                'condition' => [
		            'cat_grid_style' => 'style3'
		        ],
            ]
        );

        $this->end_controls_section(); 



        $this->start_controls_section(
		    '_section_style_button',
		    [
		        'label' => esc_html__( 'Courses Category', 'rsaddon' ),
		        'tab' => Controls_Manager::TAB_STYLE,
		    ]
		);

		$this->add_control(
		    'hover_img',
		    [
		        'label' => esc_html__( 'Hover Image Show / Hide', 'rsaddon' ),
		        'type' => Controls_Manager::SELECT,
		        'default' => 'yes',
		        'options' => [
		            'yes' => esc_html__( 'Yes', 'rsaddon' ),
		            'no' => esc_html__( 'No', 'rsaddon' ),
		        ], 
		        'condition' => [
                    'cat_grid_style' => ['style2'],
                ],               
		        'separator' => 'before',
		    ]
		);


		$this->add_control(
            'icon_image',
            [
                'label' => esc_html__( 'Choose Hover Image', 'rsaddon' ),
                'type'  => Controls_Manager::MEDIA,  
                'condition' => [
                    'hover_img' =>[ 'yes' ], 'cat_grid_style' => ['style2'],
                ],
                'separator' => 'before',
            ]
        );  

		$this->start_controls_tabs( '_tabs_button' );

		$this->start_controls_tab(
            'style_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'rsaddon' ),
            ]
        ); 

		$this->add_control(
		    'title_color',
		    [
		        'label' => esc_html__( 'Category Title Color', 'rsaddon' ),
		        'type' => Controls_Manager::COLOR,		      
		        'selectors' => [
		            '{{WRAPPER}} .react-courses-categories .categories-item .content-part .courses-title' => 'color: {{VALUE}};',
		            '{{WRAPPER}} .react-courses-categories .categories-item2 .title a' => 'color: {{VALUE}};',
		            '{{WRAPPER}} .rs-cate-slider.cate-slider-style4 .categories-items .cate-images .contents h3 a' => 'color: {{VALUE}};',
		            '{{WRAPPER}} .rs-cate-slider.cate-slider-style5 .categories-items .cate-images .contents h3 a' => 'color: {{VALUE}};',
		            '{{WRAPPER}} .rs-cate-slider .categories-items .cate-images .contents h3 a' => 'color: {{VALUE}};',
		        ],
		    ]
		); 

		$this->add_control(
		    'cat_color',
		    [
		        'label' => esc_html__( 'Category Count Color', 'rsaddon' ),
		        'type' => Controls_Manager::COLOR,		      
		        'selectors' => [
		            '{{WRAPPER}} .react-courses-categories .categories-item .content-part .courses' => 'color: {{VALUE}};',
		            '{{WRAPPER}} .react-courses-categories .categories-item2 .course-qnty' => 'color: {{VALUE}};',
		            '{{WRAPPER}} .rs-cate-slider.cate-slider-style4 .categories-items .cate-images .contents span' => 'color: {{VALUE}};',
		            '{{WRAPPER}} .rs-cate-slider.cate-slider-style5 .categories-items .cate-images .contents span' => 'color: {{VALUE}};',
		            '{{WRAPPER}} .rs-cate-slider .categories-items .cate-images .contents span' => 'color: {{VALUE}};',
		        ],
		    ]
		);


		$this->add_control(
		    'icon_colors',			
		    [
				
				'label' => esc_html__( 'Icon Background Color', 'rsaddon' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
                    'cat_grid_style' => ['style1'],
                ], 
				'selectors' => ['{{WRAPPER}} .react-courses-categories .categories-item .icon-part' => 'background: {{VALUE}};',],
			]
		);

		$this->add_control(
		    'bg_colors',			
		    [
				
				'label' => esc_html__( 'Course Background Color', 'rsaddon' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
                    'cat_grid_style' => ['style1'],
                ], 
				'selectors' => ['{{WRAPPER}} .react-courses-categories .categories-item' => 'background: {{VALUE}};',],
			]
		);

		$this->add_control(
		    'border_colors',			
		    [
				
				'label' => esc_html__( 'Border Color', 'rsaddon' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
                    'cat_grid_style' => ['style1'],
                ], 
				'selectors' => ['{{WRAPPER}} .react-courses-categories .categories-item' => 'border-color: {{VALUE}};',],
			]
		);

		$this->add_responsive_control(
		    'course_padding',
		    [
		        'label' => esc_html__( 'Padding', 'rsaddon' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .react-courses-categories .categories-item2' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		            '{{WRAPPER}} .rs-cate-slider .categories-items .cate-images .contents' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);


        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => esc_html__( 'Title Typography', 'rsaddon' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .react-courses-categories .title, {{WRAPPER}} .react-courses-categories .categories-item .content-part .courses-title, {{WRAPPER}} .rs-cate-slider.cate-slider-style4 .categories-items .cate-images .contents h3, {{WRAPPER}} .rs-cate-slider.cate-slider-style5 .categories-items .cate-images .contents h3, {{WRAPPER}} .rs-cate-slider .categories-items .cate-images .contents h3',
			]
		);

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'count_typography',
				'label' => esc_html__( 'Count Typography', 'rsaddon' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .react-courses-categories .course-qnty, {{WRAPPER}} .react-courses-categories .courses, {{WRAPPER}} .rs-cate-slider .categories-items .cate-images .contents span, {{WRAPPER}} .rs-cate-slider.cate-slider-style4 .categories-items .cate-images .contents span, {{WRAPPER}} .rs-cate-slider.cate-slider-style5 .categories-items .cate-images .contents span',
			]
		);

		$this->add_responsive_control(
		    'image_size',
		    [
		        'label' => esc_html__( 'Image Size', 'rsaddon' ),
		        'type' => Controls_Manager::SLIDER,
		        'size_units' => [ 'px' ],
		        'range' => [
		            'px' => [
		                'min' => 10,
		                'max' => 300,
		            ],
		        ],
		        'condition' => [
		            'cat_grid_style' => ['style4', 'style5'],
		        ],
		        'selectors' => [
		            '{{WRAPPER}} .rs-cate-slider.cate-slider-style4 .categories-items .cate-images .contents img' => 'width: {{SIZE}}{{UNIT}} !important;',
		            '{{WRAPPER}} .rs-cate-slider.cate-slider-style5 .categories-items .cate-images .contents img' => 'width: {{SIZE}}{{UNIT}} !important;',
		        ],
		    ]
		);

		$this->add_control(
		    'd_overlay_color',
		    [
		        'label' => esc_html__( 'Background Overlay Color', 'rsaddon' ),
		        'type' => Controls_Manager::COLOR,
		        'condition' => [
		            'cat_grid_style' => ['style4'],
		        ],
		        'selectors' => [
		            '{{WRAPPER}} .rs-cate-slider.cate-slider-style4 .categories-items .cate-images::before' => 'background-color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'background',
				'label' => __( 'Background', 'plugin-domain' ),
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .rs-cate-slider.cate-slider-style5 .categories-items .cate-images:before',
				'condition' => [
				    'cat_grid_style' => ['style5'],
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
            'style_hover_tab',
            [
                'label' => esc_html__( 'Hover', 'rsaddon' ),
            ]
        ); 

		$this->add_control(
		    'hover_title_color',
		    [
		        'label' => esc_html__( 'Category Title Color', 'rsaddon' ),
		        'type' => Controls_Manager::COLOR,		      
		        'selectors' => [
		            '{{WRAPPER}} .react-courses-categories .categories-item:hover .content-part .courses-title' => 'color: {{VALUE}};',
		            '{{WRAPPER}} .react-courses-categories .categories-item2 .title a:hover' => 'color: {{VALUE}};',
		            '{{WRAPPER}} .rs-cate-slider.cate-slider-style4 .categories-items .cate-images .contents h3 a:hover' => 'color: {{VALUE}};',
		            '{{WRAPPER}} .rs-cate-slider.cate-slider-style5 .categories-items .cate-images .contents h3 a:hover' => 'color: {{VALUE}};',
		            '{{WRAPPER}} .rs-cate-slider .categories-items .cate-images .contents h3 a:hover' => 'color: {{VALUE}};',
		        ],
		    ]
		); 

		$this->add_control(
		    'hover_cat_color',
		    [
		        'label' => esc_html__( 'Category Count Color', 'rsaddon' ),
		        'type' => Controls_Manager::COLOR,		      
		        'selectors' => [
		            '{{WRAPPER}} .react-courses-categories .categories-item:hover' => 'color: {{VALUE}};',
		            '{{WRAPPER}} .react-courses-categories .categories-item2 .course-qnty:hover' => 'color: {{VALUE}};',
		            '{{WRAPPER}} .rs-cate-slider.cate-slider-style4 .categories-items .cate-images .contents span:hover' => 'color: {{VALUE}};',
		            '{{WRAPPER}} .rs-cate-slider.cate-slider-style5 .categories-items .cate-images .contents span:hover' => 'color: {{VALUE}};',
		            '{{WRAPPER}} .rs-cate-slider .categories-items .cate-images .contents span:hover' => 'color: {{VALUE}};',
		        ],
		    ]
		);


		$this->add_control(
		    'hover_icon_colors',			
		    [
				
				'label' => esc_html__( 'Icon Background Color', 'rsaddon' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
                    'cat_grid_style' => ['style1'],
                ], 
				'selectors' => ['{{WRAPPER}} .react-courses-categories .categories-item:hover .icon-part' => 'background: {{VALUE}};',],
			]
		);

		$this->add_control(
		    'hover_bg_colors',			
		    [
				
				'label' => esc_html__( 'Course Background Color', 'rsaddon' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
                    'cat_grid_style' => ['style1'],
                ], 
				'selectors' => ['{{WRAPPER}} .react-courses-categories .categories-item:hover' => 'background: {{VALUE}};',],
			]
		);

		

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();    
	}

	/**
	 * Render rsgallery widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() { 

		$settings = $this->get_settings_for_display(); ?>
		<div id="react-courses-categories" class="react-courses-categories">	
			<div class="row">
			<?php

				if('style1' == $settings['cat_grid_style']){
					$taxonomy = 'course_category';
					$cat = $settings['cat'];
			    	$taxonomy       = 'course_category';
				   
			    	if(!empty($cat)) :
						foreach ($cat as $catid) {
							$term       = get_term_by('slug', $catid, 'course_category');							
							$icon       = get_term_meta($term->term_id, 'category_icon', true);
							$icon_color = get_term_meta($term->term_id, 'course_color', true);
							$icon_cat   = (!empty($icon)) ? '<img src="'.$icon.'" alt="">' : '';
							$icon_color = !empty($icon_color) ? 'style="background:'.$icon_color.'"' : "#fff9c5";						
							$term_link  = get_term_link($term->slug, $taxonomy);						
							$term_name  =  $term->name;
							$get_link   = get_template_directory_uri();

							$args = array(
							   'post_type' => 'lp_course',
							   'tax_query' => array(
							        array(
							          'taxonomy' => 'course_category',
							          'field' => 'slug',
							          'terms' => $catid,
							        )
							    )
							);

							$obj_name = new WP_Query($args);

							$n = $obj_name->post_count; 

							if(!empty($icon_cat)) :
									        	
				            echo '<div class="col-lg-4 col-md-6">
				            	<a class="categories-item" href="'.$term_link.'">
	                                    <div class="icon-part">
	                                        '.$icon_cat.'
	                                    </div>
	                                    <div class="content-part">
	                                        <h4 class="courses-title">'.$term_name.'</h4> '?>
	                                       <span class="courses"><?php
		            	            			$n = str_pad($n, 2, '0', STR_PAD_LEFT); 
		            	            		
	                                    printf( _nx( '%s Course', '%s Courses', $n, 'Courses', 'rsaddon' ),  $n );
	                                    ?> </span>   
	                                    </div>
	                                </a>
				        	</div>			        	
					    <?php endif;} 
					 endif			;
				    }	


			    if('style2' == $settings['cat_grid_style']){ 
				$taxonomy = 'course_category';
			    $cat = $settings['cat'];
			    if(!empty($cat)){
						$cat      = $settings['cat'];	
						$catstyle  = 1;
					}
					else{
						$args_cat = array(
				            'taxonomy'     => $taxonomy,
				            'number' => 6,
				            'hide_empty' => true,
				        
				        );
						$cat = get_categories($args_cat);	
						$catstyle  = 2;			
						
					}			   
					if(!empty($cat)) :

					foreach ($cat as $catid) {
						if($catstyle == 2) :
							$term       = get_term_by('slug', $catid->slug, 'course_category');
						else :
							$term       = get_term_by('slug', $catid, 'course_category');	
						endif;	
					$icon2      = get_term_meta($term->term_id, 'category_img', true);
					$icon_color = get_term_meta($term->term_id, 'course_color', true);
					$icon_cat2  = (!empty($icon2)) ? '<img src="'.$icon2.'" alt="">' : '';
					$icon_color = !empty($icon_color) ? 'style="background:'.$icon_color.'"' : "#fff9c5";
					
				
					$term_link  = get_term_link($term->slug, $taxonomy);						
					$term_name  =  $term->name;
					$get_link   = get_template_directory_uri();	

					$args = array(
					   'post_type' => 'lp_course',
					   'tax_query' => array(
					        array(
					          'taxonomy' => 'course_category',
					          'field' => 'slug',
					          'terms' => $catid,
					        )
					    )
					);

					$obj_name = new WP_Query($args);

					$n = $obj_name->post_count; 									

						$hover_img_url= "";

                            if(!empty($settings['icon_image']['url'])){
                                $hover_img_url         = ($settings['icon_image']['url']);
                            }			
			            ?>
			            <div class="col-lg-4 col-md-6">
			            	<div class="categories-item2" <?php echo $icon_color;?>>			            		
                                <?php echo $icon_cat2; ?>
                                 <h4 class="title"><a href="<?php echo $term_link; ?>"><?php echo 	$term_name;?></a></h4>  
                               <span class="course-qnty"><?php
	            	            			$n = str_pad($n, 2, '0', STR_PAD_LEFT); 
	            	            		
                                    printf( _nx( '%s Course', '%s Courses', $n, 'Courses', 'rsaddon' ),  $n );
                                    ?> </span>                               

                                <?php if(($settings['hover_img'] == 'yes') ){ 
                                	if(!empty($settings['icon_image']['url'])){ ?>
                                		<img class="hover-img" src="<?php echo esc_url($hover_img_url);?>" alt=" " /> 
	                                <?php } else { ?>
	                                	<img class="hover-img" src="<?php echo esc_url($get_link);?>/assets/images/hover_dot.png" alt=" " /> 
	                                <?php } ?>
                             	<?php } ?>                            	
                            </div>
			        	</div>
					<?php } endif;

			      }
			

			    if('style3' == $settings['cat_grid_style']){ 

			    $cat = $settings['cat'];
			    $taxonomy = 'course_category';				    	
			    if(!empty($cat)) :
				foreach ($cat as $catid) {
					$term = get_term_by('slug', $catid, 'course_category');	


					$icon2 = get_term_meta($term->term_id, 'category_illustration_img', true);					

					
					$icon_cat2 = (!empty($icon2)) ? '<img src="'.$icon2.'" alt="">' : '';


					$icon_color = get_term_meta($term->term_id, 'course_color', true);
					$icon_color = !empty($icon_color) ? 'style="background:'.$icon_color.'"' : "#fff9c5";

					$term_link = get_term_link($term->slug, $taxonomy);						
					$term_name =  $term->name;
					$get_link  = get_template_directory_uri();

					

					$args = array(
					   'post_type' => 'lp_course',
					   'tax_query' => array(
					        array(
					          'taxonomy' => 'course_category',
					          'field' => 'slug',
					          'terms' => $catid,
					        )
					    )
					);

					$obj_name = new WP_Query($args);

					$n = $obj_name->post_count; 


						$hover_img_url= "";

                            if(!empty($settings['icon_image']['url'])){
                                $hover_img_url         = ($settings['icon_image']['url']);
                            }			
			        ?>
		            	<div class="rs-cate-slider col-lg-4 col-md-6">
			            	<div class="categories-items">
			                    <div class="cate-images">			                    	
			                    	<?php echo $icon_cat2; ?> 
			                    	<div class="contents">

			                    		<h3 class="title"><a href="<?php echo $term_link; ?>"><?php echo $term_name;?></a></h3>
			                    		<?php if ( 'yes' === $settings['esc_show_hide'] ){ ?>
			                    			<div class="des-text"><?php echo category_description( $term->term_id ); ?></div> 
			                    		<?php } ?>               	
			                    	<?php if ( 'yes' === $settings['count_show_hide'] ){ ?>
			                    	<span class="course-qnty"><?php
	            	            		$n = str_pad($n, 2, '0', STR_PAD_LEFT); 
	            	            		
                                    printf( _nx( '%s Course', '%s Courses', $n, 'Courses', 'rsaddon' ),  $n );
                                    ?> </span>
                                	<?php } ?>
			                    </div>
			               		</div>              
			                </div>
		                </div>
					<?php } endif;

			      
			    }

			    if('style4' == $settings['cat_grid_style']){ 

			    	$cat = $settings['cat'];
			    	$taxonomy = 'course_category';
			    	
					if(!empty($cat)) :				

					foreach ($cat as $catid) {
					$term       = get_term_by('slug', $catid, 'course_category');	
					$icon       = get_term_meta($term->term_id, 'category_icon', true);
					$icon_cat   = (!empty($icon)) ? '<img src="'.$icon.'" alt="">' : '';
					$icon2      = get_term_meta($term->term_id, 'category_illustration_img', true);
					$icon_color = get_term_meta($term->term_id, 'course_color', true);
					$icon_cat2  = (!empty($icon2)) ? '<img src="'.$icon2.'" alt="">' : '';
					$icon_color = !empty($icon_color) ? 'style="background:'.$icon_color.'"' : "#fff9c5";

				
					$term_link = get_term_link($term->slug, $taxonomy);						
					$term_name =  $term->name;
					$get_link  = get_template_directory_uri();

					$args = array(
						   'post_type' => 'lp_course',
						   'tax_query' => array(
						        array(
						          'taxonomy' => 'course_category',
						          'field' => 'slug',
						          'terms' => $catid,
						        )
						    )
						);

						$obj_name = new WP_Query($args);

						$n = $obj_name->post_count; 

					$hover_img_url= "";

                    if(!empty($settings['icon_image']['url'])){
                        $hover_img_url         = ($settings['icon_image']['url']);
                    }			
			        ?>
			            <div class="rs-cate-slider cate-slider-style4 col-lg-4 col-md-6">		            	    
	            	    	<div class="categories-items">
	            	            <div class="cate-images">                	
	            	            	<?php echo $icon_cat2; ?> 
	            	            	<div class="contents">
	            	            		<?php echo $icon_cat; ?> 
	            	            		<h3 class="title">
	            	            			<a href="<?php echo $term_link; ?>"><?php echo $term_name; ?></a>
	            	            		</h3>  
	            	            		
	            	            		<span class="course-qnty"><?php
	            	            			$n = str_pad($n, 2, '0', STR_PAD_LEFT); 
	            	            		
                                    printf( _nx( '%s Course', '%s Courses', $n, 'Courses', 'rsaddon' ),  $n );
                                    ?> </span>
	            	            		<div class="vies-more"><a href="<?php echo $term_link; ?>"><?php echo esc_html__('View More', 'rsaddon'); ?> </a></div>
	            	            	</div>
	            	       		</div>              
	            	        </div>		            		
			        	</div>
					<?php }
					endif;
			     
			    }

			    if('style5' == $settings['cat_grid_style']){ 

					$cat      = $settings['cat'];
					$taxonomy = 'course_category';
					if(!empty($cat)){
						$cat      = $settings['cat'];	
						$catstyle  = 1;
					}
					else{
						$args_cat = array(
				            'taxonomy'     => $taxonomy,
				            'number' => 6,
				            'hide_empty' => true,
				        
				        );
						$cat = get_categories($args_cat);	
						$catstyle  = 2;			
						
					}			   
					if(!empty($cat)) :

					foreach ($cat as $catid) {
						if($catstyle == 2) :
							$term       = get_term_by('slug', $catid->slug, 'course_category');
						else :
							$term       = get_term_by('slug', $catid, 'course_category');	
						endif;					

						$icon       = get_term_meta($term->term_id, 'category_icon', true);
						$icon_cat   = (!empty($icon)) ? '<img src="'.$icon.'" alt="">' : '';
						$icon2      = get_term_meta($term->term_id, 'category_illustration_img', true);
						$icon_color = get_term_meta($term->term_id, 'course_color', true);
						$icon_cat2  = (!empty($icon2)) ? '<img src="'.$icon2.'" alt="">' : '';
						$icon_color = !empty($icon_color) ? 'style="background:'.$icon_color.'"' : "#fff9c5";						
						$term_link = get_term_link($term->slug, $taxonomy);						
						$term_name =  $term->name;
						
						$get_link  = get_template_directory_uri();
						$args = array(
						   'post_type' => 'lp_course',
						   'tax_query' => array(
						        array(
						          'taxonomy' => 'course_category',
						          'field' => 'slug',
						          'terms' => $catid,
						        )
						    )
						);

						$obj_name = new WP_Query($args);

						$n = $obj_name->post_count; 
			
			            ?>
			            <div class="rs-cate-slider cate-slider-style5 col-lg-4 col-md-6">		            	    
	            	    	<div class="categories-items">
	            	            <div class="cate-images">    
	            	            <a href="<?php echo $term_link; ?>"><div class="overlays"> </div></a>           	
	            	            	<a href="<?php echo $term_link; ?>"><?php echo $icon_cat2; ?></a> 
	            	            	<div class="contents">
	            	            		<div><?php echo $icon_cat; ?></div> 
	            	            		<div>
	            	            			<h3 class="title">
	            	            				<a href="<?php echo $term_link; ?>"><?php echo $term_name;?></a>
	            	            			</h3>  
	            	            			<span class="course-qnty"><?php
	            	            			$n = str_pad($n, 2, '0', STR_PAD_LEFT); 
	            	            		
                                    printf( _nx( '%s Course', '%s Courses', $n, 'Courses', 'rsaddon' ),  $n );
                                    ?> </span>
	            	            			
	            	            		</div>	            	            		
	            	            	</div>
	            	       		</div>              
	            	        </div>            		
			        	</div>
					<?php } endif;

			      }
			    ?>
			    	
		   </div>
		</div>
		
	<?php	

	}

	public function course_category(){
	if(!defined('LP_COURSE_CPT')){
      return [];
	}
	
	$tax_terms = get_terms('course_category', array('hide_empty' => false));	
	$category_list = [];	 
	foreach($tax_terms as $term_single) {      
		$category_list[$term_single->slug] = [$term_single->name];	 
	}  
	return $category_list;
  }
}?>