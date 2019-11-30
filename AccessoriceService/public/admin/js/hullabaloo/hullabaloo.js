/**
 * hullabaloo v 0.4
 *
 */
 (function (root, factory) {
     if (typeof exports === "object") {
         module.exports = factory();
     } else if (typeof define === "function" && define.amd) {
         define(['jquery'], factory);
     } else {
         root.hullabaloo = factory();
     }
 }(this, function () {
   return new function () {

    this.hullabaloo = function() {
      this.hullabaloo = {};

      this.hullabaloos = [];

      this.success = false;

      this.options = {
        ele: "body",
        offset: {
          from: "top",
          amount: 20
        },
        align: "right",
        width: 300,
        delay: 2000,
        allow_dismiss: true,
        stackup_spacing: 10,
        text: "Произошла неизвестная ошибка.",
        icon: {
          success: "fa fa-check-circle",
          error: "fa fa-times-circle",
          info: "fa fa-info-circle",
          warning: "fa fa-life-ring",
          danger: "fa fa-exclamation-circle",
          light: "fa fa-sun",
          dark: "fa fa-moon"
        },
        status: "danger",
        alertClass: "",
        fnStart: false,
        fnEnd: false,
        fnEndHide: false,
      };
    };

    this.hullabaloo.prototype.send = function(text, status, group = 1) {
      if (typeof this.options.fnStart == "function")
        this.options.fnStart();

      var self = this;

      var flag = 1;

      var i = +this.hullabaloos.length - 1;

      var parent;

      var hullabaloo = this.generate(text, status);

      if (group && this.hullabaloos.length) {
        while (i >= 0 && flag) {
          if (this.hullabaloos[i].text == hullabaloo.text && this.hullabaloos[i].status == hullabaloo.status) {

            parent = this.hullabaloos[i];
            flag = 0;

            hullabaloo.elem.css(this.options.offset.from, parseInt(parent.elem.css(this.options.offset.from)) + 4);
            hullabaloo.elem.css(this.options.align, parseInt(parent.elem.css(this.options.align)) + 4);
          }
          i--;
        }
      }

      if (typeof parent == 'object') {
        clearTimeout(parent.timer);
        parent.timer = setTimeout(function() {
          self.closed(parent);
        }, this.options.delay);
        hullabaloo.parent = parent;
        parent.hullabalooGroup.push(hullabaloo);
      } else {
        hullabaloo.position = parseInt(hullabaloo.elem.css(this.options.offset.from));

        hullabaloo.timer = setTimeout(function() {
          self.closed(hullabaloo);
        }, this.options.delay);
        this.hullabaloos.push(hullabaloo);
      }

      hullabaloo.elem.fadeIn();

      if (typeof this.options.fnEnd == "function")
        this.options.fnEnd();
    };

    this.hullabaloo.prototype.closed = function(hullabaloo) {
      var self = this;
      var idx, i, move, next;

      if("parent" in hullabaloo){
        hullabaloo = hullabaloo.parent;
      }

      if (this.hullabaloos !== null) {
        idx = $.inArray(hullabaloo, this.hullabaloos);
        if(idx == -1) return;

        if (!!hullabaloo.hullabalooGroup && hullabaloo.hullabalooGroup.length) {
          for (i = 0; i < hullabaloo.hullabalooGroup.length; i++) {
            $(hullabaloo.hullabalooGroup[i].elem).remove();
          }
        }

        $(this.hullabaloos[idx].elem).fadeOut("slow", function(){
          this.remove();
        });

        if (idx !== -1) {
          next = idx + 1;
          if (this.hullabaloos.length > 1 && next < this.hullabaloos.length) {
            move = this.hullabaloos[next].position - this.hullabaloos[idx].position;

            for (i = idx; i < this.hullabaloos.length; i++) {
              this.animate(self.hullabaloos[i], parseInt(self.hullabaloos[i].position) - move);
              self.hullabaloos[i].position = parseInt(self.hullabaloos[i].position) - move
            }
          }

          this.hullabaloos.splice(idx, 1);

          if (typeof this.options.fnEndHide == "function")
            this.options.fnEndHide();
        }
      }
    };

    this.hullabaloo.prototype.animate = function(hullabaloo, move) {
      var self = this;
      var timer,
        position,
        i,
        group = 0;

      position = parseInt(hullabaloo.elem.css(self.options.offset.from));
      group = hullabaloo.hullabalooGroup.length;

      timer = setInterval(frame, 2);
      function frame() {
        if (position == move) {
          clearInterval(timer);
        } else {
          position--;
          hullabaloo.elem.css(self.options.offset.from, position);

          if (group) {
            for (i = 0; i < group; i++) {
              hullabaloo.hullabalooGroup[i].elem.css(self.options.offset.from, position + 5);
            }
          }
        }
      }
    };


    this.hullabaloo.prototype.generate = function(text, status) {
      var alertsObj = {
        icon: "",
        status: status || this.options.status,
        text: text || this.options.text,
        elem: $("<div>"),

        hullabalooGroup: []
      };
      var option,
          offsetAmount,
          css;
          self = this;

      option = this.options;

      alertsObj.elem.attr("class", "hullabaloo alert "+option.alertClass);

      alertsObj.elem.addClass("alert-solid-" + alertsObj.status);

      if (option.allow_dismiss) {
        alertsObj.elem.addClass("alert-dismissible");
        alertsObj.elem.append("<button class=\"close\" type=\"button\" id=\"hullabalooClose\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>");
        $( "#hullabalooClose", $(alertsObj.elem) ).bind( "click", function(){
          self.closed(alertsObj);
        });
      }

      // Icon
      switch (alertsObj.status) {
        case "success":
          alertsObj.icon = option.icon.success;
          break;
        case "error":
          alertsObj.icon = option.icon.error;
          break;
        case "info":
          alertsObj.icon = option.icon.info;
          break;
        case "danger":
          alertsObj.icon = option.icon.danger;
          break;
        case "light":
          alertsObj.icon = option.icon.light;
          break;
        case "dark":
          alertsObj.icon = option.icon.dark;
          break;
        default:
          alertsObj.icon = option.icon.warning;
      }

      alertsObj.elem.append("<i class=\"" + alertsObj.icon + "\"></i> " + alertsObj.text);

      offsetAmount = Math.max(parseInt($(".header-section").css('height')));

      // var header = Math.max(parseInt($(".header-section").css('height')));
      // // alert(header);

      $(".hullabaloo").each(function() {
        return offsetAmount = Math.max(offsetAmount, parseInt($(this).css(option.offset.from)) + $(this).outerHeight() + option.stackup_spacing);
      });

      css = {
        "position": (option.ele === "body" ? "fixed" : "absolute"),
        "margin": 0,
        "z-index": "9999",
        "display": "none"
      };
      css[option.offset.from] = offsetAmount + "px";
      alertsObj.elem.css(css);

      if (option.width !== "auto") {
        alertsObj.elem.css("width", option.width + "px");
      }
      $(option.ele).append(alertsObj.elem);
      switch (option.align) {
        case "center":
          alertsObj.elem.css({
            "left": "50%",
            "margin-left": "-" + (alertsObj.elem.outerWidth() / 2) + "px"
          });
          break;
        case "left":
          alertsObj.elem.css("left", "20px");
          break;
        default:
          alertsObj.elem.css("right", "20px");
      }

      return alertsObj;
    };
    return this.hullabaloo;
  };
}));
