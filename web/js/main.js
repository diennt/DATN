(function (window, $, undefined) {

    $(function () {

//        $('select').chosen();

        $('.dropdown-toggle').dropdown();

        // Fix input element click problem
        $('.dropdown input, .dropdown label').click(function (e) {
            e.stopPropagation();
        });

        $('.table-row-click > tbody > tr > td')
            .on('click', function (e) {
                var $target = $(e.target);
                if ($target.attr('class').indexOf('__action') == -1) {
                    if ($target.attr('class').indexOf('action') == -1){
                        var url = $(this).parent().data('url');
                        if (url) {
                            window.location = url;
                        }
                    }else {
                        return true;
                    }
                }else{
                    return false;
                }
            });

        $('.on-change-submit')
            .on('change', function (e) {
                $(this)
                    .closest('form')
                    .trigger('submit');
            });

        $('.popover-handle')
            .popover()
            .on('click', function (e) {
                e.preventDefault();
                $(this).parent().find('.popover').find('input.grid-filter-input-query-from').focus();
            })
        ;

        $('.select-all')
            .on('click', function (e) {
                e.preventDefault();
            });

        $('[id^="grid_"]').each(function () {
            $(this).find('.pagination ul').prepend($(this).find('.first')).append($(this).find('.last'));
        })

    });

})(window, jQuery);
