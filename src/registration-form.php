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
	$data = fetch_the_data();
	$old  = true;
	if ( false === $data ) {
		$old = false;
	}
	?>
<ul id="alerts" class="hidden"></ul>
<form method="POST" action="" id="author-form">
	<div class="one-author-container">
		<div class="one-author-left-box">
			<div class="one-author-id">
				<input required readonly type="text" name="one_auth_id" id="one_auth_id" placeholder="Author ID">
			</div>
			<div id="one-auth-click-img" class="one-author-avatar">
				<img class="one-author-image-holder" id="one_auth_img" src="" alt="author">
				<p class="one-auth-text"><?php esc_html_e( 'Choose your Avatar', 'one-author' ); ?></p>
				<div class="edit-options">
					<input type="file" name="one_auth_avatar" id="one_auth_avatar">
					<div class="submit-btn" id="avatar_submit"><?php esc_html_e( 'Upload', 'one-author' ); ?></div>
				</div>
			</div>
			<div class="one-author-social-media">
				<div class="one-author-social-grp grp-1">
					<select class="one-author-social-select" name="one_auth_select_1" id="one_auth_select_1" placeholder="Social Select">
						<?php
						$social_media = [
							'Facebook',
							'Twitter',
							'Instagram',
							'Pinterest',
							'LinkedIn',
							'Skype',
							'YouTube',
							'WordPress',
							'Flickr',
							'RSS',
							'Google Plus',
							'Tumblr',
							'E-mail',
							'Buffer',
							'Reddit',
							'Stumble Upon',
						];
						$select       = $old ? array_search( $data->author_social_media[0]['handle'], $social_media, true ) + 1 : 1;
						foreach ( $social_media as $element ) {
							if ( 0 === --$select ) {
								echo '<option selected value="' . esc_attr( $element ) . '">' . esc_html( $element ) . '</option>';
								$select = null;
							}
							echo '<option value="' . esc_attr( $element ) . '">' . esc_html( $element ) . '</option>';
						}
						?>
					</select>
					<input required class="one-author-social-link" type="text" name="one_auth_social_1" id="one_auth_social_1" placeholder="Link" value="">
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
					<input required class="one-author-social-link" type="text" name="one_auth_social_2" id="one_auth_social_2" placeholder="Link"  value="">
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
					<input required class="one-author-social-link" type="text" name="one_auth_social_3" id="one_auth_social_3" placeholder="Link"  value="">
				</div>
			</div>
		</div>
		<div class="one-author-partition"></div>
		<div class="one-author-right-box">
			<div class="one-author-name-box">
				<div class="one-author-name">
					<select class="one-author-name-select" name="one_auth_name" id="one_auth_name">
						<option style="display:none;" selected>Select the author</option>
						<?php
						foreach ( $one_authors as $sr_no => $meta ) {
							echo '<option class="name-selector" value="' . esc_attr( $meta['name'] ) . '" data="' . esc_attr( $meta['ID'] ) . '">' . esc_html( $meta['name'] ) . '</option>';
						}
						?>
					</select>
				</div>
				<div class="one-author-display-name">
					<input required type="text" name="one_auth_display_name" id="one_auth_display_name" placeholder="Your Display Name" value="">
				</div>
			</div>
			<div class="one-author-punch-line">
				<input required type="text" name="one_auth_punch_line" id="one_auth_punch_line" placeholder="Punch line goes here" value="">
			</div>
			<div class="one-author-about-author">
				<textarea required name="one_auth_description"  rows="10" placeholder="About Author" id="one_auth_description" ></textarea>
			</div>
			<?php wp_nonce_field( 'action_camera_light', 'dont_copy_the_nonce' ); ?>
			<button id="one_auth_submit" type="submit" class="submit-btn"><?php esc_html_e( 'Submit', 'one-author' ); ?></button>
		</div>
	</div>
</form>
	<?php
}
