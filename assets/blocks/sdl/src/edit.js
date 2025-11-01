/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from "@wordpress/i18n";

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps, InspectorControls } from "@wordpress/block-editor";

import apiFetch from "@wordpress/api-fetch";
import { addQueryArgs } from "@wordpress/url";

import { useState, useEffect } from "@wordpress/element";

/**
 * Imports the RawHTML from WP JSX components
 *
 * Used for raw HTML element within the edit function
 */
import { RawHTML } from "@wordpress/element";

/**
 * Import Selectcontrol for the sidebar block settings
 */
import { SelectControl, PanelBody } from "@wordpress/components";

// Optional: Add editor styles
// /**
//  * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
//  * Those files can contain any CSS code that gets applied to the editor.
//  *
//  * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
//  */
// import "./editor.scss";

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit({ attributes: { category }, setAttributes }) {
  //const { editPost } = useDispatch( 'core/editor' );
  const [categories, setCategories] = useState([]);
  const [blockContent, setBlockContent] = useState(
    "<p>" + __("Loading", "simple-downloads-list") + "...</p>"
  );
  useEffect(() => {
    apiFetch({ path: `neofix-sdl/v1/download-categories/` }).then((data) => {
      setCategories(data);
    });
  }, []);

  useEffect(() => {
    apiFetch({
      path: addQueryArgs(`neofix-sdl/v1/editor-preview/`, {
        category: category,
      }),
    }).then((data) => {
      setBlockContent(data);
    });
  }, [category]); // category is a dependency now

  var settings;
  if (categories) {
    settings = (
      <SelectControl
        label={__("Categories", "simple-downloads-list")}
        value={category}
        options={[
          { label: __("All categories", "simple-downloads-list"), value: "" },
          ...categories.map((cat) => ({ label: cat, value: cat })),
        ]}
        onChange={(newCategory) => {
          setAttributes({ category: newCategory });
        }}
      />
    );
  } else {
    settings = <p>{__("Loading", "simple-downloads-list")}...</p>;
  }

  return (
    <>
      <InspectorControls>
        <PanelBody title={__("Settings", "simple-downloads-list")}>
          {settings}
        </PanelBody>
      </InspectorControls>

      <div {...useBlockProps()}>
        <RawHTML>{blockContent}</RawHTML>
      </div>
    </>
  );
}
