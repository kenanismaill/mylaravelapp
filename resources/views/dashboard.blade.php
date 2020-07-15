@extends('layouts.master')
@section('title')
    Dashboard
@endsection
@section('content')
    @include('includes.message-block')
    <section class="row new-post" >
        <div class="col-md-8 col-md-offset-3">
            <br>
            <header><h3> Say what you want bravely </h3>
            <br>


            </header>
            <br>
            <form action="{{route('createpost')}}" method="post">
                <div class="form-group">
                    <textarea class="form-control" rows="5" placeholder="your idea" name="body"
                              id="new-post"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Post</button>
                <input type="hidden" name="_token" value="{{Session::token() }}">
            </form>
        </div>
    </section>
    <section class="row posts">
        <div class="col-md-8 col-md-offset-3">
            <br>
            <header><h3> What other people think .... </h3></header>
            @foreach($posts as $post)
                <article class="post" data-postid="{{ $post->id }}">
                    <p style="border-radius: 20px; border: black 1px solid; margin-bottom: 10px; margin-right: 10px;text-align: center"> {{ $post->body }}</p>
                    <div class="info">
                        posted By {{ $post->user->first_name }} on {{ $post->created_at}}
                    </div>

                    <div class="interaction">
                        <a href="#" class="like">Like</a>|
                        <a href="#" class="like">Dislike</a>|
                        @if(Auth::user()==$post->user)
                            <a href="#" class="edit">Edit</a>|
                            <a href="{{ route('deletepost',['post_id'=>$post->id]) }}">Delete</a>
                        @endif

                    </div>
                    <hr>
                </article>

            @endforeach
            <br>
        </div>
    </section>
    <div class="modal" tabindex="-1" role="dialog" id="edit-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Your Idea</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                  <form>
                      <div class="form-group">
                          <label for="post-body"> Edit Your Idea Post </label>
                          <textarea class="form-control" name="post-body" id="post-body" rows="3"></textarea>
                      </div>
                  </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="modal-save">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        var token =' {{Session::token()}}'
        var urledit ='{{ route('edit') }}';
        var urllike ='{{ route('like') }}';
    </script>
@endsection
