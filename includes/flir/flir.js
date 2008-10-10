/*
Facelift Image Replacement v1.2
Facelift was written and is maintained by Cory Mawhorter.  
It is available from http://facelift.mawhorter.net/

===

This file is part of Facelife Image Replacement ("FLIR").

FLIR is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

FLIR is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Facelift Image Replacement.  If not, see <http://www.gnu.org/licenses/>.
*/

var FLIR = {
     version: '1.2'
    
    ,options: {
         path: ''
        ,classnameIgnore: false
        ,findEmbededFonts: false
        ,ignoredElements: 'BR,HR,IMG,INPUT,SELECT'
    }
    
    ,onreplacing: null
    ,onreplaced: null
    ,onreplacingchild: null
    ,onreplacedchild: null
    
    ,flirElements: {}
    ,flirPlugins: []
    
    ,isCraptastic: true
    ,isIE: true

    ,defaultStyle: null
    ,classStyles: {}
        
    ,embededFonts: {}

    ,dpi: 96
    
    // either (options Object, fstyle FLIRStyle Object) or (fstyle FLIRStyle Object)
    ,init: function(options, fstyle) { // or options for flir style
        if(this.isFStyle(options)) { // (fstyle FLIRStyle Object)
            this.defaultStyle = options;
        }else { // [options Object, fstyle FLIRStyle Object]
            if(typeof options != 'undefined')
                this.loadOptions(options);
        
            if(typeof fstyle == 'undefined') {
                this.defaultStyle = new FLIRStyle();
            }else {
                if(this.isFStyle(fstyle))
                    this.defaultStyle = fstyle;
                else
                    this.defaultStyle = new FLIRStyle(fstyle);
            }
        }

        this.calcDPI();
                        
        if(this.options.findEmbededFonts)
            this.discoverEmbededFonts();

        this.isIE = (navigator.userAgent.toLowerCase().indexOf('msie')>-1 && navigator.userAgent.toLowerCase().indexOf('opera')<0);
        this.isCraptastic = (typeof document.body.style.maxHeight=='undefined');

        if(this.isIE) {
            this.flirIERepObj = [];
            this.flirIEHovEls = [];
            this.flirIEHovStyles = [];    
        }

        FLIR._call_plugin('init', arguments);
    }
    
    ,loadOptions: function(options) {
        for(var i in options)
            this.options[i] = options[i];
    }    
    
    ,installPlugin: function(plugin) {
        this.flirPlugins.push(plugin);
    }
    
    ,_call_plugin: function(func, call) {
        var ret = call;
        for(var i=0; i<this.flirPlugins.length; i++) {
            if(typeof this.flirPlugins[i][func] == 'function') {
                var pluginret = this.flirPlugins[i][func](ret);

                if(typeof pluginret == 'undefined') {
                    continue;
                }
                if(typeof pluginret == 'boolean' && pluginret == false) {
                    return false;
                }
                if(typeof pluginret != 'boolean') // passes changes on
                    ret = call;

            }
        }
        
        var ret = typeof ret != 'object' ? [ret] : ret;
        if(ret.length && ret[0] && ret[0].callee)
            return ret[0];
        else
            return ret;
    }
    
    ,auto: function(els) {
        if(!(args = FLIR._call_plugin('auto', arguments))) return;
        els = args[0];
        
        var tags = typeof els=='undefined'?['h1','h2','h3','h4','h5']:(els.indexOf && els.indexOf(',')>-1?els.split(','):els);
        var elements;
        for(var i=0; i<tags.length; i++) {
            elements = this.getElements(tags[i]);            

            if(elements.length>0)
                this.replace(elements);
        }
    }
    
    
    ,hover: function(e) {
        var o=FLIR.evsrc(e);
        var targ=o;
        var targDescHover = o.flirHasHover;
        var hoverTree = o;
        
        var on = (e.type == 'mouseover');
        
        while(o != document.body && !o.flirMainObj) {
            o = FLIR.getParentNode(o);
            
            if(!targDescHover) {
                    targDescHover = o.flirHasHover;
                    hoverTree = o;
            }
        }
        
        if(o==document.body) return;
        
        var FStyle = FLIR.getFStyle(o);
        if(on && FStyle != FStyle.hoverStyle)
            FStyle = FStyle.hoverStyle;
            
        if(!(args = FLIR._call_plugin('hover', [ on, targ, o, hoverTree ]))) return;
        on                = args[0];
        targ             = args[1];
        o                 = args[2];
        hoverTree     = args[3];
        
        var objs = FLIR.getChildren(hoverTree);
        if(objs.length == 0 || (objs.length == 1 && (objs[0].flirImage || objs[0].flirHasHover))) {
            objs = [hoverTree];
        }else if(objs.length == 1 && !FLIR.isIgnoredElement(objs[0])) {
            var subobjs = FLIR.getChildren(objs[0]);
            if(subobjs.length > 0)
                if((subobjs.length==1 && !subobjs[0].flirImage) || subobjs.length > 1)
                    objs = subobjs;
        }

        var rep_obj;
        for(var i=0; i < objs.length; i++) {
            rep_obj = objs[i];
            if(rep_obj.nodeName == 'IMG') continue;
            if(!rep_obj.innerHTML) continue; // IE 

            if(FLIR.isIE) {
                var idx = FLIR.flirIEHovEls.length;
                FLIR.flirIERepObj[idx] = rep_obj;
                FLIR.flirIEHovStyles[idx] = FStyle;
                
                if(!FLIR.isCraptastic) {
                    if(FStyle.useBackgroundMethod && FLIR.getStyle(rep_obj, 'display') == 'block') {
                        FLIR.flirIEHovEls[idx] = rep_obj;
                        setTimeout('FLIR.flirIERepObj['+idx+'].style.background = "url("+('+on+' ? FLIR.flirIEHovStyles['+idx+'].generateURL(FLIR.flirIERepObj['+idx+']) : FLIR.flirIERepObj['+idx+'].flirOrig)+") no-repeat";', 0);
                    }else {
                        FLIR.flirIEHovEls[idx] = rep_obj.flirImage ? rep_obj : FLIR.getChildren(rep_obj)[0];
                        if(!FLIR.flirIEHovEls[idx].flirOrigWidth) {
                            FLIR.flirIEHovEls[idx].flirOrigWidth = FLIR.flirIEHovEls[idx].width;
                            FLIR.flirIEHovEls[idx].flirOrigHeight = FLIR.flirIEHovEls[idx].height;
                        }
                        var ie_js = 'FLIR.flirIEHovEls['+idx+'].src = '+on+' ? FLIR.flirIEHovStyles['+idx+'].generateURL(FLIR.flirIERepObj['+idx+'], FLIR.flirIEHovEls['+idx+'].alt) : FLIR.flirIERepObj['+idx+'].flirOrig;'
                        ie_js += 'FLIR.flirIEHovEls['+idx+'].onload = function() { ';
                        if(on && !FLIR.flirIEHovEls[idx].flirHoverWidth) {
                            ie_js += '        FLIR.flirIEHovEls['+idx+'].flirHoverWidth = this.width; ';
                            ie_js += '        FLIR.flirIEHovEls['+idx+'].flirHoverHeight = this.height; ';
                        }
                        ie_js += '    this.style.width = FLIR.flirIEHovEls['+idx+'].'+(on?'flirHoverWidth':'flirOrigWidth')+'+"px"; ';
                        ie_js += '    this.style.height = FLIR.flirIEHovEls['+idx+'].'+(on?'flirHoverHeight':'flirOrigHeight')+'+"px"; ';
                        ie_js += '}; ';
                        setTimeout(ie_js, 0);
                    }
                }else {
                    FLIR.flirIEHovEls[idx] = rep_obj.flirImage ? rep_obj : FLIR.getChildren(rep_obj)[0];
                    setTimeout('  FLIR.flirIEHovEls['+idx+'].style.filter = \'progid:DXImageTransform.Microsoft.AlphaImageLoader(src="\'+FLIR.flirIEHovStyles['+idx+'].generateURL(FLIR.flirIERepObj['+idx+'], FLIR.flirIEHovEls['+idx+'].alt)+\'", sizingMethod="image")\';  ', 0);
                }
            }else {
                if(FStyle.useBackgroundMethod && FLIR.getStyle(rep_obj, 'display') == 'block') {
                    var hovURL = rep_obj.flirHoverURL ? rep_obj.flirHoverURL : FStyle.generateURL(rep_obj);
                    rep_obj.style.background='url('+(on?hovURL:rep_obj.flirOrig)+') no-repeat';
                }else {
                    var img = rep_obj.flirImage ? rep_obj : FLIR.getChildren(rep_obj)[0];
                    var hovURL = rep_obj.flirHoverURL ? rep_obj.flirHoverURL : FStyle.generateURL(rep_obj, img.alt);
                    img.src = on?hovURL:rep_obj.flirOrig;
                }
            }
        }
    }

    ,addHover: function(obj) {
        if(!(args = FLIR._call_plugin('addHover', arguments))) return;
        obj    = args[0];
        
        obj.flirHasHover = true;
        
        if(obj.addEventListener) {
            obj.addEventListener( 'mouseover', FLIR.hover, false );
            obj.addEventListener( 'mouseout', FLIR.hover, false );
        }else if (obj.attachEvent) {
            obj.attachEvent( 'onmouseover', function() { FLIR.hover( window.event ); } );
            obj.attachEvent( 'onmouseout', function() { FLIR.hover( window.event ); } );
        }
    }
    
    ,prepare: function(n) {
        if(!(args = FLIR._call_plugin('prepare', arguments))) return;
        n = args[0];
        
        if(n && n.hasChildNodes() && n.childNodes.length > 1) {
            for(var i in n.childNodes) {
                var node = n.childNodes[i];
                if(node && node.nodeType == 3) {
                    var span = document.createElement('SPAN');
                    span.style.margin = span.style.padding = span.style.border = '0px';
                    span.className = 'flir-span';
						  span.flirSpan = true;
                    var txt = node.nodeValue.replace(/[\t\n\r]/g, ' ').replace(/\s\s+/g, ' ');
                    span.innerHTML = !FLIR.isIE ? txt : node.nodeValue.replace(/^\s+|\s+$/g,'&nbsp;');
                    n.replaceChild(span, node);
                }
            }
        }
    }
    
    ,replace: function(o, FStyle) {
        if(!(args = FLIR._call_plugin('replace', arguments))) return;
        o         = args[0];
        FStyle     = args[1];

        if (!o || o.flirReplaced)
            return;
        
        if(!this.isFStyle(FStyle))
            FStyle = this.getFStyle(o);

        if(typeof o == 'string')
            o = this.getElements(o);
        
        if(typeof o.length != 'undefined') {
            if(o.length == 0) return;

            for(var i=0; i< o.length; i++)
                this.replace(o[i], FStyle);
            
            return;
        }

        if(typeof FLIR.onreplacing == 'function') o = FLIR.onreplacing(o, FStyle);
        
        o.flirMainObj = true;
        this.setFStyle(o, FStyle);
        this.saveObject(o);
        
        if(this.options.findEmbededFonts && typeof this.embededFonts[FStyle.getFont(o)] != 'undefined')
            return;
        
        FLIR.prepare(o);        
        this._replace_tree(o, FStyle);

        if(typeof FLIR.onreplaced == 'function') FLIR.onreplaced(o, FStyle);
    }
    
    ,_replace_tree: function(o, FStyle) {
        if(typeof __flir_replacetree_recurse == 'undefined') __flir_replacetree_recurse = 1;
        else __flir_replacetree_recurse++;
        
        if(__flir_replacetree_recurse>1000) {
            console.error('Facelift: Too much recursion.');
            return;
        }
        
        var objs = !o.hasChildNodes() || (o.hasChildNodes() && o.childNodes.length==1 && o.childNodes[0].nodeType==3) ? [o] : o.childNodes;

        var rep_obj;
        for(var i=0; i < objs.length; i++) {
            rep_obj = objs[i];
            if(typeof FLIR.onreplacingchild == 'function') rep_obj = FLIR.onreplacingchild(rep_obj, FStyle);

            if(!rep_obj.innerHTML || rep_obj.nodeType != 1) continue;
            if(FLIR.isIgnoredElement(rep_obj)) continue;
            if(rep_obj.flirReplaced) continue;

            if(rep_obj.nodeName == 'A' && !rep_obj.flirHasHover)
                FLIR.addHover(rep_obj);

            if(rep_obj.hasChildNodes() && (rep_obj.childNodes.length > 1 || rep_obj.childNodes[0].nodeType != 3)) {
                FLIR.prepare(rep_obj);
                FLIR._replace_tree(rep_obj, FStyle);
                continue;
            }

            if(rep_obj.innerHTML == '') continue; // skip empty tags, if they exist
            
            if(!FLIR.isCraptastic)
                if(FStyle.useBackgroundMethod)
                    FLIR.replaceMethodBackground(rep_obj, FStyle);
                else
                    FLIR.replaceMethodOverlay(rep_obj, FStyle);
            else
                FLIR.replaceMethodCraptastic(rep_obj, FStyle);

            rep_obj.className += ' flir-replaced';
            rep_obj.flirReplaced = true;
            
            if(typeof FLIR.onreplacedchild == 'function') FLIR.onreplacedchild(o, FStyle);
        }
    }
    
    ,replaceMethodBackground: function(o, FStyle) {
        if(!(args = FLIR._call_plugin('replaceMethodBackground', arguments))) return;
        o         = args[0];
        FStyle     = args[1];

        var oid = this.saveObject(o);
        var url = FStyle.generateURL(o);
        
        if(FLIR.getStyle(o, 'display') != 'block')
            o.style.display='block';
        
        var tmp = new Image();
        tmp.onload = function() {
            FLIR.flirElements[oid].style.width=this.width+'px';
            FLIR.flirElements[oid].style.height=this.height+'px';
            
            if(FStyle != FStyle.hoverStyle) {
                var h_img = new Image();
                o.flirHoverURL = h_img.src = FStyle.hoverStyle.generateURL(o);
            }
        };
        tmp.src = url;
        
        o.style.background = 'url("'+url.replace(/ /g, '%20')+'") no-repeat';
        o.flirOrig = url;
        
        o.oldTextIndent = o.style.textIndent;
        o.style.textIndent='-9999px';
    }

    ,replaceMethodOverlay: function(o, FStyle) {
        if(!(args = FLIR._call_plugin('replaceMethodOverlay', arguments))) return;
        o         = args[0];
        FStyle     = args[1];

        var oid = this.saveObject(o);
        var img = document.createElement('IMG');
        img.alt = this.sanitizeHTML(o.innerHTML);

        if(FStyle != FStyle.hoverStyle) {
            img.onload = function() {
                    var h_img = new Image();
                    o.flirHoverURL = h_img.src = FStyle.hoverStyle.generateURL(o, img.alt);
            };
        }
        
        if(img.onerror) {
            img.onerror = function() {
                var span = document.createElement('SPAN');
                span.innerHTML = img.alt;
                try {
                    o.replaceChild(span,img)
                }catch(err) { }
            };
        }

        img.flirImage = true;
        img.className = 'flir-image';
        img.src = FStyle.generateURL(o);
        img.style.border='none';
        o.flirOrig = img.src;
        o.innerHTML='';
        o.appendChild(img);
    }

    ,replaceMethodCraptastic: function(o, FStyle) {
        if(!(args = FLIR._call_plugin('replaceMethodCraptastic', arguments))) return;
        o         = args[0];
        FStyle     = args[1];

        var oid = this.saveObject(o);
        var url = FStyle.generateURL(o);
        
        var img = document.createElement('IMG');
        img.alt = this.sanitizeHTML(o.innerHTML);        
        if(FStyle != FStyle.hoverStyle) {
            img.onload = function() {
                    var h_img = new Image();
                    o.flirHoverURL = h_img.src = FStyle.hoverStyle.generateURL(o, img.alt);
            };
        }

        img.flirImage = true;
        img.className = 'flir-image';
        img.src = this.options.path+'spacer.png';
        img.style.width=o.offsetWidth+'px';
        img.style.height=o.offsetHeight+'px';
        img.style.filter = 'progid:DXImageTransform.Microsoft.AlphaImageLoader(src="'+url+'", sizingMethod="image")';

        o.flirOrig = url;
        o.innerHTML='';
        o.appendChild(img);
    }

    ,saveObject: function(o) {
        if(typeof o.flirId == 'undefined') {
            o.flirId = this.getUID();
            this.flirElements[o.flirId] = o;
        }
        
        return o.flirId;
    }
    
    ,getUID: function() {
        var prefix='flir-';
        var id=prefix+Math.random().toString().split('.')[1];
        var i=0;
        while(typeof this.flirElements[id] != 'undefined') {
            if(i>100000) {
                console.error('Facelift: Unable to generate unique id.');    
            }
            id=prefix+Math.random().toString().split('.')[1];
            i++;
        }
        
        return id;
    }
    
    ,getElements: function(tag) {
        if(!(args = FLIR._call_plugin('getElements', arguments))) return;
        switch(args.length) {
            case 1:
                tag = args[0];
                break;
            case 2: // plugin returned list of elements
                return args[0];
                break;
        }
        
        var found = [];

        if(document.querySelectorAll) {
            var qsa = false;
            try{
                found = document.querySelectorAll(tag);
                qsa = true;
            }catch(err){ qsa=false; }

            if(qsa)
                return found;
        }

        var objs,subels,cn,childs,tag,el,matches,subel,rep_el;
    
        el = tag;
        
        subel=false;
		if(el.indexOf(' ')>-1) {
			var parts = el.split(' ');
			el = parts[0];
			subel = parts[1];
		}else if(el[0] == '#') {
			return document.getElementById(el.substr(1));
		}
        
        var grain_id=false;
        if(el.indexOf('#') > -1) {
            grain_id = el.split('#')[1];
            tag = el.split('#')[0];
        }

        var grain_cn=false;
        if(el.indexOf('.') > -1) {
            grain_cn = el.split('.')[1];
            tag = el.split('.')[0];
        }

        objs = document.getElementsByTagName(tag);
        for(var p=0; p<objs.length; p++) {
            if(objs[p].nodeType != 1) continue;
            matches = false;
            cn = objs[p].className?objs[p].className:'';
            
            if(grain_id && objs[p].id && objs[p].id == grain_id)
                matches=true;
            if(grain_cn && FLIR.hasClass(objs[p], grain_cn))
                matches=true;
            if(!grain_id && !grain_cn)
                matches=true;
            
            if(!matches) continue;
            if(this.options.classnameIgnore && cn.indexOf(this.options.classnameIgnore)>-1) continue;
            
            subels = false != subel ? objs[p].getElementsByTagName(subel) : [objs[p]];
            for(var pp=0; pp<subels.length; pp++) {
                rep_el = subels[pp];
                if(this.options.classnameIgnore && rep_el.className && rep_el.className.indexOf(this.options.classnameIgnore)>-1) continue;

                found.push(rep_el);
            }
        }
        
        return found;
    }
    
    ,discoverEmbededFonts: function() {
        this.embededFonts = {};
        for(var i in document.styleSheets) {
            if(!document.styleSheets[i].cssRules) continue;
            for(var ii in document.styleSheets[i].cssRules) {
                if(!document.styleSheets[0].cssRules[ii]) continue;
                var node = document.styleSheets[0].cssRules[ii];
                
                if(node.type && node.type == node.FONT_FACE_RULE) {
                    var nodesrc = node.style.getPropertyValue('src').match(/url\("?([^"\)]+\.[ot]tf)"?\)/i)[1];
                    var font = node.style.getPropertyValue('font-family');
                    if(font.indexOf(',')) {
                        font = font.split(',')[0];
                    }
                
                    font = font.replace(/['"]/g, '').toLowerCase();
                    
                    if(font!='' && nodesrc != '')
                        this.embededFonts[font] = nodesrc;
                }
            }
        }    
    }

    ,getStyle: function(el,prop) {
        if(el.currentStyle) {
            if(prop.indexOf('-') > -1)
                prop = prop.split('-')[0]+prop.split('-')[1].substr(0, 1).toUpperCase()+prop.split('-')[1].substr(1);
            var y = el.currentStyle[prop];
        }else if(window.getComputedStyle) {
            var y = document.defaultView.getComputedStyle(el,'').getPropertyValue(prop);
        }
        return y;
    }
        
    ,getChildren: function(n) {
        var children=[];
        if(n && n.hasChildNodes())
            for(var i in n.childNodes)
                if(n.childNodes[i] && n.childNodes[i].nodeType == 1)
                    children[children.length]=n.childNodes[i];
    
        return children;
    }
    
    ,getParentNode: function(n) {
        var o=n.parentNode;
        while(o != document && o.nodeType != 1)
            o=o.parentNode;
    
        return o;
    }
    
    ,hasClass: function(o, cn) {
        return (o && o.className && o.className.indexOf(cn)>-1);
    }
    
    ,evsrc: function(e) {
        var o;
        if (e.target) o = e.target;
        else if (e.srcElement) o = e.srcElement;
        if (o.nodeType == 3) // defeat Safari bug
            o = o.parentNode;    
            
        return o;
    }
    
    ,calcDPI: function() {
        if(screen.logicalXDPI) {
            var dpi = screen.logicalXDPI;
        }else {
            var id = 'flir-dpi-div-test';
            if(document.getElementById(id)) {
                var test = document.getElementById(id);
            }else {
                var test = document.createElement('DIV');
                test.id = id;
                test.style.position='absolute';
                test.style.visibility='hidden';
                test.style.border=test.style.padding=test.style.margin='0';
                test.style.left=test.style.top='-1000px';
                test.style.height=test.style.width='1in';
                document.body.appendChild(test);
            }
            
            var dpi = test.offsetHeight;
        }
        
        this.dpi = parseInt(dpi);
    }
    
    ,isIgnoredElement: function(el, breakIgnored) { return ((','+this.options.ignoredElements).indexOf(','+el.nodeName)>-1); }
    ,sanitizeHTML: function(html) { return html.replace(/<[^>]+>/g, ''); }
    
    ,getFStyle: function(o, fstyle) { 
        var cStyle = this.getClassStyle(o);
        if(this.isFStyle(cStyle))
            fstyle = cStyle;

        if(this.isFStyle(fstyle)) {
            return fstyle;
        }else if(this.isFStyle(o.flirStyle)) {
            return o.flirStyle;
        }else {
            return this.defaultStyle;
        }
    }
    ,setFStyle: function(o, FStyle) { o.flirStyle = FStyle; }
    ,isFStyle: function(o) { if(!o) return false; return (o.toString() == '[FLIRStyle Object]'); }

    ,addClassStyle: function(classname, FStyle) {
        if(this.isFStyle(FStyle))
            this.classStyles[classname] = FStyle;
    }
    ,getClassStyle: function(o) {
        if(!(args = FLIR._call_plugin('getClassStyle', arguments))) return;
        switch(args.length) {
            case 1:
                o = args[0];
                break;
            case 2: // plugin returned a style
                return args[0];
                break;
        }

        var cn = o.className;
        if(this.classStyles.length == 0 || typeof cn == 'undefined' || cn=='') return false;
        
        var classes = cn.split(' ');
        for(var i in this.classStyles) {
            for(var ii=0; ii<classes.length; ii++) {
                if(classes[ii]==i) {
                    return this.classStyles[i];
                }
            }
        }
        
        return false;
    }
};












function FLIRStyle(options) {
    this.useBackgroundMethod     = false;
    this.inheritStyle             = true;
    this.useExtendedStyles        = false;
    this.hoverStyle             = (arguments[1] && FLIR.isFStyle(arguments[1])) ? arguments[1] : this;
    
    // options are sent along with the query string
    this.options = {
         mode: '' // none (''), wrap,progressive or name of a plugin
        ,output:'auto' // auto, png, gif, jpg
        
        ,cSize: null
        ,cColor: null
        ,cFont: null // font-family
        
        ,realFontHeight: false
        ,dpi: 96
    };
    
    // supported css properties to internal name
    this.cssStyles = {
         'background-color'    : 'Background'
        ,'color'             : 'Color'
        ,'font-family'        : 'Font'
        ,'font-size'        : 'Size'
        ,'letter-spacing'    : 'Spacing'
        ,'line-height'        : 'Line'
        ,'text-align'        : 'Align'
        ,'text-transform'    : 'Transform'
    };
    
    this.extendedStyles = {
         'font-stretch'        : 'Stretch'
        ,'font-style'        : 'FontStyle'
        ,'font-variant'        : 'Variant'
        ,'font-weight'        : 'Weight'
        ,'opacity'            : 'Opacity'
        ,'text-decoration'    : 'Decoration'
    }
    
    // legacy option support
    for(var i in options) {
        if(i.indexOf('css')==0)
            i = 'c'+i.substr(3);

        if(typeof this[i] != 'undefined') {
            this[i] = options[i];
        }else {
            this.options[i] = options[i];
        }
    }
    this.options.dpi = FLIR.dpi;
    
    
    if(this.useExtendedStyles)
        for(var i in this.extendedStyles)
            this.cssStyles[i] = this.extendedStyles[i];
    
    for(var i=0; i<FLIR.flirPlugins.length; i++)
        if(FLIR.flirPlugins[i].FLIRStyleExtend && typeof FLIR.flirPlugins[i].FLIRStyleExtend.init)
            FLIR.flirPlugins[i].FLIRStyleExtend.init.call(this);
}

// generate a url based on an object
FLIRStyle.prototype.generateURL = function(o) { // [, text]
    var enc_text = (arguments[1]?arguments[1]:o.innerHTML);
    var transform = this.options.cTransform;
    if(transform==null)
        transform = FLIR.getStyle(o, 'text-transform');

    switch(transform) {
        case 'capitalize':
            enc_text = enc_text.replace(/\w+/g, function(w){
                              return w.charAt(0).toUpperCase() + w.substr(1).toLowerCase();
                         });
            break;
        case 'lowercase':
            enc_text = enc_text.toLowerCase();
            break;
        case 'uppercase':
            enc_text = enc_text.toUpperCase().replace(/&[a-z0-9]+;/gi, function(m) { return m.toLowerCase(); }); // keep entities lowercase, numeric don't matter
            break;
    }

    enc_text = encodeURIComponent(enc_text.replace(/&/g, '{amp}').replace(/\+/g, '{plus}'));

    return FLIR.options.path+'generate.php?text='+enc_text+'&h='+o.offsetHeight+'&w='+o.offsetWidth+'&fstyle='+this.serialize(o);
};

// create a custom image on the fly
FLIRStyle.prototype.buildURL = function(text, o, maxwidth, maxheight) {
    var enc_text = encodeURIComponent(text.replace(/&/g, '{amp}').replace(/\+/g, '{plus}'));
    return FLIR.options.path+'generate.php?text='+enc_text+'&h='+(maxheight?maxheight:'200')+'&w='+(maxwidth?maxwidth:'800')+'&fstyle='+(o?this.serialize(o):this.serialize());
};

FLIRStyle.prototype.serialize = function(o) {
    var sdata='';
    var options = this.copyObject(this.options);    
    
    if(o && this.inheritStyle) {
        for(var i in this.cssStyles) {
            var name = this.cssStyles[i];

            if(this.options['c'+name] == null || name=='Size')
                this.options['c'+name] = this.get(o, i, name);    
        }
    }
    
    for(var i in this.options) {
        if(this.options[i] == null || typeof this.options[i] == 'undefined' || this.options[i] == 'NaN')
            continue;
        sdata += ',"'+i+'":"'+this.options[i].toString().replace(/"/g, "'")+'"';
    }

    sdata = '{'+sdata.substr(1)+'}';
    this.options = options;

    return escape(sdata);
};

FLIRStyle.prototype.get = function(o, css_property, flirstyle_name) {
    var func = 'get'+flirstyle_name;
    
	 while(o.flirSpan && o != document.body)
	 	o = FLIR.getParentNode(o);
    
    return typeof this[func] == 'function' ? this[func](o) : FLIR.getStyle(o, css_property);
};

FLIRStyle.prototype.getFontStyle = function(o) { 
    return o.nodeName=='EM' || FLIR.getParentNode(o).nodeName=='EM' ? 'italic' : FLIR.getStyle(o, 'font-style');
};

FLIRStyle.prototype.getWeight = function(o) { 
    var fontweight = o.nodeName=='STRONG' || FLIR.getParentNode(o).nodeName=='STRONG' ? 'bold' : FLIR.getStyle(o, 'font-weight');
    
    switch(fontweight.toString()) {
        case '100': case '200': case '300': case 'lighter':
            return 'lighter';
        case '400': case 'normal':
            return '';
        case '500': case '600': case '700': case 'bold':
            return 'bold';
        case '800': case '900': case 'bolder':
            return 'bolder';
    }
};

FLIRStyle.prototype.getFont = function(o) { 
    var font = FLIR.getStyle(o, 'font-family');
    if(font.indexOf(',')) {
        font = font.split(',')[0];
    }

    return font.replace(/['"]/g, '').toLowerCase();
};

FLIRStyle.prototype.getColor = function(o) { 
    var color = FLIR.getStyle(o, 'color');
    if(color.substr(0, 1)=='#')
        color = color.substr(1);
    
    return color.replace(/['"]/g, '').toLowerCase();
};

FLIRStyle.prototype.getSize = function(o) {
    if(this.options.cSize!=null && '*/+-'.indexOf(this.options.cSize[0])<0)
        return this.options.cSize;
    
    var raw = FLIR.getStyle(o, 'font-size');

    var pix;
    if(raw.indexOf('px') > -1) {
        pix = Math.round(parseFloat(raw));
    }else {
        if(raw.indexOf('pt') > -1) {
            var pts = parseFloat(raw);
            pix = pts/(72/this.options.dpi);
        }else if(raw.indexOf('em') > -1 || raw.indexOf('%') > -1) {
            pix = this.calcFontSize(o);
        }
    }

    if(this.options.cSize && '*/+-'.indexOf(this.options.cSize[0])>-1) {
        try {
            pix = this.roundFloat(parseFloat(eval(pix.toString().concat(this.options.cSize))));
        }catch(err) { }
    }
    
    o.flirFontSize = pix;
    
    return pix;
};

FLIRStyle.prototype.getSpacing = function(o) {
    var spacing = FLIR.getStyle(o, 'letter-spacing');
    var ret;
    if(spacing != 'normal') {
        if(spacing.indexOf('em') > -1) {
            var fontsize = o.flirFontSize ? o.flirFontSize : this.getSize(o);
            ret = (parseFloat(spacing)*fontsize);
        }else if(spacing.indexOf('px') > -1) {
            ret = parseFloat(spacing);
        }else if(spacing.indexOf('pt') > -1) {
            var pts = parseFloat(spacing);
            ret = pts/(72/this.options.dpi);            
        }
        
        return this.roundFloat(ret);
    }

    return '';    
};

FLIRStyle.prototype.getLine = function(o) {
    var spacing = FLIR.getStyle(o, 'line-height');
    var val = parseFloat(spacing);
    var fontsize = o.flirFontSize ? o.flirFontSize : this.getSize(o);
    if(spacing.indexOf('em') > -1) {
        ret = (val*fontsize)/fontsize;
    }else if(spacing.indexOf('px') > -1) {
        ret = val/fontsize;
    }else if(spacing.indexOf('pt') > -1) {
        var pts = val;
        ret = (pts/(72/this.options.dpi))/fontsize;
    }else if(spacing.indexOf('%') > -1) {
        return 1.0;    
    }else {
        ret = val;    
    }
    
    return this.roundFloat(ret);
};

FLIRStyle.prototype.roundFloat = function(val) {
    return Math.round(val*10000)/10000;
};

FLIRStyle.prototype.calcFontSize = function(o) {
    var test = document.createElement('DIV');
    test.style.border = '0';
    test.style.padding = '0';
    test.style.position='absolute';
    test.style.visibility='hidden';
    test.style.left=test.style.top='-1000px';
    test.style.left=test.style.top='10px';
    test.style.lineHeight = '100%';
    test.innerHTML = 'Flir_Test';        
    o.appendChild(test);
    
    var size = test.offsetHeight;
    o.removeChild(test);

    return size;
};

FLIRStyle.prototype.copyObject = function(obj) { 
    var copy = {};
    for(var i in obj) {
        copy[i] = obj[i];    
    }
    
    return copy;
};

FLIRStyle.prototype.toString = function() { return '[FLIRStyle Object]'; };
