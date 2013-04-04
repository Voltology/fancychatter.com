var user = {
  login : function() {
    ajax.get(API_URL, '&action=login&email=' + $('#email').val() + '&password=' + $('#password').val(), function(json) {
      if (json.result === 'success') {
        document.location = '/home';
      } else {
        alert('error');
      }
    });
  },
  logout : function() {
    ajax.get(API_URL, '&action=logout', function(json) {
      if (json.result === 'success') {
      } else {
      }
    });
  },
  register : function() {
    ajax.get(API_URL, '&action=register', function(json) {
      if (json.result === 'success') {
      } else {
      }
    });
  }
};
