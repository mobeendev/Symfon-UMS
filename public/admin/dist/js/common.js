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



const hideFilterMiniLoader = () => {
    $('#ajax_wrapper').hide();
    $('#ajax_wrapper_filter').empty();
}

const showFilterMiniLoader = () => {
    $('#ajax_wrapper_filter').empty().append('<img src="/assets/admin/images/loading.gif" />');
    $('#ajax_wrapper').show();
}

const searchUser = (page, redirectUrl=null) => {
    $('.js-user-autocomplete').each(function () {
        let autocompleteUrl = $(this).data('autocomplete-url');
        $(this).autocomplete(
            { hint: false, minLength: 3, maxLength: 255 },
            [
                {
                    source: function (query, cb) {
                        $.ajax({
                            type: "POST",
                            url: autocompleteUrl + '?q=' + query,
                            beforeSend: function() {
                                showFilterMiniLoader();
                            },
                            error: function () {
                                renderUserNotFoundError();
                                hideFilterMiniLoader();
                            }
                        }).then(function (data) {
                            $('#user-validation-feedback').html('');
                            cb(data.authors);
                        })
                    },
                    displayKey: 'displayName',
                    debounce: 500,
                    templates: {
                        suggestion(suggestion) {
                            return `<div class="intro-x">
                                        <div class="box px-2 py-1 flex items-center zoom-in">
                                            <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                                                <img src="https://i.pravatar.cc/32?u=${(suggestion.email)}">
                                            </div>
                                            <div class="ml-2 mr-auto">
                                                <div class="font-medium"> ${(suggestion.displayName)}</div>
                                                <div class="text-gray-600 text-xs">Phone: ${(suggestion.phone ? suggestion.phone : '')}</div>
                                            </div>
                                        </div>
                                    </div>`;
                        }
                    },
                }
            ]
        );
    }).on('autocomplete:selected', function (event, suggestion) {
        let userObj =  JSON.stringify({'user_id':suggestion.id, 'search_term':$('.js-user-autocomplete').val()});
        $('#user').val('');
        $('#user').val(suggestion.id);

        switch (page) {
            case 'books':
                localStorage.removeItem('selected_books');
                localStorage.setItem('selected_books',userObj);
                break;
            default:
                text = "No value found";
                break;
        }
        hideFilterMiniLoader();
    });
}

const isEmpty = (value) => {
    return (value == null || value.length === 0);
}