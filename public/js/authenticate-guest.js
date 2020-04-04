/*
 * If not guest, redirect to user dashboard
 */

$(function() {
  if ($$.getUser() !== null && $$.getToken() !== null) {
    if ($$.getUser().Status == "Active") {
      $$.to("user/home");
    }
    if ($$.getUser().Status == "Pending") {
      if ($$.getUrl().indexOf("register") < 0) {
        $$.to("auth/register");
      }
    }
  }
});
