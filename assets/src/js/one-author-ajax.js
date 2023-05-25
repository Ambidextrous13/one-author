(
	function() {

		/**
		 * Function used for enabling the disabled element.
		 * @param {HTMLElement} element element which going to re-enable.
		 */
		function enableIt( element ) {
			element.setAttribute( 'disabled', false );
			element.style.cursor = 'pointer';
			element.style.opacity = 1;
		}

		if ( AjaxData ) {
			const AjaxUrl = AjaxData.ajax_url;
			const AjaxNonce = AjaxData.ajax_nonce;
			const idElement = document.getElementById( 'one_auth_id' );
			const authForm = document.getElementById( 'author-form' );
			const imageTag = document.getElementById( 'one_auth_avatar' );
			const submitImg = document.getElementById( 'avatar_submit' );
			const alertsDiv = document.getElementById( 'alerts' );
			const submitBtn = document.getElementById( 'one_auth_submit' );

			alertsDiv.classList.add( 'hidden' );

			submitImg.addEventListener( 'click', () => {
				const miniForm = new FormData( authForm );
				if ( imageTag.files.length ) {
					miniForm.append( 'one_auth_avatar', imageTag.files[ 0 ] );
					miniForm.append( 'mini_form_OTW', AjaxNonce );
					miniForm.append( 'action', 'reg_avatar' );
					if ( 9 < miniForm.get( 'one_auth_id' ).length ) {
						fetch(
							AjaxUrl,
							{
								method: 'POST',
								  body: miniForm,
							}
						).then( ( response ) => response.json() )
							.then( ( jsonRes ) => {
								if ( jsonRes.success ) {
									if ( jsonRes.url ) {
										document.getElementById( 'one_auth_img' ).setAttribute( 'src', jsonRes.url );
										enableIt( submitBtn );
									}
								}
							} );
					} else {
						alertsDiv.classList.remove( 'hidden' );
						const alert1 = document.createElement( 'li' );
						alert1.innerHTML = 'Please select the user';
						alertsDiv.append( alert1 );
					}
				} else {
					alertsDiv.classList.remove( 'hidden' );
					const alert1 = document.createElement( 'li' );
					alert1.innerHTML = 'Please select the avatar image';
					alertsDiv.append( alert1 );
				}
			} );

			idElement.addEventListener( 'onAdminDemands', () => {
				const miniForm = new FormData();
				miniForm.append( 'mini_form_OTW', AjaxNonce );
				miniForm.append( 'action', 'gods_eye' );
				miniForm.append( 'one_auth_id', idElement.value );
				fetch(
					AjaxUrl,
					{
						method: 'POST',
						body: miniForm,
					}
				).then( ( response ) => response.json() )
					.then( ( jsonRes ) => {
						if ( jsonRes.success ) {
							document.getElementById( 'one_auth_img' ).setAttribute( 'src', jsonRes.author_display_img );
							document.getElementById( 'one_auth_display_name' ).value = jsonRes.author_name;
							document.getElementById( 'one_auth_punch_line' ).value = jsonRes.author_punch_line;
							document.getElementById( 'one_auth_description' ).value = jsonRes.author_about;

							for ( const count in jsonRes.author_social_media ) {
								const selectTag = document.getElementById( 'one_auth_select_' + parseInt( parseInt( count ) + 1 ) );
								const handle = jsonRes.author_social_media[ count ].handle;
								const url = jsonRes.author_social_media[ count ].url;
								selectTag.querySelector( 'option[value="' + handle + '"]' ).selected = true;
								document.getElementById( 'one_auth_social_' + parseInt( parseInt( count ) + 1 ) ).value = url;
								if ( url ) {
									enableIt( submitBtn );
								}
							}
						}
					} );
			} );
		}
	}()
);
