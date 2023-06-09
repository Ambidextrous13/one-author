(
	function() {

		/**
		 * Function used for enabling the disabled element.
		 * @param {HTMLElement} element element which going to re-enable.
		 */
		function enableIt( element ) {
			element.removeAttribute( 'disabled' );
			element.style.cursor = 'pointer';
			element.style.opacity = 1;
		}

		/**
		 * Specifically converts the avatar upload button into edit button
		 * @param {string} editLink link of Avatar
		 */
		function toggleBtn2Edit( editLink ) {
			submitImg.innerHTML = '';
			const editBtn = document.createElement( 'a' );
			editBtn.innerHTML = 'Edit';
			editBtn.setAttribute( 'href', editLink ); // jsonRes.edit_link;
			editBtn.setAttribute( 'id', 'edit-avatar' );
			editBtn.style.padding = '8px 25px';
			editBtn.style.color = '#000';
			editBtn.style.margin = '0';
			submitImg.style.padding = '8px 0px';
			editBtn.addEventListener( 'click', ( event ) => {
				event.stopPropagation();
			} );
			submitImg.append( editBtn );
			isEditBtn = true;
		}

		/**
		 * Specifically converts the avatar edit button into upload button
		 */
		function toggleBtn2Upload() {
			const editLink = document.getElementById( 'edit-avatar' );
			if ( editLink ) {
				editLink.remove();
			}
			submitImg.style.padding = '8px 25px';
			submitImg.innerHTML = 'Upload';
			isEditBtn = false;
		}

		const loadingEvent = new CustomEvent( 'waitPlease' );
		const stopLoadEvent = new CustomEvent( 'noMoreWait' );
		const idElement = document.getElementById( 'one_auth_id' );
		const authForm = document.getElementById( 'author-form' );
		const imageTag = document.getElementById( 'one_auth_avatar' );
		const submitImg = document.getElementById( 'avatar_submit' );
		const alertsDiv = document.getElementById( 'alerts' );
		const submitBtn = document.getElementById( 'one_auth_submit' );
		let isEditBtn = false;

		document.getElementById( 'one_auth_avatar' ).addEventListener( 'click', () => {
			if ( isEditBtn ) {
				toggleBtn2Upload();
			}
		} );
		// eslint-disable-next-line no-undef
		if ( AjaxData ) {
			// eslint-disable-next-line no-undef
			const AjaxUrl = AjaxData.ajax_url;
			// eslint-disable-next-line no-undef
			const AjaxNonce = AjaxData.ajax_nonce;

			alertsDiv.classList.add( 'hidden' );

			submitImg.addEventListener( 'click', () => {
				submitImg.dispatchEvent( loadingEvent );
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
										submitImg.dispatchEvent( stopLoadEvent );
										if ( '' !== jsonRes.edit_link ) {
											toggleBtn2Edit( jsonRes.edit_link );
										}
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
				submitImg.dispatchEvent( stopLoadEvent );
			} );

			idElement.addEventListener( 'onAdminDemands', () => {
				submitImg.dispatchEvent( loadingEvent );
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

							if ( '' !== jsonRes.author_display_img ) {
								toggleBtn2Edit( jsonRes.author_display_img );
							}

							for ( const count in jsonRes.author_social_media ) {
								const selectTag = document.getElementById( 'one_auth_select_' + parseInt( parseInt( count ) + 1 ) );
								const handle = jsonRes.author_social_media[ count ].handle;
								const url = jsonRes.author_social_media[ count ].url;
								selectTag.querySelector( 'option[value="' + handle + '"]' ).selected = true;
								document.getElementById( 'one_auth_social_' + parseInt( parseInt( count ) + 1 ) ).value = url;
							}
							if ( jsonRes.author_display_img ) {
								enableIt( submitBtn );
							}
						} else {
							const selectedUser = document.getElementById( 'one_auth_name' ).value;
							const selectedID = idElement.value;
							document.getElementById( 'author-form' ).reset();
							document.getElementById( 'one_auth_img' ).removeAttribute( 'src' );
							document.querySelector( 'option[value="' + selectedUser + '"]' ).selected = true;
							idElement.value = selectedID;
						}
						submitImg.dispatchEvent( stopLoadEvent );
					} );
			} );

			submitImg.addEventListener( 'waitPlease', () => {
				submitImg.classList.add( 'loader' );
				submitImg.classList.remove( 'submit-btn' );
			} );

			submitImg.addEventListener( 'noMoreWait', () => {
				submitImg.classList.add( 'submit-btn' );
				submitImg.classList.remove( 'loader' );
			} );
		}

		submitImg.addEventListener( 'click', () => {
			toggleBtn2Upload();
		} );
	}()
);
