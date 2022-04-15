let delete_url = "{{ path('admin_ajax_delete_entity', {id: 'ID_ENTITY' , entityType:'TYPE_ENTITY'}  ) }}";

let filterPlaceholderText = "type to filter";
const startLoader = () => {
    $.LoadingOverlay("show", {
        background: "rgba(255, 255, 255, 0.5)"
    });
}
const stopLoader = () => {
    $.LoadingOverlay("hide");
}
const renderUserNotFoundError = () => {
    let error = `<span class="text-theme-6">User not found!</span>`;
    $('#user-validation-feedback').html(error);
}
const renderUserNotSelectedError = () => {
    let error = `<span class="text-theme-6">Please select a user!</span>`;
    $('#user-validation-feedback').html(error);
}

const showAjaxLoader = () => {
    $('#ajax_wrapper').empty().append('<img src="/assets/admin/images/loading.gif" />');
}

const hideAjaxLoader = () => {
    $('#ajax_wrapper').empty();
}

const renderError = (msg,element) => {
    let element_id = "#"+ element;
    let error = `<span class="text-theme-6">${msg}</span>`;
    $(element_id).html(error);
}

$(document).ready(function() {
    $('.select2').select2({
        width: '100%',
    });
    $(document).on('click', '.navigation', function(e) {
        startLoader();
    });

    $('.input-upload-file').on('click', function() {
        $(this).parent().find('#upload_file_filename').trigger('click');
    });
    $('.file-upload-input').on('change', function() {
        $(this).parent().parent().parent().submit();
        startLoader();
    });

    $('#filter-menu').click(function() {
        $("i", this).toggleClass("fa-times fa-filter ");
        // $("i", this).toggleClass("filter x");
        $(".toggle-filter").fadeToggle();        
    });    
});

const refreshPage = function(time = 500) {
    setTimeout(function() {
        window.location.reload(true);
    }, time);
}

const showCounter = function(time = 3000) {
    let timeleft = time / 1000;
    let reloadTimer = setInterval(function() {
        if (timeleft <= 0) {
            clearInterval(reloadTimer);
            document.getElementById("countdown").innerHTML = "Reloading...";
        } else {
            document.getElementById("countdown").innerHTML = "Page will refresh in " + timeleft + " seconds ";
        }
        timeleft -= 1;
    }, 1000);
}


