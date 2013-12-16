/* Based on http://wordpress.org/extend/plugins/social-connect/ */

(function($){ 
	$(function(){
		$(".service-filters a").unbind('click');
		$(".service-filters a").click(function(){
			popupurl = $("#wsi_base_url").val();
			provider = $(this).attr("data-provider");
			var current_url = $('#wsi_base_url').val();
			var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
		    var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;
		    var left = ((screen.width / 2) - (600 / 2)) + dualScreenLeft;
		    var top = ((screen.height / 2) - (640 / 2)) + dualScreenTop;
		    var widget_id = $(this).closest('.wsi-locker').attr('id');
		    var wsi_locker = true;
		    if( !widget_id ) 
		    {
		    	var widget_id = Date.now();
		    	$(this).closest('.service-filter-content').attr('id',widget_id);
				wsi_locker = false;
		    	
		    }	
			window.open(
				WsiMyAjax.admin_url+"?action=wsi_authenticate&redirect_to="+encodeURIComponent(popupurl)+"&provider="+provider+ "&widget_id="+widget_id+"&wsi_locker="+wsi_locker+"&current_url="+encodeURIComponent(current_url)+"&_ts=" + (new Date()).getTime(),
				"hybridauth_social_sing_on", 
				"directories=no,copyhistory=no,toolbar=0,location=0,menubar=0,status=0,scrollbars=1,width=600,height=640,top=" + top + ", left=" + left
			); 
		});
	});
})(jQuery);
