/**
 * Created by oleg on 01.11.16.
 */
$(function () {

    $(document).ajaxComplete(function() {
        GalleryEventHandler.onAjaxReload();
    });

    //Get current album and page from URL
    AlbumManager.getAlbumList(function() {
        if (AlbumManager.data.albumList) {
            if (!AlbumManager.data.activeAlbum.id) AlbumManager.data.activeAlbum.id = 1;
            if (!AlbumManager.data.currentPage)    AlbumManager.data.currentPage = 1;
        }
        AlbumManager.setActiveAlbum()
    });


    $("#modal-album-add").on("hidden.bs.modal", function () {
        var input = $('#add-album-title');
        input.removeClass('error');
    });

    $('#add-album-submit').click(function(){
        var input = $('#add-album-title');
        if (!input.val()) {
            input.addClass('error');
            return;
        }
        AlbumManager.addAlbum(
            input.val(),
            function (success) {
                $("#modal-album-add").modal('hide');
            }
        )
    });

    $('.upload-button').click(function(){
        $('#photo-dropzone').click();
    });

    // Every time a modal is shown, if it has an autofocus element, focus on it.
    $('.modal').on('shown.bs.modal', function() {
        $(this).find('[autofocus]').focus();
    });

});