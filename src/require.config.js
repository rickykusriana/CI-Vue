// Init requirejs
requirejs.config({
    paths: {
        Vue: 'vendor/vue',
        VueRouter: 'vendor/vue-router',
        text: 'vendor/text.min',

        jquery: '../public/assets/js/jquery-3.3.1.min',
        bootstrap: '../public/assets/dist/js/bootstrap.min',
        datepicker: '../public/ext/bootstrap-datepicker/js/bootstrap-datepicker',
        
        appHelper: '../public/ext/app-helper',
    },
    shim: {
    	Vue: { 
    		exports: 'Vue'
    	},
        jquery: {
            exports: 'jquery'
        },
    	bootstrap: {
            deps: ['jquery'],
            exports: 'jquery'
        },
        datepicker: {
            deps: ['jquery'],
            exports: 'jquery'
        },
        appHelper: {
            deps: ['jquery'],
            exports: 'jquery'
        }
    }
});

// These function calls every "Component" to find it.
function view(name) {
    return function (resolve) {
        return require([name], resolve);
    };
}

// Init the require function with Vue Router and Vue.
require( 

    [
        "Vue", 
        "VueRouter", 
        "jquery", 
        "bootstrap", 
        "datepicker",
        "appHelper"
    ], 

    function (
        Vue, 
        VueRouter, 
        $, 
        bootstrap, 
        datepicker,
        appHelper
    ) {

        var routes = [
            {
            	path: '/dashboard',
            	name: 'dashboard', 
            	component: view('./components/dashboard/Dashboard')
            },
            {
                path: '/create',
                name: 'create_transaction',
                component: view('./components/transaction/Create')
            },
            {
                path: '/list',
                name: 'list_transaction', 
                component: view('./components/transaction/List')
            },
            {
                path: '/',
                name: 'default', 
                component: view('./components/dashboard/Dashboard')
            }
        ];

        var router = new VueRouter({
    	    routes: routes,
            linkActiveClass: 'active',
            linkExactActiveClass: 'active'
            // mode: 'history',
    	});

        Vue.use(VueRouter);

        var app = new Vue({
        	'router': router, 
            'data': {}, 
        	'watch': {}, 
            'computed': {},
        	'methods': {},

        }).$mount('#app');
    }
);
