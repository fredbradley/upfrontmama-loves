<?php
	
namespace UpfrontMama\Loves;

use Vc_Grid_Item_Editor;
class VisualComposer {
	public function __construct() {
		add_filter( 'vc_gitem_add_link_param', array($this,'vc_gitem_add_link_param_upfrontmama') );
add_filter( 'vc_gitem_zone_image_block_link', array($this,'vc_gitem_zone_image_block_link_upfrontmama'), 10, 3 );
add_filter( 'vc_grid_item_shortcodes', array($this,'my_module_add_grid_shortcodes') );
add_shortcode( 'vc_say_hello', array($this,'vc_say_hello_render') );
add_filter( 'vc_gitem_template_attribute_ufm_loves_url', array($this,'vc_gitem_template_attribute_ufm_loves_url'), 10, 2 );
	}
	
	/**
	 * Append 'add to card' link to the list of Add link for grid element shortcodes.
	 *
	 * @param $param
	 *
	 * @since 4.5
	 *
	 * @return array
	 */
	function vc_gitem_add_link_param_upfrontmama( $param ) {
		$param['value'][ __( 'Upfront Mama Loves URL', 'js_composer' ) ] = 'upfrontmama_loves_style';
	
		return $param;
	}
	function vc_gitem_zone_image_block_link_upfrontmama( $image_block, $link, $css_class ) {
		global $post;
		if ( 'upfrontmama_loves_style' === $link ) {
			$css_class .= ' vc_gitem-link vc-zone-link';
	
			return '<a href="{{ufm_loves_url}}" class="' . esc_attr( $css_class ) . '" data-product_id="{{ woocommerce_product:id }}"' . ' data-product_sku="{{ woocommerce_product:sku }}" data-product-quantity="1"></a>';
		}
	
		return $image_block;
	}
	
	
	
	function my_module_add_grid_shortcodes( $shortcodes ) {
	   $shortcodes['vc_say_hello'] = array(
	     'name' => __( 'Say Hello', 'my-text-domain' ),
	     'base' => 'vc_say_hello',
	     'category' => __( 'Content', 'my-text-domain' ),
	     'description' => __( 'Just outputs Hello World', 'my-text-domain' ),
	     'post_type' => Vc_Grid_Item_Editor::postType(),
	  );
	   return $shortcodes;
	}
	 
	function vc_say_hello_render() {
	   return "<h2 class=\"entry-title\"><a href=\"{{ufm_loves_url}}\">{{ post_data:post_title }}</a></h2>";
	}
	
	function vc_gitem_template_attribute_ufm_loves_url( $value, $data ) {
	   /**
	    * @var Wp_Post $post
	    * @var string $data
	    */
	   extract( array_merge( array(
	      'post' => null,
	      'data' => ''
	   ), $data ) );
	 
	   // return a template for featured_image variable
	   return get_post_meta( $post->ID, 'ufm_loves_url', true );
	}
	
	
}






