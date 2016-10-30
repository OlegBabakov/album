/**
 * Created by oleg on 29.10.16.
 */
//TODO: edit image, delete image, delete album

var GalleryEventHandler = {
    // Handles gallery work errors
    // @param boolean success
    'onGalleryError' : function(message) {
        showMessageBox('#message-box-danger', message);
    },
    'onGallerySuccess' : function(message) {
        showMessageBox('#message-box-success', message);
    },
    //update handlers after ajax reload
    'onAjaxReload' : function () {
        //Album selector handlers
        // $('a.album-model').on('click', function(){
        //     AlbumManager.setActiveAlbum($(this));
        // });
    },
    //handles image upload complete
    'onUploadComplete' : function () {
        AlbumManager.getAlbumList(function () {
            $('.album-model[data-id='+ AlbumManager.data.activeAlbum.id +']').effect("highlight", {}, 3000); //Highlight album after update
        });
        AlbumManager.getMediaList();
    },
    //handles media gallery update event
    'onMediaGalleryUpdate' : function () {
        window.formElements.init(); //update elements customization

        $('.gallery-item-edit')
            .unbind( "click" )
            .on('click', function () {
                $("#modal_media_edit").modal('show');
            })
    }
};
