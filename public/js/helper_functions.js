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
    
function setFocus(myPanel)
{
	// Bind keyup / keydown to this (and ONLY this element!)
   	myPanel.attr("tabindex", "1");
   	myPanel.focus();
   	// Moving down
   	myPanel.bind("keydown", "down", function(e) {
   		// Is there a next element?
   		if(!$(this).next().children()[0])
   			return;
   		
   		$(this).unbind("keydown");
   		$(this).removeAttr("tabindex");
   		$(this).next().children(".panel-heading")[0].click();
   		closeNote($(this));
   		/*$(this).children(".panel-body").slideUp("fast", function() {
   			// Remove highlight class
   			$(this).parent().removeClass("panel-primary");
   			$(this).remove();
   		});*/
   	});
   	myPanel.bind("keydown", "up", function(e) {
   		// Is there a prev element?
   		if(!$(this).prev().children()[0])
   			return;
    		
   		$(this).unbind("keydown");
   		$(this).removeAttr("tabindex");
   		$(this).prev().children(".panel-heading")[0].click();
   		closeNote($(this));
   		/*$(this).children(".panel-body").slideUp("fast", function() {
   			// Remove highlight class
   			$(this).parent().removeClass("panel-primary");
   			$(this).remove();
   		})*/;
   	});
}

// Exporting open() and close() functions ...
function openNote(myPanel)
{
	id = myPanel.attr("id");
		// Ask the server via Ajax
  	$.getJSON(ajaxNoteBaseUrl + "/" + id, function(data) {
   		// "Arrayfy" the tags
   		tagArray = [];
       	for(i = 0; i < data.tags.length; i++)
       		tagArray.push('<button class="btn btn-primary">'+data.tags[i].name+'</button>\n');
   		
   		// Do we already have a panel-body?
   		if(! myPanel.children(".panel-body")[0])
   			myPanel.append('<div class="panel-body" style="display:none;" id="note-'+ id +'-content">'+ data.content +'<hr>'+tagArray.join("")+'</div>');
   		
   		// Add highlight class to parent element.
   		myPanel.addClass("panel-primary");
   		myPanel.children(".panel-body").slideDown("fast");
   		
   		// At last scroll to the panel. Because it looks nice.
   		$('html, body').animate({
   			scrollTop: myPanel.offset().top
   			}, 100);
   		
   		setFocus(myPanel);
   	})
   	.fail(function() {
   		displayError("Couldn't find note.");
   	});
}

function closeNote(myPanel)
{
	myPanelBody = myPanel.children(".panel-body");
	myPanelBody.slideUp("fast", function() {
   			
   		myPanel.removeClass("panel-primary");
   		myPanelBody.remove();
   	});
}
