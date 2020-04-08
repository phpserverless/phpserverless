@extends('guest.layout', ['webpage_title'=>'Login'])

@section('content')
<div class="container">
    <!-- START: Content -->
    <br />
    <br />


    <div class="alert alert-message alert-info">
        <a class="close" data-dismiss='alert'>×</a>
        <img data-icon="ionicons ios-repeat" style="width:24px;height:24px;color:white;" />
        We are currently logging you.
        Please wait.
    </div>

    <div class="alert alert-message alert-success logged-out" style="display: none;">
        <a class="close" data-dismiss='alert'>×</a>
        <img data-icon="ionicons ios-checkmark-circle-outline" style="width:24px;height:24px;color:white;" />
        You were successfully logged out.
        Thank you.
    </div>

    <div class="alert alert-message alert-danger logout-unsuccessful" style="display: none;">
        <a class="close" data-dismiss='alert'>×</a>
        <img data-icon="ionicons ios-close-circle-outline" style="width:24px;height:24px;color:white;" />
        We are sorry. Logging out was unsuccessful.
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
    var p = $$.ws("auth/logout", {});
    p.then(function(response) {
        if (response.status != "success") {
            alert(response.message);
            $('.alert').hide();
            $('.logout-unsuccessful').show();
            return;
        }

        $$.setUser(null);
        $$.setToken(null);

        $$.to('/');

        $('.alert').hide();
        $('.logged-out').show();
        return;
    });
    p.fail(function(error) {
        $('.alert').hide();
        $('.io-error').show();
        return;
    })
});


// Swal.fire({
//     title: 'Error!',
//     text: 'Sorry, login failed, due to IO error.',
//     icon: 'error',
//     confirmButtonText: 'Thanks'
// });
</script>
<!-- END: Scripts -->
@endsection