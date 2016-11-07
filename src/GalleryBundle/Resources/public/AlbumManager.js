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
        AlbumManager.parseURL();
        if (!AlbumManager.data.activeAlbum.id) return 0;
        $('.album-model').removeClass('active'); //remove active from prev album

        albumModelElement = $('.album-model[data-id='+ AlbumManager.data.activeAlbum.id +']');
        if (albumModelElement.length) { //Checks that album list was loaded before
            albumModelElement.addClass('active');
            AlbumManager.getMediaList();
            //Dropzone
            $('#photo-dropzone input[name=album]').val(AlbumManager.data.activeAlbum.id);
            //Album Title
            $('#album-title').html(albumModelElement.data('title'));
        }
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
    // URL parsing and update gallery parameters
    'parseURL': function (callback) {
        var path = window.location.hash;
        if (path) {
            path = path.replace('#','');
            var parts = path.split('/');

            if (parts[0] == 'albums' && parts[2] == 'page' &&
                Number.isInteger(parseInt(parts[1])) && Number.isInteger(parseInt(parts[3])) ) {

                AlbumManager.data.activeAlbum.id = parseInt(parts[1]);
                AlbumManager.data.currentPage    = parseInt(parts[3]);
            }
        }
        if (callback) callback();
    },
    'data' : {
        'albumList' : null,     //album list
        'activeAlbum' : { //current album
            'id'   : null,
            'title': null
        },
        'currentPage' : 1
    }
};
