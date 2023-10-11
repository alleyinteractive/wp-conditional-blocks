import { __ } from '@wordpress/i18n';
import { InnerBlocks, InspectorControls, useBlockProps } from '@wordpress/block-editor';
import {
  PanelBody, PanelRow, SelectControl, TextControl,
} from '@wordpress/components';

import { useParentBlock } from '@alleyinteractive/block-editor-tools';

interface EditProps {
  attributes: {
    condition?: string;
    custom?: string;
    post?: string;
    query?: string;
    index?: object;
  };
  setAttributes: (attributes: any) => void;
  clientId: string;
}

/**
 * The wp-conditional-blocks/condition block edit function.
 *
 * @return {WPElement} Element to render.
 */
export default function Edit({
  attributes: {
    condition = '',
    custom = '',
    post = '',
    query = '',
    index = { '': '' },
  },
  setAttributes,
  clientId,
}: EditProps) {
  const { name: parentBlock } = useParentBlock(clientId) as { name?: string } || {};
  const [operator, compared] = Object.entries(index)[0];

  return (
    <>
      <div {...useBlockProps()}>
        <InnerBlocks
          allowedBlocks={['wp-conditional-blocks/is-true', 'wp-conditional-blocks/is-false']}
        />
      </div>

      <InspectorControls>
        <PanelBody
          title={__('Condition', 'wp-conditional-blocks')}
          initialOpen
        >
          <PanelRow>
            <TextControl
              label={__('Query', 'wp-conditional-blocks')}
              help={__('Query condition, ie "is_home" or "is_category"', 'wp-conditional-blocks')}
              onChange={(next) => setAttributes({ query: next })}
              value={query}
            />
          </PanelRow>

          <PanelRow>
            <TextControl
              label={__('Post', 'wp-conditional-blocks')}
              help={__('Post condition, ie "is_content"', 'wp-conditional-blocks')}
              onChange={(next) => setAttributes({ post: next })}
              value={post}
            />
          </PanelRow>

          <PanelRow>
            <TextControl
              label={__('Custom', 'wp-conditional-blocks')}
              help={__('Custom condition, ie "is_column"', 'wp-conditional-blocks')}
              onChange={(next) => setAttributes({ custom: next })}
              value={custom}
            />
          </PanelRow>

          <PanelRow>
            <TextControl
              label={__('Condition', 'wp-conditional-blocks')}
              help={__('Any other condition', 'wp-conditional-blocks')}
              onChange={(next) => setAttributes({ condition: next })}
              value={condition}
            />
          </PanelRow>
        </PanelBody>

        { parentBlock === 'wp-conditional-blocks/query' ? (
          <PanelBody
            title={__('Index Condition', 'wp-conditional-blocks')}
          >
            <p>{__('Checks the index of how many times the parent condition block has been rendered, ie "Equal to 0", "Greater than 5"', 'wp-conditional-blocks')}</p>

            <PanelRow>
              <SelectControl
                label={__('Index Operator', 'wp-conditional-blocks')}
                value={operator}
                options={[
                  { value: '', label: __('Select Operator', 'wp-conditional-blocks') },
                  { value: '===', label: __('Equal', 'wp-conditional-blocks') },
                  { value: '!==', label: __('Not equal', 'wp-conditional-blocks') },
                  { value: '>', label: __('Greater than', 'wp-conditional-blocks') },
                  { value: '<', label: __('Less than', 'wp-conditional-blocks') },
                  { value: '>=', label: __('Greater than or equal to', 'wp-conditional-blocks') },
                  { value: '<=', label: __('Less than or equal to', 'wp-conditional-blocks') },
                ]}
                onChange={(next: string) => setAttributes({ index: { [next]: compared } })}
              />
            </PanelRow>

            <PanelRow>
              <TextControl
                label={__('Index compared', 'wp-conditional-blocks')}
                onChange={(next) => setAttributes({ index: { [operator]: next } })}
                type="number"
                value={compared}
              />
            </PanelRow>
          </PanelBody>
        ) : null}
      </InspectorControls>
    </>
  );
}
