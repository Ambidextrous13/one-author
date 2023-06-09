import './one-author-ajax.js';
(
	function() {
		// /////////////////////////////////////////////////////////////////////// HTML Element selection  ///////////////////////////////
		const idElement = document.getElementById( 'one_auth_id' );
		const nameElement = document.getElementById( 'one_auth_name' );
		const submitBtn = document.getElementById( 'one_auth_submit' );

		// /////////////////////////////////////////////////////////////////////// Function Declarations ///////////////////////////////
		/**
		 * This function pulls out the value of 'data' attribute from the 'fromElement', and put it into 'toElement' as a value or innerHTML.
		 * @param {HTMLElement} fromElement : HTML Element from which data attribute to be read.
		 * @param {HTMLElement} toElement   : HTML Element to which read value write.
		 */
		function setId( fromElement, toElement ) {
			const idValue = fromElement.getAttribute( 'data' );
			if ( idValue ) {
				toElement.value = 'User Id: ' + idValue;
			}
		}

		/**
		 * Function used for disabling the element, Rejects the clicks and reduces the opacity of the element.
		 * @param {HTMLElement} element element which going to disable.
		 */
		function disabledIt( element ) {
			element.setAttribute( 'disabled', true );
			element.style.cursor = 'not-allowed';
			element.style.opacity = 0.66;
		}

		const adminDemands = new CustomEvent( 'onAdminDemands' );
		// ///////////////////////////////////////////////////////////////////////////// Actual Flow //////////////////////////////////

		disabledIt( submitBtn );

		if ( nameElement && idElement ) {
			setId( nameElement, idElement );
			if ( 1 < nameElement.length ) {
				nameElement.addEventListener( 'change', ( event ) => {
					const subjectedElement = event.target;
					const optionNumber = subjectedElement.selectedIndex;
					const option = subjectedElement[ optionNumber ];
					setId( option, idElement );
					idElement.dispatchEvent( adminDemands );
				} );
			}
		}
	}()
);

