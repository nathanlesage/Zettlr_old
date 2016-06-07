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

// Adds a tag on the create and show forms
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
    $("#tagList").append('<div class="btn btn-primary tag" onClick="$(this).fadeOut(function() { $(this).remove(); })"><input type="hidden" value="'+$("#tagSearchBox").val()+'" name="tags[]">'+$("#tagSearchBox").val()+' <button type="button" class="close" title="Remove" onClick="$(this).parent().fadeOut(function() { $(this).remove(); })"><span aria-hidden="true">&times;</span></button></div>');
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

/**
*  Wrapper function to prevent codifying if not in edit mode
*
*  @param   {DOM}  myElem  DOM object to be codified
*  @param   {integer}  index   The note's index
*
*  @return  {void}
*/
function codifyOnEdit(myElem, index)
{
    if(editMode)
    codify(myElem, index);
}

/**
 *  Helper function to take myElem and index into the success function
 *
 *  @param   {DOM}  myElem  The element to replace
 *  @param   {integer}  index   index of this note
 *
 *  @return  {function}          Returns the original handler function
 */
var successWithElem = function(myElem, index) {

    return function(data, textStatus, jqXHR)
    {
        $(myElem).replaceWith('<textarea class="form-control" data-former-tag="' + $(myElem).prop('tagName') + '" name="'+index+'" id="gfm-code">' + data.content + '</textarea>');

        var editor = CodeMirror.fromTextArea(document.getElementById("gfm-code"), {
            mode: 'gfm',
            lineNumbers: true,
            viewportMargin: Infinity,
            theme: "default",
            lineWrapping: true,
            autofocus: true,
            // Set Tab to false to focus next input
            // And let Shift-Enter submit the form.
            extraKeys: { "Shift-Enter": deCodify }
        });

        // Display an info that one can close this via Return
        displayInfo("Finish editing by pressing Shift+Return");
    }
}

/**
*  Turns any element to a content-editable markdown editor
*
*  @param   {mixed}  myElem  DOM element to be turned to a CodeMirror field
*  @param   {integer}  index  The notes index (does NOT correspond to note id!)
*  @param   {bool}   eval    Whether or not we should re-evaluate
*
*  @return  {void}
*/
function codify(myElem, index)
{
    // First check if there are other to edit (then close them first)
    if($("#gfm-code").length)
        deCodify($('.CodeMirror')[0].CodeMirror);

    // Retrieve the note's index - format: title[index]
    // index = $(myElem).find("textarea[class='hidden']").attr("name").match(/([0-9]{1,})/)[0];

    // Two possible situations: a PRE-tag with the raw data or a DIV-tag with
    // parsed data. In the last case we need to get the raw data from the server

    if($(myElem).is("div"))
    {
        $.get(appBaseUrl + '/ajax/note/' + index + "/true")
        .success(successWithElem(myElem, index))
        .fail(function(data) {
            displayError("Could not load contents to edit");
        });
    }
    else {
        // We have a pre-Tag and must fill our element with this data
        // To prevent double-filling the note contents (with also the content of
        // the hidden text area) we have to deleted this hidden textarea first.
        $(myElem).find("textarea").remove();
        $(myElem).replaceWith('<textarea class="form-control" data-former-tag="' + $(myElem).prop('tagName') + '" name="'+index+'" id="gfm-code">' + $(myElem).text() + '</textarea>');

        var editor = CodeMirror.fromTextArea(document.getElementById("gfm-code"), {
            mode: 'gfm',
            lineNumbers: true,
            viewportMargin: Infinity,
            theme: "default",
            lineWrapping: true,
            autofocus: true,
            // Set Tab to false to focus next input
            // And let Shift-Enter submit the form.
            extraKeys: { "Shift-Enter": deCodify }
        });

        // Display an info that one can close this via Return
        displayInfo("Finish editing by pressing Shift+Return");
    }
}

/**
*  Restores the original element that has been edited
*
*  @param   {CodeMirror}  cm  The CodeMirror object to be destroyed
*
*  @return  {void}
*/
function deCodify(cm)
{
    // We have two possible situations deCodify will be called upon:
    // Either we have an imported form OR we have an outline in edit mode.
    // On first occasion, we can just restore the pre-element with the content
    // but in outline mode, we HAVE to re-evaluate the contents and then reload.

    if($('#gfm-code').attr('data-former-tag') === "PRE")
    {
        cm.save();
        cm.toTextArea();

        id = $("#gfm-code").attr("name");
        $("#gfm-code").replaceWith('<pre onClick="codify($(this), '+id+')">'
        + '<textarea class="hidden" name="content['+id+']">'+$("#gfm-code").val()+'</textarea>'
        + $("#gfm-code").val() + '</pre>');
    }
    else { // We got our option two: outline in edit mode
        // Take the textarea, send the contents to the updateNote ajax controller
        // Then reload the note contents (we can utilize the interface used on
        // notes/index)
        //
        csrf = $('#csrf').val();
        var noteID = $('#gfm-code').attr('name');
        cm.save();
        noteContent = $('#gfm-code').val();

        $.post(appBaseUrl + '/ajax/note/update',
        {
            id: noteID,
            content: noteContent,
            title: '',
            _token: csrf
        }, function(data) {
            cm.toTextArea();
            // The server should have given us the note contents
            // So let's insert them!
            $('#gfm-code').replaceWith(
                '<div onClick="codifyOnEdit($(this), '+noteID+')">' + data + '</div>'
            );
        });
    }
}
