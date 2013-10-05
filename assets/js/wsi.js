/* Based on http://wordpress.org/extend/plugins/social-connect/ */

(function($){ 
	$(function(){
		$(".service-filters a").unbind('click');
		$(".service-filters a").click(function(){
			popupurl = $("#wsi_base_url").val();
			provider = $(this).attr("data-provider");
			var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
		    var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;
		    var left = ((screen.width / 2) - (600 / 2)) + dualScreenLeft;
		    var top = ((screen.height / 2) - (640 / 2)) + dualScreenTop;
			window.open(
				WsiMyAjax.admin_url+"?action=wsi_authenticate&redirect_to"+encodeURIComponent(popupurl)+"&provider="+provider+ "&_ts=" + (new Date()).getTime(),
				"hybridauth_social_sing_on", 
				"directories=no,copyhistory=no,toolbar=0,location=0,menubar=0,status=0,scrollbars=1,width=600,height=640,top=" + top + ", left=" + left
			); 
		});
	});
})(jQuery);
