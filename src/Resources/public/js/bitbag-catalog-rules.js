(function($) {
    $(document).ready(function () {
        $('.bitbag-rules a[data-form-collection="add"]').on('click', (event) => {
            const name = $(event.target).closest('form').attr('name');
            setTimeout(() => {
                $(`select[name^="${name}[productAssociationRules]"][name$="[type]"]`).last().change();
            }, 50);
        });

    });
})(jQuery);
