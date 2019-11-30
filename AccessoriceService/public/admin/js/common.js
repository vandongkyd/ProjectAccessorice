const SUCCESS = "SUCCESS";
const VALIDATION_ERROR = "VALIDATION_ERROR";
const HEADER_HEIGHT = 70;
let BASE_PATH = '';

$(document).ajaxStart(function () {
        $('#ajax_loading').show();
    })
    .ajaxStop(function () {
        $('#ajax_loading').hide();
    })
    .ajaxError(function () {
        $('#ajax_loading').hide();
    });

function scrollToTop() {
    $("html, body").animate({ scrollTop: 0 }, 150);
}

function scrollToElement(element, headerHeight) {
    $("html, body").animate({ scrollTop: $(element).offset().top - headerHeight }, 150);
}

function scrollToResolver(elem) {

    try {
        let jump = parseInt(elem.getBoundingClientRect().top * .2);

        document.body.scrollTop += jump;
        document.documentElement.scrollTop += jump;

        if (!elem.lastjump || elem.lastjump > Math.abs(jump)) {

            elem.lastjump = Math.abs(jump);

            setTimeout(function () {
                scrollToResolver(elem);
            }, "5");

        } else {
            elem.lastjump = null;
        }

    } catch (e) {

    }
}

function replaceUrlParam(url, paramName, paramValue) {

    if (paramValue == null) {
        paramValue = '';
    }

    var pattern = new RegExp('\\b(' + paramName + '=).*?(&|#|$)');
    if (url.search(pattern) >= 0) {
        return url.replace(pattern, '$1' + paramValue + '$2');
    }

    url = url.replace(/[?#]$/, '');

    let delimiter = (url.indexOf('?') !== -1 ? '&' : '?');
    return url + delimiter + paramName + '=' + paramValue;
}

function ajaxSearch(formId, url, searchResultDivId, successCallback) {

    let queryString = $("#" + formId).serialize();
    url = addQueryString(url, queryString);
    url = addQueryString(url, 'Action=search');

    url = BASE_PATH + url;

    ajaxQuery(url, "", searchResultDivId, true, successCallback);
}

function ajaxPaging(pageNum) {

    let currentUrl = window.location.href;

    currentUrl = replaceUrlParam(currentUrl, 'Pagination.PageNum', pageNum);
    currentUrl = replaceUrlParam(currentUrl, 'Action', 'paging');
    
    queryString = '';
    searchResultDivId = 'search_results';

    ajaxQuery(currentUrl, queryString, searchResultDivId, true);
}

function ajaxQuery(url, queryString, searchResultDivId, scrollToResult, successCallback) {

    url = addQueryString(url, queryString);
    ajaxUrl = addQueryString(url, 'IsAjaxRequest=true');

    $.ajax({
        async: true,
        url: ajaxUrl,
        success: function (response, status, xhr) {

            clearMessages();

            var contentType = xhr.getResponseHeader("content-type");

            if (contentType.indexOf('html') > -1) {
                // Search success
                populateSearchResult(url, response, searchResultDivId, scrollToResult);

                if (successCallback) {
                    successCallback();
                }

            } else if (contentType.indexOf('json') > -1) {

                // Search error. Some following scenarios may happen:  
                // 1. Http Session Timeout.
                // 2. There may be some search-field has invalid value.
                //    e.g.,: datetime format exception.
                logError(response);

                // Redirect if need
                if (response.redirectUrl) {
                    redirectTo(response.redirectUrl, false);
                    return;
                }

                // Display error if any
                if (response.messages) {
                    // Display error message below fields
                    displayMessages(response.messages);
                    return;
                }
            }
        }
    });
}

function addParams(existingParams, param) {
    return existingParams + "&" + param;
}

function addQueryString(url, queryString) {

    if (queryString == null || queryString == '') {
        return url;
    }

    let delimiter = '';

    if (url.indexOf('&') !== -1) {
        delimiter = '&';

    } else if (url.indexOf('?') !== -1) {
        delimiter = '&';

    } else {
        delimiter = '?';
    }

    url = url + delimiter + queryString;
    return url;
}

function serializeFormToJson(formId) {

    var elementArr, index, entry;
    elementArr = $("#" + formId).serializeArray();
    var obj = {};

    for (index = 0; index < elementArr.length; ++index) {
        entry = elementArr[index];
        obj[entry.name] = entry.value;
    }

    return obj;
}

function convertQueryStringToJson(frmData) {

    var data = frmData.split("&");
    var obj = {};

    for (var key in data) {
        var entry = data[key].split("=");
        obj[entry[0]] = entry[1];
    }

    return obj;
}

function populateSearchResult(url, response, searchResultDivId, scrollToResult) {

    $("#" + searchResultDivId).html(response);

    if (scrollToResult) {
        scrollToResolver(document.getElementById(searchResultDivId));
    }

    updateUrl(url);
}

function ajaxSubmitFormWithFile(args) {

    let formId = args.formId;
    let url = args.url;
    let success = args.success;
    let error = args.error;

    var formData = new FormData($('#' + formId)[0]);

    formData.append('IsAjaxRequest', 'true');

    $.ajax({
        async: true,
        url: url,
        dataType: 'json',
        method: 'post',
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
        },
        success: function (response) {
            processAjaxSuccess(response, false, success, error);
        },
        error: logAjaxResponseError
    });
}

function ajaxSubmit(formId, url, reloadPage, successCallback, errorCallback) {

    let form = $('#' + formId);
    let data = form.serialize();

    ajaxPost(data, url, reloadPage, successCallback, errorCallback);
}

function ajaxPost(data, url, reloadPage, successCallback, errorCallback) {

    url = BASE_PATH + url;
    ajaxData = addParams(data, 'IsAjaxRequest=true');

    $.ajax({
        async: true,
        url: url,
        type: 'POST',
        data: ajaxData,
        beforeSend: function (xhr) {
            xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
        },
        success: function (response) {
            processAjaxSuccess(response, reloadPage, successCallback, errorCallback);
        },
        error: logAjaxResponseError
    });
}

function ajaxRequest(url, reloadPage, successCallback, errorCallback) {

    url = BASE_PATH + url;

    $.ajax({
        async: true,
        url: url,
        type: 'GET',
        beforeSend: function (xhr) {
            xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
        },
        success: function (response) {
            processAjaxSuccess(response, reloadPage, successCallback, errorCallback);
        },
        error: function (xhr, status, error) {
            // TODO: handle error
            logAjaxResponseError(xhr, status, error);
        }
    });
}

function processAjaxSuccess(response, reloadPage, successCallback, errorCallback) {

    // If result is ERROR
    if (response.result !== SUCCESS) {

        logError(response);
        clearMessages();

        // Display error message below fields
        displayMessages(response.messages);

        if (errorCallback) {
            errorCallback();
        }

        return false;
    }

    // If result is SUCCESS
    if (hasValue(reloadPage) && reloadPage == true) {
        window.location.href = response.redirectUrl;
        return false;
    }

    let rsMessages = response.messages;

    clearMessages();

    let redirectUrl = response.redirectUrl;

    if (hasValue(redirectUrl)) {
        ajaxGoToPage(redirectUrl, function () {

            // Display message if any
            if (hasValue(response.messages)) {
                displayMessages(response.messages);
            }

            // Display message if any
            if (hasValue(rsMessages)) {
                displayMessages(rsMessages);
            }

            if (successCallback) {
                successCallback(response);
            }
        });

    } else {
        if (successCallback) {
            successCallback(response);
        }
    }
}

function hasValue(argument) {

    if (argument === undefined || typeof argument === 'undefined') {
        return false;
    }

    return true;
}

function clearMessages() {

    $.each($('.field-error'), function () {
        $(this).removeClass('field-error');
    });

    $('.error-message').remove();
    $('.error-label').remove();
    $('.error-asterisk').removeClass('error-label');
}

function clearMessage(element) {

    let parent = element.closest('.field-error');
    parent.removeClass('field-error');
    parent.find('span.error-message').remove();
};

function displayMessages(errors) {

    if (!errors) {
        return;
    }

    $.each(errors, function (name, messages) {

        if (isGlobalMessage(name)) {
            showGlobalMessages(name, messages);

        } else {
            showFieldMessages(name, messages);
        }
    });

    scrollToFirstErrorField(errors);
}

function showGlobalMessages(name, messages) {

    let strHtml = "<div class='global-messages'>"
    $.each(messages, function (key, message) {
        strHtml += '<span class="error-message">' + message + '</span>';
    });
    strHtml += "</div>"

    $('#global_message').html(strHtml);
}

function showFieldMessages(name, messages) {

    let field = $('#' + name);
    field.addClass('field-error');

    $.each(messages, function (key, message) {
        field.after("<span class='error-message'>" + message + "</span>");
        return false;
    });

    let label = $('#label_' + name);
    if (label) {
        let txt = "<span class='error-label'>*</span>" + label.html();
        label.html(txt);
    }

    let asterisk = $('#required_' + name);
    if (asterisk) {
        asterisk.addClass('error-asterisk');
    }
}

function scrollToFirstErrorField(errors) {

    let hasGlobalError = false;
    let firstErrField = null;

    $.each(errors, function (name, messages) {

        if (isGlobalMessage(name)) {
            // At least, it has global error
            hasGlobalError = true;

        } else {
            // We found the first error field
            firstErrField = name;
            return false;
        }
    });

    // If first error field found, then scroll to it.
    if (firstErrField != null) {
        scrollToElement($('#' + firstErrField), HEADER_HEIGHT);

    } else if (hasGlobalError) {
        // Otherwise, if has global error, then scroll to top
        scrollToTop();
    }
}

function isGlobalMessage(name) {
    return (name == 'global');
}

function redirectTo(pageUrl) {
    url = BASE_PATH + pageUrl;
    window.location.href = url;
}

function navigateToPage(args) {

    let url = args.url;
    let success = args.success;
    let requestHeaders = args.requestHeaders;

    url = BASE_PATH + url;
    ajaxGoToPage(url, success, requestHeaders);
}

function goToPage(pageUrl, successCallback, requestHeaders) {
    url = BASE_PATH + pageUrl;
    ajaxGoToPage(url, successCallback, requestHeaders);
}

function ajaxGoToPage(url, successCallback, requestHeaders) {

    ajaxUrl = addQueryString(url, 'IsAjaxRequest=true');

    $.ajax({
        async: true,
        url: ajaxUrl,
        type: 'GET',
        beforeSend: function (xhr) {

            xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());

            try {
                if (hasValue(requestHeaders)) {

                    $.each(requestHeaders, function (name, value) {
                        xhr.setRequestHeader(name, value);
                    });
                }

            } catch (e) {

            }
        },
        success: function (htmlContent) {

            clearMessages();
            $('#main-content-div').html(htmlContent);

            scrollToTop();

            updateUrl(url);
            selectMenuItem();

            if (successCallback) {
                successCallback();
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
        }
    });
}

function updateUrl(url) {
    window.history.pushState("Module", "Title", url);
}

function isStartsWith(pathName, urls) {

    var len = urls.length;

    for (index = 0; index < len; index++) {
        if (pathName.indexOf(urls[index]) == 0) {
            return true;
        }
    }

    return false;
}

const MENU_ITEM_DASHBOARD = 'menu-item-dashboard';

const DASHBOARD_URLs = [
    '/Dashboard'
];

function selectMenuItem() {

    let pathName = window.location.pathname;
    let menuItemId;

    logDebug('selectMenuItem::pathName=' + pathName);

    if (pathName == '/Dashboard'
        || pathName == '/Dashboard/'
        || isStartsWith(pathName, DASHBOARD_URLs)) {
        menuItemId = MENU_ITEM_DASHBOARD;
 
    }

    $('ul#sidebar-menu li.active').removeClass('active');

    $('#' + menuItemId).addClass('active');
}

function logAjaxResponseError(xhr, status, error) {
    logError('Status: \n' + status);
    logError('Error: \n' + error);
    logError('Response text: \n' + xhr.responseText);
}

function logError(response) {
    console.error(response);
}

function logDebug(response) {
    console.log(response);
}

function setupDatepicker(id) {
    $('#'+id).datepicker({
        format: 'd/m/Y',
        autoclose: true
    });
}