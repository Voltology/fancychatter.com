var ajax = {
  get : function(url, query, callback) {
    jQuery.ajax({
      type: 'GET',
      url: url,
      data: query,
      dataType: 'jsonp',
      success: function(response) {
        callback(response);
      },
      jsonp: 'jsonp',
      jsonpCallback: 'json'
    });
  },
  send : function(url, query) {
    jQuery.ajax({
      type: 'GET',
      url: url,
      data: query,
      dataType: 'jsonp',
      jsonpCallback: 'json'
    });
  }
};
