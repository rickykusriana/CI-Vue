var viewFolder = '../../../application/modules/dashboard/views/';

define(['text!'+viewFolder+'content.php'], function (htmlTemplate) {
  	
  	var VueComponent = function () {
   		
        this.template = htmlTemplate; 
        this.data = function() {
        	return {
    		    message: 'Hello Vue!'
        	}
        };
        // this.created = {};
        // this.methods = {}; 
    };

    return new VueComponent();
});