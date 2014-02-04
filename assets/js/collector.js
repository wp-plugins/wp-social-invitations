jQuery(document).ready(function($) { 
	
	$('.unselect-all a').click(function(){
		
		var link = $(this);
        if( link.hasClass('select'))
        {
        	$('#FriendsList').find(':checkbox').prop('checked',true);
        	$('#FriendsList').find('tr').addClass('selectedTr');
			$(this).hide();
			$('.unselect-all a.unselect').fadeIn();
        }
        else
        {	
			$('#FriendsList').find(':checkbox').prop('checked',false);
			$('#FriendsList').find('tr').removeClass('selectedTr');
			$(this).hide();
			$('.unselect-all a.select').fadeIn();
    	}
    	return false;
    });
    
    $('#FriendsList input:checkbox').click(function(){
    	
    	if( $(this).prop('checked') )
    	{
    		$(this).parent('td').parent('tr').addClass('selectedTr');
    	}
    	else
    	{
    		$(this).parent('td').parent('tr').removeClass('selectedTr');
    	}
    
    });
	
	
	$('#searchinput').blur(function(e){
	
		checkEmpty(e);

	}).focus(function(e){
			
		checkEmpty(e);
		
	}).keydown(function(e){
		checkEmpty(e);
	});
	
	function checkEmpty(e){
		if( $('#searchinput').val() ==='')
		{
			if(e.type == 'blur')
			{
			
				$('#friendsSearch label').animate({opacity:1}, 300);
			}
			else
			{
				$('#friendsSearch label').animate({opacity:0.5}, 300);
			
			}
			$('#friendsSearch label').fadeIn();
		}
		else
		{
			$('#friendsSearch label').hide();
		}
	}
}); 



(function ($) {
  // custom css expression for a case-insensitive contains()
  jQuery.expr[':'].Contains = function(a,i,m){
      return (a.textContent || a.innerText || "").toUpperCase().indexOf(m[3].toUpperCase())>=0;
  };


  function listFilter(input, list) { // header is any element, list is an unordered list
    // create and add the filter form to the header
   
   input
      .change( function () {
        var filter = $(this).val();
        if(filter) {
          // this finds all links in a list that contain the input,
          // and hide the ones not containing the input while showing the ones that do
          $(list).find("td.last-child:not(:Contains(" + filter + "))").parent().hide();
          $(list).find("td.last-child:Contains(" + filter + ")").parent().fadeIn('slow');
        } else {
          $(list).find("tr").slideDown();
        }
        return false;
      })
    .keyup( function () {
        // fire the above change event after every letter
        $(this).change();
    });
  }


  //ondomready
  $(function () {
    listFilter($("#searchinput"), $("#FriendsList"));
  });
}(jQuery));

if (jQuery.support.leadingWhitespace != false){

jQuery(window).load(function(){
	var total_heigh = jQuery(window).height() + 50;
	window.resizeTo(600, total_heigh);
	
	var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
    var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;

    var left = ((screen.width / 2) - (600 / 2)) + dualScreenLeft;
    var top = ((screen.height / 2) - (640 / 2)) + dualScreenTop;
    
    window.moveTo( top,left);
});
}