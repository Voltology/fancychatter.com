var chitchat = {
  respond : function(response) {
    if (response == null) {
      ajax(HOSTNAME + '/api.php?a=chitchat-respond&email=' + localStorage.getItem('email') + '&password=' + localStorage.getItem('password') + '&msg=' + $('#chitchat-field').val(), 'chitchat.respond');
    } else {
      if (response.result === 'success') {
        alert('ChitChat response sent!');
        $('chitchat-field').val('');
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
