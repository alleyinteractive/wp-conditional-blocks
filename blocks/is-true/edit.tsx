import { InnerBlocks, useBlockProps } from '@wordpress/block-editor';

/**
 * The wp-conditional-blocks/is-true block edit function.
 *
 * @return {WPElement} Element to render.
 */
export default function Edit() {
  return (
    <div {...useBlockProps()}>
      <InnerBlocks />
    </div>
  );
}
