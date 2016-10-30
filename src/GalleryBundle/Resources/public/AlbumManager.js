/**
 * Created by oleg on 29.10.16.
 */
//TODO: edit image, delete image, delete album

//Object to manage gallery data
var AlbumManager = {
    // Add album
    // @param title
    // @param callback: function(success)
    'addAlbum' : function(title, callback) {
        $.ajax({
            type: "POST",
            url: Routing.generate('post_albums'),
            data: JSON.stringify({
                'title' : title
            }),
            success: function (result) {
                if (callback) callback();
                if (result.id) AlbumManager.getAlbumList();
            },
            error: function (result) {
                GalleryEventHandler.onGalleryError('Error occurred while the album adding')
            }
        });
    },
    // Returns album list and render
    'getAlbumList' : function(callback) {
        $.ajax({
            type: "GET",
            url: Routing.generate('get_albums'),
            success: function (result) {
                if (result) {
                    AlbumManager.data.albumList = result;
                    Templating.renderAlbumList();
                }
                if (callback) callback();
            },
            error: function () {
                GalleryEventHandler.onGalleryError('Error occurred while album list update')
            }
        });
    },
    // Set current album and updates interface
    'setActiveAlbum' : function(albumModelElement, callback) {
        if (AlbumManager.data.activeAlbum) {
            $('.album-model[data-id='+ AlbumManager.data.activeAlbum.id +']').removeClass('active'); //remove active from prev album
        }
        albumModelElement.addClass('active');

        AlbumManager.data.activeAlbum = {
            'id'    : albumModelElement.data('id'),
            'title' : albumModelElement.data('title')
        };
        AlbumManager.getMediaList();

        $('#photo-dropzone input[name=album]').val(
            AlbumManager.data.activeAlbum.id
        );
        $('#album-title').html(
            AlbumManager.data.activeAlbum.title
        );
    },
    // Updates medias gallery for current album
    'getMediaList' : function(callback) {
        if (AlbumManager.data.activeAlbum && AlbumManager.data.currentPage) {
            $.ajax({
                type: "GET",
                url: Routing.generate('get_album_medias', {
                    'album' : AlbumManager.data.activeAlbum.id,
                    'page'  : AlbumManager.data.currentPage
                }),
                success: function (result) {
                    if (result) Templating.renderMediaList(result);
                    if (callback) callback();
                },
                error: function () {
                    GalleryEventHandler.onGalleryError('Error occurred while album list update')
                }
            });
        }
    },

    'data' : {
        'albumList' : {},     //album list
        'activeAlbum' : null, //current album
        'currentPage' : 1
    }
};
