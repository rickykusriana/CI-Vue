var viewFolder = '../../../application/modules/transaction/views/';

define(['text!'+viewFolder+'form.php'], function (htmlTemplate) {
  	
  	var VueComponent = function () {
   		
        this.template = htmlTemplate; 
        
        this.data = function() {
        	return {
        		title: 'Add Product',
        		
        		product: [],

    			product_name: null,
    			product_qty: null,
    			utilities: null,
    			date_of_return: null,
        	}
        };

        this.mounted = function() {
			if (localStorage.getItem('product')) {
				try {
					this.product = JSON.parse(localStorage.getItem('product'));
				} 
				catch(e) {
					localStorage.removeItem('product');
				}
			}
			
			$('.datepicker').datepicker({
				onSelect:function(selectedDate, datePicker) {            
					this.date_of_return = selectedDate;
				}
			});
        };

        this.methods = {

			btn_save() {
				if (!this.product_name) {
					return;
				}

				var no = this.product.length;

				input_data = {
					'no': no+1,
					'product_name': this.product_name,
					'product_qty': this.product_qty,
					'utilities': this.utilities,
					'date_of_return': this.date_of_return
				}

				this.product.push(input_data);

				this.product_name = '';
				this.product_qty = '';
				this.utilities = '';
				this.date_of_return = '';

				this.save_product();
			},
			
			btn_remove(x) {
				this.product.splice(x, 1);
				this.save_product();
			},
			
			save_product() {
				const parsed = JSON.stringify(this.product);
				localStorage.setItem('product', parsed);
			}

        }

        
    };

    return new VueComponent();
});