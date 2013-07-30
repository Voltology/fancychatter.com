var alerts = {
  id : null,
  get: function(response) {
    if (response == null) {
      ajax('http://173.203.81.65/api.php?a=getalerts&email=' + localStorage.getItem('email') + '&password=' + localStorage.getItem('password') + '&id=' + alerts.id, 'alerts.get');
    } else {
      if (response.result === 'success') {
        var html = '';
        $.each(response.alerts, function(key, value) {
          html += '<tr><td style="border-bottom: 1px solid #ccc; font-size: 14px;"><i class="icon-comment-alt"></i> <a href="profile.html">' + value.message + '</a></td></tr>';
        });
        $('#alerts-table').html(html);

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
