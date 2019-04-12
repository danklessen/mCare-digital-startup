<?php

$exito_posrtfolio_single_iframe = get_post_meta( $post->ID, 'exito_posrtfolio_single_iframe', true );
?>

		<div class="portfolio_video">
			<?php echo apply_filters("the_content", htmlspecialchars_decode( $exito_posrtfolio_single_iframe )) ?>
		</div>