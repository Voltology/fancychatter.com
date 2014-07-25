var system = {
  deleteSession : function() {
    //$.removeCookie('id');
    //$.removeCookie('firstname');
    //$.removeCookie('email');
    //$.removeCookie('password');
    localStorage.setItem('email', '');
    transition('../index.html');
  }
};

$(document).ready(function() {
  if (localStorage.getItem('id') === '' || localStorage.getItem('id')  === null) {
    //system.deleteSession();
  }
  user.setfirstname();
  $('#alert-count').html(localStorage.getItem('alert-count'));
});
