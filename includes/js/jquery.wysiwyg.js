/* 
Author: de77.com
Licence: MIT
*/
function action(e,a,p)
{    
	$(e).parents().each(function(){
		var obj = $(this);				
	});    
	if (p == null) p = false;
	document.execCommand(a,null,p);
}

function makeToolbar(el)
{
	toolbar = $.ajax({url:'includes/js/jquery.wysiwyg.htm',async:false}).responseText;
	el.parent().prepend(toolbar);    

}

(function($){
 $.fn.de77_wysiwyg = function(options) {
 	if (options == false)
 	{
		return this.each(function() {
			var obj = $(this);
			obj.parent().find('.de77_toolbar').detach();
			obj.unwrap();
			obj.removeClass('de77_editor');
			this.contentEditable="false";			
		});				
	}
	else
	{
		return this.each(function() {
			var obj = $(this);            			
			obj.addClass('de77_editor');
			obj.wrap('<div class="de77_wysiwyg"></div>');		
			this.contentEditable="true";		
			makeToolbar($(this));
		});	
	}
 };
})(jQuery);