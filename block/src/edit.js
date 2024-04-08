/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps, InspectorControls  } from '@wordpress/block-editor';


/**
 * Imports the RawHTML from WP JSX components
 * 
 * Used for raw HTML element within the edit function
 */
import { RawHTML } from '@wordpress/element';

/**
 * Import Selectcontrol for the sidebar block settings
 */
import { SelectControl } from '@wordpress/components'

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit( { attributes } ) {
	let category = {attributes.category};
	const[downloadCategory, setDownloadCategory] = useState( { attributes.category });
	return (

		<>
		
		<InspectorControls>
			<PanelRow>
				<fieldset>
					<SelectControl
						label={ __('Download category', 'neofix-sdl') }
						valie={ category }
					/>
				</fieldset>
			</PanelRow>
		</InspectorControls>
		<p { ...useBlockProps() }>
			<RawHTML>
				{ '<strong>Hallo</strong>' }
			</RawHTML>
			{ __( 'Neofix Sdl – hello from the editor!', 'neofix-sdl' ) }
		</p>
		</>
	);
}
