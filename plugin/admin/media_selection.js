jQuery(document).ready( function($) {

  // when download input is clicked, open wp media library to select a file
  jQuery(".sdl_upload").on("click", "input.tabledit-input.form-control.input-sm", function(e) {
    e.preventDefault();
    var element = jQuery(this);

  
    var image_frame;
    if(image_frame){
      image_frame.open();
    }

    // Define image_frame as wp.media object
    image_frame = wp.media({
        title: 'Select Media',
        multiple : true,
        button:{
              text: 'Select'
        }
    });

    image_frame.on('close',function() {
      var selection =  image_frame.state().get('selection');

      var file_ids = selection.map( function( attachment ) {
        attachment = attachment.toJSON();
        return attachment.id;
      })
      if(file_ids.length <= 0) return true;
      console.log(file_ids);
      fetch_file_url(file_ids[0], element);
    });

    image_frame.open();
  });

});

function fetch_file_url(id, element){
  var data = {
      action: 'neofix_sdl_get_file_url',
      id: id
  };
  jQuery.get(ajaxurl, data, function(response) {
      if(response.success === true) {
        jQuery(element).val(response.data);
      }
  });
}