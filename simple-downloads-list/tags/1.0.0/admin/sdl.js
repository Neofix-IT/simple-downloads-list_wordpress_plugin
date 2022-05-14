jQuery(document).ready(function(){ 
  
  var ajax_url = plugin_ajax_object.ajax_url;

  setupTableEdit();

  function setupTableEdit(){
    jQuery('#example10').Tabledit({
      url: ajax_url,
      neofix_sdl_editmethod: 'post',
      neofix_sdl_deletemethod: 'post',
      neofix_sdl_restoremethod: 'post',
      buttons: {
        edit: {
            class: 'btn btn-sm btn-default',
            html: '<span class="fas fa-edit"></span>',
            action: 'neofix_sdl_edit'
        },
        delete: {
            class: 'btn btn-sm btn-default',
            html: '<span class="fas fa-trash-alt"></span>',
            action: 'neofix_sdl_delete'
        },
        save: {
            class: 'btn btn-sm btn-success',
            html: 'Save'
        },
        restore: {
            class: 'btn btn-sm btn-warning',
            html: 'Restore',
            action: 'neofix_sdl_restore'
        },
        confirm: {
            class: 'btn btn-sm btn-danger',
            html: 'Confirm'
        }
      },
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
  }
	
  jQuery("#addRow10").on('click', function () {
    
    var data = {'action': 'neofix_sdl_add'};

    jQuery.ajax({
      url: ajax_url,
      type: 'post',
      data: data,
      dataType: 'html',
      success: function (data) {
  
        // Add 'html' data to table
        jQuery('#example10 tbody').html(data);

        setupTableEdit();
      },
      error: function () {
        console.log(data);
  
      }
    });
  });
}); 