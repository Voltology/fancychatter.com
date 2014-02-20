var chitchat = {
  category : null,
  distance : null,
  id : null,
  location : null,
  response : null,
  userId : null,
  delete : function(response) {
    if (response == null) {
      ajax(HOSTNAME + '/api/' + API_VERSION+ '/?method=chitchat-delete&source=app&user-id=' + localStorage.getItem('user-id') + '&user-token=' + localStorage.getItem('user-token') + '&merchant-token=' + localStorage.getItem('merchant-token'), 'chitchat.get');
    } else {
      if (response.result === 'success') {
      } else {
      }
    }
  },
  get : function(response) {
    if (response == null) {
      ajax(HOSTNAME + '/api/' + API_VERSION+ '/?method=chitchat-get&source=app&user-id=' + localStorage.getItem('user-id') + '&user-token=' + localStorage.getItem('user-token') + '&merchant-token=' + localStorage.getItem('merchant-token'), 'chitchat.get');
    } else {
      if (response.result === 'success') {
        var $container = $('#chitchat-container');
        $.each(response.chitchat, function(key, value) {
          var html = '<table width="100%" cellpadding="2" cellspacing="0" id=chitchat-table-' + value.id + '>';
          html += '<tr><td valign="top" width="30">';
          if (value.profile_img) {
            html += '<div class="image-placeholder"><img src="http://www.fancychatter.com/uploads/profile/' + value.profile_img + '"></div>';
          } else {
            html += '<div class="image-placeholder"><img src="http://www.fancychatter.com/uploads/profile/default.png"></div>';
          }
          html += '</td>';
          html += '<td colspan="2">';
          html += '<span class="username-placeholder">' + value.firstname + ' ' + value.lastname + '</span><span class="date-placeholder"> - (Sent 25 minutes ago)</span><br />';
          html += value.body;
          html += '</td>';
          html += '</tr>';
          $.each(value.responses, function(key2, respond) {
            html += '<tr>';
            html += '<td></td>';
            html += '<td valign="top" width="30" style="">';
            if (respond.last_response === 'user') {
              if (value.profile_img) {
                html += '<div class="image-placeholder"><img src="http://www.fancychatter.com/uploads/profile/' + value.profile_img + '"></div>';
              } else {
                html += '<div class="image-placeholder"><img src="http://www.fancychatter.com/uploads/profile/default.png"></div>';
              }
            } else {
              if (response.merchant.logo) {
                merchant.setLogo(response.merchant.logo);
                merchant.setName(response.merchant.name);
                html += '<div class="image-placeholder"><img src="http://www.fancychatter.com/uploads/logos/' + response.merchant.logo + '"></div>';
              } else {
                html += '<div class="image-placeholder"><img src="http://www.fancychatter.com/uploads/profile/default.png"></div>';
              }
            }
            html += '</td>';
            html += '<td style="position: relative;">' ;
            if (respond.last_response === 'user') {
              html += '<div class="username-placeholder">' + respond.firstname + ' ' + respond.lastname + '</div>';
            } else {
              html += '<div style="position: absolute; top: 5px; right: 5px; font-size: 24px;" onclick="chitchat.setId(' + value.id + '); chitchat.delete(' + value.id + ');"><i class="icon-remove"></i></div>';
              html += '<div class="username-placeholder">' + response.merchant.name + '</div>';
            }
            html += respond.body;
            html += '</td>';
            html += '</tr>';
          });
          html += '<tr>';
          html += '<td></td>';
          html += '<td valign="top" width="30">';
          html += '<div class="image-placeholder"><img src="http://www.fancychatter.com/uploads/logos/' + response.merchant.logo + '"></div>';
          html += '</td>';
          html += '<td align="left">';
          html += '<div class="username-placeholder">' + response.merchant.name + '</div>';
          html += '<textarea id="chitchat-body-' + value.id + '"></textarea><button onclick="chitchat.setId(' + value.id + '); chitchat.setUserId(' + value.user_id + '); chitchat.setResponse(); chitchat.respond()">Send Response</button>';
          html += '</td>';
          html += '</tr>';
          html += '</table>';
          $container.append(html);
        });
      } else {
        var errors = '';
        $.each(response.errors, function(key, value) {
          errors += value + '\n';
        });
        alert(errors);
      }
    }
  },
  respond : function(response) {
    if (response == null) {
      ajax(HOSTNAME + '/api/' + API_VERSION+ '/?method=chitchat-respond&source=app&chitchat-id=' + this.id + '&user-id=' + localStorage.getItem('user-id') + '&user-token=' + localStorage.getItem('user-token') + '&merchant-token=' + localStorage.getItem('merchant-token') + '&body=' + $('#chitchat-body-' + this.id).val(), 'chitchat.respond');
    } else {
      if (response.result === 'success') {
        var html = '<tr>';
        html += '<td></td>';
        html += '<td valign="top" width="30">';
        html += '<div class="image-placeholder"><img src="http://www.fancychatter.com/uploads/logos/' + merchant.getLogo() + '"></div>';
        html += '</td>';
        html += '<td>' ;
        html += '<div class="username-placeholder">' + merchant.getName() + '</div>';
        html += this.response;
        html += '</td>';
        html += '</tr>';
        html += '<tr>';
        html += '<td></td>';
        html += '<td valign="top" width="30">';
        html += '<div class="image-placeholder"><img src="http://www.fancychatter.com/uploads/logos/' + merchant.getLogo() + '"></div>';
        html += '</td>';
        html += '<td align="left">';
        html += '<div class="username-placeholder">' + merchant.getName() + '</div>';
        html += '<textarea id="chitchat-body-' + this.id + '"></textarea><button onclick="chitchat.setId(' + this.id + '); chitchat.setUserId(' + this.userId + '); chitchat.respond()">Send Response</button>';
        html += '</td>';
        html += '</tr>';
        $('#chitchat-table-' + this.id + ' tr:last').remove();
        $('#chitchat-table-' + this.id).append(html);
        $('#chitchat-body-' + this.id).val('');
        alert('ChitChat response sent!');
      } else {
        var errors = '';
        $.each(response.errors, function(key, value) {
          errors += value + '\n';
        });
        alert(errors);
      }
    }
  },
  send : function(response) {
    if (response == null) {
      ajax(HOSTNAME + '/api/' + API_VERSION + '/?method=chitchat-send&source=app&user-id=' + localStorage.getItem('user-id') + '&user-token=' + localStorage.getItem('user-token') + '&location=' + chitchat.location + '&category=' + chitchat.category + '&distance=' + chitchat.distance + '&msg=' + $('#chitchat-field').val(), 'chitchat.send');
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
  },
  setId : function(id) {
    this.id = id;
  },
  setResponse: function() {
    this.response = $('#chitchat-body-' + this.id).val();
  },
  setUserId : function(id) {
    this.userId = id;
  }
};
