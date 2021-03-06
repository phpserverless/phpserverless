/*
 * If not guest, redirect to user dashboard
 */

$(function () {
  if ($$.getUser() !== null && $$.getToken() !== null) {
    if ($$.getUser().Status == "Active") {
      if ($$.getUrl().indexOf("logout") < 0) {
        $$.to("user/home");
      }
    }
    if ($$.getUser().Status == "Pending") {
      if ($$.getUrl().indexOf("register") < 0) {
        $$.to("auth/register");
      }
    }
  }
});
