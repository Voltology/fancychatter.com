var chitchat = {
  distance : null,
  category : null,
  location : null,
  send : function(response) {
    if (response == null) {
      ajax('http://173.203.81.65/api.php?a=chitchat-send-app&email=' + localStorage.getItem('email') + '&password=' + localStorage.getItem('password') + '&location=' + chitchat.location + '&category=' + chitchat.category + '&distance=' + chitchat.distance + '&msg=' + $('#chitchat-field').val(), 'chitchat.send');
    } else {
      if (response.result === 'success') {
        alert('ChitChat sent!');
        dialog.close();
      } else {
        var errors = '';
        $.each(response.errors, function(key, value) {
          errors += value + '\n';
        });
        alert(errors);
      }
    }
  }
};
