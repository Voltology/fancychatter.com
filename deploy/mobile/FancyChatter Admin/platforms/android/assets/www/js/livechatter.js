var livechatter = {
  get : function(response) {
    if (response == null) {
      ajax(HOSTNAME + '/api.php?a=livechatter-get&email=' + localStorage.getItem('email') + '&password=' + localStorage.getItem('password') + '&where=' + $('#where').val() + '&what=' + $('#what').val() + '&distance=' + $('#distance').val(), 'livechatter.get');
    } else {
      if (response.result === 'success') {
        alert('yay');
      } else {
        var errors = '';
        $.each(response.errors, function(key, value) {
          errors += value + '\n';
        });
        if (response.logout == true) {
          system.deletesession();
        }
      }
    }
  },
  send : function(response) {
    if (response == null) {
      ajax(HOSTNAME + 'api/v1.0/?a=livechatter-send&email=' + localStorage.getItem('email') + '&password=' + localStorage.getItem('password'), 'livechatter.send');
    } else {
      if (response.result === 'success') {
        alert('yay');
      } else {
        var errors = '';
        $.each(response.errors, function(key, value) {
          errors += value + '\n';
        });
        if (response.logout == true) {
          system.deletesession();
        }
      }
    }
  },
}
