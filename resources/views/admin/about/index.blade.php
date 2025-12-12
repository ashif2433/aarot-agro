@extends('layouts.admin.e-commerce.app')

@section('title', $config['name'].' List')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>{{ $config['name'] }} List</h4>
        <a href="{{ route('admin.about.create', $section) }}" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> Add
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="60">#</th>
                        <th>Title</th>
                        @if($config['has_image'])
                            <th width="120">Image</th>
                        @endif
                        <th width="80">Status</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $key => $row)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $row->title }}</td>
                            @if($config['has_image'])
                                <td>
                                    @if($row->image)
                                        <img src="{{ asset('storage/'.$row->image) }}" alt="" style="max-width:100px;">
                                    @endif
                                </td>
                            @endif
                            <td>
                                @if($row->status)
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-danger">Deactive</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.about.edit', [$section, $row->id]) }}"
                                   class="btn btn-sm btn-info">
                                    Edit
                                </a>

                                <form action="{{ route('admin.about.destroy', [$section, $row->id]) }}"
                                      method="POST"
                                      style="display:inline-block;"
                                      onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $config['has_image'] ? 5 : 4 }}" class="text-center">
                                No data found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
