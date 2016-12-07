<?php
/*
Plugin Name: Woocommerce Product Archive Page Title
Plugin URI: https://simplyweb.gr/
Description: Changes the title tag of the product taxonomy archive to display the full taxonomy tree
Version: 0.1
Author: Giorgos Tsarmpopoulos
Author URI: https://simplyweb.gr/
*/

/**
 * Copyright (c) `date "+%Y"` . All rights reserved.
 *
 * Released under the GPL license
 * http://www.opensource.org/licenses/gpl-license.php
 *
 * This is an add-on for WordPress
 * http://wordpress.org/
 *
 * **********************************************************************
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * **********************************************************************
 */

add_filter( 'wp_title', 'sw_product_archive_title', 1000 );

function sw_product_archive_title( $title ) {
 	if ( is_tax('product_cat')) {
		// error_log('in title filter');
		$tax = get_queried_object();
		// error_log(print_r($tax, true));
		$tax_title_arr = array();
		$sep = ' | ';
		if($tax->parent == 0) {
			$tax_title = $tax->name;
			return $tax_title . ' | ' . get_bloginfo( 'name' );
		}
		$tax_title_arr[] = $tax->name;
		do {
			$tax = get_term($tax->parent);
			$tax_title_arr[] = $tax->name;
			$parent = $tax->parent;
		} while ($parent > 0);
		$rev_title = array_reverse($tax_title_arr);
		$title_string = implode($sep, $rev_title);
		$tax_title = $title_string . ' | ' . get_bloginfo( 'name' );
		return $tax_title;
 	}
	return $title;
}
