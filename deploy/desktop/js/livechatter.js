var livechatter = {
  search : function(cityzip) {
    ajax.get(API_URL, '&action=search&cityzip=' + cityzip, function() {
      alert('test');
    });
  }
};
