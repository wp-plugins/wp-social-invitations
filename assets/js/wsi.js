/* Based on http://wordpress.org/extend/plugins/social-connect/ */

(function($){ 
	$(function(){
		$(".service-filters a").click(function(){
			popupurl = $("#wsi_base_url").val();
			provider = $(this).attr("data-provider");

			window.open(
				WsiMyAjax.url+"?action=wsi_authenticate&redirect_to"+encodeURIComponent(popupurl)+"&provider="+provider+ "&_ts=" + (new Date()).getTime(),
				"hybridauth_social_sing_on", 
				"location=1,status=0,scrollbars=1,width=900,height=530"
			); 
		});
	});
})(jQuery);

