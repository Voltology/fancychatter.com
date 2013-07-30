var system = {
  deletesession : function() {
    //$.removeCookie('id');
    //$.removeCookie('firstname');
    //$.removeCookie('email');
    //$.removeCookie('password');
    transition('login.html');
  }
};

$(document).ready(function() {
  if (localStorage.getItem('id') === '' || localStorage.getItem('id')  === null) {
    system.deletesession();
  }
  user.setfirstname();
  $('#alert-count').html(localStorage.getItem('alert-count'));
});
