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
                'href'        : '#'+Routing.generateHash('get_album_medias', {
                    album : album.id,
                    page: 1
                }),
                'title'       : album.title,
                'mediasCount' : album.mediasCount,
                'active'      : album.id == activeAlbumId ? 'active' : ''
            });
        });

        if (html) $('#album-list').html('<h4>Albums:</h4>' + html);
        GalleryEventHandler.onAlbumListUpdate();
    },

    //Render media list of current album and page
    'renderMediaList' : function(galleryData) {
        var html = '';
        var template = $('#gallery-image-template').html();

        galleryData.medias.forEach(function (media) {
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
        $('#paginator').html(galleryData.paginator);

        GalleryEventHandler.onMediaGalleryUpdate();
    }
};
