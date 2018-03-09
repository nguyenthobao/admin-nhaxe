// Numeric only control handler
jQuery.fn.numericOnly =
function()
{
    return this.each(function()
    {
        $(this).keyup(function () {     
		  	this.value = this.value.replace(/[^1-9\.]/g,'');
		});
    });
};