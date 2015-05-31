<br/><br/>
<div id="Container" class="container">

	<?php
	while( $query->have_posts() ) {
		$p = $query->the_post();
		$post_terms = wp_get_post_terms( get_the_ID(), $this->post_taxonomy, array( 'fields' => 'slugs' ) );
		
		echo '<div class="mix ' . implode( ' ', $post_terms ) . '">';
		echo '<a href="' . esc_attr( get_post_meta( get_the_ID(), 'link_url', true ) ) . '">';
		
		if( 'publish' == get_post_status( get_the_ID() ) ) { echo '<strike>'; }
		the_title();
		if( 'publish' == get_post_status( get_the_ID() ) ) { echo '</strike>'; }
		echo '</a>';
		echo '</div>';
	}
	?>
</div>

<style>
#Container .mix{
	display: none;
}

#Container div {
	display: list-item;
}


</style>
<script type="text/javascript">
	jQuery(function(){
		jQuery('#Container').mixItUp({
			layout: {
				display: 'block'
			}
		});
	});
</script>
