<?php

/*
Plugin Name: Grid Pages Teaser
Plugin URI: 
Description: Pages With Grid view including Thumbnail
Version: 1.0
Author: Dominic Fernandes
Author URI: 
License: A GPL2
*/

add_shortcode( 'pteaser', 'page_teaser' );
add_action( 'wp_head', 'pteaser_css' );

function page_teaser($atts){

		extract( shortcode_atts( array(
		'parent'     => '',
		'id' 		 => '',
		'size' 		 => '',
		'num'	 => '',
		
		), $atts ) );


		if(empty($parent)){
			$child = '';	
		}else{
			if($parent <= 2){
				$child = (int)$parent;
			}
			else{
			$child = (int)explode(',', $parent);
			}
		}
		
		
		if(empty($id)){
			$uid = '';
		}else{
			if($id <= 2){
				$uid = (int)$id;
			}
			else{
			$uid = (int)explode(',', $id);
			}
		}
		

		
		$args = array(
			 'include' 	   => $uid,
			 'child_of'	   => $parent,
			 'number'     	   => $num,
			 'offset'          => 0,
			 'sort_order'	   => 'DESC',
			 'include'         => '',
			 'exclude'         => '',
			 'post_type'       => 'page',
			 'post_mime_type'  => '',
			 'post_status'     => 'publish'
			);
		 
		$lastposts = get_pages($args);


	  $html =	"<div class='teaser_wrapper'>";

		foreach($lastposts as $pages) : 
		
		$html .='<div class="img_thumb">';
		$html .= '<div class="details">';
		
		$medium_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($pages->ID), 'medium');
		
		$html .= '<a href="#"><img src="'. $medium_image_url[0] .'"  style="width:280px;height:195px;"></a>';
		$html .= '<h2 class="title_link"><a href="' .get_page_link( $pages->ID ) .'">' . $pages->post_title .'</a></h2>';
		$html .= '</div><div class="clear"></div></div>';
		
		endforeach;

$html .= '</div>'; 

	return $html; 

}

function pteaser_css()
{
?>
	<link rel="stylesheet" type="text/css" href="<?php echo plugins_url( 'css/style.css' , __FILE__ ); ?>" />
<?php
}
?>