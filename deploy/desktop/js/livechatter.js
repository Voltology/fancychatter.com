var livechatter = {
  search : function() {
    if ($('#where').val() === '' || $('#what').val() === 'null' || $('#distance').val() === 'null') {
      alert('Make sure all search fields have been filled out');
    } else {
      $('#livechatter-search').submit();
    }
  }
};
