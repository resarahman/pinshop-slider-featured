<?php
/**
 * Carousel to display products
 * @since 1.0.0
 */
$prefix = 'setting-product_slider_2_';
if('' == themify_get($prefix.'enabled') || 'on' == themify_get($prefix.'enabled')):
	
	$args = array(
		'post_type' => 'product',
		'posts_per_page' => -1
	);
	if( '0' == themify_get($prefix.'posts_category') || !themify_get($prefix.'posts_category') ){
		$args['meta_query'] = array(
			array(
				'key' => '_featured',
				'value' => 'yes',
			)
		);
	} elseif(themify_get($prefix.'posts_category') && '0' != themify_get($prefix.'posts_category') ){
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'product_cat',
				'field' => 'id',
				'terms' => array( themify_get($prefix.'posts_category') )
			)
		);	
	}
	$loop = new WP_Query( $args );
	?>
	
	<?php if ($loop->have_posts()) : ?>

	<h2><?php _e('Featured 2', 'themify') ?></h2>
	
	<div id="product-slider-2" class="product-sliderwrap">
		<div class="product-slider-inner pagewidth">
		
			<div class="product-slider clearfix">
	
				<ul class="product-slides">
					
	       	<?php while ($loop->have_posts()) : $loop->the_post(); ?>
	       				
					<li>
						<div class="product product-<?php the_ID(); ?>">
							<div class="product-imagewrap">
							    <?php
							    if(class_exists('WC_Product_Factory')){
							    	$wcpc = new WC_Product_Factory();
									$_product = $wcpc->get_product( $loop->post->ID );
							    } else {
							    	$_product = &new WC_Product( $loop->post->ID );
							    }
								woocommerce_show_product_sale_flash( $post, $_product ); ?>
								
								<figure class="product-image">
                                	<?php themify_product_slider_image_start(); //hook ?>
									<a href="<?php the_permalink(); ?>">
										<?php if (has_post_thumbnail($loop->post->ID)): ?>
												<?php echo get_the_post_thumbnail( $loop->post->ID, 'shop_catalog' ); ?>
										<?php else: ?>
											<img src="http://placehold.it/200x160">
										<?php endif; ?>
									</a><span class="loading-product"></span>
                                    <?php themify_product_slider_image_end(); //hook ?>
								</figure>
								
							</div>
							<?php if(themify_get($prefix.'hide_title') != 'yes'): ?>
							<h3 class="product-title">
                            	 <?php themify_product_slider_title_start(); //hook ?>
							    <a href="<?php the_permalink(); ?>">
									<?php the_title(); ?>
							    </a>
                                 <?php themify_product_slider_title_end(); //hook ?>
							</h3>
							<?php endif; ?>
							
							<?php if(themify_get($prefix.'hide_price') != 'yes'): ?>
								<p class="price">
									<?php themify_product_slider_price_start(); //hook ?>
									<?php echo $_product->get_price_html(); ?>
									<?php themify_product_slider_price_end(); //hook ?>
								</p>
							<?php endif; ?>
                            
                            <?php themify_product_slider_add_to_cart_before(); //hook  ?>
							<?php woocommerce_template_loop_add_to_cart( $loop->post, $_product ); ?>
                            <?php themify_product_slider_add_to_cart_after(); //hook  ?>
                            
							<?php edit_post_link( __( 'Edit', 'themify' ), '[', ']'); ?>
						</div>
					</li>
					
					<?php endwhile; ?>
	        
				</ul>
			
			</div>
			<!-- /product slider -->
	
		</div>
		<!-- /.product-slider-inner -->
	</div>
	<!-- /.product-sliderwrap -->		
	<?php endif; // have posts ?>


<?php endif; ?>