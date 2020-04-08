<style>
.main-menu {
    font-size: 16px;
}
</style>
<template id="menu">
    <ul class="list-group main-menu">
        <li class="list-group-item">
            <a class="nav-link" href="<?php echo \App\Helpers\Links::guestHome(); ?>">
                Home
            </a>
        </li>
        <li class="list-group-item">
            <a class="nav-link" href="<?php echo \App\Helpers\Links::authLogout(); ?>">
                Logout
            </a>
        </li>
    </ul>
</template>
<script>
function openMenu() {
    var html = $('template#menu').html();
    Swal.fire({
        title: 'QUICK MENU',
        html: html,
        __icon: 'info',
        confirmButtonText: 'Close',
        showClass: {
            popup: 'animated fadeInDown faster'
        },
        hideClass: {
            popup: 'animated fadeOutUp faster'
        }
    })
}
</script>