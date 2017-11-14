@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-primary">
                    <div class="panel-heading">Comments</div>
                    <div class="panel-body">
                        @foreach ($comments as $comment)
                            <p>{{ $comment->description }}</p>
                            <hr>
                        @endforeach
                        @if (count($comments) === 0)
                            There are no comments about this item.
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-primary">
                    <div class="panel-heading">New Comment</div>
                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="{{ route('store')  }}">
                            {{ csrf_field() }}
                            <input type="hidden" id="item_id" name="item_id" value="{{ $item_id }}">
                            <div class="form-group{{ $errors->has('comment') ? ' has-error' : '' }}">
                                <label for="comment" class="col-md-4 control-label">Your Comment</label>

                                <div class="col-md-6">
                                    <textarea id="comment" class="form-control"
                                              name="comment">{{ old('comment') }}</textarea>

                                    @if ($errors->has('comment'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('comment') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Post
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection