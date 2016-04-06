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
