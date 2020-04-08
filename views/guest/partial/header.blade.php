<!-- START: Top Menu -->
@include('guest/partial/menu')
<style scoped="scoped">
.navbar .navbar-brand {
    font-weight: 900;
}

.navbar .btn {
    border: 0px;
}
</style>
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <table style="width:100%">
            <tr>
                <td align="left" valign="middle" style="width:100px;">
                    <a class="navbar-brand" href="/" title="Home - PHP Serverless">
                        PHP Serverless
                    </a>
                </td>
                <td align="center" valign="middle">
                    &nbsp;
                </td>
                <td align="right" valign="middle" style="width:200px;">
                    <button class="btn btn-md btn-box-tool" style="color:#333;background: white;" onclick="openMenu()">
                        &#9776; menu
                    </button>
                    <a href="<?php echo \App\Helpers\Links::authPasswordlessUrl(); ?>" class="btn btn-md btn-box-tool"
                        style="color:#333;background: white;">
                        <img title="Login" data-icon="ionicons ios-log-in" style="width:16px;height:16px;color:red;" />
                        login
                    </a>
                </td>
            </tr>
        </table>
    </div>
</nav>
<!-- END: Top Menu -->