var url = document.URL;

switch(url) {
  case "http://m.fancychatter/":
    var API_VERSION  = 'v1.0';
    var HOSTNAME = 'http://127.0.0.1';
    break;
  case "http://staging.fancychatter/":
    var API_VERSION  = 'v1.0';
    var HOSTNAME = 'http://staging.fancychatter.com';
    break;
  case "http://demo.fancychatter/":
    var API_VERSION  = 'v1.0';
    var HOSTNAME = 'http://demo.fancychatter.com';
    break;
  case "http://b2b.fancychatter/":
    var API_VERSION  = 'v1.0';
    var HOSTNAME = 'http://b2b.fancychatter.com';
    break;
  case "http://fancychatter/":
  case "http://www.fancychatter/":
    var API_VERSION  = 'v1.0';
    var HOSTNAME = 'http://www.fancychatter.com';
    break;
  default:
    var API_VERSION  = 'v1.0';
    var HOSTNAME = 'http://fancychatter';
    break;
}
