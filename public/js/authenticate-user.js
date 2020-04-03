/*
 * If not user, redirect to guest home
 */
$(function() {
  if ($$.getUser() === null) {
    return $$.to("/");
  }
  if ($$.getToken() === null) {
    return $$.to("/");
  }
  // Register, if name empty
  if ($$.getUrl().indexOf("register") < 0) {
    console.log($$.getUser().FirstName);
    if ($$.getUser().FirstName == "") {
      return $$.to("user/register");
    }
  }
});
