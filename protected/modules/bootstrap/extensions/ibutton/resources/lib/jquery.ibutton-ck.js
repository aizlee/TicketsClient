/*!
 * iButton jQuery Plug-in
 *
 * Copyright 2011 Giva, Inc. (http://www.givainc.com/labs/) 
 * 
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * 
 * 	http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * Date: 2011-07-26
 * Rev:  1.0.03
 */(function(e) {
    e.iButton = {
        version: "1.0.03",
        setDefaults: function(t) {
            e.extend(r, t);
        }
    };
    e.fn.iButton = function(t) {
        var r = typeof arguments[0] == "string" && arguments[0], i = r && Array.prototype.slice.call(arguments, 1) || arguments, s = this.length == 0 ? null : e.data(this[0], "iButton");
        if (s && r && this.length) {
            if (r.toLowerCase() == "object") return s;
            if (s[r]) {
                var o;
                this.each(function(t) {
                    var n = e.data(this, "iButton")[r].apply(s, i);
                    if (t == 0 && n) {
                        if (!n.jquery) {
                            o = n;
                            return !1;
                        }
                        o = e([]).add(n);
                    } else !!n && !!n.jquery && (o = o.add(n));
                });
                return o || this;
            }
            return this;
        }
        return this.each(function() {
            new n(this, t);
        });
    };
    var t = 0;
    e.browser.iphone = navigator.userAgent.toLowerCase().indexOf("iphone") > -1;
    var n = function(n, o) {
        var u = this, a = e(n), f = ++t, l = !1, c = {}, h = {
            dragging: !1,
            clicked: null
        }, p = {
            position: null,
            offset: null,
            time: null
        }, o = e.extend({}, r, o, e.metadata ? a.metadata() : {}), d = o.labelOn == i && o.labelOff == s, v = ":checkbox, :radio";
        if (!a.is(v)) return a.find(v).iButton(o);
        if (e.data(a[0], "iButton")) return;
        e.data(a[0], "iButton", u);
        o.resizeHandle == "auto" && (o.resizeHandle = !d);
        o.resizeContainer == "auto" && (o.resizeContainer = !d);
        this.toggle = function(e) {
            var t = arguments.length > 0 ? e : !a[0].checked;
            a.attr("checked", t).trigger("change");
        };
        this.disable = function(t) {
            var n = arguments.length > 0 ? t : !l;
            l = n;
            a.attr("disabled", n);
            m[n ? "addClass" : "removeClass"](o.classDisabled);
            e.isFunction(o.disable) && o.disable.apply(u, [ l, a, o ]);
        };
        this.repaint = function() {
            x();
        };
        this.destroy = function() {
            e([ a[0], m[0] ]).unbind(".iButton");
            e(document).unbind(".iButton_" + f);
            m.after(a).remove();
            e.data(a[0], "iButton", null);
            e.isFunction(o.destroy) && o.destroy.apply(u, [ a, o ]);
        };
        a.wrap('<div class="' + e.trim(o.classContainer + " " + o.className) + '" />').after('<div class="' + o.classHandle + '"><div class="' + o.classHandleRight + '"><div class="' + o.classHandleMiddle + '" /></div></div>' + '<div class="' + o.classLabelOff + '"><span><label>' + o.labelOff + "</label></span></div>" + '<div class="' + o.classLabelOn + '"><span><label>' + o.labelOn + "</label></span></div>" + '<div class="' + o.classPaddingLeft + '"></div><div class="' + o.classPaddingRight + '"></div>');
        var m = a.parent(), g = a.siblings("." + o.classHandle), y = a.siblings("." + o.classLabelOff), b = y.children("span"), w = a.siblings("." + o.classLabelOn), E = w.children("span");
        if (o.resizeHandle || o.resizeContainer) {
            c.onspan = E.outerWidth();
            c.offspan = b.outerWidth();
        }
        if (o.resizeHandle) {
            c.handle = Math.min(c.onspan, c.offspan);
            g.css("width", c.handle);
        } else c.handle = g.width();
        if (o.resizeContainer) {
            c.container = Math.max(c.onspan, c.offspan) + c.handle + 20;
            m.css("width", c.container);
            y.css("width", c.container - 5);
        } else c.container = m.width();
        var S = c.container - c.handle - 6, x = function(e) {
            var t = a[0].checked, n = t ? S : 0, e = arguments.length > 0 ? arguments[0] : !0;
            if (e && o.enableFx) {
                g.stop().animate({
                    left: n
                }, o.duration, o.easing);
                w.stop().animate({
                    width: n + 4
                }, o.duration, o.easing);
                E.stop().animate({
                    marginLeft: n - S
                }, o.duration, o.easing);
                b.stop().animate({
                    marginRight: -n
                }, o.duration, o.easing);
            } else {
                g.css("left", n);
                w.css("width", n + 4);
                E.css("marginLeft", n - S);
                b.css("marginRight", -n);
            }
        };
        x(!1);
        var T = function(e) {
            return e.pageX || (e.originalEvent.changedTouches ? e.originalEvent.changedTouches[0].pageX : 0);
        };
        m.bind("mousedown.iButton touchstart.iButton", function(t) {
            if (e(t.target).is(v) || l || !o.allowRadioUncheck && a.is(":radio:checked")) return;
            t.preventDefault();
            h.clicked = g;
            p.position = T(t);
            p.offset = p.position - (parseInt(g.css("left"), 10) || 0);
            p.time = (new Date).getTime();
            return !1;
        });
        o.enableDrag && e(document).bind("mousemove.iButton_" + f + " touchmove.iButton_" + f, function(e) {
            if (h.clicked != g) return;
            e.preventDefault();
            var t = T(e);
            if (t != p.offset) {
                h.dragging = !0;
                m.addClass(o.classHandleActive);
            }
            var n = Math.min(1, Math.max(0, (t - p.offset) / S));
            g.css("left", n * S);
            w.css("width", n * S + 4);
            b.css("marginRight", -n * S);
            E.css("marginLeft", -(1 - n) * S);
            return !1;
        });
        e(document).bind("mouseup.iButton_" + f + " touchend.iButton_" + f, function(t) {
            if (h.clicked != g) return !1;
            t.preventDefault();
            var n = !0;
            if (!h.dragging || (new Date).getTime() - p.time < o.clickOffset) {
                var r = a[0].checked;
                a.attr("checked", !r);
                e.isFunction(o.click) && o.click.apply(u, [ !r, a, o ]);
            } else {
                var i = T(t), s = (i - p.offset) / S, r = s >= .5;
                a[0].checked == r && (n = !1);
                a.attr("checked", r);
            }
            m.removeClass(o.classHandleActive);
            h.clicked = null;
            h.dragging = null;
            n ? a.trigger("change") : x();
            return !1;
        });
        a.bind("change.iButton", function() {
            x();
            if (a.is(":radio")) {
                var t = a[0], n = e(t.form ? t.form[t.name] : ":radio[name=" + t.name + "]");
                n.filter(":not(:checked)").iButton("repaint");
            }
            e.isFunction(o.change) && o.change.apply(u, [ a, o ]);
        }).bind("focus.iButton", function() {
            m.addClass(o.classFocus);
        }).bind("blur.iButton", function() {
            m.removeClass(o.classFocus);
        });
        e.isFunction(o.click) && a.bind("click.iButton", function() {
            o.click.apply(u, [ a[0].checked, a, o ]);
        });
        a.is(":disabled") && this.disable(!0);
        if (e.browser.msie) {
            m.find("*").andSelf().attr("unselectable", "on");
            a.bind("click.iButton", function() {
                a.triggerHandler("change.iButton");
            });
        }
        e.isFunction(o.init) && o.init.apply(u, [ a, o ]);
    }, r = {
        duration: 200,
        easing: "swing",
        labelOn: "ON",
        labelOff: "OFF",
        resizeHandle: "auto",
        resizeContainer: "auto",
        enableDrag: !0,
        enableFx: !0,
        allowRadioUncheck: !1,
        clickOffset: 120,
        className: "",
        classContainer: "ibutton-container",
        classDisabled: "ibutton-disabled",
        classFocus: "ibutton-focus",
        classLabelOn: "ibutton-label-on",
        classLabelOff: "ibutton-label-off",
        classHandle: "ibutton-handle",
        classHandleMiddle: "ibutton-handle-middle",
        classHandleRight: "ibutton-handle-right",
        classHandleActive: "ibutton-active-handle",
        classPaddingLeft: "ibutton-padding-left",
        classPaddingRight: "ibutton-padding-right",
        init: null,
        change: null,
        click: null,
        disable: null,
        destroy: null
    }, i = r.labelOn, s = r.labelOff;
})(jQuery);