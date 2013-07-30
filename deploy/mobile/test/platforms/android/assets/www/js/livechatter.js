var livechatter = {
  search : function(response) {
    if (response == null) {
      ajax('http://173.203.81.65//api.php?a=livechatter&where=' + $('#where').val() + '&what=' + $('#what').val() + '&distance=' + $('#distance').val(), 'livechatter.search');
    } else {
      if (response.result === 'success') {
        if (response.livechatter.length === 0) {
          alert('Sorry, no LiveChatter was found for that search.');
        } else {
          var html = '<tr class="livechatter-results-header"><td width="86"></td><td><strong>Business Name/Message</strong></td><td width="95" align="right"><strong>Distance</strong></td></tr>';
          var count = 0;
          $.each(response.livechatter, function(key, value) {
            html += '<tr style="background-color: #fff;" class="livechatter-results-row"><td valign="top"><div style="overflow: hidden; width: 70px;">';
            html += '<a href="profile.html?mid=' + value.merchant_id + '"><img src="http://173.203.81.65//uploads/logos/' + value.logo + '" style="width: 100%;" /></a></div></td>';
            html += '<td valign="top"><strong><a href="profile.html?mid=' + value.merchant_id + '">' + value.merchant_name + '</a></strong><br />' + value.body + '</td>';
            html += '<td valign="top">' + Math.round(value.distance * 100) / 100 + ' miles</td></tr>';
            html += '<img src="http://fancychatter/uploads/logos/' + value.logo + '" />';
            count++;
          });
          $('#livechatter-search').fadeOut(300, function () {
            $('#livechatter-results').fadeIn(300);
            $('#livechatter-info').html('Found ' + count + ' results for ' + $('#what').val() + ' within ' + $('#distance').val() + ' miles of ' + $('#where').val());
            $('#livechatter-results-table').html(html);
          });
        }
      } else {
        var errors = '';
        $.each(response.errors, function(key, value) {
          errors += value + '\n';
        });
        alert(errors);
      }
    }
  },
}
