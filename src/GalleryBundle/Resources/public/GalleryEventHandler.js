/**
 * Created by oleg on 29.10.16.
 */
//TODO: edit image, delete image, delete album
//Gallery event handler
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
    },
    //handles image upload complete
    'onUploadComplete' : function () {
        AlbumManager.getAlbumList(function () {
            AlbumManager.getMediaList();
        });
    },
    //handles media gallery update event
    'onMediaGalleryUpdate' : function () {
        window.formElements.init(); //update elements customization

        $('#paginator li:not(.disabled) a').on('click', function () {
            window.location.hash = $(this).attr('href');
            AlbumManager.parseURL(function () {
                AlbumManager.getMediaList();
            })
        });

        $('.lazy').lazy({
            afterLoad: function(element) {
                $(element).parent().parent().fadeIn(1000);
            }
        });
    },
    //handles album update event
    'onAlbumListUpdate' : function () {
        //Set album click handler
        $('#album-list a.album-model').on('click', function(){
            window.location.hash = Routing.generateHash('get_album_medias', {
                album : $(this).data('id'),
                page: 1
            });
            AlbumManager.setActiveAlbum();
        });
    }
};
