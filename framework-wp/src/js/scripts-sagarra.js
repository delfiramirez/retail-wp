var $ = jQuery.noConflict();
function sagarraWindow() {
    console.log("ready");
    console.log($("window").width(), $("window").height());
}

$(window).scroll(function() {	
	var scrollTop = $(window).scrollTop(); 
	var elementTop = $('#content-sagarra').offset().top;
 
	if(scrollTop >= elementTop) {
		$('#content-sagarra h1').addClass('scrolled');
		$('#content-sagarra p').addClass('scrolled');
	}
});
/*
$(document).ready(function () {
     $(window)    
          .bind('orientationchange', function(){
               if (window.orientation % 180 == 0){
                   $(document.body).css("-webkit-transform-origin", "")
                       .css("-webkit-transform", "");               
               } 
               else {                   
                   if ( window.orientation > 0) { //clockwise
                     $(document.body).css("-webkit-transform-origin", "200px 190px")
                       .css("-webkit-transform",  "rotate(-90deg)");  
                   }
                   else {
                     $(document.body).css("-webkit-transform-origin", "280px 190px")
                       .css("-webkit-transform",  "rotate(90deg)"); 
                   }
               }
           })
          .trigger('orientationchange'); 
});
*/



$(document).ready(function() {
    $("html").niceScroll();
    $('#sgr').hide();
    $("body").removeClass("preload");
    $('.sagarra-logo h1').mouseenter(function() {
        sagarraWindow();
        $('#sgr').show('slow', 400);
    });
    $('.boxee').fadeIn(500);
    var imgarr = new Array();
    for (var i = 1; i <= 73; ++i) {
        imgarr.push(i);
    }

});

jQuery(document).ready(function($){

 $('.wp-caption-text').hide();   

 $('.gallery-item').hover(function(){
  $(this).children('.wp-caption-text').toggle();
 });

});

$(function() {
    var url = window.location.pathname, urlRegExp = new RegExp(url == '/' ? window.location.origin + '/?$' : url.replace(/\/$/, ''));
    $('#sgr li a').each(function() {
        if (urlRegExp.test(this.href.replace(/\/$/, ''))) {
            $(this).addClass('active');
        }
    });
});



//Create HTML5 Placeholder in Forms

$(function() {
    var input = document.createElement("input");
    if (('placeholder' in input) == false) {
        $('[placeholder]').focus(function() {
            var i = $(this);
            if (i.val() == i.attr('placeholder')) {
                i.val('').removeClass('placeholder');
                if (i.hasClass('password')) {
                    i.removeClass('password');
                    this.type = 'password';
                }
            }
        }).blur(function() {
            var i = $(this);
            if (i.val() == '' || i.val() == i.attr('placeholder')) {
                if (this.type == 'password') {
                    i.addClass('password');
                    this.type = 'text';
                }
                i.addClass('placeholder').val(i.attr('placeholder'));
            }
        }).blur().parents('form').submit(function() {
            $(this).find('[placeholder]').each(function() {
                var i = $(this);
                if (i.val() == i.attr('placeholder'))
                    i.val('');
            })
        });
    }
});


/*
 *************************************************************************************************************

 Table of Content:
 - HTML5 Shiv
 - Respond
 - FitVids
 - iOS Orientationchange Fix
 - ResponsiveSlides
 - imagesLoaded

 *************************************************************************************************************/
/*! matchMedia() polyfill - Test a CSS media type/query in JS. Authors & copyright (c) 2012: Scott Jehl, Paul Irish, Nicholas Zakas. Dual MIT/BSD license */
/*! NOTE: If you're already including a window.matchMedia polyfill via Modernizr or otherwise, you don't need this part */
window.matchMedia = window.matchMedia || function(a) {
    "use strict";
    var c, d = a.documentElement, e = d.firstElementChild || d.firstChild, f = a.createElement("body"), g = a.createElement("div");
    return g.id = "mq-test-1", g.style.cssText = "position:absolute;top:-100em", f.style.background = "none", f.appendChild(g), function(a) {
        return g.innerHTML = '&shy;<style media="' + a + '"> #mq-test-1 { width: 42px; }</style>', d.insertBefore(f, e), c = 42 === g.offsetWidth, d.removeChild(f), {matches: c, media: a}
    }
}(document);

/*! Respond.js v1.1.0: min/max-width media query polyfill. (c) Scott Jehl. MIT/GPLv2 Lic. j.mp/respondjs  */
(function(a) {
    "use strict";
    function x() {
        u(!0)
    }
    var b = {};
    if (a.respond = b, b.update = function() {
    }, b.mediaQueriesSupported = a.matchMedia && a.matchMedia("only all").matches, !b.mediaQueriesSupported) {
        var q, r, t, c = a.document, d = c.documentElement, e = [], f = [], g = [], h = {}, i = 30, j = c.getElementsByTagName("head")[0] || d, k = c.getElementsByTagName("base")[0], l = j.getElementsByTagName("link"), m = [], n = function() {
            for (var b = 0; l.length > b; b++) {
                var c = l[b], d = c.href, e = c.media, f = c.rel && "stylesheet" === c.rel.toLowerCase();
                d && f && !h[d] && (c.styleSheet && c.styleSheet.rawCssText ? (p(c.styleSheet.rawCssText, d, e), h[d] = !0) : (!/^([a-zA-Z:]*\/\/)/.test(d) && !k || d.replace(RegExp.$1, "").split("/")[0] === a.location.host) && m.push({href: d, media: e}))
            }
            o()
        }, o = function() {
            if (m.length) {
                var a = m.shift();
                v(a.href, function(b) {
                    p(b, a.href, a.media), h[a.href] = !0, setTimeout(function() {
                        o()
                    }, 0)
                })
            }
        }, p = function(a, b, c) {
            var d = a.match(/@media[^\{]+\{([^\{\}]*\{[^\}\{]*\})+/gi), g = d && d.length || 0;
            b = b.substring(0, b.lastIndexOf("/"));
            var h = function(a) {
                return a.replace(/(url\()['"]?([^\/\)'"][^:\)'"]+)['"]?(\))/g, "$1" + b + "$2$3")
            }, i = !g && c;
            b.length && (b += "/"), i && (g = 1);
            for (var j = 0; g > j; j++) {
                var k, l, m, n;
                i ? (k = c, f.push(h(a))) : (k = d[j].match(/@media *([^\{]+)\{([\S\s]+?)$/) && RegExp.$1, f.push(RegExp.$2 && h(RegExp.$2))), m = k.split(","), n = m.length;
                for (var o = 0; n > o; o++)
                    l = m[o], e.push({media: l.split("(")[0].match(/(only\s+)?([a-zA-Z]+)\s?/) && RegExp.$2 || "all", rules: f.length - 1, hasquery: l.indexOf("(") > -1, minw: l.match(/\(min\-width:[\s]*([\s]*[0-9\.]+)(px|em)[\s]*\)/) && parseFloat(RegExp.$1) + (RegExp.$2 || ""), maxw: l.match(/\(max\-width:[\s]*([\s]*[0-9\.]+)(px|em)[\s]*\)/) && parseFloat(RegExp.$1) + (RegExp.$2 || "")})
            }
            u()
        }, s = function() {
            var a, b = c.createElement("div"), e = c.body, f = !1;
            return b.style.cssText = "position:absolute;font-size:1em;width:1em", e || (e = f = c.createElement("body"), e.style.background = "none"), e.appendChild(b), d.insertBefore(e, d.firstChild), a = b.offsetWidth, f ? d.removeChild(e) : e.removeChild(b), a = t = parseFloat(a)
        }, u = function(a) {
            var b = "clientWidth", h = d[b], k = "CSS1Compat" === c.compatMode && h || c.body[b] || h, m = {}, n = l[l.length - 1], o = (new Date).getTime();
            if (a && q && i > o - q)
                return clearTimeout(r), r = setTimeout(u, i), void 0;
            q = o;
            for (var p in e)
                if (e.hasOwnProperty(p)) {
                    var v = e[p], w = v.minw, x = v.maxw, y = null === w, z = null === x, A = "em";
                    w && (w = parseFloat(w) * (w.indexOf(A) > -1 ? t || s() : 1)), x && (x = parseFloat(x) * (x.indexOf(A) > -1 ? t || s() : 1)), v.hasquery && (y && z || !(y || k >= w) || !(z || x >= k)) || (m[v.media] || (m[v.media] = []), m[v.media].push(f[v.rules]))
                }
            for (var B in g)
                g.hasOwnProperty(B) && g[B] && g[B].parentNode === j && j.removeChild(g[B]);
            for (var C in m)
                if (m.hasOwnProperty(C)) {
                    var D = c.createElement("style"), E = m[C].join("\n");
                    D.type = "text/css", D.media = C, j.insertBefore(D, n.nextSibling), D.styleSheet ? D.styleSheet.cssText = E : D.appendChild(c.createTextNode(E)), g.push(D)
                }
        }, v = function(a, b) {
            var c = w();
            c && (c.open("GET", a, !0), c.onreadystatechange = function() {
                4 !== c.readyState || 200 !== c.status && 304 !== c.status || b(c.responseText)
            }, 4 !== c.readyState && c.send(null))
        }, w = function() {
            var b = !1;
            try {
                b = new a.XMLHttpRequest
            } catch (c) {
                b = new a.ActiveXObject("Microsoft.XMLHTTP")
            }
            return function() {
                return b
            }
        }();
        n(), b.update = n, a.addEventListener ? a.addEventListener("resize", x, !1) : a.attachEvent && a.attachEvent("onresize", x)
    }
})(this);

/*!
 * FitVids 1.0
 *
 * Copyright 2011, Chris Coyier - http://css-tricks.com + Dave Rupert - http://daverupert.com
 * Credit to Thierry Koblentz - http://www.alistapart.com/articles/creating-intrinsic-ratios-for-video/
 * Released under the WTFPL license - http://sam.zoy.org/wtfpl/
 *
 * Date: Thu Sept 01 18:00:00 2011 -0500
 */
(function(a) {
    "use strict";
    a.fn.fitVids = function(b) {
        var c = {customSelector: null}, d = document.createElement("div"), e = document.getElementsByTagName("base")[0] || document.getElementsByTagName("script")[0];
        return d.className = "fit-vids-style", d.innerHTML = "&shy;<style>               .fluid-width-video-wrapper {                 width: 100%;                              position: relative;                       padding: 0;                            }                                                                                   .fluid-width-video-wrapper iframe,        .fluid-width-video-wrapper object,        .fluid-width-video-wrapper embed {           position: absolute;                       top: 0;                                   left: 0;                                  width: 100%;                              height: 100%;                          }                                       </style>", e.parentNode.insertBefore(d, e), b && a.extend(c, b), this.each(function() {
            var b = ["iframe[src*='player.vimeo.com']", "iframe[src*='www.youtube.com']", "iframe[src*='www.youtube-nocookie.com']", "iframe[src*='www.kickstarter.com']", "object", "embed"];
            c.customSelector && b.push(c.customSelector);
            var d = a(this).find(b.join(","));
            d.each(function() {
                var b = a(this);
                if (!("embed" === this.tagName.toLowerCase() && b.parent("object").length || b.parent(".fluid-width-video-wrapper").length)) {
                    var c = "object" === this.tagName.toLowerCase() || b.attr("height") && !isNaN(parseInt(b.attr("height"), 10)) ? parseInt(b.attr("height"), 10) : b.height(), d = isNaN(parseInt(b.attr("width"), 10)) ? b.width() : parseInt(b.attr("width"), 10), e = c / d;
                    if (!b.attr("id")) {
                        var f = "fitvid" + Math.floor(999999 * Math.random());
                        b.attr("id", f)
                    }
                    b.wrap('<div class="fluid-width-video-wrapper"></div>').parent(".fluid-width-video-wrapper").css("padding-top", 100 * e + "%"), b.removeAttr("height").removeAttr("width")
                }
            })
        })
    }
})(jQuery);

/*! A fix for the iOS orientationchange zoom bug. Script by @scottjehl, rebound by @wilto.MIT / GPLv2 License.*/
(function(a) {
    function m() {
        d.setAttribute("content", g), h = !0
    }
    function n() {
        d.setAttribute("content", f), h = !1
    }
    function o(b) {
        l = b.accelerationIncludingGravity, i = Math.abs(l.x), j = Math.abs(l.y), k = Math.abs(l.z), (!a.orientation || a.orientation === 180) && (i > 7 || (k > 6 && j < 8 || k < 8 && j > 6) && i > 5) ? h && n() : h || m()
    }
    var b = navigator.userAgent;
    if (!(/iPhone|iPad|iPod/.test(navigator.platform) && /OS [1-5]_[0-9_]* like Mac OS X/i.test(b) && b.indexOf("AppleWebKit") > -1))
        return;
    var c = a.document;
    if (!c.querySelector)
        return;
    var d = c.querySelector("meta[name=viewport]"), e = d && d.getAttribute("content"), f = e + ",maximum-scale=1", g = e + ",maximum-scale=10", h = !0, i, j, k, l;
    if (!d)
        return;
    a.addEventListener("orientationchange", m, !1), a.addEventListener("devicemotion", o, !1)
})(this);


/*! http://responsiveslides.com v1.53 by @viljamis */
(function(c, I, B) {
    c.fn.responsiveSlides = function(l) {
        var a = c.extend({auto: !0, speed: 500, timeout: 4E3, pager: !1, nav: !1, random: !1, pause: !1, pauseControls: !0, prevText: "Previous", nextText: "Next", maxwidth: "", navContainer: "", manualControls: "", namespace: "rslides", before: function() {
            }, after: function() {
            }}, l);
        return this.each(function() {
            B++;
            var f = c(this), s, r, t, m, p, q, n = 0, e = f.children(), C = e.size(), h = parseFloat(a.speed), D = parseFloat(a.timeout), u = parseFloat(a.maxwidth), g = a.namespace, d = g + B, E = g + "_nav " + d + "_nav", v = g + "_here",
                    j = d + "_on", w = d + "_s", k = c("<ul class='" + g + "_tabs " + d + "_tabs' />"), x = {"float": "left", position: "relative", opacity: 1, zIndex: 2}, y = {"float": "none", position: "absolute", opacity: 0, zIndex: 1}, F = function() {
                var b = (document.body || document.documentElement).style, a = "transition";
                if ("string" === typeof b[a])
                    return!0;
                s = ["Moz", "Webkit", "Khtml", "O", "ms"];
                var a = a.charAt(0).toUpperCase() + a.substr(1), c;
                for (c = 0; c < s.length; c++)
                    if ("string" === typeof b[s[c] + a])
                        return!0;
                return!1
            }(), z = function(b) {
                a.before();
                F ? (e.removeClass(j).css(y).eq(b).addClass(j).css(x),
                        n = b, setTimeout(function() {
                    a.after()
                }, h)) : e.stop().fadeOut(h, function() {
                    c(this).removeClass(j).css(y).css("opacity", 1)
                }).eq(b).fadeIn(h, function() {
                    c(this).addClass(j).css(x);
                    a.after();
                    n = b
                })
            };
            a.random && (e.sort(function() {
                return Math.round(Math.random()) - 0.5
            }), f.empty().append(e));
            e.each(function(a) {
                this.id = w + a
            });
            f.addClass(g + " " + d);
            l && l.maxwidth && f.css("max-width", u);
            e.hide().css(y).eq(0).addClass(j).css(x).show();
            F && e.show().css({"-webkit-transition": "opacity " + h + "ms ease-in-out", "-moz-transition": "opacity " +
                        h + "ms ease-in-out", "-o-transition": "opacity " + h + "ms ease-in-out", transition: "opacity " + h + "ms ease-in-out"});
            if (1 < e.size()) {
                if (D < h + 100)
                    return;
                if (a.pager && !a.manualControls) {
                    var A = [];
                    e.each(function(a) {
                        a += 1;
                        A += "<li><a href='#' class='" + w + a + "'>" + a + "</a></li>"
                    });
                    k.append(A);
                    l.navContainer ? c(a.navContainer).append(k) : f.after(k)
                }
                a.manualControls && (k = c(a.manualControls), k.addClass(g + "_tabs " + d + "_tabs"));
                (a.pager || a.manualControls) && k.find("li").each(function(a) {
                    c(this).addClass(w + (a + 1))
                });
                if (a.pager || a.manualControls)
                    q =
                            k.find("a"), r = function(a) {
                        q.closest("li").removeClass(v).eq(a).addClass(v)
                    };
                a.auto && (t = function() {
                    p = setInterval(function() {
                        e.stop(!0, !0);
                        var b = n + 1 < C ? n + 1 : 0;
                        (a.pager || a.manualControls) && r(b);
                        z(b)
                    }, D)
                }, t());
                m = function() {
                    a.auto && (clearInterval(p), t())
                };
                a.pause && f.hover(function() {
                    clearInterval(p)
                }, function() {
                    m()
                });
                if (a.pager || a.manualControls)
                    q.bind("click", function(b) {
                        b.preventDefault();
                        a.pauseControls || m();
                        b = q.index(this);
                        n === b || c("." + j).queue("fx").length || (r(b), z(b))
                    }).eq(0).closest("li").addClass(v),
                            a.pauseControls && q.hover(function() {
                        clearInterval(p)
                    }, function() {
                        m()
                    });
                if (a.nav) {
                    g = "<a href='#' class='" + E + " prev'>" + a.prevText + "</a><a href='#' class='" + E + " next'>" + a.nextText + "</a>";
                    l.navContainer ? c(a.navContainer).append(g) : f.after(g);
                    var d = c("." + d + "_nav"), G = d.filter(".prev");
                    d.bind("click", function(b) {
                        b.preventDefault();
                        b = c("." + j);
                        if (!b.queue("fx").length) {
                            var d = e.index(b);
                            b = d - 1;
                            d = d + 1 < C ? n + 1 : 0;
                            z(c(this)[0] === G[0] ? b : d);
                            if (a.pager || a.manualControls)
                                r(c(this)[0] === G[0] ? b : d);
                            a.pauseControls || m()
                        }
                    });
                    a.pauseControls && d.hover(function() {
                        clearInterval(p)
                    }, function() {
                        m()
                    })
                }
            }
            if ("undefined" === typeof document.body.style.maxWidth && l.maxwidth) {
                var H = function() {
                    f.css("width", "100%");
                    f.width() > u && f.css("width", u)
                };
                H();
                c(I).bind("resize", function() {
                    H()
                })
            }
        })
    }
})(jQuery, this, 0);

/*!
 * jQuery imagesLoaded plugin v2.1.1
 * http://github.com/desandro/imagesloaded
 *
 * MIT License. by Paul Irish et al.
 */

/*jshint curly: true, eqeqeq: true, noempty: true, strict: true, undef: true, browser: true */
/*global jQuery: false */
(function(c, q) {
    var m = "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==";
    c.fn.imagesLoaded = function(f) {
        function n() {
            var b = c(j), a = c(h);
            d && (h.length ? d.reject(e, b, a) : d.resolve(e));
            c.isFunction(f) && f.call(g, e, b, a)
        }
        function p(b) {
            k(b.target, "error" === b.type)
        }
        function k(b, a) {
            b.src === m || -1 !== c.inArray(b, l) || (l.push(b), a ? h.push(b) : j.push(b), c.data(b, "imagesLoaded", {isBroken: a, src: b.src}), r && d.notifyWith(c(b), [a, e, c(j), c(h)]), e.length === l.length && (setTimeout(n), e.unbind(".imagesLoaded",
                    p)))
        }
        var g = this, d = c.isFunction(c.Deferred) ? c.Deferred() : 0, r = c.isFunction(d.notify), e = g.find("img").add(g.filter("img")), l = [], j = [], h = [];
        c.isPlainObject(f) && c.each(f, function(b, a) {
            if ("callback" === b)
                f = a;
            else if (d)
                d[b](a)
        });
        e.length ? e.bind("load.imagesLoaded error.imagesLoaded", p).each(function(b, a) {
            var d = a.src, e = c.data(a, "imagesLoaded");
            if (e && e.src === d)
                k(a, e.isBroken);
            else if (a.complete && a.naturalWidth !== q)
                k(a, 0 === a.naturalWidth || 0 === a.naturalHeight);
            else if (a.readyState || a.complete)
                a.src = m, a.src = d
        }) :
                n();
        return d ? d.promise(g) : g
    }
})(jQuery);
(function(a, b) {

    // EASINGS
    jQuery.easing["jswing"] = jQuery.easing["swing"];
    jQuery.extend(jQuery.easing, {def: "easeOutQuad", swing: function(a, b, c, d, e) {
            return jQuery.easing[jQuery.easing.def](a, b, c, d, e)
        }, easeInQuad: function(a, b, c, d, e) {
            return d * (b /= e) * b + c
        }, easeOutQuad: function(a, b, c, d, e) {
            return-d * (b /= e) * (b - 2) + c
        }, easeInOutQuad: function(a, b, c, d, e) {
            if ((b /= e / 2) < 1)
                return d / 2 * b * b + c;
            return-d / 2 * (--b * (b - 2) - 1) + c
        }, easeInCubic: function(a, b, c, d, e) {
            return d * (b /= e) * b * b + c
        }, easeOutCubic: function(a, b, c, d, e) {
            return d * ((b = b / e - 1) * b * b + 1) + c
        }, easeInOutCubic: function(a, b, c, d, e) {
            if ((b /= e / 2) < 1)
                return d / 2 * b * b * b + c;
            return d / 2 * ((b -= 2) * b * b + 2) + c
        }, easeInQuart: function(a, b, c, d, e) {
            return d * (b /= e) * b * b * b + c
        }, easeOutQuart: function(a, b, c, d, e) {
            return-d * ((b = b / e - 1) * b * b * b - 1) + c
        }, easeInOutQuart: function(a, b, c, d, e) {
            if ((b /= e / 2) < 1)
                return d / 2 * b * b * b * b + c;
            return-d / 2 * ((b -= 2) * b * b * b - 2) + c
        }, easeInQuint: function(a, b, c, d, e) {
            return d * (b /= e) * b * b * b * b + c
        }, easeOutQuint: function(a, b, c, d, e) {
            return d * ((b = b / e - 1) * b * b * b * b + 1) + c
        }, easeInOutQuint: function(a, b, c, d, e) {
            if ((b /= e / 2) < 1)
                return d / 2 * b * b * b * b * b + c;
            return d / 2 * ((b -= 2) * b * b * b * b + 2) + c
        }, easeInSine: function(a, b, c, d, e) {
            return-d * Math.cos(b / e * (Math.PI / 2)) + d + c
        }, easeOutSine: function(a, b, c, d, e) {
            return d * Math.sin(b / e * (Math.PI / 2)) + c
        }, easeInOutSine: function(a, b, c, d, e) {
            return-d / 2 * (Math.cos(Math.PI * b / e) - 1) + c
        }, easeInExpo: function(a, b, c, d, e) {
            return b == 0 ? c : d * Math.pow(2, 10 * (b / e - 1)) + c
        }, easeOutExpo: function(a, b, c, d, e) {
            return b == e ? c + d : d * (-Math.pow(2, -10 * b / e) + 1) + c
        }, easeInOutExpo: function(a, b, c, d, e) {
            if (b == 0)
                return c;
            if (b == e)
                return c + d;
            if ((b /= e / 2) < 1)
                return d / 2 * Math.pow(2, 10 * (b - 1)) + c;
            return d / 2 * (-Math.pow(2, -10 * --b) + 2) + c
        }, easeInCirc: function(a, b, c, d, e) {
            return-d * (Math.sqrt(1 - (b /= e) * b) - 1) + c
        }, easeOutCirc: function(a, b, c, d, e) {
            return d * Math.sqrt(1 - (b = b / e - 1) * b) + c
        }, easeInOutCirc: function(a, b, c, d, e) {
            if ((b /= e / 2) < 1)
                return-d / 2 * (Math.sqrt(1 - b * b) - 1) + c;
            return d / 2 * (Math.sqrt(1 - (b -= 2) * b) + 1) + c
        }, easeInElastic: function(a, b, c, d, e) {
            var f = 1.70158;
            var g = 0;
            var h = d;
            if (b == 0)
                return c;
            if ((b /= e) == 1)
                return c + d;
            if (!g)
                g = e * .3;
            if (h < Math.abs(d)) {
                h = d;
                var f = g / 4
            } else
                var f = g / (2 * Math.PI) * Math.asin(d / h);
            return-(h * Math.pow(2, 10 * (b -= 1)) * Math.sin((b * e - f) * 2 * Math.PI / g)) + c
        }, easeOutElastic: function(a, b, c, d, e) {
            var f = 1.70158;
            var g = 0;
            var h = d;
            if (b == 0)
                return c;
            if ((b /= e) == 1)
                return c + d;
            if (!g)
                g = e * .3;
            if (h < Math.abs(d)) {
                h = d;
                var f = g / 4
            } else
                var f = g / (2 * Math.PI) * Math.asin(d / h);
            return h * Math.pow(2, -10 * b) * Math.sin((b * e - f) * 2 * Math.PI / g) + d + c
        }, easeInOutElastic: function(a, b, c, d, e) {
            var f = 1.70158;
            var g = 0;
            var h = d;
            if (b == 0)
                return c;
            if ((b /= e / 2) == 2)
                return c + d;
            if (!g)
                g = e * .3 * 1.5;
            if (h < Math.abs(d)) {
                h = d;
                var f = g / 4
            } else
                var f = g / (2 * Math.PI) * Math.asin(d / h);
            if (b < 1)
                return-.5 * h * Math.pow(2, 10 * (b -= 1)) * Math.sin((b * e - f) * 2 * Math.PI / g) + c;
            return h * Math.pow(2, -10 * (b -= 1)) * Math.sin((b * e - f) * 2 * Math.PI / g) * .5 + d + c
        }, easeInBack: function(a, b, c, d, e, f) {
            if (f == undefined)
                f = 1.70158;
            return d * (b /= e) * b * ((f + 1) * b - f) + c
        }, easeOutBack: function(a, b, c, d, e, f) {
            if (f == undefined)
                f = 1.70158;
            return d * ((b = b / e - 1) * b * ((f + 1) * b + f) + 1) + c
        }, easeInOutBack: function(a, b, c, d, e, f) {
            if (f == undefined)
                f = 1.70158;
            if ((b /= e / 2) < 1)
                return d / 2 * b * b * (((f *= 1.525) + 1) * b - f) + c;
            return d / 2 * ((b -= 2) * b * (((f *= 1.525) + 1) * b + f) + 2) + c
        }, easeInBounce: function(a, b, c, d, e) {
            return d - jQuery.easing.easeOutBounce(a, e - b, 0, d, e) + c
        }, easeOutBounce: function(a, b, c, d, e) {
            if ((b /= e) < 1 / 2.75) {
                return d * 7.5625 * b * b + c
            } else if (b < 2 / 2.75) {
                return d * (7.5625 * (b -= 1.5 / 2.75) * b + .75) + c
            } else if (b < 2.5 / 2.75) {
                return d * (7.5625 * (b -= 2.25 / 2.75) * b + .9375) + c
            } else {
                return d * (7.5625 * (b -= 2.625 / 2.75) * b + .984375) + c
            }
        }, easeInOutBounce: function(a, b, c, d, e) {
            if (b < e / 2)
                return jQuery.easing.easeInBounce(a, b * 2, 0, d, e) * .5 + c;
            return jQuery.easing.easeOutBounce(a, b * 2 - e, 0, d, e) * .5 + d * .5 + c
        }})


    // WAIT FOR IMAGES
    /*
     * waitForImages 1.4
     * -----------------
     * Provides a callback when all images have loaded in your given selector.
     * http://www.alexanderdickson.com/
     *
     *
     * Copyright (c) 2011 Alex Dickson
     * Licensed under the MIT licenses.
     * See website for more info.
     *
     */
    a.waitForImages = {hasImageProperties: ["backgroundImage", "listStyleImage", "borderImage", "borderCornerImage"]};
    a.expr[":"].uncached = function(b) {
        var c = document.createElement("img");
        c.src = b.src;
        return a(b).is('img[src!=""]') && !c.complete
    };
    a.fn.waitForImages = function(b, c, d) {
        if (a.isPlainObject(arguments[0])) {
            c = b.each;
            d = b.waitForAll;
            b = b.finished
        }
        b = b || a.noop;
        c = c || a.noop;
        d = !!d;
        if (!a.isFunction(b) || !a.isFunction(c)) {
            throw new TypeError("An invalid callback was supplied.")
        }
        return this.each(function() {
            var e = a(this), f = [];
            if (d) {
                var g = a.waitForImages.hasImageProperties || [], h = /url\((['"]?)(.*?)\1\)/g;
                e.find("*").each(function() {
                    var b = a(this);
                    if (b.is("img:uncached")) {
                        f.push({src: b.attr("src"), element: b[0]})
                    }
                    a.each(g, function(a, c) {
                        var d = b.css(c);
                        if (!d) {
                            return true
                        }
                        var e;
                        while (e = h.exec(d)) {
                            f.push({src: e[2], element: b[0]})
                        }
                    })
                })
            } else {
                e.find("img:uncached").each(function() {
                    f.push({src: this.src, element: this})
                })
            }
            var i = f.length, j = 0;
            if (i == 0) {
                b.call(e[0])
            }
            a.each(f, function(d, f) {
                var g = new Image;
                a(g).bind("load error", function(a) {
                    j++;
                    c.call(f.element, j, i, a.type == "load");
                    if (j == i) {
                        b.call(e[0]);
                        return false
                    }
                });
                g.src = f.src
            })
        })
    }



// CSS ANIMATE
    /**************************************\
     *  cssAnimate 1.1.5 for jQuery       *
     *  (c) 2012 - Clemens Damke          *
     *  Licensed under MIT License        *
     *  Works with jQuery >=1.4.3         *
     /**************************************/
    var b = ["Webkit", "Moz", "O", "Ms", "Khtml", ""];
    var c = ["borderRadius", "boxShadow", "userSelect", "transformOrigin", "transformStyle", "transition", "transitionDuration", "transitionProperty", "transitionTimingFunction", "backgroundOrigin", "backgroundSize", "animation", "filter", "zoom", "columns", "perspective", "perspectiveOrigin", "appearance"];
    a.fn.cssSetQueue = function(e, t) {
        v = this;
        var n = v.data("cssQueue") ? v.data("cssQueue") : [];
        var r = v.data("cssCall") ? v.data("cssCall") : [];
        var i = 0;
        var s = {};
        a.each(t, function(e, t) {
            s[e] = t
        });
        while (1) {
            if (!r[i]) {
                r[i] = s.complete;
                break
            }
            i++
        }
        s.complete = i;
        n.push([e, s]);
        v.data({cssQueue: n, cssRunning: true, cssCall: r})
    };
    a.fn.cssRunQueue = function() {
        v = this;
        var e = v.data("cssQueue") ? v.data("cssQueue") : [];
        if (e[0])
            v.cssEngine(e[0][0], e[0][1]);
        else
            v.data("cssRunning", false);
        e.shift();
        v.data("cssQueue", e)
    };
    a.cssMerge = function(e, t, n) {
        a.each(t, function(t, r) {
            a.each(n, function(n, i) {
                e[i + t] = r
            })
        });
        return e
    };
    a.fn.cssAnimationData = function(e, t) {
        var n = this;
        var r = n.data("cssAnimations");
        if (!r)
            r = {};
        if (!r[e])
            r[e] = [];
        r[e].push(t);
        n.data("cssAnimations", r);
        return r[e]
    };
    a.fn.cssAnimationRemove = function() {
        var e = this;
        if (e.data("cssAnimations") != undefined) {
            var t = e.data("cssAnimations");
            var n = e.data("identity");
            a.each(t, function(e, r) {
                t[e] = r.splice(n + 1, 1)
            });
            e.data("cssAnimations", t)
        }
    };
    a.css3D = function(e) {
        a("body").data("cssPerspective", isFinite(e) ? e : e ? 1e3 : 0).cssOriginal(a.cssMerge({}, {TransformStyle: e ? "preserve-3d" : "flat"}, b))
    };
    a.cssPropertySupporter = function(e) {
        a.each(c, function(t, n) {
            if (e[n])
                a.each(b, function(t, r) {
                    var i = n.substr(0, 1);
                    e[r + i[r ? "toUpperCase" : "toLowerCase"]() + n.substr(1)] = e[n]
                })
        });
        return e
    };
    a.cssAnimateSupport = function() {
        var e = false;
        a.each(b, function(t, n) {
            e = document.body.style[n + "AnimationName"] !== undefined ? true : e
        });
        return e
    };
    a.fn.cssEngine = function(e, t) {
        function n(e) {
            return String(e).replace(/([A-Z])/g, "-jQuery1").toLowerCase()
        }
        var r = this;
        var r = this;
        if (typeof t.complete == "number")
            r.data("cssCallIndex", t.complete);
        var i = {linear: "linear", swing: "ease", easeIn: "ease-in", easeOut: "ease-out", easeInOut: "ease-in-out"};
        var s = {};
        var o = a("body").data("cssPerspective");
        if (e.transform)
            a.each(b, function(t, i) {
                var u = i + (i ? "T" : "t") + "ransform";
                var a = r.cssOriginal(n(u));
                var f = e.transform;
                if (!a || a == "none")
                    s[u] = "scale(1)";
                e[u] = (o && !/perspective/gi.test(f) ? "perspective(" + o + ") " : "") + f
            });
        e = a.cssPropertySupporter(e);
        var u = [];
        a.each(e, function(e, t) {
            u.push(n(e))
        });
        var f = false;
        var l = [];
        var c = [];
        if (u != undefined) {
            for (var h = 0; h < u.length; h++) {
                l.push(String(t.duration / 1e3) + "s");
                var p = i[t.easing];
                c.push(p ? p : t.easing)
            }
            l = r.cssAnimationData("dur", l.join(", ")).join(", ");
            c = r.cssAnimationData("eas", c.join(", ")).join(", ");
            var d = r.cssAnimationData("prop", u.join(", "));
            r.data("identity", d.length - 1);
            d = d.join(", ");
            var v = {TransitionDuration: l, TransitionProperty: d, TransitionTimingFunction: c};
            var m = {};
            m = a.cssMerge(m, v, b);
            var g = e;
            a.extend(m, e);
            if (m.display == "callbackHide")
                f = true;
            else if (m.display)
                s["display"] = m.display;
            r.cssOriginal(s)
        }
        setTimeout(function() {
            r.cssOriginal(m);
            var e = r.data("runningCSS");
            e = !e ? g : a.extend(e, g);
            r.data("runningCSS", e);
            setTimeout(function() {
                r.data("cssCallIndex", "a");
                if (f)
                    r.cssOriginal("display", "none");
                r.cssAnimationRemove();
                if (t.queue)
                    r.cssRunQueue();
                if (typeof t.complete == "number") {
                    r.data("cssCall")[t.complete].call(r);
                    r.data("cssCall")[t.complete] = 0
                } else
                    t.complete.call(r)
            }, t.duration)
        }, 0)
    };
    a.str2Speed = function(e) {
        return isNaN(e) ? e == "slow" ? 1e3 : e == "fast" ? 200 : 600 : e
    };
    a.fn.cssAnimate = function(e, t, n, r) {
        var i = this;
        var s = {duration: 0, easing: "swing", complete: function() {
            }, queue: true};
        var o = {};
        o = typeof t == "object" ? t : {duration: t};
        o[n ? typeof n == "function" ? "complete" : "easing" : 0] = n;
        o[r ? "complete" : 0] = r;
        o.duration = a.str2Speed(o.duration);
        a.extend(s, o);
        if (a.cssAnimateSupport()) {
            i.each(function(t, n) {
                n = a(n);
                if (s.queue) {
                    var r = !n.data("cssRunning");
                    n.cssSetQueue(e, s);
                    if (r)
                        n.cssRunQueue()
                } else
                    n.cssEngine(e, s)
            })
        } else
            i.animate(e, s);
        return i
    };
    a.cssPresetOptGen = function(e, t) {
        var n = {};
        n[e ? typeof e == "function" ? "complete" : "easing" : 0] = e;
        n[t ? "complete" : 0] = t;
        return n
    };
    a.fn.cssFadeTo = function(e, t, n, r) {
        var i = this;
        opt = a.cssPresetOptGen(n, r);
        var s = {opacity: t};
        opt.duration = e;
        if (a.cssAnimateSupport()) {
            i.each(function(e, n) {
                n = a(n);
                if (n.data("displayOriginal") != n.cssOriginal("display") && n.cssOriginal("display") != "none")
                    n.data("displayOriginal", n.cssOriginal("display") ? n.cssOriginal("display") : "block");
                else
                    n.data("displayOriginal", "block");
                s.display = t ? n.data("displayOriginal") : "callbackHide";
                n.cssAnimate(s, opt)
            })
        } else
            i.fadeTo(e, opt);
        return i
    };
    a.fn.cssFadeOut = function(e, t, n) {
        if (a.cssAnimateSupport()) {
            if (!this.cssOriginal("opacity"))
                this.cssOriginal("opacity", 1);
            this.cssFadeTo(e, 0, t, n)
        } else
            this.fadeOut(e, t, n);
        return this
    };
    a.fn.cssFadeIn = function(e, t, n) {
        if (a.cssAnimateSupport()) {
            if (this.cssOriginal("opacity"))
                this.cssOriginal("opacity", 0);
            this.cssFadeTo(e, 1, t, n)
        } else
            this.fadeIn(e, t, n);
        return this
    };
    a.cssPx2Int = function(e) {
        return e.split("p")[0] * 1
    };
    a.fn.cssStop = function() {
        var e = this, t = 0;
        e.data("cssAnimations", false).each(function(n, r) {
            r = a(r);
            var i = {TransitionDuration: "0s"};
            var s = r.data("runningCSS");
            var o = {};
            if (s)
                a.each(s, function(e, t) {
                    t = isFinite(a.cssPx2Int(t)) ? a.cssPx2Int(t) : t;
                    var n = [0, 1];
                    var r = {color: ["#000", "#fff"], background: ["#000", "#fff"], "float": ["none", "left"], clear: ["none", "left"], border: ["none", "0px solid #fff"], position: ["absolute", "relative"], family: ["Arial", "Helvetica"], display: ["none", "block"], visibility: ["hidden", "visible"], transform: ["translate(0,0)", "scale(1)"]};
                    a.each(r, function(t, r) {
                        if ((new RegExp(t, "gi")).test(e))
                            n = r
                    });
                    o[e] = n[0] != t ? n[0] : n[1]
                });
            else
                s = {};
            i = a.cssMerge(o, i, b);
            r.cssOriginal(i);
            setTimeout(function() {
                var n = a(e[t]);
                n.cssOriginal(s).data({runningCSS: {}, cssAnimations: {}, cssQueue: [], cssRunning: false});
                if (typeof n.data("cssCallIndex") == "number")
                    n.data("cssCall")[n.data("cssCallIndex")].call(n);
                n.data("cssCall", []);
                t++
            }, 0)
        });
        return e
    };
    a.fn.cssDelay = function(e) {
        return this.cssAnimate({}, e)
    };
    if (a.fn.cssOriginal != undefined)
        a.fn.css = a.fn.cssOriginal;
    a.fn.cssOriginal = a.fn.css;
    var LEFT = "left", RIGHT = "right", UP = "up", DOWN = "down", IN = "in", OUT = "out", NONE = "none", AUTO = "auto", HORIZONTAL = "horizontal", VERTICAL = "vertical", ALL_FINGERS = "all", PHASE_START = "start", PHASE_MOVE = "move", PHASE_END = "end", PHASE_CANCEL = "cancel", SUPPORTS_TOUCH = "ontouchstart"in window, PLUGIN_NS = "TouchSwipe";
    var defaults = {fingers: 1, threshold: 75, maxTimeThreshold: null, swipe: null, swipeLeft: null, swipeRight: null, swipeUp: null, swipeDown: null, swipeStatus: null, pinchIn: null, pinchOut: null, pinchStatus: null, click: null, triggerOnTouchEnd: true, allowPageScroll: "auto", fallbackToMouseEvents: true, excludedElements: "button, input, select, textarea, a, .noSwipe"}



    function init(e) {
        if (e && e.allowPageScroll === undefined && (e.swipe !== undefined || e.swipeStatus !== undefined)) {
            e.allowPageScroll = NONE
        }
        if (!e) {
            e = {}
        }
        e = jQuery.extend({}, jQuery.fn.swipe.defaults, e);
        return this.each(function() {
            var t = jQuery(this);
            var n = t.data(PLUGIN_NS);
            if (!n) {
                n = new touchSwipe(this, e);
                t.data(PLUGIN_NS, n)
            }
        })
    }
    function touchSwipe(e, t) {
        function E(e) {
            if (q())
                return;
            if (jQuery(e.target).closest(t.excludedElements, d).length > 0)
                return;
            e = e.originalEvent;
            var n, r = SUPPORTS_TOUCH ? e.touches[0] : e;
            v = PHASE_START;
            if (SUPPORTS_TOUCH) {
                m = e.touches.length
            } else {
                e.preventDefault()
            }
            u = 0;
            a = null;
            p = null;
            f = 0;
            l = 0;
            c = 0;
            h = 1;
            g = U();
            if (!SUPPORTS_TOUCH || m === t.fingers || t.fingers === ALL_FINGERS || F()) {
                g[0].start.x = g[0].end.x = r.pageX;
                g[0].start.y = g[0].end.y = r.pageY;
                y = B();
                if (m == 2) {
                    g[1].start.x = g[1].end.x = e.touches[1].pageX;
                    g[1].start.y = g[1].end.y = e.touches[1].pageY;
                    l = c = O(g[0].start, g[1].start)
                }
                if (t.swipeStatus || t.pinchStatus) {
                    n = N(e, v)
                }
            } else {
                T(e);
                n = false
            }
            if (n === false) {
                v = PHASE_CANCEL;
                N(e, v);
                return n
            } else {
                R(true);
                d.bind(i, S);
                d.bind(s, x)
            }
        }
        function S(e) {
            e = e.originalEvent;
            if (v === PHASE_END || v === PHASE_CANCEL)
                return;
            var n, r = SUPPORTS_TOUCH ? e.touches[0] : e;
            g[0].end.x = SUPPORTS_TOUCH ? e.touches[0].pageX : r.pageX;
            g[0].end.y = SUPPORTS_TOUCH ? e.touches[0].pageY : r.pageY;
            b = B();
            a = H(g[0].start, g[0].end);
            if (SUPPORTS_TOUCH) {
                m = e.touches.length
            }
            v = PHASE_MOVE;
            if (m == 2) {
                if (l == 0) {
                    g[1].start.x = e.touches[1].pageX;
                    g[1].start.y = e.touches[1].pageY;
                    l = c = O(g[0].start, g[1].start)
                } else {
                    g[1].end.x = e.touches[1].pageX;
                    g[1].end.y = e.touches[1].pageY;
                    c = O(g[0].end, g[1].end);
                    p = _(g[0].end, g[1].end)
                }
                h = M(l, c)
            }
            if (m === t.fingers || t.fingers === ALL_FINGERS || !SUPPORTS_TOUCH) {
                L(e, a);
                u = D(g[0].start, g[0].end);
                f = A(g[0].start, g[0].end);
                if (t.swipeStatus || t.pinchStatus) {
                    n = N(e, v)
                }
                if (!t.triggerOnTouchEnd) {
                    var i = !k();
                    if (C() === true) {
                        v = PHASE_END;
                        n = N(e, v)
                    } else if (i) {
                        v = PHASE_CANCEL;
                        N(e, v)
                    }
                }
            } else {
                v = PHASE_CANCEL;
                N(e, v)
            }
            if (n === false) {
                v = PHASE_CANCEL;
                N(e, v)
            }
        }
        function x(e) {
            e = e.originalEvent;
            if (e.touches && e.touches.length > 0)
                return true;
            e.preventDefault();
            b = B();
            if (l != 0) {
                c = O(g[0].end, g[1].end);
                h = M(l, c);
                p = _(g[0].end, g[1].end)
            }
            u = D(g[0].start, g[0].end);
            a = H(g[0].start, g[0].end);
            f = A();
            if (t.triggerOnTouchEnd || t.triggerOnTouchEnd === false && v === PHASE_MOVE) {
                v = PHASE_END;
                var n = I() || !F();
                var r = m === t.fingers || t.fingers === ALL_FINGERS || !SUPPORTS_TOUCH;
                var o = g[0].end.x !== 0;
                var y = r && o && n;
                if (y) {
                    var w = k();
                    var E = C();
                    if ((E === true || E === null) && w) {
                        N(e, v)
                    } else if (!w || E === false) {
                        v = PHASE_CANCEL;
                        N(e, v)
                    }
                } else {
                    v = PHASE_CANCEL;
                    N(e, v)
                }
            } else if (v === PHASE_MOVE) {
                v = PHASE_CANCEL;
                N(e, v)
            }
            d.unbind(i, S, false);
            d.unbind(s, x, false);
            R(false)
        }
        function T() {
            m = 0;
            b = 0;
            y = 0;
            l = 0;
            c = 0;
            h = 1;
            R(false)
        }
        function N(e, n) {
            var r = undefined;
            if (t.swipeStatus) {
                r = t.swipeStatus.call(d, e, n, a || null, u || 0, f || 0, m)
            }
            if (t.pinchStatus && I()) {
                r = t.pinchStatus.call(d, e, n, p || null, c || 0, f || 0, m, h)
            }
            if (n === PHASE_CANCEL) {
                if (t.click && (m === 1 || !SUPPORTS_TOUCH) && (isNaN(u) || u === 0)) {
                    r = t.click.call(d, e, e.target)
                }
            }
            if (n == PHASE_END) {
                if (t.swipe) {
                    r = t.swipe.call(d, e, a, u, f, m)
                }
                switch (a) {
                    case LEFT:
                        if (t.swipeLeft) {
                            r = t.swipeLeft.call(d, e, a, u, f, m)
                        }
                        break;
                    case RIGHT:
                        if (t.swipeRight) {
                            r = t.swipeRight.call(d, e, a, u, f, m)
                        }
                        break;
                    case UP:
                        if (t.swipeUp) {
                            r = t.swipeUp.call(d, e, a, u, f, m)
                        }
                        break;
                    case DOWN:
                        if (t.swipeDown) {
                            r = t.swipeDown.call(d, e, a, u, f, m)
                        }
                        break
                }
                switch (p) {
                    case IN:
                        if (t.pinchIn) {
                            r = t.pinchIn.call(d, e, p || null, c || 0, f || 0, m, h)
                        }
                        break;
                    case OUT:
                        if (t.pinchOut) {
                            r = t.pinchOut.call(d, e, p || null, c || 0, f || 0, m, h)
                        }
                        break
                }
            }
            if (n === PHASE_CANCEL || n === PHASE_END) {
                T(e)
            }
            return r
        }
        function C() {
            if (t.threshold !== null) {
                return u >= t.threshold
            }
            return null
        }
        function k() {
            var e;
            if (t.maxTimeThreshold) {
                if (f >= t.maxTimeThreshold) {
                    e = false
                } else {
                    e = true
                }
            } else {
                e = true
            }
            return e
        }
        function L(e, n) {
            if (t.allowPageScroll === NONE || F()) {
                e.preventDefault()
            } else {
                var r = t.allowPageScroll === AUTO;
                switch (n) {
                    case LEFT:
                        if (t.swipeLeft && r || !r && t.allowPageScroll != HORIZONTAL) {
                            e.preventDefault()
                        }
                        break;
                    case RIGHT:
                        if (t.swipeRight && r || !r && t.allowPageScroll != HORIZONTAL) {
                            e.preventDefault()
                        }
                        break;
                    case UP:
                        if (t.swipeUp && r || !r && t.allowPageScroll != VERTICAL) {
                            e.preventDefault()
                        }
                        break;
                    case DOWN:
                        if (t.swipeDown && r || !r && t.allowPageScroll != VERTICAL) {
                            e.preventDefault()
                        }
                        break
                }
            }
        }
        function A() {
            return b - y
        }
        function O(e, t) {
            var n = Math.abs(e.x - t.x);
            var r = Math.abs(e.y - t.y);
            return Math.round(Math.sqrt(n * n + r * r))
        }
        function M(e, t) {
            var n = t / e * 1;
            return n.toFixed(2)
        }
        function _() {
            if (h < 1) {
                return OUT
            } else {
                return IN
            }
        }
        function D(e, t) {
            return Math.round(Math.sqrt(Math.pow(t.x - e.x, 2) + Math.pow(t.y - e.y, 2)))
        }
        function P(e, t) {
            var n = e.x - t.x;
            var r = t.y - e.y;
            var i = Math.atan2(r, n);
            var s = Math.round(i * 180 / Math.PI);
            if (s < 0) {
                s = 360 - Math.abs(s)
            }
            return s
        }
        function H(e, t) {
            var n = P(e, t);
            if (n <= 45 && n >= 0) {
                return LEFT
            } else if (n <= 360 && n >= 315) {
                return LEFT
            } else if (n >= 135 && n <= 225) {
                return RIGHT
            } else if (n > 45 && n < 135) {
                return DOWN
            } else {
                return UP
            }
        }
        function B() {
            var e = new Date;
            return e.getTime()
        }
        function j() {
            d.unbind(r, E);
            d.unbind(o, T);
            d.unbind(i, S);
            d.unbind(s, x);
            R(false)
        }
        function F() {
            return t.pinchStatus || t.pinchIn || t.pinchOut
        }
        function I() {
            return p && F()
        }
        function q() {
            return d.data(PLUGIN_NS + "_intouch") === true ? true : false
        }
        function R(e) {
            e = e === true ? true : false;
            d.data(PLUGIN_NS + "_intouch", e)
        }
        function U() {
            var e = [];
            for (var t = 0; t <= 5; t++) {
                e.push({start: {x: 0, y: 0}, end: {x: 0, y: 0}, delta: {x: 0, y: 0}})
            }
            return e
        }
        var n = SUPPORTS_TOUCH || !t.fallbackToMouseEvents, r = n ? "touchstart" : "mousedown", i = n ? "touchmove" : "mousemove", s = n ? "touchend" : "mouseup", o = "touchcancel";
        var u = 0;
        var a = null;
        var f = 0;
        var l = 0;
        var c = 0;
        var h = 1;
        var p = 0;
        var d = jQuery(e);
        var v = "start";
        var m = 0;
        var g = null;
        var y = 0;
        var b = 0;
        try {
            d.bind(r, E);
            d.bind(o, T)
        } catch (w) {
            jQuery.error("events not supported " + r + "," + o + " on jQuery.swipe")
        }
        this.enable = function() {
            d.bind(r, E);
            d.bind(o, T);
            return d
        };
        this.disable = function() {
            j();
            return d
        };
        this.destroy = function() {
            j();
            d.data(PLUGIN_NS, null);
            return d
        };
    }
    jQuery.fn.swipe = function(e) {
        var t = jQuery(this), n = t.data(PLUGIN_NS);
        if (n && typeof e === "string") {
            if (n[e]) {
                return n[e].apply(this, Array.prototype.slice.call(arguments, 1))
            } else {
                jQuery.error("Method " + e + " does not exist on jQuery.swipe")
            }
        } else if (!n && (typeof e === "object" || !e)) {
            return init.apply(this, arguments)
        }
        return t
    };
    jQuery.fn.swipe.defaults = defaults;
    jQuery.fn.swipe.phases = {PHASE_START: PHASE_START, PHASE_MOVE: PHASE_MOVE, PHASE_END: PHASE_END, PHASE_CANCEL: PHASE_CANCEL};
    jQuery.fn.swipe.directions = {LEFT: LEFT, RIGHT: RIGHT, UP: UP, DOWN: DOWN, IN: IN, OUT: OUT};
    jQuery.fn.swipe.pageScroll = {NONE: NONE, HORIZONTAL: HORIZONTAL, VERTICAL: VERTICAL, AUTO: AUTO};
    jQuery.fn.swipe.fingers = {ONE: 1, TWO: 2, THREE: 3, ALL: ALL_FINGERS}
})(jQuery);
