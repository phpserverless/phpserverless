@extends('user/layout', ['webpage_title'=>'Home'])

@section('content')

<div class="container">
    Welcome <span class="UserFirstName"></span>
</div>

@endsection

@section('scripts')

<script>
$(function() {
    $('span.UserFirstName').html($$.getUser().FirstName);
});
</script>

@endsection