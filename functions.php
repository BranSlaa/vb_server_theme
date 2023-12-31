<?php

class Blog {
	const VB = '1';
	const NYNY = '9';
	const CHI = '11';
	const LDN = '12';
	const MIA = '13';
	const SANFRAN = '14';
	const MTL = '15';
	const LA = '16';
	const SERVER = '17';
}

add_action('save_post_vbrands-products', 'vb_sync_products', 10, 3);
function vb_sync_products($post_id, $post, $update) {
	$title = get_field('title_of_design', $post_id);
	$my_post = array(
		'ID' => $post_id,
		'post_title' => $title,
	);
	wp_update_post($my_post);

	$artwork = get_field('artwork', $post_id);
	$artist = get_field('art_artist', $artwork);
	$artist_id = get_user_by('ID', $artist);
	update_field('art_artist', $artist_id, $post_id);
	if (get_field('stop_sync', $post_id)) {
		// TODO Handle Stop Sync
	} else {
		if (get_field('status') === 'Approved' || get_field('status') === 'Synced') {
			if (get_field('sync', $post_id) && get_field('ready', $post_id)) {

				// TODO Update VB Product On Save
				/**
				 * Images
				 * Printful API
				 * Sku
				 */
				update_field('art_artist', $artist_id, $post_id);

				$color_vb = get_field('color-vb', $post_id);
				$printful_product = get_field('printful_product', $post_id);

				$city_select = get_field('city_select_product', $post_id);
				$simple_color = get_field('simple_color', $post_id);
				$type = get_field('type', $printful_product);
				$gender = get_field('gender', $post_id);

				var_dump($color_vb);
				var_dump($printful_product);
				var_dump($artwork);
				var_dump($city_select);
				var_dump($artist);
				var_dump($simple_color);
				var_dump($type);
				var_dump($gender);

				// Get Products from visitbrands main site
				switch_to_blog(BLOG::VB);
				$vb_prod_args = array(
					"post_type" => "product",
					"post_status" => ["publish", "pending", "draft", "auto-draft", "future", "private", "inherit"],
					"meta_key" => "product_origin_id",
					"meta_value" => $post_id,
				);

				$vb_products = get_posts($vb_prod_args);

				foreach ($vb_products as $key => $value) {
				}
				restore_current_blog();
				if (get_field('sync_images', 'global_options_page')) {
				}
			}
		}
	}

	// die(print_r($_POST));
}
