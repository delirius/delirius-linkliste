/*
---

name: Element.getFavicons

description: Adds a site's favicon to external links on your page

license: MIT-style

requires:
  - Core/Element
  - More/URI
  - More/Assets

provides: [Element.getFavicons]

authors: [Michael Russell]

...
*/

Element.implement({
    getFavicons: function (classNamePrefix, imgExtensions) {
        var baseHost = URI.base.get('host'),
                //  externalLinks = this.getElements('a[href^="http://"], a[href^="https://"]'),
                externalLinks = this.getElements('a[class^="ext_favicon"]'),
                imgTypes = imgExtensions || ['ico', 'png'],
                classPrefix = classNamePrefix || '';


        externalLinks.each(function (a) {
            var uri = new URI(a),
                    domain, wrapper;

            if (baseHost != uri.get('host'))
                domain = uri.get('scheme') + '://' + uri.get('host');


            (function recurse(i) {
                var args = arguments,
                        favLink = domain + '/favicon.' + imgTypes[i];
                if (i >= imgTypes.length)
                    return;
                Asset.image(favLink, {
                    onload: function () {
                        // delirius: remove standard icon
                        a.getElement('img').setProperty('src', favLink);
                    },
                    onerror: function () {
                        recurse(++i)
                    }
                });
            })(0)
        });
    }
});

window.addEvent('load', function() {document.id('favicon').getFavicons('');});