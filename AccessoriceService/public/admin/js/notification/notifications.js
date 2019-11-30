var margintop = 45;
var notifications = [];

function notifySuccess(description, durration) {

  var notificationDiv = document.createElement("div");
  var titleElement = document.createElement("h2");
  var descriptionElement = document.createElement("h3");
  var text1 = document.createTextNode("Success");
  var text2 = document.createTextNode(description);
  var id = makeId();

  notifications.push(id);

  notificationDiv.id = id;
  notificationDiv.style.marginTop = margintop + "px";

  titleElement.appendChild(text1);
  descriptionElement.appendChild(text2);
  notificationDiv.appendChild(titleElement);
  notificationDiv.appendChild(descriptionElement);
  document.body.appendChild(notificationDiv);

  margintop += 85;

  var idof = "#" + id;

  $(idof).addClass("notifi-success notification animated bounceInRight");

  setTimeout(function() {

    $(idof).removeClass("bounceInRight");
    $(idof).addClass("bounceOutRight");

  }, durration);

  durr = durration + 450;

  setTimeout(function() {

    var indexOf = notifications.indexOf(id);

    if (indexOf > -1) {

      notifications.splice(indexOf, 1);

      $(idof).remove();

    }

  }, durr);

}

function notifyError(description, durration) {

  var notificationDiv = document.createElement("div");
  var titleElement = document.createElement("h2");
  var descriptionElement = document.createElement("h3");
  var text1 = document.createTextNode("Error");
  var text2 = document.createTextNode(description);
  var id = makeId();

  notifications.push(id);

  notificationDiv.id = id;
  notificationDiv.style.marginTop = margintop + "px";

  titleElement.appendChild(text1);
  descriptionElement.appendChild(text2);
  notificationDiv.appendChild(titleElement);
  notificationDiv.appendChild(descriptionElement);
  document.body.appendChild(notificationDiv);

  margintop += 85;

  var idof = "#" + id;

  $(idof).addClass("notifi-error notification animated bounceInRight");

  setTimeout(function() {

    $(idof).removeClass("bounceInRight");
    $(idof).addClass("bounceOutRight");

  }, durration);

  durr = durration + 450;

  setTimeout(function() {

    var indexOf = notifications.indexOf(id);

    if (indexOf > -1) {

      notifications.splice(indexOf, 1);

      $(idof).remove();

    }

  }, durr);

}


setInterval(function() {

  margintop = 45;

  for (var i = 0; i < notifications.length; i++) {

    var currNot = document.getElementById(notifications[i]);

    currNot.style.marginTop = margintop + "px";

    margintop += 85;

  }

}, 100);

function makeId() {

  var text = "notification";
  var possible = "0123456789";

  for (var i = 0; i < 5; i++) {

    text += possible.charAt(Math.floor(Math.random() * possible.length));

  }

  return text;

}
