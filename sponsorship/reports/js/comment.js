
$(document).ready(function() {


    $('.delete').click(function() {
        var id = $(this).attr('id').replace('d', '');
        var confirmit = confirm('Are you sure you want to delete this comment.\nThis action cannot be undone.');
        if (confirmit) {
            $('#pid').val($(this).attr('id').replace('d', ''));
            $('#formaction').val('delete');
            $('#registration').submit();
        }
    });

    $('.toggleButton').click(function() {
        var id = $(this).attr('id').replace('de', '');
        $('#pid').val(id);
        $('#formaction').val($(this).val());
        $('#registration').submit();
    });

});