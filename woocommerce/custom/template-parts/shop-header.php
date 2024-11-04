<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */


use RT\ShopBuilderWP\Helpers\Fns;

if (is_shop()){
	$content_columns = Fns::content_columns();
}elseif (is_singular('product')){
	$content_columns = Fns::product_single_columns();
}else{
	$content_columns = Fns::content_columns();
}

?>


<div id="primary" class="section content-area customize-content-selector">
	<div class="container">
		<div class="row align-stretch">
			<div class="<?php echo esc_attr( $content_columns ); ?>">
				<main id="main" class="site-main page-content-main">
