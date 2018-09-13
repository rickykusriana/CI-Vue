var viewFolder = '../../../application/modules/transaction/views/';

define(['text!'+viewFolder+'table.php'], function (htmlTemplate) {
  	
  	var VueComponent = function () {
   		
        this.template = htmlTemplate; 
        // this.data = {};
        // this.created = {};
        // this.methods = {}; 
    };

    return new VueComponent();
});