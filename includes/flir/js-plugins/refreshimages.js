// JavaScript Document

var FLIR_RefreshImages = {
	 version: '1.0'

	,watch_element: null
	
	,is_safari: false
	,safari_poll: null
	
	,init: function() {
		this.watch_element = document.createElement('SPAN');
		this.watch_element.id = 'flir-refreshimages-test'
		this.watch_element.style.fontSize = '1em';
		this.watch_element.style.visibility = 'hidden';
		this.watch_element.style.left = this.watch_element.style.top = '-1000px';
		this.watch_element.innerHTML = 'Test';
		document.body.appendChild(this.watch_element);
		this.watch_element.previousFontSize = FLIR.getStyle(this.watch_element, 'font-size');
		
		var oldresize = window.onresize;
		window.onresize = function() {
			FLIR_RefreshImages.refreshReplacedImages();
			if(typeof oldresize == 'function')
				oldresize(window.event);
		};
		
		this.is_safari = (navigator.userAgent.search(/safari|chrome/i)>-1);
		
		if(this.is_safari)
			this._init_safari();
	}
	
	,_init_safari: function() {
		this.safari_poll = setInterval('FLIR_RefreshImages._textsize_watch();', 1000);
	}
	
	,_textsize_watch: function() {
		var csize = FLIR.getStyle(this.watch_element, 'font-size');
		if(this.watch_element.previousFontSize != csize) {
			this.refreshReplacedImages();
			this.watch_element.previousFontSize = csize;
		}
	}
	
	,refreshReplacedImages: function() {
		for(var i in FLIR.flirElements) {
			var o=FLIR.flirElements[i];
			if(o.flirMainObj)
				this.refreshReplacedElement(o, FLIR.getFStyle(o));
		}
	}
	
	,refreshReplacedElement: function(n, FStyle, root) {
		if(typeof root == 'undefined') root = n;
		
		if(FStyle.useBackgroundMethod)
			return false; // background method not supported

		if(n && n.hasChildNodes()) {
			for(var i in n.childNodes) {
				var node = n.childNodes[i];
				if(node && node.nodeType == 1) {
					if(node.flirImage) {
						var url = FStyle.buildURL(node.alt, node, root.offsetWidth);
						n.flirOrig = url;
						if(!FLIR.isCraptastic) {
							node.src = url;
						}else {
							node.style.filter = 'progid:DXImageTransform.Microsoft.AlphaImageLoader(src="'+url+'", sizingMethod="image")';
						}
					}else {
						this.refreshReplacedElement(node, FStyle, root);
					}
				}
			}
		}
	}
	
	,toString: function() {
		return '[RefreshImages FLIRPlugin]';
	}
};
FLIR.installPlugin(FLIR_RefreshImages);
