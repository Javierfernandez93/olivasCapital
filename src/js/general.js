/* FUNC MODES */
const CHECK_MAIL = "CHECK_MAIL";

/* TIME MODES */
const SHORT_TIME = 250;
const MEDIUM_TIME = 750;
const LONG_TIME = 1250;
const LOAD_TIMER = 1500;

/* ALERT MODES */
const DANGER = "alert-danger";
const SUCCESS = "alert-success";

const DELTA_TIME = 440;

/* OTHER VARS */
let alert = null;

class DinamicLoader {
  construct() {
    this.element = null;
    this.html = null;
    this.classes = null;
  }
  setElement(element) {
    this.element = element;
  }
  getElement() {
    return this.element;
  }
  show(element, __class) {
    this.showLoader(element, __class);
  }
  showLoaderMagic(element) {
    $(element).addClass("overlay-loader-element");
  }
  showLoader(element, __class) {
    // this.setElement($(element));
    this.setElement($("#default-loader"));
    this.html = this.getElement().html();
    this.classes = this.getElement().attr("class");

    if (this.getElement().length > 0) {
      let _class = __class != undefined ? __class : "preloader-sm";

      if (this.getElement().get(0).tagName == "BUTTON") {
        this.getElement().attr("disabled", true);
        this.getElement().css("width", "auto");

        this.getElement().removeClass("btn-block");
        this.getElement().html(
          "<div class='d-flex justify-content-center'><div class='" +
            _class +
            "'></div></div>"
        );
        this.getElement().animate(
          {
            width: "120px",
          },
          DELTA_TIME
        );
      } else if (this.getElement().get(0).tagName == "SPAN") {
        this.getElement().html(
          "<div class='d-flex justify-content-center'><div class='preloader-sm-black'></div></div>"
        );
      } else if (this.getElement().get(0).tagName == "DIV") {
        // let _class = __class != undefined ? __class : "preloader-lg";
        // this.getElement().html("<div class='d-flex justify-content-center'><div class='"+_class+"'></div></div>");

        this.getElement().html(
          '<div class="progress-mds"><div class="indeterminate"></div></div>'
        );
      }
    }
  }
  removeStyle() {
    this.getElement().removeAttr("style");
    this.getElement().html(this.html);
    this.getElement().attr("class", this.classes);
  }
  hideLoader() {
    this.closeLoader();
  }
  close() {
    this.closeLoader();
  }
  hide() {
    this.closeLoader();
  }
  closeLoader() {
    this.getElement().removeAttr("disabled");
    this.removeStyle();
  }
}

var dinamicLoader = new DinamicLoader();
var document_loaded = false;

function load(callback) {
  $(function () {
    if (document_loaded == false) {
      document_loaded = true;

      setTimeout(() => {
        if ($("#preloader").length > 0) {
          $("#preloader").addClass("preloader-hide");
        }
        callback();
      }, LOAD_TIMER);

      $("[data-ellipsis").click(function () {
        console.log("TO");
      });
    } else {
      callback();
    }
  });
}

function delay(callback, ms) {
  var timer = 0;
  return function () {
    var context = this,
      args = arguments;
    clearTimeout(timer);
    timer = setTimeout(function () {
      callback.apply(context, args);
    }, ms || 0);
  };
}

$(document).ready(function () {});

function alertDanger(message) {
  $("#alert").removeClass("d-none").text(message);
}

function _alert(alert_element, mode, html) {
  $(alert_element)
    .removeClass("d-none alert-danger alert-success")
    .addClass(mode)
    .html(html);
}

function nextElement(element, event, next_element, _function) {
  if (_function != undefined) {
    if (_function === CHECK_MAIL) {
      if (isValidMail(element.value) == true) {
        $(element).addClass("is-valid").removeClass("is-invalid");

        if (event.keyCode == 13) {
          $(next_element).focus();
        }
      } else {
        $(element).addClass("is-invalid").removeClass("is-valid");
      }
    }
  } else {
    if (event.keyCode == 13) {
      $(next_element).focus();
    }
  }
}

window.alertMessage = function (message, element, title) {
  alertMesage(message, element, title);
};

function alertMessage(mesage, element, title = false) {
  alertmesage(mesage, element, title);
}

function alertHtml(html,title,size)
{
    closeModal();

    title = (title) ? title : null;
    size = size ? size : 'modal-md';

    let alert = alertCtrl.create({
      title: title,
      size: size,
      html: html
    });

    alertCtrl.present(alert.modal);
}

function closeModal()
{
    if (alert != null) {
        alert.modal.dismiss();
    }
}

function alertmesage(mesage, element, title = false) {
  if (alert != null) {
    alert.modal.dismiss();
  }
  title = title ? title : "Aviso";
  alert = alertCtrl.create({
    title: title,
    subTitle: mesage,
    buttons: [
      {
        text: "Aceptar",
        role: "cancel",
        handler: (data) => {
          if (element != undefined) $(element).focus();
        },
      },
    ],
  });

  alertCtrl.present(alert.modal);
}

function singleDisccuss(positive_callback, negative_callback) {
  disccuss(null, null, positive_callback, negative_callback);
}

function disccuss(title, subTitle, positive_callback, negative_callback) {
  if (alert != null) {
    alert.modal.dismiss();
  }

  title = title ? title : translate("Aviso");
  subTitle = subTitle
    ? subTitle
    : translate("¿Estás seguro de realizar esta acción?");
  alert = alertCtrl.create({
    title: title,
    subTitle: subTitle,
    buttons: [
      {
        text: translate("Sí"),
        role: "cancel",
        handler: (data) => {
          if (positive_callback != undefined) positive_callback();
        },
      },
      {
        text: translate("No"),
        role: "cancel",
        handler: (data) => {
          if (negative_callback != undefined) negative_callback();
        },
      },
    ],
  });

  alertCtrl.present(alert.modal);
}

function alertMesage(mesage, element, title = false) {
  alertmesage(mesage, element, title);
}

function getUniqueId() {
  var d = new Date().getTime();

  if (window.performance && typeof window.performance.now === "function") {
    d += performance.now();
  }

  var uuid = "xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx".replace(
    /[xy]/g,
    function (c) {
      var r = (d + Math.random() * 16) % 16 | 0;
      d = Math.floor(d / 16);
      return (c == "x" ? r : (r & 0x3) | 0x8).toString(16);
    }
  );

  return uuid;
}

function verifyall(element, tipo, minlength = false, message = false) {
  var bandera = true;
  if (element.val() == "") {
    bandera = false;
  } else {
    if (tipo == "mail") {
      if (!isValidMail(element.val())) bandera = false;
    } else if (tipo == "number") {
      if (minlength) {
        if (
          isNaN(element.val()) ||
          element.val().length > minlength ||
          element.val().length < minlength
        )
          bandera = false;
      } else if (isNaN(element.val())) bandera = false;
    }
  }

  if (bandera == false) {
    if ($(element).hasClass("inputError") == false) alertmesage(message);
    // element.focus();
    element.removeClass("inputSuccess");
    element.addClass("inputError");
    return false;
  } else {
    element.removeClass("inputError");
    element.addClass("inputSuccess");
    return true;
  }
}

function isValidMail(mail) {
  var pattern = new RegExp(
    /^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i
  );
  return pattern.test(mail);
}

window._isValidMail = function (mail) {
  return isValidMail(mail);
};

function ponerReadOnly(id) {
  //4 Ponemos el atributo de solo lectura
  $("#cellular").attr("readonly", "readonly");
  // Ponemos una clase para cambiar el color del texto y mostrar que
  // esta deshabilitado
  $("#cellular").addClass("readOnly");
}

function quitarReadOnly(id) {
  // Eliminamos el atributo de solo lectura
  $("#cellular").attr("readonly", false);
  // Ponemos una clase para cambiar el color del texto y mostrar que
  // esta deshabilitado
  alertmesage("edita el numero de celular");
}

function diferenceInMinutes(startTime, endTime) {
  var startTime = new Date(startTime);
  var endTime = new Date(endTime);
  var difference = endTime.getTime() - startTime.getTime(); // This will give difference in milliseconds
  return Math.round(difference / 60000);
}

function date() {
  var date = new Date();
  // Hours part from the timestamp
  var year = date.getFullYear();
  var month = date.getMonth();
  var day = date.getDay();
  var hours = date.getHours();
  // Minutes part from the timestamp
  var minutes = "0" + date.getMinutes();
  // Seconds part from the timestamp
  var seconds = "0" + date.getSeconds();

  // Will display time in 10:30:23 format
  return (
    year +
    "/" +
    month +
    "/" +
    day +
    " " +
    hours +
    ":" +
    minutes.substr(-2) +
    ":" +
    seconds.substr(-2)
  );
}

function compareDates(date_future) {
  var date_now = time();

  // get total seconds between the times
  var delta = Math.abs(date_future - date_now);

  // calculate (and subtract) whole days
  var days = Math.floor(delta / 86400);
  delta -= days * 86400;

  // calculate (and subtract) whole hours
  var hours = Math.floor(delta / 3600) % 24;
  delta -= hours * 3600;

  // calculate (and subtract) whole minutes
  var minutes = Math.floor(delta / 60) % 60;
  delta -= minutes * 60;

  // what's left is seconds
  var seconds = delta % 60; // in theory the modulus is not required

  return { days: days, hours: hours, minutes: minutes, seconds: seconds };
}

function time() {
  return parseInt((new Date().getTime() / 1000).toFixed(0));
}

function unixToDate(unix) {
  var date = new Date(unix * 1000);
  // Hours part from the timestamp
  var year = date.getFullYear();
  var month = date.getMonth();
  var day = date.getDay();
  var hours = date.getHours();
  // Minutes part from the timestamp
  var minutes = "0" + date.getMinutes();
  // Seconds part from the timestamp
  var seconds = "0" + date.getSeconds();

  // Will display time in 10:30:23 format
  return (
    year +
    "/" +
    month +
    "/" +
    day +
    " " +
    hours +
    ":" +
    minutes.substr(-2) +
    ":" +
    seconds.substr(-2)
  );
}

function copyToClipboard(elemento) {
  var $temp = $("<input>");
  $("body").append($temp);
  $temp.val($(elemento).text()).select();
  document.execCommand("copy");
  $temp.remove();
  alertmesage(
    "Se copio el enlace en el portapapeles ",
    null,
    "Comparta el enlace con sus prospectos"
  );
}

function getParam(name) {
  name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
  var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    results = regex.exec(location.search);
  return results === null
    ? ""
    : decodeURIComponent(results[1].replace(/\+/g, " "));
}

function number_format(number, decimals, dec_point, thousands_sep) {
  // *     example: number_format(1234.56, 2, ',', ' ');
  // *     return: '1 234,56'
  number = (number + "").replace(",", "").replace(" ", "");
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = typeof thousands_sep === "undefined" ? "," : thousands_sep,
    dec = typeof dec_point === "undefined" ? "." : dec_point,
    s = "",
    toFixedFix = function (n, prec) {
      var k = Math.pow(10, prec);
      return "" + Math.round(n * k) / k;
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : "" + Math.round(n)).split(".");
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || "").length < prec) {
    s[1] = s[1] || "";
    s[1] += new Array(prec - s[1].length + 1).join("0");
  }
  return s.join(dec);
}

function makeScreenShoot() {
  let region = document.querySelector("body"); // whole screen
  html2canvas(region, {
    onrendered: function (canvas) {
      let pngUrl = canvas.toDataURL(); // png in dataURL format
      let img = document.querySelector(".screen");
      img.src = pngUrl;
      console.log("SCDOEN");
    },
  });
}

function isEmpty(string) {
  if (string == undefined || string == null) return true;

  return string === 0 || !string.trim();
}

window.togglePassword = function (element) {
  if ($(element).parent().parent().find("input").attr("type") == "password") {
    $(element)
      .html('<i class="fas fa-eye-slash"></i>')
      .parent()
      .parent()
      .find("input")
      .attr("type", "text");
  } else {
    $(element)
      .html('<i class="far fa-eye"></i>')
      .parent()
      .parent()
      .find("input")
      .attr("type", "password");
  }
};

function copyToClipboardTextFromElement(element_to_copy, element, helper) {
  let text = $(element_to_copy).val();
  var $temp = $("<input>");
  $("body").append($temp);
  $temp.val(text).select();
  document.execCommand("copy");
  $temp.remove();

  $(element).html(helper);
}

function copyToClipboardText(element, text, helper) {
  var $temp = $("<input>");
  $("body").append($temp);
  $temp.val(text).select();
  document.execCommand("copy");
  $temp.remove();

  $(element).html(helper);
}

function validURL(str) {
  var pattern = new RegExp(
    "^(https?:\\/\\/)?" + // protocol
      "((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|" + // domain name
      "((\\d{1,3}\\.){3}\\d{1,3}))" + // OR ip (v4) address
      "(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*" + // port and path
      "(\\?[;&a-z\\d%_.~+=-]*)?" + // query string
      "(\\#[-a-z\\d_]*)?$",
    "i"
  ); // fragment locator
  return !!pattern.test(str);
}

function isValid(element) {
  $(element).addClass("is-valid").removeClass("is-invalid");
}

function isInvalid(element) {
  $(element).addClass("is-invalid").removeClass("is-valid");
}

function typeWriter(text, element) {
  let i = 0;
  if (i < text.length) {
    document.getElementById(element).innerHTML += txt.charAt(i);
    i++;
    setTimeout(typeWriter, 50);
  }
}

function chunkSubstr(str, size) {
  const numChunks = Math.ceil(str.length / size);
  const chunks = new Array(numChunks);

  for (let i = 0, o = 0; i < numChunks; ++i, o += size) {
    chunks[i] = str.substr(o, size);
  }

  return chunks;
}

function _scrollTo(top) {
  var body = $("html, body");
  body.stop().animate({ scrollTop: top }, 500, "swing", function () {
    console.log("Finished animating");
  });
}
function scrollTo(event, target, offset) {
  if (event != null) {
    event.preventDefault();
  }

  $("html, body").animate(
    {
      scrollTop: $(target).offset().top + offset,
    },
    MEDIUM_TIME
  );
}

function copyToClipboardTextFromData(element) {
  navigator.clipboard.writeText($(element).data("text")).then(() => {
    $(element).html($(element).data("helper"));
  });
}

function percentage(partialValue, totalValue) {
  return (100 * partialValue) / totalValue;
}

Number.prototype.formatDate = function () {
  return new Date(this * 1000).toLocaleDateString();
};

String.prototype.formatDate = function () {
  return new Date(this * 1000).toLocaleDateString();
};

Number.prototype.formatFullDate = function () {
  return new Date(this * 1000).toLocaleTimeString("es-ES",{ hour: 'numeric', minute: 'numeric', hour12: true, day: 'numeric', month: 'long'})
};

Number.prototype.formatDateText = function () {
  return new Date(this * 1000).toLocaleDateString("es-ES",{ weekday: 'long', day: 'numeric', month: 'long'})
};

Number.prototype.formatDateTextChart = function () {
  return new Date(this * 1000).toLocaleDateString("es-ES",{ day: 'numeric', month: 'long'})
};

Number.prototype.numberFormat = function (decimals, dec_point, thousands_sep) {
  let number = this;
  // *     example: number_format(1234.56, 2, ',', ' ');
  // *     return: '1 234,56'
  number = (number + "").replace(",", "").replace(" ", "");
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = typeof thousands_sep === "undefined" ? "," : thousands_sep,
    dec = typeof dec_point === "undefined" ? "." : dec_point,
    s = "",
    toFixedFix = function (n, prec) {
      var k = Math.pow(10, prec);
      return "" + Math.round(n * k) / k;
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : "" + Math.round(n)).split(".");
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || "").length < prec) {
    s[1] = s[1] || "";
    s[1] += new Array(prec - s[1].length + 1).join("0");
  }
  return s.join(dec);
};

String.prototype.numberFormat = function (decimals, dec_point, thousands_sep) {
  let number = this;
  // *     example: number_format(1234.56, 2, ',', ' ');
  // *     return: '1 234,56'
  number = (number + "").replace(",", "").replace(" ", "");
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = typeof thousands_sep === "undefined" ? "," : thousands_sep,
    dec = typeof dec_point === "undefined" ? "." : dec_point,
    s = "",
    toFixedFix = function (n, prec) {
      var k = Math.pow(10, prec);
      return "" + Math.round(n * k) / k;
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : "" + Math.round(n)).split(".");
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || "").length < prec) {
    s[1] = s[1] || "";
    s[1] += new Array(prec - s[1].length + 1).join("0");
  }
  return s.join(dec);
};

Array.prototype.inArray = function(needle)
{
  let key = -1
  for(let i = 0; i < this.length; i++) 
  {
    if(this[i] === needle)
    {
      key = i
    }
  }

  return key
}

Number.prototype.timeSince = function() 
{
  var date = this * 1000
  var seconds = Math.floor((new Date() - date) / 1000);

  var interval = seconds / 31536000;

  if (interval > 1) {
    return Math.floor(interval) + " años";
  }
  interval = seconds / 2592000;
  if (interval > 1) {
    return Math.floor(interval) + " meses";
  }
  interval = seconds / 86400;
  if (interval > 1) {
    return Math.floor(interval) + " dias";
  }
  interval = seconds / 3600;
  if (interval > 1) {
    return Math.floor(interval) + " horas";
  }
  interval = seconds / 60;
  if (interval > 1) {
    return Math.floor(interval) + " minutos";
  }
  return Math.floor(seconds) + " segundos";
}
String.prototype.convertDataToHtml = function() {
  var blocks = JSON.parse(this).blocks

  var convertedHtml = "";
  blocks.map(block => {
    
    switch (block.type) {
      case "header":
        convertedHtml += `<h${block.data.level}>${block.data.text}</h${block.data.level}>`;
        break;
      case "embded":
        convertedHtml += `<div><iframe width="560" height="315" src="${block.data.embed}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe></div>`;
        break;
      case "paragraph":
        convertedHtml += `<p>${block.data.text}</p>`;
        break;
      case "delimiter":
        convertedHtml += "<hr />";
        break;
      case "image":
        convertedHtml += `<img class="img-fluid" src="${block.data.file.url}" title="${block.data.caption}" /><br /><em>${block.data.caption}</em>`;
        break;
      case "list":
        convertedHtml += "<ul>";
        block.data.items.forEach(function(li) {
          convertedHtml += `<li>${li}</li>`;
        });
        convertedHtml += "</ul>";
        break;
      default:
        console.log("Unknown block type", block.type);
        break;
    }
  });
  return convertedHtml;
}