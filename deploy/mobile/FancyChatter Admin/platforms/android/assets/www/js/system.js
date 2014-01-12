var system = {
  deletesession : function() {
    transition('index.html');
  }
};

$(document).ready(function() {
  if (localStorage.getItem('id') === '' || localStorage.getItem('id')  === null) {
    system.deletesession();
  }
  user.setfirstname();
  $('#alert-count').html(localStorage.getItem('alert-count'));
  $('#chitchat-count').html(localStorage.getItem('chitchat-count'));
  setInterval(function() {
    user.update();
  }, 5000);
});
