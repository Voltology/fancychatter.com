$(document).ready(function() {
  $("body").css("display", "none");
  $("body").fadeIn(200);
  $("a.transition").click(function(event){
    event.preventDefault();
    linkLocation = this.href;
    $("body").fadeOut(200, redirectPage);
  });
  function redirectPage() {
    window.location = linkLocation;
  }
});

function transition(page) {
  $("body").fadeOut(200, redirectPage);
  function redirectPage() {
    window.location = page;
  }
}
