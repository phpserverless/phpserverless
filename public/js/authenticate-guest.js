/*
 * If not guest, redirect to user dashboard
 */

$(function() {
  if ($$.getUser() !== null && $$.getToken() !== null) {
    if ($$.getUser().Status == "Active") {
      $$.to("user/home");
    }
    if ($$.getUser().Status == "Pending") {
      $$.to("auth/register");
    }
  }
});
