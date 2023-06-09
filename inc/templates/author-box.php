<?php
/**
 * Template part: HTML that will be served at front-end to display author block.
 *
 * @package one-author
 * @author Janak Patel <pateljanak830@gmail.com>
 */

$author_data = fetch_the_data( get_the_author_meta( 'ID' ) );
if ( $author_data ) {
	$author_avatar = wp_get_attachment_url( $author_data->author_display_img );
	if ( ! $author_avatar ) {
		$author_avatar = plugin_dir_url( ONE_AUTHOR_PATH ) . 'one-author\\assets\\build\\img\\author_def.jpg';
	}

	/**
	 * Local function to derive style class for particular social media platform.
	 *
	 * @param string $handle : Name of platform for which class name is returned.
	 * @return string class name corresponds to the given platform.
	 */
	function fetch_class( $handle ) {
		switch ( $handle ) {
			case 'Facebook':
				return 'fb';
			case 'Twitter':
				return 'twtr';
			case 'Instagram':
				return 'instagram';
			case 'Pinterest':
				return 'pinterest';
			case 'LinkedIn':
				return 'linkedin';
			case 'Skype':
				return 'skype';
			case 'YouTube':
				return 'youtube';
			case 'WordPress':
				return 'tumblr';
			case 'Flickr':
				return 'flickr';
			case 'RSS':
				return 'rss';
			case 'Google Plus':
				return 'youtube';
			case 'Tumblr':
				return 'tumblr';
			case 'E-mail':
				return 'gmail';
			case 'Buffer':
				return 'gmail';
			case 'Reddit':
				return 'rss';
			case 'Stumble Upon':
				return 'youtube';
		}
	}

	?>
	<div class="about_author">
		<div class="author_desc">
			<img src="<?php echo esc_url( $author_avatar ); ?>" alt="about author" height="80px" width="80px">
			<ul class="author_social">
				<?php
				foreach ( $author_data->author_social_media as $srno => $arr ) {
					$class  = fetch_class( $arr['handle'] );
					$url    = $arr['url'];
					$title_ = ucfirst( $arr['handle'] );
					$icon   = 'E-mail' === $arr['handle'] ? 'envelope' : strtolower( str_replace( ' ', '', $arr['handle'] ) );
					?>
						<li style="margin: 0 3px">
							<a class="<?php echo esc_attr( $class ); ?>" href="<?php echo esc_url( $url ); ?>" data-placement="top" data-toggle="tooltip" title="<?php echo esc_attr( $arr['handle'] ); ?>">
								<i class="fa fa-<?php echo esc_attr( $icon ); ?>"></i>
							</a>
						</li>
					<?php
				}
				?>
			</ul>
		</div>
		<div class="author_bio">
			<h3 class="author_name"><a href="<?php echo esc_url( get_author_posts_url( $author_data->author_id ) ); ?>"><?php echo esc_html( $author_data->author_display_name ); ?></a></h3>
			<h5><?php echo esc_html( $author_data->author_punch_line ); ?></h5>
			<p class="author_det" style="overflow-x: hidden; overflow-y: scroll; height: 60px">
			<?php echo esc_html( $author_data->author_about ); ?>
			</p>
		</div>
	</div>
	<?php
}
