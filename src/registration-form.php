<?php
/**
 * Template part: Author registration and modification form.
 *
 * @package One-Author
 * @author Janak Patel <pateljanak830@gmail.com>
 */

$one_authors = $this->all_users();
$auth_count  = count( $one_authors );
if ( empty( $one_authors ) ) {
	wp_die( esc_html( __( 'Something went wrong, contact developer', 'one-author' ) ) );
} else {
	if ( catch_the_data() ) {
		echo 'Data stored successfully';
	}
	$data  = fetch_the_data();
	$old   = true;
	$image = false;
	if ( false === $data ) {
		$old = false;
		// $image = fetch_the_image();
	}
?>
<ul id="alerts" class="hidden"></ul>
<form method="POST" action="" enctype="multipart/form-data" id="author-form">
	<div class="one-author-container">
		<div class="one-author-left-box">
			<div class="one-author-id">
				<?php
				if ( 1 === $auth_count ) {
					echo '<input required readonly type="text" name="one_auth_id" id="one_auth_id" placeholder="Your ID" value="' . esc_attr__( 'User Id: ', 'one-author' ) . esc_attr( $one_authors[0]['ID'] ) . '">';
				} else {
					echo '<input required type="text" name="one_auth_id" id="one_auth_id" placeholder="Author ID">';
				}
				?>
			</div>
			<div id="one-auth-click-img" class="one-author-avatar">
				<img class="one-author-image-holder" id="one_auth_img" src="<?php echo $old ? esc_url( wp_get_attachment_url( $data->author_display_img ) ) : ''; ?>" alt="author">
				<p class="one-auth-text"><?php esc_html_e( 'Choose your Avatar', 'one-author' ); ?>
				<div class="edit-options">
					<input type="file" name="one_auth_avatar" id="one_auth_avatar">
					<div class="submit-btn" id="avatar_submit">Upload</div>
				</div>
			</div>
			<div class="one-author-social-media">
				<div class="one-author-social-grp grp-1">
					<select class="one-author-social-select" name="one_auth_select_1" id="one_auth_select_1" placeholder="Social Select">
						<?php
						$social_media = [
							'facebook',
							'twitter',
							'pinterest',
							'google',
							'linkedin',
							'buffer',
							'tumblr',
							'reddit',
							'stumbleupon',
							'delicious',
							'evernote',
							'email',
							'wordpress',
							'pocket',
						];
						$select       = $old ? array_search( $data->author_social_media[0]['handle'], $social_media, true ) + 1 : 1;
						foreach ( $social_media as $element ) {
							if ( 0 === --$select ) {
								echo '<option selected value="' . esc_attr( $element ) . '">' . esc_html( ucfirst( str_replace( '_', ' ', $element ) ) ) . '</option>';
								$select = null;
							}
							echo '<option value="' . esc_attr( $element ) . '">' . esc_html( ucfirst( str_replace( '_', ' ', $element ) ) ) . '</option>';
						}
						?>
					</select>
					<input required class="one-author-social-link" type="text" name="one_auth_social_1" id="one_auth_social_1" placeholder="Link" value="<?php echo $old ? esc_attr( $data->author_social_media[0]['url'] ) : ''; ?>">
				</div>
				<div class="one-author-social-grp grp-2">
					<select class="one-author-social-select" name="one_auth_select_2" id="one_auth_select_2" placeholder="Social Select">
						<?php
						$select = $old ? array_search( $data->author_social_media[1]['handle'], $social_media, true ) + 1 : 2;
						foreach ( $social_media as $element ) {
							if ( 0 === --$select ) {
								echo '<option selected value="' . esc_attr( $element ) . '">' . esc_html( ucfirst( str_replace( '_', ' ', $element ) ) ) . '</option>';
								$select = null;
							}
							echo '<option value="' . esc_attr( $element ) . '">' . esc_html( ucfirst( str_replace( '_', ' ', $element ) ) ) . '</option>';
						}
						?>
					</select>
					<input required class="one-author-social-link" type="text" name="one_auth_social_2" id="one_auth_social_2" placeholder="Link"  value="<?php echo $old ? esc_attr( $data->author_social_media[1]['url'] ) : ''; ?>">
				</div>
				<div class="one-author-social-grp grp-3">
					<select class="one-author-social-select" name="one_auth_select_3" id="one_auth_select_3" placeholder="Social Select">
						<?php
						$select = $old ? array_search( $data->author_social_media[2]['handle'], $social_media, true ) + 1 : 3;
						foreach ( $social_media as $element ) {
							if ( 0 === --$select ) {
								echo '<option selected value="' . esc_attr( $element ) . '">' . esc_html( ucfirst( str_replace( '_', ' ', $element ) ) ) . '</option>';
								$select = null;
							}
							echo '<option value="' . esc_attr( $element ) . '">' . esc_html( ucfirst( str_replace( '_', ' ', $element ) ) ) . '</option>';
						}
						?>
					</select>
					<input required class="one-author-social-link" type="text" name="one_auth_social_3" id="one_auth_social_3" placeholder="Link"  value="<?php echo $old ? esc_attr( $data->author_social_media[2]['url'] ) : ''; ?>">
				</div>
			</div>
		</div>
		<div class="one-author-partition"></div>
		<div class="one-author-right-box">
			<div class="one-author-name-box">
				<div class="one-author-name">
					<select class="one-author-name-select" name="one_auth_name" id="one_auth_name">
						<?php
						if ( $auth_count > 1 ) {
							echo '<option style="display:none;" selected>Select the author</option>';
						}
						?>
						<?php
						foreach ( $one_authors as $sr_no => $meta ) {
							echo '<option class="name-selector" value="' . esc_attr( $meta['name'] ) . '" data="' . esc_attr( $meta['ID'] ) . '">' . esc_html( $meta['name'] ) . '</option>';
						}
						?>
					</select>
				</div>
				<div class="one-author-display-name">
					<input required type="text" name="one_auth_display_name" id="one_auth_display_name" placeholder="Your Display Name" value="<?php echo $old ? esc_attr( $data->author_display_name ) : ''; ?>">
				</div>
			</div>
			<div class="one-author-punch-line">
				<input required type="text" name="one_auth_punch_line" id="one_auth_punch_line" placeholder="Punch line goes here" value="<?php echo $old ? esc_attr( $data->author_punch_line ) : ''; ?>">
			</div>
			<div class="one-author-about-author">
				<textarea required name="one_auth_description"  rows="10" placeholder="About Author" id="one_auth_description" ><?php echo $old ? esc_html( $data->author_about ) : ''; ?></textarea>
			</div>
			<?php wp_nonce_field( 'action_camera_light', 'dont_copy_the_nonce' ); ?>
			<button id="one_auth_submit" type="submit" class="submit-btn"><?php esc_html_e( 'Submit', 'one-author' ); ?></button>
		</div>
	</div>
</form>
	<?php
	if ( $old ) {
	?>
		<div class="display">
			<div class="about_author">
				<div class="author_desc">
					<img src="<?php echo esc_url( wp_get_attachment_url( $data->author_display_img ) ); ?>" alt="about author">
					<ul class="author_social">
						<li><a class="<?php echo esc_attr( $data->author_social_media[0]['handle'] ); ?>" href="<?php echo esc_url( $data->author_social_media[0]['url'] ); ?>" data-placement="top" data-toggle="tooltip" title="<?php echo esc_attr( $data->author_social_media[0]['handle'] ); ?>"><i class="fa fa-<?php echo esc_attr( $data->author_social_media[0]['handle'] ); ?>"></i></a></li>
						<li><a class="<?php echo esc_attr( $data->author_social_media[1]['handle'] ); ?>" href="<?php echo esc_url( $data->author_social_media[1]['url'] ); ?>" data-placement="top" data-toggle="tooltip" title="<?php echo esc_attr( $data->author_social_media[1]['handle'] ); ?>"><i class="fa fa-<?php echo esc_attr( $data->author_social_media[1]['handle'] ); ?>"></i></a></li>
						<li><a class="<?php echo esc_attr( $data->author_social_media[2]['handle'] ); ?>" href="<?php echo esc_url( $data->author_social_media[2]['url'] ); ?>" data-placement="top" data-toggle="tooltip" title="<?php echo esc_attr( $data->author_social_media[2]['handle'] ); ?>"><i class="fa fa-<?php echo esc_attr( $data->author_social_media[2]['handle'] ); ?>"></i></a></li>
					</ul>
				</div>
				<div class="author_bio">
					<h3 class="author_name"><a href="<?php echo esc_url( get_author_posts_url( $one_authors[0]['ID'] ) ); ?>"><?php echo esc_html( $data->author_display_name ); ?></a></h3>
					<h5><?php echo esc_html( $data->author_punch_line ); ?></h5>
					<p class="author_det">
					<?php echo esc_html( $data->author_about ); ?>
					</p>
				</div>
			</div>
		</div>
		<?
	}
}
