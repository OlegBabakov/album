/**
 * Created by oleg on 29.10.16.
 */
//TODO: edit image, delete image, delete album

var Templating = {
    //Render album list
    'renderAlbumList' : function() {
        var html = '';
        var template = $('#album-list-template').html();

        var activeAlbumId = null;
        if (AlbumManager.data.activeAlbum) {
            activeAlbumId = AlbumManager.data.activeAlbum.id;
        }

        AlbumManager.data.albumList.forEach(function (album) {
            html += Mustache.render(template, {
                'id'          : album.id,
                'title'       : album.title,
                'mediasCount' : album.mediasCount,
                'active'      : album.id == activeAlbumId ? 'active' : ''
            });
        });

        if (html) $('#album-list').html('<h4>Albums:</h4>' + html);
        $('a.album-model').on('click', function(){
            AlbumManager.setActiveAlbum($(this));
        });
    },

    //Render media list of current album and page
    'renderMediaList' : function(mediaList) {
        var html = '';
        var template = $('#gallery-image-template').html();

        mediaList.forEach(function (media) {
            html += Mustache.render(template, {
                'id'          : media.id,
                'url'         : media.url,
                'thumb'       : media.thumb ? media.thumb : media.url,
                'title'       : media.title,
                'description' : media.description
            });
        });

        if (html) {
            $('#empty-gallery-message').hide();
        } else {
            $('#empty-gallery-message').show();
        }
        $('#links').html(html);
        GalleryEventHandler.onMediaGalleryUpdate();
    }
};
