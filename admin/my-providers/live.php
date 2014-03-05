<link rel="stylesheet" href="<?php echo plugins_url( 'assets/css/jquery.fileupload-ui.css', $this->PLUGIN_FILE );?>" type="text/css" media="all">
<script src="<?php echo plugins_url( 'assets/js/jquery.ui.widget.js', $this->PLUGIN_FILE );?>"></script>
<script src="<?php echo plugins_url( 'assets/js/jquery.iframe-transport.js', $this->PLUGIN_FILE );?>"></script>
<script src="<?php echo plugins_url( 'assets/js/jquery.fileupload.js', $this->PLUGIN_FILE );?>"></script>
<script type="text/javascript">
jQuery(function($){
	$('#collect_container').hide();
});
jQuery(document).ready(function($) { 
	$('#collect_container').hide();
	$('#fileupload').fileupload({
        url: '<?php echo $this->WPB_PLUGIN_URL ?>/uploads/',
        dataType: 'json',
        start: function(){
        	 $('#progress .bar').fadeIn();
        	 $('.errors').hide();
        },
        done: function (e, data) {
            $.each(data.result.files, function (index, file) {
                 if ( file.error)
                 {
                 	$('.errors').html(file.error).fadeIn();
                 }
                 else
                 {
                 	var html_inputs = '';
                 	var counter = 0;
                 	var classstr= '';
                 	persons = file.data;
                 	for( i in persons)
                 	{
                 		counter++;
                 		classstr= '';
                 		if( counter == 3)
                 		{
                 			classstr = 'last';
                 			counter = 0;
                 		}	
                 		html_inputs += '<tr><td class="checkbox-container"><input type="checkbox" value="'+persons[i]['E-mail Address']+'" name="friend[]" checked="true"/></td><td class="user-img"></td><td class="last-child"> '+persons[i]['First Name']+' '+persons[i]['Last Name']+'<em>'+persons[i]['E-mail Address']+'</em></td></tr>';
                 		
                 	}
                 
                 	$('.friends_container tbody').html(html_inputs);
                 	$('#upload_container').hide();
                 	$('#collect_container').fadeIn();
                 }
                 $('#progress .bar').fadeOut();
            });
        },
        dropZone: $('#dropzone'),
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .bar').css(
                'width',
                progress + '%'
            );
        }    
    });
$(document).bind('dragover', function (e) {
    var dropZone = $('#dropzone'),
        timeout = window.dropZoneTimeout;
    if (!timeout) {
        dropZone.addClass('in');
    } else {
        clearTimeout(timeout);
    }
    var found = false,
      	node = e.target;
    do {
        if (node === dropZone[0]) {
       		found = true;
       		break;
       	}
       	node = node.parentNode;
    } while (node != null);
    if (found) {
        dropZone.addClass('hover');
    } else {
        dropZone.removeClass('hover');
    }
    window.dropZoneTimeout = setTimeout(function () {
        window.dropZoneTimeout = null;
        dropZone.removeClass('in hover');
    }, 100);
});
}); 
</script>
<?php
	wsi_get_template('popup/live-upload.php', array( 'options' => $this->_options, 'WPB_PREFIX' => $this->WPB_PREFIX, 'assets_url' => $this->assets_url, 'provider' => $provider  ) );