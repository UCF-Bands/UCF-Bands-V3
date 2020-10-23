/**
 * URL picker for block toolbar
 *
 * @see   https://github.com/WordPress/gutenberg/blob/master/packages/block-library/src/button/edit.js
 * @since 1.0.0
 * @package Knight_Blocks
 */

const { __ } = wp.i18n;
const { useCallback, useState, Fragment } = wp.element;
const { KeyboardShortcuts, ToolbarButton, ToolbarGroup, Popover } = wp.components;
const { BlockControls, __experimentalLinkControl } = wp.blockEditor;
const { rawShortcut, displayShortcut } = wp.keycodes;

import { link, linkOff } from '@wordpress/icons';

const NEW_TAB_REL = 'noreferrer noopener';

export default function URLPicker( {
	isSelected,
	url,
	rel,
	setAttributes,
	opensInNewTab,
	// onToggleOpenInNewTab
} ) {
	const [ isURLPickerOpen, setIsURLPickerOpen ] = useState( false );
	const urlIsSet = !! url;
	const urlIsSetandSelected = urlIsSet && isSelected;

	const openLinkControl = () => {
		setIsURLPickerOpen( true );
		return false; // prevents default behaviour for event
	};

	const unlinkButton = () => {
		setAttributes( {
			url: undefined,
			linkTarget: undefined,
			rel: undefined,
		} );
	};

	// DIFFERENT THAN GUTENBERG
	// this was brought into the the component instead of being in the button
	const onToggleOpenInNewTab = useCallback(
		( value ) => {
			const newLinkTarget = value ? '_blank' : undefined;

			let updatedRel = rel;
			if ( newLinkTarget && ! rel ) {
				updatedRel = NEW_TAB_REL;
			} else if ( ! newLinkTarget && rel === NEW_TAB_REL ) {
				updatedRel = undefined;
			}

			setAttributes( {
				linkTarget: newLinkTarget,
				rel: updatedRel,
			} );
		},
		[ rel, setAttributes ]
	);

	const linkControl = ( isURLPickerOpen || urlIsSetandSelected ) && (
		<Popover
			position="bottom center"
			onClose={ () => setIsURLPickerOpen( false ) }
		>
			<__experimentalLinkControl
				className="wp-block-navigation-link__inline-link-input"
				value={ { url, opensInNewTab } }
				onChange={ ( {
					url: newUrl = '',
					opensInNewTab: newOpensInNewTab,
				} ) => {
					setAttributes( { url: newUrl } );

					if ( opensInNewTab !== newOpensInNewTab ) {
						onToggleOpenInNewTab( newOpensInNewTab );
					}
				} }
			/>
		</Popover>
	);

	return <Fragment>
		<BlockControls>
			<ToolbarGroup>
				{ ! urlIsSet && (
					<ToolbarButton
						name="link"
						icon={ link }
						title={ __( 'Link' ) }
						shortcut={ displayShortcut.primary( 'k' ) }
						onClick={ openLinkControl }
					/>
				) }
				{ urlIsSetandSelected && (
					<ToolbarButton
						name="link"
						icon={ linkOff }
						title={ __( 'Unlink' ) }
						shortcut={ displayShortcut.primaryShift( 'k' ) }
						onClick={ unlinkButton }
						isActive={ true }
					/>
				) }
			</ToolbarGroup>
		</BlockControls>
		{ isSelected && (
			<KeyboardShortcuts
				bindGlobal
				shortcuts={ {
					[ rawShortcut.primary( 'k' ) ]: openLinkControl,
					[ rawShortcut.primaryShift( 'k' ) ]: unlinkButton,
				} }
			/>
		) }
		{ linkControl }
	</Fragment>;
}
