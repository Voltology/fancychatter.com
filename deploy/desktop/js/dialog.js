var dialog = {
  close: function() {
    $('#dialog').css('display', 'none');
    $('#dialog-blanket').css('display', 'none');
  },
  open : function(type, header, height, width, searchwall) {
    $('#dialog').css({
      'display' : 'block',
      'height' : height,
      'left' : ($(window).width() / 2) - (width / 2),
      'top' : ($(window).height() / 2) - (height / 2),
      'width' : width
    });
    $('#dialog-blanket').css('display', 'block');
    $('#dialog-blanket').click(function() {
      dialog.close();
    });
    $('#dialog-header').html(header);
    if (type === 'chitchat') {
      var html = '<p>Sending a ChitChat is a way for you to tell businesses exactly what you are looking for. By filling out the form below, you will be initiating a direct conversation with businesses matching the criteria that you are searching for. Briefly explain what you want and within a short time you will recieve responses directly from the businesses. Go ahead and start making your own deals!</p>';
      html += '<strong>Example 1:</strong> I am looking for an Italian restaurant with a good wine list.<br />';
      html += '<strong>Example 2:</strong> Does any grocery store currently have a sale on fresh lobster?';
      html += '<textarea id="chitchat-field"></textarea><br />';
      html += '<button class="btn btn-mini btn-success dialog-btn" id="dialog-button">Send ChitChat</button>';
      $('#dialog-body').html(html);
      $('#dialog-button').on('click', function() {
        chitchat.send($('#chitchat-field').val());
      });
    } else if (type === 'login') {
      var html = '<input type="text" placeholder="Email Address" id="email" /><br />';
      html += '<input type="password" placeholder="Password" id="password" /><br />';
      if (searchwall) { html += '<input type="hidden" id="search-wall" value="true" />'; }
      html += '<button class="btn btn-mini btn-success dialog-btn" id="dialog-button">Log In</button>';
      html += '<div style="margin-left: 4px;"><strong>Don\'t have an account? <a href="#" onclick="dialog.open(\'signup\', \'Sign Up\', 320, 330, ' + searchwall + ');">Click here to sign up!</a></strong></div>';
      $('#dialog-body').html(html);
      $('#dialog-button').on('click', function() {
        user.login($('#email').val(), $('#password').val());
      });
      $("#email, #password").keypress(function(event) {
        if (event.which == 13) {
          user.login($('#email').val(), $('#password').val());
         }
      });
    } else if (type === 'signup') {
      var html = '<input type="text" placeholder="First Name" id="firstname" /><br />';
      html += '<input type="text" placeholder="Last Name" id="lastname" /><br />';
      html += '<input type="text" placeholder="Email Address" id="email" /><br />';
      html += '<input type="password" placeholder="Password" id="password1" /><br />';
      html += '<input type="password" placeholder="Re-enter Password" id="password2" /><br />';
      if (searchwall) { html += '<input type="hidden" id="search-wall" value="true" />'; }
      html += '<button class="btn btn-mini btn-success dialog-btn" id="dialog-button">Sign Up</button>';
      html += '<div style="margin-left: 4px;"><strong>Already have an account? <a href="#" onclick="dialog.open(\'login\', \'Log In\', 190, 310, ' + searchwall + ');">Click here to log in!</a></strong></div>';
      $('#dialog-body').html(html);
      $('#dialog-button').on('click', function() {
        user.signup($('#email').val(), $('#password1').val(), $('#password2').val(), $('#firstname').val(), $('#lastname').val());
      });
      $("#email, #password1, #password2, #firstname, #lastname").keypress(function(event) {
        if (event.which == 13) {
          user.signup($('#email').val(), $('#password1').val(), $('#password2').val(), $('#firstname').val(), $('#lastname').val());
         }
      });
    }
  },
  reposition : function() {
    var left = ($(window).width() / 2) - ($('#dialog').width() / 2);
    var top = ($(window).height() / 2) - ($('#dialog').height() / 2);
    if (left < 0) { left = 0; }
    if (top < 0) { top = 0; }
    $('#dialog').css({
      'left' : left,
      'top' : top
    });
  }
};
