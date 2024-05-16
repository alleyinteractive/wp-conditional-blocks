!function(){"use strict";var e={n:function(n){var t=n&&n.__esModule?function(){return n.default}:function(){return n};return e.d(t,{a:t}),t},d:function(n,t){for(var o in t)e.o(t,o)&&!e.o(n,o)&&Object.defineProperty(n,o,{enumerable:!0,get:t[o]})},o:function(e,n){return Object.prototype.hasOwnProperty.call(e,n)}},n=window.React,t=window.wp.blocks,o=window.wp.blockEditor,i=window.wp.i18n,l=window.wp.apiFetch,r=e.n(l),s=window.wp.element,c=window.wp.components,a=JSON.parse('{"$schema":"https://schemas.wp.org/trunk/block.json","apiVersion":2,"name":"wp-conditional-blocks/condition","version":"0.1.0","title":"Condition","category":"theme","icon":"star-half","description":"Conditionally show is-true or is-false blocks","textdomain":"wp-conditional-blocks","editorScript":"file:index.ts","editorStyle":"file:index.css","render":"file:render.php","attributes":{"condition":{"type":"string"}}}');(0,t.registerBlockType)(a,{edit:function(e){let{attributes:{condition:t=""},setAttributes:l}=e;const[a,d]=(0,s.useState)([]);return(0,s.useEffect)((()=>{r()({path:"/conditional-blocks/v1/get-conditions/"}).then((e=>{if(Array.isArray(e.message)&&e.message.length>0){const n=e.message.map((e=>{var n,t;return{value:null!==(n=e.slug)&&void 0!==n?n:"",label:null!==(t=e.name)&&void 0!==t?t:""}}));d(n)}else console.error("[wp-block-conditions] Failed to retrieve conditions.")}))}),[]),(0,n.createElement)(n.Fragment,null,(0,n.createElement)("div",{...(0,o.useBlockProps)()},(0,n.createElement)(o.InnerBlocks,{allowedBlocks:["wp-conditional-blocks/is-true","wp-conditional-blocks/is-false"]})),(0,n.createElement)(o.InspectorControls,null,(0,n.createElement)(c.PanelBody,{title:(0,i.__)("Conditions","wp-conditional-blocks"),initialOpen:!0},(0,n.createElement)(c.PanelRow,null,(0,n.createElement)(c.SelectControl,{label:(0,i.__)("Conditions","wp-conditional-blocks"),help:(0,i.__)('Select condition, e.g. "Is Home" or "Is Archive"',"wp-conditional-blocks"),onChange:e=>l({condition:e}),multiple:!1,value:t,options:a})))))},save:()=>(0,n.createElement)("div",{...o.useBlockProps.save()},(0,n.createElement)(o.InnerBlocks.Content,null))})}();