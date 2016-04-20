// Set a global variables
var tagList = [];
var referenceList = [];

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
	// We can use the tagList to firstly check whether there is already a tag
	// with our input value or not.
	for(i = 0; i < tagList.length; i++)
	{
		if($("#tagSearchBox").val() == tagList[i])
		{
			// We already have that tag: display an error and return
			displayInfo("That tag is already in your tag list");
			// Empty the search box
			$("#tagSearchBox").val("");
			return;
		}
	}
	// Do we have at least one item?
	if(!tagList)
	tagList = [$("#tagSearchBox").val()];
	else
	{
		// We don't have that tag yet, so push it
		tagList.push($("#tagSearchBox").val());
	}
	$("#tagList").append('<div class="btn btn-primary" onClick="$(this).fadeOut(function() { $(this).remove(); })"><input type="hidden" value="'+$("#tagSearchBox").val()+'" name="tags[]">'+$("#tagSearchBox").val()+' <button type="button" class="close" title="Remove" onClick="$(this).parent().fadeOut(function() { $(this).remove(); })"><span aria-hidden="true">&times;</span></button></div>');
	$("#tagSearchBox").val("");
}

// Adds a reference on the create and show (blade.php) forms
function addReference(referenceId = 0)
{
	if(referenceId <= 0)
	return;

	// We can use the referenceList to firstly check whether there is already a tag
	// with our input value or not.
	for(i = 0; i < referenceList.length; i++)
	{
		if($("#referenceSearchBox").val() == referenceList[i])
		{
			// We already have that tag: display an error and return
			displayInfo("That reference is already in your references list");
			$("#referenceSearchBox").val("");
			return;
		}
	}
	// Do we have at least one item?
	if(!referenceList)
	referenceList = [$("#referenceSearchBox").val()];
	else
	{
		// We don't have that tag yet, so push it
		referenceList.push($("#referenceSearchBox").val());
	}

	$("#referenceList").append('<div class="alert alert-success alert-dismissable"><input type="hidden" value="'+referenceId+'" name="references[]">'+$("#referenceSearchBox").val()+' <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
	$("#referenceSearchBox").val("");
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
	});
	myPanel.bind("keydown", "up", function(e) {
		// Is there a prev element?
		if(!$(this).prev().children()[0])
		return;

		$(this).unbind("keydown");
		$(this).removeAttr("tabindex");
		$(this).prev().children(".panel-heading")[0].click();
		closeNote($(this));
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
		{
			console.log(data.tags[i].name);
			tagArray.push('<button class="btn btn-primary tag">'+data.tags[i].name+'</button>\n');
		}


		// Do we already have a panel-body?
		if(! myPanel.children(".panel-body")[0])
		myPanel.append('<div class="panel-body" style="display:none;" id="note-'+ id +'-content">'+ data.content +'<hr>'+tagArray.join("")+'</div>');

		// Add highlight class to parent element.
		myPanel.removeClass("panel-info");
		myPanel.addClass("panel-primary");
		myPanel.children(".panel-body").slideDown("fast");

		// At last scroll to the panel. Because it looks nice.
		$('html, body').animate({
			// add the body padding (fixed navbar hack)
			scrollTop: myPanel.offset().top - parseInt($("body").css("paddingTop"))
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
