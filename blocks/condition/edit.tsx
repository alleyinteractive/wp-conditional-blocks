import { __ } from '@wordpress/i18n';
import apiFetch from '@wordpress/api-fetch';
import { useEffect, useState } from '@wordpress/element';
import { InnerBlocks, InspectorControls, useBlockProps } from '@wordpress/block-editor';
import {
  PanelBody, PanelRow, SelectControl,
} from '@wordpress/components';

interface EditProps {
  attributes: {
    condition?: string;
  };
  setAttributes: (attributes: any) => void;
}

interface Conditions {
  value: string;
  label: string;
}

/**
 * The wp-conditional-blocks/condition block edit function.
 *
 * @return {WPElement} Element to render.
 */
export default function Edit({
  attributes: {
    condition = '',
  },
  setAttributes,
}: EditProps) {
  const [conditions, setConditions] = useState<Conditions[]>([]);

  // Fetch and set the Conditions data.
  useEffect(() => {
    apiFetch({path: '/conditional-blocks/v1/get-conditions/'})
      .then((response) => {
        // @ts-ignore
        if (Array.isArray(response.message) && response.message.length > 0) {
          const nextConditions = response.message.map((condition) => ({
            value: condition.slug ?? '',
            label: condition.name ?? '',
          }));
          setConditions(nextConditions);
        } else {
          console.error('[wp-block-conditions] Failed to retrieve conditions.');
        }
      });
  }, []);

  return (
    <>
      <div {...useBlockProps()}>
        <InnerBlocks
          allowedBlocks={['wp-conditional-blocks/is-true', 'wp-conditional-blocks/is-false']}
        />
      </div>

      <InspectorControls>
        {/* @ts-ignore-next-line */}
        <PanelBody
          title={__('Conditions', 'wp-conditional-blocks')}
          initialOpen
        >
          {/* @ts-ignore-next-line */}
          <PanelRow>
            {/* @ts-ignore-next-line */}
            <SelectControl
              label={__('Conditionals', 'wp-conditional-blocks')}
              help={__('Select condition, e.g. "Is Home" or "Is Archive"', 'wp-conditional-blocks')}
              onChange={(next) => setAttributes({ condition: next })}
              multiple={false}
              value={condition}
              options={conditions}
            />
          </PanelRow>
        </PanelBody>
      </InspectorControls>
    </>
  );
}
