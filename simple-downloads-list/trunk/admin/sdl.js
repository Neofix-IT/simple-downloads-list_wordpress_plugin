jQuery(document).ready(function(){ 
	
	var plugin_folder = neofix_sdl_folder.pluginsUrl;
  
    jQuery('#example10').Tabledit({
      url: plugin_folder + "/admin/backend.php",
      columns: {
        identifier: [0, 'id'],
        editable: [
				  [1, 'name'],
				  [2, 'description', 'textarea'],
				  [3, 'category'],
				  [4, 'download']
			  ]
      }
    });
	
	
	
    jQuery("#addRow10").on('click', function () {

      jQuery.ajax({
        type: "POST",
        url: plugin_folder + "/admin/add_backend.php",
        datatype: 'html',
        success: function (data) {
    
          // Add 'html' data to table
          jQuery('#example10 tbody').html(data);


          jQuery('#example10').Tabledit({
            url: plugin_folder + "/admin/backend.php",
            columns: {
              identifier: [0, 'id'],
              editable: [
				  [1, 'name'],
				  [2, 'description', 'textarea'],
				  [3, 'category'],
				  [4, 'download']
			  ]
            }
          });
        },
        error: function () {
          console.log(data);
    
        }
      })
    });
}); 