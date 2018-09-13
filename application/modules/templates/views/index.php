<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Ricky">
        <meta name="description" content="CodeIgniter with VueJS">
        <title>App</title>

        <link href="<?=base_url();?>public/assets/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?=base_url();?>public/ext/font-awesome/font-awesome.min.css" rel="stylesheet">
        <link href="<?=base_url();?>public/assets/css/starter-template.css" rel="stylesheet">
        <link href="<?=base_url();?>public/ext/node-snackbar/snackbar.min.css" rel="stylesheet">
        <link href="<?=base_url();?>public/ext/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet">

        <script src="<?=base_url();?>src/vendor/require.min.js" data-main="src/require.config"></script>
    </head>

    <body>
        <noscript>You need to enable JavaScript to run this app.</noscript>

        <div id="app">

            <?=$this->load->view('templates/header');?>

            <div class="container theme-showcase" role="main">

                <router-view></router-view>

            </div>
            
            <footer class="footer">
                <div class="container">
                    <p class="text-muted">&copy; 2018
                        <span class="pull-right">build with <i style="color:red" class="fa fa-heart" onclick="window.open('http://kodokode.com');"></i></span>
                    </p>
                </div>
            </footer>

        </div>
    </body>
</html>


