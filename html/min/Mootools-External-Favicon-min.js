window.addEvent("load",function(){$$('a[class^="ext_favicon"]').each(function(t){if(!t.get("href").contains(window.location.host)){var e=t.get("href").replace(/^(http:\/\/[^\/]+).*$/,"$1")+"/favicon.ico";t.getElement("img").setProperty("src",e)}})});