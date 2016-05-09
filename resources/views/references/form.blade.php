@extends('app')

<script>
@section('scripts_on_document_ready')
// Initialize dropzone
$("#drop").dropzone({
    url: "{{ url('ajax/import/collect') }}",
    // method: put <-- Remember for RESTful implementation
    // parallelUploads
    maxFilesize: 8, // 2 MB maximum
    paramName: "import_tmp", // Filename
    acceptedFiles: ".bib",
    previewTemplate: document.getElementById('dropzoneFileTemplate').innerHTML,
    init: function() {
        this.on('success', function(file) {
            $(file.previewElement).find('div[role="progressbar"]').append(document.createTextNode("Upload successful!"));
            $(file.previewElement).find("img").remove();
        });
        this.on('addedfile', function(file) {
            // TODO: I don't like traversing up a directory...
            file.previewElement.querySelector("img").src = "../img/loading_spinner.gif";
        });
        this.on("sending", function(file) {
            $("#total").parent().removeClass("hidden");
            $("#importSubmit").prop("disabled", true);
        });
        this.on("totaluploadprogress", function(progress, bytes, bytesSend) {
            $("#total").removeClass("progress-bar-danger progress-bar-warning progress-bar-danger");

            $("#totalinfo").html("Uploading &hellip; (" + Math.round(bytesSend/1000) + " kB/" + Math.round(bytes/1000) + " kB)")

            if(progress < 33)
            $("#total").addClass("progress-bar-danger");
            else if(progress < 66)
            $("#total").addClass("progress-bar-warning");
            else
            $("#total").addClass("progress-bar-success");

            if(progress == 100) {
                $("#total").parent().addClass("hidden");
                $("#totalinfo").html("Upload complete!");
                $("#importSubmit").prop("disabled", false);
            }

            console.log(progress);

            $("#total").css("width", progress + "%");
        });
    },
    sending: function(file, xhr, formData) {
        formData.append("_token", "{{ csrf_token() }}");
        formData.append('type', 'bibtex');
    },
    error: function(file, errorMessage, xhr) {
        $(file.previewElement).find("img").remove();
        $(file.previewElement).find('div[role="progressbar"]').addClass("progress-bar-danger");
        console.log(errorMessage);
        displayError("An error occured while uploading file: " + errorMessage);
    }
});
@endsection
</script>

@section('content')
    <!--Temporary: for styling -->
    <style>
    /* Pulse */
    @-webkit-keyframes pulse {
        0% {
            background-color:white;
        }

        50% {
            background-color:#ddeedd;
        }
    }

    @keyframes pulse {
        0% {
            background-color:white;
        }

        50% {
            background-color:#ddeedd;
        }
    }
    div.dz-drag-hover {
        border:4px solid #15c707;
        -webkit-animation-name: pulse;
        animation-name: pulse;
        -webkit-animation-duration: 2s;
        animation-duration: 2s;
        -webkit-animation-timing-function: linear;
        animation-timing-function: linear;
        -webkit-animation-iteration-count: infinite;
        animation-iteration-count: infinite;
    }
    div.dz-clickable {
        min-height:200px;
        border-radius:5px;
        cursor:pointer;
        -webkit-transition: 0.2s ease;
        transition: 0.2s ease;
    }
    div.dz-preview {
        background-color:#efe;
        color:#333;
        margin:10px 10px 10px 10px;
        padding:10px;
    }
    div.dz-message {
        font-size:25px;
        font-weight:bold;
        text-align: center;
        cursor:pointer;
    }
    div.dz-error {
        color:red;
    }
    </style>
    <div class="hidden clearfix" id="dropzoneFileTemplate">
        <div class="media dz-preview dz-file-preview">
            <div class="media-left media-middle">
            </div>
            <div class="dz-details media-body">
                <div>
                    <div class="dz-filename"><span data-dz-name></span> <img data-dz-thumbnail style="height:auto; width:20px;"> <span class="pull-right">(<span data-dz-size ></span>)</span></div>
                </div>
                <div class="dz-progress">
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" data-dz-uploadprogress>
                        </div>
                    </div></div>
                    <div class="dz-error"><span data-dz-errormessage></span></div>
                </div>
            </div>
        </div>
    </div>

    <!-- For now just display a simple form -->
    <div class="container" style="background-color:white;">
        <div class="page-header">
            <h1>Import BibTex <small>Step #1: Choose files</small></h1>
        </div>
        <div class="alert alert-info">
            Welcome to file uploading! The process of uploading is divided into two steps. First choose BibTex-files with references to upload. In a second step, you will be able to review your uploads and make sure everything is correctly imported.<br><br><strong>Only *.bib files are supported</strong>.<br><br>
            Currently, only the following item types are allowed:
                @foreach($types as $type)
                    {{ $type }},
                @endforeach
            </ul>
        </div>

        <div>
            <div id="totalinfo"></div>
            <div class="progress hidden" title="Total progress" data-toggle="tooltip">
                <div class="progress-bar progress-bar-striped active" role="progressbar" id="total" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" data-dz-uploadprogress>
                </div>
            </div>
        </div>
        <div id="drop">
            <div class="dz-message">Drop files or click to upload</div>
        </div>
        <hr>
        <div class="form-group">
            <a href="{{ url('references/import/confirm') }}"><button type="submit" id="importSubmit" class="form-control btn btn-primary">Next</button></a>
        </div>
    @if(count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
@endsection
