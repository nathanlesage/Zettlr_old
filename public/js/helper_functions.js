function displayError(msg)
	{
		noty({
            		text        : msg,
            		type        : 'error',
            		dismissQueue: true,
            		timeout     : 2000,
            		closeWith   : ['click'],
            		layout      : 'bottomCenter',
            		theme       : 'defaultTheme',
            		maxVisible  : 10
        			});
	}
function displaySuccess(msg)
	{
		noty({
            		text        : msg,
            		type        : 'success',
            		dismissQueue: true,
            		timeout     : 2000,
            		closeWith   : ['click'],
            		layout      : 'bottomCenter',
            		theme       : 'defaultTheme',
            		maxVisible  : 10
        			});
	}
function displayInfo(msg)
	{
		noty({
            		text        : msg,
            		type        : 'info',
            		dismissQueue: true,
            		timeout     : 2000,
            		closeWith   : ['click'],
            		layout      : 'bottomCenter',
            		theme       : 'defaultTheme',
            		maxVisible  : 10
        			});
	}
function displayWarning(msg)
	{
		noty({
            		text        : msg,
            		type        : 'warning',
            		dismissQueue: true,
            		timeout     : 2000,
            		closeWith   : ['click'],
            		layout      : 'bottomCenter',
            		theme       : 'defaultTheme',
            		maxVisible  : 10
        			});
	}
	
// Adds a tag on the create and show (blade.php) forms
function addTag()
    {
    	$("#tagList").append('<div class="alert alert-info alert-dismissable"><input type="hidden" value="'+$("#tagSearchBox").val()+'" name="tags[]">'+$("#tagSearchBox").val()+' <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      		$("#tagSearchBox").val("");
    }
