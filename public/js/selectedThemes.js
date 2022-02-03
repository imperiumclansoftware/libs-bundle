$(document).ready(function(){

    $('a[data_theme="select"]').click(function() {
        var themaName = $(this).attr('data_theme_select');

        $.ajax({
            url: updateThemeUrl + '/' + themaName,
        }).done(function(data){
            if(data == 'Ok')
            {
                location.reload();
            }
        })
    });



});