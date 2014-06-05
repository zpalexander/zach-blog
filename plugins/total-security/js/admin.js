/*
|--------------------------------------------------------------------------
| POPUP data-width="600" data-height="800" rel="1" id="pop_1" class="newWindow"
|--------------------------------------------------------------------------
*/
jQuery(document).ready(function($){
var scrollBArray = [ "scrollbars=no",  /* rel="0" */
                     "scrollbars=yes" /* rel="1" */
                   ];
$('.newWindow').click(function (event){
var url = $(this).attr("href");
var w1 = $(this).attr("data-width"), h1 = $(this).attr("data-height");
var left  = ($(window).width()/2)-(w1/2),
    top   = ($(window).height()/2)-(h1/2);
var windowName = $(this).attr("id");
var scrollB = scrollBArray[$(this).attr("rel")];
window.open(url, windowName,"width="+w1+", height="+h1+", top="+top+", left="+left+", "+scrollB);
event.preventDefault();
      });
});

/*
|--------------------------------------------------------------------------
| Tooltip
|--------------------------------------------------------------------------
*/
jQuery(document).ready(function($) {
        // Tooltip only Text
        $('.pluginbuddy_tip').hover(function(){
                // Hover over code
                var title = $(this).attr('title');
                $(this).data('tipText', title).removeAttr('title');
                $('<p class="tooltip"></p>')
                .text(title)
                .appendTo('body')
                .fadeIn('slow');
        }, function() {
                // Hover out code
                $(this).attr('title', $(this).data('tipText'));
                $('.tooltip').remove();
        }).mousemove(function(e) {
                var mousex = e.pageX + 20; //Get X coordinates
                var mousey = e.pageY + 10; //Get Y coordinates
                $('.tooltip')
                .css({ top: mousey, left: mousex })
        });
});

/*
|--------------------------------------------------------------------------
| select  all button
|--------------------------------------------------------------------------
*/
function selectcopy(fieldid){
	var field=document.getElementById(fieldid) || eval('document.'+fieldid)
	field.select()
	if (field.createTextRange){ //if browser supports built in copy and paste (IE only at the moment)
		field.createTextRange().execCommand("Copy")
		alert("Value copied to clipboard!")
	}
}


