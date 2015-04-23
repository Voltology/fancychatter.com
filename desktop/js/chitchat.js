var chitchat = {
  respond : function() {
  },
  send : function(location, category, distance, msg) {
    if (msg !== '') {
      ajax.get('api.php', '&a=chitchat-send&location=' + location + '&category=' + category + '&distance=' + distance + '&msg=' + msg, function(response) {
        alert('ChitChat Sent!');
        dialog.close();
      });
    } else {
      alert('The ChitChat field is blank!');
    }
  }
};
