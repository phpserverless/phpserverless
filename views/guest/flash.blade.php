@extends('guest.layout',['shared_errors'=>false, 'webpage_title'=>$webpageTitle])

@section('title', $webpageTitle)

@section('content')
<div class="container">
    <br />
    <br />

    <!-- START: Message Area -->
    <div id="alert-area">
        <?php if ($flashSuccess != '') {?>
            <div class="alert alert-message alert-success data-alert">
                <a class="close" data-dismiss='alert'>×</a>
                <span class="fa fa-check-circle"></span>
                <?php echo $flashSuccess; ?>
            </div>
        <?php }?>
        <?php if ($flashError != '') {?>
            <div class="alert alert-message alert-danger data-alert">
                <a class="close" data-dismiss='alert'>×</a>
                <span class="fa fa-ban"></span>
                <?php echo $flashError; ?>
            </div>
        <?php }?>
        <?php if ($flashInfo != '') {?>
            <div class="alert alert-message alert-info data-alert">
                <a class="close" data-dismiss='alert'>×</a>
                <span class="fa fa-question-circle"></span>
                <?php echo $flashInfo; ?>
            </div>
        <?php }?>
        <?php if ($flashWarning != '') {?>
            <div class="alert alert-message alert-warning data-alert">
                <a class="close" data-dismiss='alert'>×</a>
                <span class="fa fa-warning"></span>
                <?php echo $flashWarning; ?>
            </div>
        <?php }?>
    </div>
    <!-- END: Message Area -->

    <!-- START: Continue Link -->
    <?php if ($flashUrl !== '') {?>
        <div class="container">
            <a href="<?php echo $flashUrl; ?>" style="color:red;">Continue &gt;&gt;</a>
        </div>
    <?php }?>
    <!-- END: Continue Link -->

    <!-- START: Timer -->
    <?php if ($flashUrl != '' && $flashTime != '') {?>
        <div class="container">
            <div style="padding:10px;font-size:11px;color:#666;">You will be automatically redirected in <span id="countdown"><?php echo $time; ?></span> s.</div>
            <script>
                function countdown(num) {
                    document.getElementById("countdown").innerHTML = num;
                    if (num > 0) {
                        setTimeout("countdown(" + (num - 1) + ")", 1000);
                    } else {
                        window.location.href = "<?php echo $flashUrl; ?>";
                    }
                }
                countdown(<?php echo $flashTime; ?>);
            </script>
        </div>
    <?php }?>
    <!-- END: Timer -->

</div>
@stop