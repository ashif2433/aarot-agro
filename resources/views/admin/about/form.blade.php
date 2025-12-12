@extends('layouts.admin.e-commerce.app')

@section('title', ($item->id ? 'Edit ' : 'Add ').$config['name'])

@push('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css" rel="stylesheet">
@endpush

@section('content')
<div class="container-fluid">
    <h4>{{ $item->id ? 'Edit ' : 'Add ' }} {{ $config['name'] }}</h4>

    <div class="card">
        <div class="card-body">

            <form action="{{ $route }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if($method === 'PUT')
                    @method('PUT')
                @endif

                <div class="form-group">
                    <label>Title<span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control"
                           value="{{ old('title', $item->title) }}" required>
                    @error('title') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="form-control summernote">{!! old('description', $item->description) !!}</textarea>
                    @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                @if($config['has_image'])
                    <div class="form-group">
                        <label>Image</label>
                        <input type="file" name="image" class="form-control">
                        @error('image') <small class="text-danger">{{ $message }}</small> @enderror

                        @if($item->image)
                            <div class="mt-2">
                                <img src="{{ asset('storage/'.$item->image) }}" alt="" style="max-width:120px;">
                            </div>
                        @endif
                    </div>
                @endif

                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="1" {{ old('status', $item->status ?? 1) == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('status', $item->status ?? 1) == 0 ? 'selected' : '' }}>Deactive</option>
                    </select>
                    @error('status') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <button class="btn btn-success">Save</button>
                <a href="{{ route('admin.about.index', $section) }}" class="btn btn-secondary">Back</a>
            </form>

        </div>
    </div>
</div>
@endsection

@push('js')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.js"></script>
    <script>
    $(document).ready(function() {
        $('.summernote').summernote({
            height: 300,
            tabsize: 2,
            placeholder: 'Write description...'
        });
    });
    </script>

@endpush
