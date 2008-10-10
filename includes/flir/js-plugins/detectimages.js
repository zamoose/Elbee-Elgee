/*
FLIR Plugin - DetectImages v1.0
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

/*

To use this plugin, simple include it AFTER you include the flir.js on your page.  It will automatically install itself and configure.

*/

var FLIR_DetectImages = {
	 version: '1.0'
	,imagesDisabled: null
	,inserted_id: 'detectimagestate-test-img'
	,ie_detectionComplete: false
	,callback: function() { }
	,img: null
	,ie_Timeout: 100
	
	,callQueue: []
	
	,init: function() {
		this.callback = this._detection_complete;
		document.body.innerHTML += '<img id="'+this.inserted_id+'" src="'+FLIR.options.path+'generate.php?'+Math.random()+'" style="visibility:hidden; position:absolute;left:-1000px;" />';
		this.img = document.getElementById(this.inserted_id);
		
		if(window.opera || navigator.userAgent.toLowerCase().indexOf('opera')>-1) {
			var pre = this.img.complete;
			this.img.src = 'about:blank';
			this.imagesDisabled = (!pre && this.img.complete) ? false : true;
			this.callback(this.imagesDisabled);
			return;
		}else if(FLIR.isIE) {
			this.img.src = FLIR.options.path+'generate.php?'+Math.random();
			this.img.onabort = function() {
				FLIR_DetectImages.ie_detectionComplete = true;
				FLIR_DetectImages.imagesDisabled = false;
				FLIR_DetectImages.callback(FLIR_DetectImages.imagesDisabled);
			};
		
			setTimeout('if(!FLIR_DetectImages.ie_detectionComplete) FLIR_DetectImages.callback(true);', this.ie_Timeout);
			return;
		}else {
			this.imagesDisabled = this.img.complete;
			this.callback(this.imagesDisabled);
			return;
		}
	}
	
	,_add_to_queue: function(fn,args) {
		this.callQueue.push([fn,args]);
	}
	
	,_detection_complete: function(disabled) {
		this.imagesDisabled = disabled;
		
		if(!disabled)
			this._process_queue();
	}
	
	,_process_queue: function() {
		if(this.callQueue.length > 0) {
			for(var i=0; i< this.callQueue.length; i++) {
				FLIR[this.callQueue[i][0]].apply(FLIR, this.callQueue[i][1]);
			}
		}	
	}
	
	,auto: function() {
		if(this.imagesDisabled) return false;
		if(this.imagesDisabled == null) {
			this._add_to_queue('auto', arguments);
			return false;
		}
		
		return true;
	}

	,replace: function() {
		if(this.imagesDisabled) return false;
		if(this.imagesDisabled == null) {
			this._add_to_queue('replace', arguments);
			return false;
		}

		return true;
	}
	
	,toString: function() {
		return '[DetectImages FLIRPlugin]';
	}
};
FLIR.installPlugin(FLIR_DetectImages);
