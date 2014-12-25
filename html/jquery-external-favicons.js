
$(window).load(function () {
    var externalLinks = $('a[class^="ext_favicon"]');
    $.each(externalLinks, function (key, val) {
        var aURL = "" + val;

        var faviconURL = aURL.replace(/^(http:\/\/[^\/]+).*$/, "$1") + '/favicon.ico';
        var faviconIMG = $(this).children('img');
        var extImg = new Image();

        extImg.src = faviconURL;


        extImg.onload = function () {
            faviconIMG.attr('src', faviconURL);
        };



    });

});