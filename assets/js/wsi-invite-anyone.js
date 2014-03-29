/* Based on http://wordpress.org/extend/plugins/social-connect/ */

(function($){ 
	$(function(){
		$('#invite-anyone-steps #linkedin-provider').remove();
		$('#invite-anyone-steps #facebook-provider').remove();
		$('#invite-anyone-steps #twitter-provider').remove();
		$("#invite-anyone-steps .service-filters").addClass('wsi-anyone');
		$("#invite-anyone-steps .service-filters a").click(function(){
			popupurl = $("#wsi_base_url").val();
			provider = $(this).attr("data-provider");
			var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
		    var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;
		    var left = ((screen.width / 2) - (600 / 2)) + dualScreenLeft;
		    var top = ((screen.height / 2) - (640 / 2)) + dualScreenTop;
		    var widget_id = $(this).closest('.wsi-locker').attr('id');
		    if( !widget_id ) 
		    {
		    	var widget_id = Date.now();
		    	$(this).closest('.service-filter-content').attr('id',widget_id);
		    	
		    }			    
			window.open(
				WsiMyAjax.admin_url+"?action=wsi_authenticate&widget_id="+widget_id+"&redirect_to="+encodeURIComponent(popupurl)+"&provider="+provider+ "&wsi_hook=anyone&_ts=" + (new Date()).getTime(),
				"hybridauth_social_sing_on", 
				"directories=no,copyhistory=no,toolbar=0,location=0,menubar=0,status=0,scrollbars=1,width=600,height=640,top=" + top + ", left=" + left
			); 
		});
	});
})(jQuery);
