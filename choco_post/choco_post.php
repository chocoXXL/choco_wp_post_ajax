<?php
/**
 * Plugin Name: Choco Posts w/Ajax, one day with Custom Meta Values and maybe pagination :D
 * Plugin URI: https://chocospace42.weebly.com/
 * Description: Test para los pedidos.
 * Version: 0.62
 * Author: Choco
 * Author URI: https://chocospace42.weebly.com/
 * License: GPLv2
 *
 * Copyright 2020  Choco
 * Free u know.
*/


/* CATEGORIES */
function osea_hello_cats() {

	?><div class="le-pedido-box-filter">
		<ul>
			<li class="cat-list-item"><a href="">All Categories</a></li><?php

				$cat_args = array (
					'exclude' => array(1),
					'option_all' => 'All',
					'posts_per_page' => 2, 
					'orderby' => 'date', 
					'order' => 'DESC',
				);

				$categories = get_categories( $cat_args );
				
				?> <?php
				foreach( $categories as $cat ) : ?>
					<li class="cat-list-item">
					<a data-category="<?= $cat->term_id; ?>" href="<?= get_category_link( $cat->term_id ); ?>"><?= $cat ->name; ?></a>
					</li>
				<?php	endforeach;	?>
		</ul>
	</div>
	
	<?php	
};

/* METAS VALUE */

function osea_hello_metas() {

	?><div class="le-pedido-box-metas-filter">
		<ul>
			<li class="metas-list-item"><a href="">All Metas</a></li><?php
				/*
				$cat_args = array (
					'exclude' => array(1),
					'option_all' => 'All'
				);*//*
				$metas = array('');
				$metas_args = array(
					'meta_query' => array(
						array(
							'key' => 'key_value',
							//'value' => array(1),
						)
					)
				);			
				//echo $metas_args;	
				foreach($metas_args as $metas){
					//echo $metas[0];
					echo $metas;
				}*/
				//$metas = get_post_custom_values( $metas_args );
				/*
				//$categories = get_categories( $cat_args );
				//$meta = get_post_meta( get_the_ID(), '', true );
				?> <?php
				foreach( $metas as $cat ) : ?>
					<li class="cat-list-item">
					<a data-category="<?= $cat->term_id; ?>" href="<?= get_category_link( $cat->term_id ); ?>"><?= $cat ->name; ?></a></li>
				<?php	endforeach;	*/
				?>
				<?php
				$jhf_values = array('');//AN EMPTY ARRAY TO STORE THE VALUES GATHERED
				$the_query = new WP_Query( 'post_type=post' );//CHANGE TO CUSTOM POST TYPE IF REQUIRED
				if ( $the_query->have_posts() ) {
					while ( $the_query->have_posts() ) {
						$the_query->the_post();
						
						$the_answer=get_post_meta($the_query->post->ID, 'key_value' , true);//'TRUE' WILL RETURN ONLY ONE VALUE FOR EACH POST.
						
						//$key_name1 = get_post_custom_values($key = 'precio'); echo $key_name1[0];
						//$the_answer= get_post_meta();
						//$the_answer= the_title(); 
						$the_answer=trim($the_answer);//REMOVE UNWANTED WHITESPACE FROM BEGINNING AND END 
						array_push($jhf_values, $the_answer);//ADD THE RESULT TO THE EMPTY ARRAY
					}
				}
				$jhf_values = array_unique($jhf_values);//NOW WEVE GOT ALL THE VALUES, WE CAN REMOVE DUPLICATES
				$jhf_values = sort($jhf_values);//AND WE CAN PUT THEM IN ORDER
				//NOW WE CAN RUN THROUGH THE ARRAY AND DO SOMETHING WITH EACH OBJECT...
				/////NOT WORKING T_T
				/////foreach ($jhf_values as $value) { 
				/////echo "<p>".$value."</p>";
				/////}
				
				wp_reset_postdata();
				?>
		</ul>
	</div>
	<?php

	/*$mykey_values = get_post_custom_values( 'my_key' );
 
	foreach ( $mykey_values as $key => $value ) {
		echo '<pre>';
		//$key => $value ( 'my_key' ); 
		$key_name1 = get_post_custom_values($key = 'precio'); echo $key_name1[0]; 
		echo '</pre>';
	}*/
	
};
/* POSTS */ 

function osea_hello_posts_2() {
	$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
	$args = array(
		'post_type'		 => 'post',
		'posts_per_page' => 2, 
        'paged'			 => $paged
	);
	?>	<div class="le-pedido-box-result"> <?php
	
	$query = new WP_Query( $args );

	if($query -> have_posts()) :
		while($query -> have_posts()) : $query -> the_post(); ?>
		<div class="le-pedido-box-o">
			
			<div class="le-pedido-title-box-o">
				<span class="le-pedido-title-span"><?php the_title(); ?></span> 
			</div>
		</div>
		<?php
		endwhile;
	endif;
	?> 
	</div>

	<div class="pagination">
		<?php 
			echo paginate_links( array(
				'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
				//'base' => @add_query_arg('paged1','%#%'),
				'total'        => $query->max_num_pages,
				//'current'      => max( 1, get_query_var( 'paged' ) ),
				'current'  => '?paged=%#%',
				'format'       => '?paged=%#%',
				'show_all'     => false,
				'type'         => 'plain',
				'end_size'     => 2,
				'mid_size'     => 1,
				'prev_next'    => false,
				//'prev_text'    => sprintf( '<i></i> %1$s', __( 'Newer Posts', 'text-domain' ) ),
				//'next_text'    => sprintf( '%1$s <i></i>', __( 'Older Posts', 'text-domain' ) ),
				'add_args'     => false,
				'add_fragment' => '',
			) );
		?>
	</div>
 	<?php	wp_reset_postdata();
};


/* ERA SRICPTS.PHP */
function load_scripts() {
	wp_register_style( 'namespace',  plugin_dir_url( __FILE__ ) . 'assets/css/swagg.css' );
    wp_enqueue_style( 'namespace' );
	wp_enqueue_script( 'ajax', plugin_dir_url( __FILE__ ) . 'assets/js/scripts.js', array('jquery'), NULL, true );
	wp_localize_script( 'ajax', 'wp_ajax', array( 'ajax_url'  => admin_url( 'admin-ajax.php' )) );
};
add_action( 'wp_enqueue_script', 'load_scripts' );


/* ERA EXAMPLE.PHP */
add_action( 'wp_ajax_nopriv_filter', 'filter_ajax' );
add_action( 'wp_ajax_filter', 'filter_ajax' );

function filter_ajax() {

	$category = $_POST['category'];

	$args = array(
			'post_type' => 'post',
			'posts_per_page' => -1
			);

	if(isset($category)) {
		$args['category__in'] = array($category);
	}
			$query = new WP_Query($args);

			if($query->have_posts()) :
				while($query->have_posts()) : $query->the_post();
					//the_title('<h2>', '</h2>');
					//the_content('<p>', '</p>');
					?>
					<div class="le-pedido-box-o">
				
						<div class="le-pedido-title-box-o">
							<span class="le-pedido-title-span-o"><?php the_title(); ?></span> 
						</div>
						
					</div>
					<?php
				endwhile;
			endif;
				wp_reset_postdata(); 
		die();
}

function osea_hello_inner_shortcode(  ) {	
	ob_start();
	osea_hello_metas();
	osea_hello_cats();
	osea_hello_posts_2();
	load_scripts();
	return ob_get_clean();
}
add_shortcode( 'choco_post_cards_o', 'osea_hello_inner_shortcode' );