$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ajaxSend(function(event, jqxhr, settings) 
{
    if (settings.type == 'POST')
    {
        $(`form[action="${settings.url}"] [type="submit"]`).prop('disabled', true).append(' <span class="loading loading-spinner"></span>');
    }
});

$(document).ajaxComplete(function(event, jqxhr, settings) 
{
    $(`form[action="${settings.url}"] [type="submit"]`).prop('disabled', false).find('.loading').remove();
});

$(document).ajaxError(function() 
{
    Swal.fire({
        icon: 'error',
        text: 'Something went wrong, please try again',
    });
});
