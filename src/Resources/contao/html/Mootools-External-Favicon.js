
window.addEvent('load', function () {

    /* grab all complete linked anchors */
    $$('a[class^="ext_favicon"]').each(function (a) {
        /* if it's not on the davidwalsh.name domain */
        if (!a.get('href').contains(window.location.host)) {
            /* get the favicon */
            var favicon = a.get('href').replace(/^(http:\/\/[^\/]+).*$/, '$1') + '/favicon.ico';
            /* place it in the anchor */
            //a.setStyle('background-image','url(' + favicon + ')').addClass('favicon');
            a.getElement('img').setProperty('src', favicon);

        }
    });
});