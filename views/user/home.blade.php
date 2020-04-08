@extends('user/layout', ['webpage_title'=>'Home'])

@section('content')
<style>
h1 {
    margin-top: 60px;
    font-size: 84px;
    margin-bottom: 30px;
    text-align: center;
}
</style>
<div class="container">
    <h1>
        Welcome <span class="UserFirstName"></span>
    </h1>
</div>

@endsection

@section('scripts')

<script>
$(function() {
    $('span.UserFirstName').html($$.getUser().FirstName);
});
</script>

@endsection