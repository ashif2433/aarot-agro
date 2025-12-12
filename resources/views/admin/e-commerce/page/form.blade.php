@extends('layouts.admin.e-commerce.app')

@section('title', 'Ticket List')
@push('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="/assets/plugins/select2/css/select2.min.css">
    <link type="text/css" rel="stylesheet" href="/assets/plugins/file-uploader/image-uploader.min.css">
    
    <!-- Latest Summernote v0.9.0 -->
     <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
     <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs4.min.css" rel="stylesheet"> -->
    <style>
        /* Prevent full width images/tables */
        .note-editable table {
            width: auto !important;
            max-width: 100% !important;
            margin: 0 !important;
            border-collapse: collapse !important;
        }

        .note-editable table,
        .note-editable td,
        .note-editable th {
            resize: both !important;
            overflow: auto !important;
        }

        .note-editable img {
            display: inline-block !important;
            position: relative !important;
            max-width: 100% !important;
            height: auto !important;
        }
    </style>

  
@endpush


@section('content')

<!-- Main content -->
<section class="content">
    @isset($page)
    <form action="{{ route('admin.page.update')}}" method="POST">
        <input type="hidden" value="{{$page->id}}" name="id">
    @else
    <form action="{{ route('admin.page.make')}}" method="POST">
    @endif
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input value="{{ $page->name ?? old('name') }}" type="text" name="name"  class="form-control" value="" >
                        </div>
                        <div class="form-group">
                            <label for="name">Title:</label>
                            <input value="{{ $page->title ?? old('title') }}" type="text" name="title"  class="form-control" value="" >
                        </div>
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea name="body"id="full_description"  cols="5" placeholder="Write size description" class="form-control" >{{ $page->body ?? old('body') }}</textarea>
                        </div> 
                        <div class="form-group">
                            <label for="description">Position:</label>
                            <select class="form-control" name="position" id="">
                                <option  @isset($page) {{ $page->position==0 ? 'selected':''  }} @endisset value="0">Nav</option>
                                <option  @isset($page){{  $page->position==1 ? 'selected':''  }} @endisset value="1">bottom</option>
                                 <option  @isset($page){{  $page->position==2 ? 'selected':''  }} @endisset value="2">Both</option>
                            </select>
                        </div> 
                        <div class="form-group">
                            <label for="description">Status:</label>
                            <select class="form-control" name="status" id="">
                                <option  @isset($page){{  $page->status==0 ? 'selected':''  }} @endisset value="1">Active</option>
                                <option  @isset($page) {{ $page->status==1 ? 'selected':'' }}  @endisset value="0">Deactive</option>
                            </select>
                        </div> 
                        
                    </div>
                    <div class="card-footer">
                        <div class="form-group">
                            <button class="mt-1 btn btn-primary">
                                    <i class="fas fa-arrow-circle-up"></i>
                                    Create
                            </button>
                        </div>
                    </div>
                </form>
    

</section>
<!-- /.content -->

@endsection

@push('js')
    <!-- Select2 -->
    <script src="/assets/plugins/select2/js/select2.full.min.js"></script>
    <script src="{{ asset('/assets/plugins/dropify/dropify.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs4.min.js"></script> -->
    <script type="text/javascript" src="/assets/plugins/file-uploader/image-uploader.min.js"></script>

    

    <script>
        $(document).ready(function () {
            $('.select2').select2();
            $('.dropify').dropify();

            $('#full_description').summernote({
                height: 600,
                followingToolbar: true,

                toolbar: [
                    ['style', ['style', 'bold', 'italic', 'underline', 'strikethrough', 'clear']],
                    ['font', ['fontname', 'fontsize', 'color']],
                    ['para', ['ul', 'ol', 'paragraph', 'height']],
                    ['insert', ['picture', 'link', 'table', 'hr']],
                    ['misc', ['undo', 'redo']],
                    ['view', ['fullscreen', 'codeview']]
                ],

                callbacks: {

                    /* 🔥 ADD THIS PART FOR IMAGE UPLOAD */
                    onImageUpload: function(files) {

                        let data = new FormData();
                        data.append("file", files[0]);
                        data.append("_token", "{{ csrf_token() }}");

                        $.ajax({
                            url: "{{ route('summernote.upload') }}", // your upload route
                            method: "POST",
                            data: data,
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                $('#full_description').summernote('insertImage', response.url);
                            }
                        });
                    },
                    /* 🔥 END OF IMAGE UPLOAD PART */

                    onInit: function() {
                        $(".note-editable img").css("cursor", "move");

                        $(".note-editable").on("mousedown", "img", function(e) {
                            let img = $(this);
                            img.addClass("dragging");

                            $(document).on("mousemove.dragImage", function(e) {
                                img.css({
                                    position: "absolute",
                                    left: e.pageX - 50,
                                    top: e.pageY - 50
                                });
                            });

                            $(document).on("mouseup.dragImage", function() {
                                img.removeClass("dragging");
                                $(document).off(".dragImage");
                            });
                        });
                    }
                }
            });
        });
    </script>
 
@endpush
