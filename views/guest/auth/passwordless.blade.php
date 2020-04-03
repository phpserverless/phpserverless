@extends('guest.layout',['webpage_title'=>'Login'])

@section('content')
<div class="container">
    <!-- START: Message Area -->
    <div id="alert-area" class="col-sm-12" style="margin-left: 0px;"></div>
    <!-- END: Message Area -->

    <!-- START: Content -->
    <br />
    <br />


    <div class="alert alert-message alert-info">
        <a class="close" data-dismiss='alert'>×</a>
        <img data-icon="ionicons ios-repeat" style="width:24px;height:24px;color:white;" />
        We are currently checking your authentiication information.
        Please wait.
    </div>

    <div class="alert alert-message alert-success logged-in" style="display: none;">
        <a class="close" data-dismiss='alert'>×</a>
        <img data-icon="ionicons ios-checkmark-circle-outline" style="width:24px;height:24px;color:white;" />
        You successfully logged in.
        Please wait while we are redirecting you
    </div>

    <div class="alert alert-message alert-danger missing-token" style="display: none;">
        <a class="close" data-dismiss='alert'>×</a>
        <img data-icon="ionicons ios-close-circle-outline" style="width:24px;height:24px;color:white;" />
        Your login information seems incomplete.
        Please, try login in again.
    </div>

    <div class="alert alert-message alert-danger io-error" style="display: none;">
        <a class="close" data-dismiss='alert'>×</a>
        <img data-icon="ionicons ios-close-circle-outline" style="width:24px;height:24px;color:white;" />
        We are sorry. There was an internal error and could not process your request.
        Please, try login in again later.
    </div>
    <!-- END: Content -->
</div>
@endsection

@section('scripts')
<script>
$(function() {
    var once = $$.getUrlParam('once');
    if (once == null) {
        $('.alert').hide();
        $('.missing-token').show();
        return;
    }
    $$.ws('/auth/passwordless', {
        once: once
    }).then(function(data) {
        console.log(data);
    }).fail(function(error) {
        $('.alert').hide();
        $('.io-error').show();

        // Swal.fire({
        //     title: 'Error!',
        //     text: 'Sorry, login failed, due to IO error.',
        //     icon: 'error',
        //     confirmButtonText: 'Thanks'
        // });
        return;
    })
});
</script>
<!-- END: Scripts -->
@endsection