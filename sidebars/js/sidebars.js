(function ($) {

    // Form validation
    $('#submit-button').click(function (e) {
        var $sidebarTitle = $('#sidebar-title'),
            $sidebarAlias = $('#sidebar-alias'),
            sidebarTitle = $sidebarTitle.val().trim(),
            sidebarAlias = $sidebarAlias.val().trim();

        $sidebarTitle.css('border-color', '');
        $sidebarAlias.css('border-color', '');

        if (sidebarTitle == '') {
            $sidebarTitle.css('border-color', 'Red');
        }

        if (sidebarAlias == '') {
            $sidebarAlias.css('border-color', 'Red');
        }

        if (sidebarTitle != '' && sidebarAlias != '') {
            $('#add-edit-sidebar').submit();
        }
    });

})(jQuery);
