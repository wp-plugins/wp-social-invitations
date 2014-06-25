//Load Facebook SDK
window.fbAsyncInit = function() {
FB.init({
  appId      : WsiMyAjax.appId,
  xfbml      : false,
  version    : 'v2.0'
});
};
(function(d, s, id){
 var js, fjs = d.getElementsByTagName(s)[0];
 if (d.getElementById(id)) {return;}
 js = d.createElement(s); js.id = id;
 js.src = "//connect.facebook.net/"+WsiMyAjax.locale+"/sdk.js";
 fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

(function($){ 
	$(function(){
		$(".service-filters a").unbind('click');
		$(".service-filters a").click(function(){
			popupurl = $("#wsi_base_url").val();
			provider = $(this).attr("data-provider");
			var current_url = $('#wsi_base_url').val();
			var obj_id 		= $('#wsi_obj_id').val();
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
		    if( 'facebook' == provider) {
		    		var link = current_url;
		    		FB.ui(
					  {
					    method: 'share',
					    href: link,
					  },
					  function(response) {
					    if (response && !response.error_code) {
					        $('#'+widget_id+' #facebook-provider').addClass('completed');
							$('#'+widget_id+' #wsi_provider').html(provider);
							$('#'+widget_id+' .wsi_success').fadeIn('slow',function(){
								if( wsi_locker == 'true' ) {
									setCookie("wsi-lock["+widget_id+"]",1,365);
									window.location.reload();
								}
					    	});
					  	}
					  }	 
					);
		    } else {		    	
				window.open(
					WsiMyAjax.admin_url+"?action=wsi_authenticate&redirect_to="+encodeURIComponent(popupurl)+"&provider="+provider+ "&widget_id="+widget_id+"&wsi_locker="+wsi_locker+"&current_url="+encodeURIComponent(current_url)+"&wsi_obj_id="+obj_id+"&_ts=" + (new Date()).getTime(),
					"hybridauth_social_sing_on", 
					"directories=no,copyhistory=no,toolbar=0,location=0,menubar=0,status=0,scrollbars=1,width=600,height=640,top=" + top + ", left=" + left
				);
			}	 
		});
	});
})(jQuery);
