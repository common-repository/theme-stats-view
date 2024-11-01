import { __ } from '@wordpress/i18n';
import ServerSideRender from '@wordpress/server-side-render';
import { TextControl, RadioControl, ToggleControl, PanelBody, PanelRow } from '@wordpress/components';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';

export default function Edit( { attributes, setAttributes } ) {
	const blockProps = useBlockProps();
	return (
		<div { ...blockProps }>
			<ServerSideRender
				block = 'theme-stats-view/tsview-block'
				attributes = { attributes }
			/>
			<TextControl
				label = { __( 'Slug', 'theme-stats-view' ) }
				value = { attributes.slug }
				onChange = { ( value ) => setAttributes( { slug: value } ) }
			/>
			<RadioControl
				label = { __( 'View', 'theme-stats-view' ) }
				selected = { attributes.view }
				onChange = { ( value ) => setAttributes( { view: value } ) }
				options = { [
					{ label: __( 'Normal display', 'theme-stats-view' ), value: 'normal' },
					{ label: __( 'Card display', 'theme-stats-view' ), value: 'card' },
					{ label: __( 'Simple display', 'theme-stats-view' ), value: 'simple' },
				] }
			/>

			<InspectorControls>
				<TextControl
					label = { __( 'Slug', 'theme-stats-view' ) }
					value = { attributes.slug }
					onChange = { ( value ) => setAttributes( { slug: value } ) }
				/>
				<RadioControl
					label = { __( 'View', 'theme-stats-view' ) }
					selected = { attributes.view }
					onChange = { ( value ) => setAttributes( { view: value } ) }
					options = { [
						{ label: __( 'Normal display', 'theme-stats-view' ), value: 'normal' },
						{ label: __( 'Card display', 'theme-stats-view' ), value: 'card' },
						{ label: __( 'Simple display', 'theme-stats-view' ), value: 'simple' },
					] }
				/>
				<PanelBody title = { __( 'Other settings', 'theme-stats-view' ) } initialOpen = { false }>
					<TextControl
						label = { __( 'Link', 'theme-stats-view' ) }
						value = { attributes.link }
						onChange = { ( value ) => setAttributes( { link: value } ) }
					/>
					<ToggleControl
						label = { __( 'View Description', 'theme-stats-view' ) }
						checked = { attributes.open }
						onChange = { ( value ) => setAttributes( { open: value } ) }
					/>
				</PanelBody>
			</InspectorControls>
		</div>
	);
}
