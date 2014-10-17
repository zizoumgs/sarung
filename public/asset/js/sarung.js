/**
 *  this file contains all global java script
 *  You can call it anytime as long as you include js in root.php
**/

/**
 *  make url , you can also use http://api.jquery.com/jQuery.param/ 
 *  example :
 *  buildUrl('http://www.example.com/foo', 'test', '123');
 *  buildUrl('http://www.example.com/foo?bar=baz', 'test', '123');
 *  return url
 *  
**/

    var buildUrl = function(base, key, value) {
        var sep = (base.indexOf('?') > -1) ? '&' : '?';
        return base + sep + key + '=' + value;
    }
/**
 *  this will called after youtype something
 *  how to use
 *  just do something like following :  addTextAreaCallback(document.getElementById("your_id"), doAjaxStuff, 500 );
*/
function addTextAreaCallback(textArea, callback, delay) {
    var timer = null;
   	textArea.onkeyup = function() {
       	if (timer) {
       		window.clearTimeout(timer);
   		}
   		timer = window.setTimeout( function() {
   			timer = null;
   			callback();
   		}, delay );
	};
	textArea = null;
}

function test_alert(){
    alert();    
}

