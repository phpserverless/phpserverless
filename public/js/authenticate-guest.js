/*
 * If not guest, redirect to user dashboard
 */

$(function () {
    if ($$.getUser() !== null) {
        $$.to('user/home');
    }
    if ($$.getToken() !== null) {
        $$.to('user/home');
    }
});