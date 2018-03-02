@if(count($errors))
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert">
            <i class="ace-icon fa fa-times"></i>
        </button>
        @foreach($errors->all() as $error)
            <strong>
                错误：
            </strong>
            <span class="resp-error"> {{$error}}</span>

            <br>
        @endforeach
    </div>

@endif


@if(session()->has('success'))
    <div class="alert alert-block alert-success">
        <button type="button" class="close" data-dismiss="alert">
            <i class="ace-icon fa fa-times"></i>
        </button>

        <strong>
            <i class="ace-icon fa fa-check"></i>
        </strong>
        <span class="resp-success">{{session()->get('success')}}</span>
    </div>
@endif


@if(session()->has('error'))
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert">
            <i class="ace-icon fa fa-times"></i>
        </button>
        <strong>
            错误：
        </strong>
        <strong class="resp-error">{{session()->get('error')}}</strong>

        <br>
    </div>
@endif


@if(session()->has('warning'))

    <div class="alert alert-warning">
        <button type="button" class="close" data-dismiss="alert">
            <i class="ace-icon fa fa-times"></i>
        </button>
        <strong>注意：</strong>

        {{session()->get('warning')}}
        <br>
    </div>

@endif


@if(session()->has('info'))

    <div class="alert alert-info">
        <button type="button" class="close" data-dismiss="alert">
            <i class="ace-icon fa fa-times"></i>
        </button>
        <strong>提示：</strong>

        {{session()->get('info')}}
        <br>
    </div>

@endif