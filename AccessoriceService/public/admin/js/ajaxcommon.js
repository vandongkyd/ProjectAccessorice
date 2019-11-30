$(document).on('click', 'a.page-link', function (event) {
    event.preventDefault();
    ajaxLoad($(this).attr('href'));
});
function ajaxLoad(filename, content) {
    content = typeof content !== 'undefined' ? content : 'SearchResult_DIV';
    showLoading();
    $.ajax({
        type: "GET",
        url: filename,
        contentType: false,
        success: function (data) {
            $('#' + content).html(data);
            hideLoading();
        },
        error: function (xhr, status, error) {
            alert(xhr.responseText);
        }
    });
}
function ajaxDelete(filename, token, content) {
    content = typeof content !== 'undefined' ? content : 'SearchResult_DIV';
    showLoading();
    $.ajax({
        type: 'POST',
        data: {_method: 'DELETE', _token: token},
        url: filename,
        success: function (data) {
            $("#" + content).html(data);
            hideLoading();
        },
        error: function (xhr, status, error) {
            alert(xhr.responseText);
        }
    });
}

function navigateTo(url) {
    $('body').css({'pointer-events':'none'});
    sessionStorage.setItem('previous_page_url', $('#current_page_url').val());

    window.location.href = url;
}
$('.ajax-form').on('submit', function(event){
    event.preventDefault();
    showLoading();
    $('#deleteModal').modal('toggle');
    $('body').removeClass('modal-open');
    $(".modal-backdrop").remove();
    $.ajax({
        url:$(this).attr('action'),
        method:"POST",
        data:new FormData(this),
        dataType:'JSON',
        contentType: false,
        cache: false,
        processData: false,
        success:function(data)
        {
            let dataType = jQuery.type(data);
            console.log('data type = ' + dataType);
            if (data.fail) {
                hideLoading();
                $('#error').html(data.success);
                $('.success_id').css("display", "none");
                $('.error_id').css("display", "block");
                scrollTo('.error_id');
                clearErrors();
                showErrors(data.errors);
                CloseAlert();
            } else {
                hideLoading();
                $('#success').html(data.success);
                $('.error_id').css("display", "none");
                $('.success_id').css("display", "block");
                scrollTo('.success_id');
                CloseAlert();
                ajaxLoad(window.location.href = data.redirect_url);
            }
        }
    })
});
$('.ajaxdelete').submit(function (e) {
    event.preventDefault();
    content = typeof content !== 'undefined' ? content : 'SearchResult_DIV';
    showLoading();
    $('#deleteModal').modal('toggle');
    $('body').removeClass('modal-open');
    $(".modal-backdrop").remove();
    $.ajax({
        url:$(this).attr('action'),
        method:"POST",
        data:new FormData(this),
        dataType:'JSON',
        contentType: false,
        cache: false,
        processData: false,
        success:function(data)
        {
            if (data.fail) {
                hideLoading();
                $('#error').html(data.success);
                $('.success_id').css("display", "none");
                $('.error_id').css("display", "block");
                scrollTo('.error_id');
                clearErrors();
                showErrors(data.errors);
                CloseAlert();
            } else {
                hideLoading();
                $('.error_id').css("display", "none");
                $('.success_id').css("display", "block");
                $('#success').html(data.success);
                scrollTo('.success_id');
                CloseAlert();
                ajaxLoad(window.location.href = data.redirect_url);
            }
        }
    })
});

function scrollTo(tag){
    if($(tag).length > 0){
        $("html, body").animate({ scrollTop: $(tag).offset().top -90 }, 200);
        $(tag).focus();
        return;
    }
}
$('.btn_close').on('click', function (e) {
    $(".error_id").fadeOut(1000);
    $(".success_id").fadeOut(1000);
});

function CloseAlert() {
    setTimeout(function(){
        $(".error_id").fadeOut(1000);
        $(".success_id").fadeOut(1000);
    }, 1000);
}

function showErrors(errors) {
    if (errors) {
        scrollTo('#' + Object.keys(errors)[0]);

        $.each(errors, function(name, messages) {
            $('#' + name).closest('.has-feedback').addClass('has-error');

            $.each(messages, function(key, message) {
                $('#' + name).after('<span class="help-block">' + message + '</span>');
                return false;
            });
        });
    }
}
function clearErrors() {
    $.each($('.has-error'), function() {
        $(this).removeClass('has-error');
        $(this).find('.help-block').remove();
    });
}
function showLoading(){
    $.preloader.start({
        modal: true,
        src : '/img/sprites2.png'
    });
}
function hideLoading(){
    $.preloader.stop();
}

function toggleDisableInput(id){
    let input = $('#' + id);
    input.prop({
        readonly: !input.prop('readonly')
    });
}


$('#deleteModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    document.getElementById("id").value = button.data('id');
    $('#brand_name').text(button.data('name'));
    $('#f_delete').attr('action', button.data('url'));
});
$('#deleteModal2').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    document.getElementById("id").value = button.data('id');
    document.getElementById("login_id").value = button.data('login-id');
    $('#messages').text(button.data('messages'));
    $('#brand_name').text(button.data('name'));
    $('#f_delete').attr('action', button.data('url'));
});

function setupDatepicker(id) {
    $('#'+id).datepicker({
        format: 'd/m/Y',
        autoclose: true
    });
}