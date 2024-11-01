import { __ } from '@wordpress/i18n';
import ServerSideRender from '@wordpress/server-side-render';
import { TextControl, ToggleControl, PanelBody, PanelRow } from '@wordpress/components';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';

export default function Edit( { attributes, setAttributes } ) {
	const blockProps = useBlockProps();
	return (
		<div { ...blockProps }>
			<ServerSideRender
				block = 'theme-stats-view/taview-block'
				attributes = { attributes }
			/>
			<TextControl
				label = { __( 'Slug', 'theme-stats-view' ) }
				value = { attributes.slug }
				onChange = { ( value ) => setAttributes( { slug: value } ) }
			/>

			<InspectorControls>
				<TextControl
					label = { __( 'Slug', 'theme-stats-view' ) }
					value = { attributes.slug }
					onChange = { ( value ) => setAttributes( { slug: value } ) }
				/>
				<PanelBody title = { __( 'Other settings', 'theme-stats-view' ) } initialOpen = { false }>
					<TextControl
						label = { __( 'Link', 'theme-stats-view' ) }
						value = { attributes.link }
						onChange = { ( value ) => setAttributes( { link: value } ) }
					/>
					<ToggleControl
						label = { __( 'Total only', 'theme-stats-view' ) }
						checked = { attributes.totalonly }
						onChange = { ( value ) => setAttributes( { totalonly: value } ) }
					/>
				</PanelBody>
			</InspectorControls>
		</div>
	);
}
