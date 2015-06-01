<br/><br/>
<div id="Container" class="container">

	<?php
	while( $query->have_posts() ) {
		$p = $query->the_post();
		$post_terms = wp_get_post_terms( get_the_ID(), $this->post_taxonomy, array( 'fields' => 'slugs' ) );
		$link = get_post_meta( get_the_ID(), 'link_url', true );
	
		echo '<div class="mix ' . implode( ' ', $post_terms ) . '">';

		if( !empty( $link ) ) 
			echo '<a href="' . esc_attr( $link  ) . '">';
		
		if( 'publish' == get_post_status( get_the_ID() ) ) { echo '<strike>'; }
		the_title();
		if( 'publish' == get_post_status( get_the_ID() ) ) { 
			echo '</strike>'; 
		}
		
		if( !empty( $link ) )
			echo '</a>';

		if( 'publish' == get_post_status( get_the_ID() ) ) {
			echo ' - Thanks ' . get_post_meta( get_the_ID(), 'link_credit', true );
		}
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
