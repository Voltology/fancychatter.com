var chitchat = {
  respond : function() {
  },
  send : function(msg) {
    ajax.get('api.php', '&a=chitchat-send&msg=' + msg, function(response) {
      alert('ChitChat Sent!');
      dialog.close();
    });
  }
};
