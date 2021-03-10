@extends('layouts.app')

@section('styles')
<!-- Font Awesome -->
<link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
<!-- Theme style -->
<link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
<!-- summernote -->
<link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.css') }}">
@endsection

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Text Message</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Text Message</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title">
                        Text Message
                        <small>Text message to send mail</small>
                    </h3>
                    <!-- tools box -->
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse"
                            data-toggle="tooltip" title="Collapse">
                            <i class="fas fa-minus"></i></button>
                    </div>
                    <!-- /. tools -->
                </div>
                <!-- /.card-header -->
                <form method="post">
                    @csrf

                    <div class="card-body pad">
                        @if(Session::has('message'))
                        <div class="alert alert-success">
                            {{ Session::get('message') }}
                        </div>
                        @endif
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </div>
                        @endif
                        <div class="mb-3">
                            <textarea class="textarea" name="body" placeholder="Place some text here"
                                style="width: 100%; height: 400px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ old('body') }}</textarea>
                        </div>
                        <p class="text-sm mb-0 float-left">
                            Message Editor
                            </a>
                        </p>
                        <button type="submit" class="btn btn-sm btn-success float-right">Save</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.col-->
    </div>
    <!-- ./row -->

    <div class="row">
        <div class="col-md-10 m-auto">
            @foreach($messages as $message)
            <div class="card h-50 float-left m-1 border @if($message->status == 1)  border-success @else  border-primary @endif " style="width: 48%">
                <div class="card-header">
                    <div class="row">
                        <div class="col-4">
                            @if($message->status == 1)
                            <span class="badge badge-success">Active</span>
                            @endif
                        </div>
                        <div class="col-8">
                            <a href="{{ url('remove-text-message',$message->id) }}" class="btn btn-danger btn-sm float-right ml-2">Remove</a>
                            <a href="{{ url('update-text-message',$message->id) }}" class="btn btn-primary btn-sm float-right">Edit</a>

                        </div>
                    </div>
                </div>
                <div class="card-body" style="height: 400px;overflow-y: scroll;">
                    {!! $message->body !!}
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!-- /.content -->
@endsection

@section('scripts')
<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js')  }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('plugins/summernote/summernote.js') }}"></script>
<script>
    $(function () {
    // Summernote
    $('.textarea').summernote()
  })
</script>

</script>
@endsection
