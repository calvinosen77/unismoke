<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<?php $seo_title = (!empty($seo_title)) ? $seo_title : '' ?>
<title><?php echo config_item('company_name').': '. $seo_title;?></title>

<link rel="shortcut icon" href="<?php echo theme_img('favicon.png');?>" type="image/png" />
<?php if(isset($meta)):?>
<?php echo (strpos($meta, '<meta') !== false) ? $meta : '<meta name="description" content="'.$meta.'" />';?>
<?php else:?>
    <meta name="keywords" content="<?php echo config_item('default_meta_keywords');?>" />
    <meta name="description" content="<?php echo config_item('default_meta_description');?>" />
<?php endif;?>

<?php
$_css = new CSSCrunch();
$_css->addFile('bootstrap');
$_css->addFile('bootstrap-theme');
$_css->addFile('jquery.mCustomScrollbar');

$_css->addFile('age-verification');
$_css->addFile('jquery.bxslider');
$_css->addFile('select2');
$_css->addFile('slick');
$_css->addFile('star-rating');
$_css->addFile('style');
$_css->addFile('tooltipster');
$_css->addFile('custom');

$_js = new JSCrunch();
$_js->addFile('jquery-2.1.4.min');
$_js->addFile('jquery.bxslider.min');
$_js->addFile('jquery.FlowupLabels');
$_js->addFile('jquery.mCustomScrollbar.concat.min');
$_js->addFile('jquery.tooltipster.min');
$_js->addFile('jquery.waypoints.min');
$_js->addFile('_main');
$_js->addFile('bootstrap.min');
$_js->addFile('device.min');
$_js->addFile('elementQuery.min');
$_js->addFile('infinite.min');
$_js->addFile('modernizr.custom.53952');
$_js->addFile('parsley.min');
$_js->addFile('select2.min');
$_js->addFile('slick.min');
$_js->addFile('star-rating.min');
$_js->addFile('zoomsl-3.0.min');
$_js->addFile('product');

if(true) //Dev Mode
{
    //in development mode keep all the css files separate
    $_css->crunch(true);
    $_js->crunch(true);
}
else
{
    //combine all css files in live mode
    $_css->crunch();
    $_js->crunch();
}


//with this I can put header data in the header instead of in the body.
if(isset($additional_header_info))
{
    echo $additional_header_info;
}
?>
</head>

<body>
<header>
    <div class="container-fluid top-header">
        <button type="button" class="navbar-toggle">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <button type="button" class="btn open-search icon-search-btn"><span class="sr-only">Toggle search form</span></button>
        <div class="wrapper clearfix">
            <div class="top-header-info pull-left clearfix">
                <p>Free Shipping On $49+ Orders</p>
                <p><mark>%100 Money Back Guarantee</mark></p>
            </div>
            <div class="top-header-controls pull-right clearfix">
                <ul class="nav navbar-nav">
                    <li class="chat"><a href="#" class="icon-comment-empty">Live Chat</a></li>
                    <!--<li class="invite"><a href="#" class="icon-mail">Invite a Friend</a></li>-->
                    <li id="account" class="account">
                        <a href="<?php echo site_url('my-account'); ?>" class="dropdown-toggle icon-user" role="button" aria-haspopup="true" aria-expanded="false">
                        <?php if(CI::Login()->isLoggedIn(false, false)):?>
                            <?php echo '<b>'.lang('hello').lang('your_account').'</b>'; ?>
                        <?php else: ?>
                            <?php echo '<b>'.lang('hello').', '.lang('sign_in').'</b>'; ?>
                        <?php endif; ?>
                        <span class="caret icon-down-open-mini"></span></a>
                        <div id="ajaxLoginBox" class="login-form dropdown-menu dropdown-menu-right">
                            <?php if(CI::Login()->isLoggedIn(false, false)):?>
                                <h3>LOG IN TO UNISMOKE</h3>
                                <form id="homeAjaxLogin" action="<?php //echo $ajax_login; ?>" method="post">
                                    <div class="field-row form-group">
                                        <label class="sr-only" for="login-form-email">Email</label>
                                        <input name="email" type="email" class="form-control" id="login-form-email" placeholder="Email">
                                    </div>
                                    <div class="field-row form-group">
                                        <label class="sr-only" for="login-form-password">Password</label>
                                        <input name="password" type="password" class="form-control" id="login-form-password" placeholder="Password">
                                    </div>
                                    <div class="field-row pull-left form-group">
                                        <input type="checkbox" id="keep-logged"/>
                                        <label for="keep-logged">Keep me logged in</label>
                                    </div>
                                    <a href="<?php echo lang('forgot_password'); ?>" class="pull-right pass-help"><?php echo lang('forgot_password') ?></a>
                                    <div id="ajaxLoginErrorMessageBox" class="field-row form-group hidden">
                                        <p class="pull-left"><span id="ajaxLoginErrorMessage" class="error-message">test</span></p>
                                    </div>
                                    <button id="ajaxLogin" type="button" class="btn btn-default">SIGN IN<span id="ajaxLoaderWhite" class="ajaxLoader"></span></button>
                                    <a href="<?php echo lang('register'); ?>" class="btn btn-dark"><?php echo lang('register'); ?></a>
                                    <!--
                                    <div class="separator">
                                      <p>or</p>
                                    </div>
                                    <button type="submit" class="btn btn-amazon icon-amazon">Login with Amazon</button>
                                    -->
                                </form>
                            <?php else: ?>
                                <?php //echo $account_links; ?>
                            <?php endif; ?>
                        </div>
                    </li>
                    <li id="wish" class="wish"><a href="<?php echo lang('wish_list');; ?>" title="<?php echo lang('wish_list'); ?>" class="icon-heart-empty dropdown-toggle" role="button" aria-haspopup="true" aria-expanded="false"><?php echo lang('wish_list'); ?><span class="caret icon-down-open-mini"></span></a>
                        <div class="cart-box dropdown-menu dropdown-menu-right">
                            <?php //if( sizeof($wishlist_data['products']) > 0 ) { // If we have items in Wishlist ?>
                                <ul class="goods-list scrolled">
                                    <?php //foreach ($wishlist_data['products'] as $wishlist_product) { ?>
                                        <li>
                                            <a href="<?php //echo $wishlist_product['href']; ?>" class="clearfix">
                                                <img src="<?php //echo $wishlist_product['thumb']; ?>" alt="" class="pull-left"/>
                                                <p class="good-name"><?php //echo $wishlist_product['name']; ?></p>
                                                <p class="">50 ml / 3 mg</p>
                                            </a>
                                        </li>
                                        <?php if(CI::Login()->isLoggedIn(false, false)): ?>
                                            <a href="<?php //echo $wishlist; ?>" type="submit" class="btn btn-default">Edit <?php lang('wish_list'); ?></a>
                                        <?php endif; ?>
                                    <?php //} ?>
                                </ul>
                            <?php //}else{ ?>
                                <p>
                                    Add products to your Wish List & we will email you once their price drop. <br/>
                                    Already have a list? <a href="<?php echo site_url('login');?>" class="blue-link"><?php echo lang('sign_in'); ?></a>
                                </p>
                            <?php //} ?>
                        </div>
                    </li>
                    <li class="basket">
                        <a href="<?php //echo $shopping_cart; ?>" title="<?php echo lang('cart'); ?>" class="icon-cart dropdown-toggle" role="button" aria-haspopup="true" aria-expanded="false"><b><?php echo lang('cart'); ?></b><span class="num"><?php echo GC::totalItems();?></span></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="wrapper">
            <nav class="navbar">
                <div class="navbar-header">
                    <a class="navbar-brand logo" href="<?php echo base_url();?>" title="<?php  echo lang('unismoke'); ?>" alt="<?php echo lang('unismoke'); ?>" ></a>
                    <div class="navbar-form navbar-right">
                        <form class="" role="search" id="header-search-form">
                            <div class="form-group">
                                <label class="sr-only" for="search">Search</label>
                                <input type="text" class="form-control" placeholder="What are you looking for?" id="search">
                            </div>
                            <button type="submit" class="btn btn-default icon-search-btn"><span class="sr-only">Submit</span></button>
                        </form>
                    </div>
                </div>

                <!-- Main Menu (Categories) HELPER -->
                <div class="navbar-collapse" id="main-menu">
                    <ul class="nav navbar-nav">
                        <?php category_loop(0, false, false); ?>
                        <!-- Mobile -->
                        <div class="social-box">
                            <ul>
                                <li><a href="" class="icon-pinterest"><span class="sr-only">Pinterest</span></a></li>
                                <li><a href="" class="icon-twitter"><span class="sr-only">Twitter</span></a></li>
                                <li><a href="" class="icon-facebook"><span class="sr-only">Facebook</span></a></li>
                                <li><a href="" class="icon-instagram"><span class="sr-only">Instagram</span></a></li>
                                <li><a href="" class="icon-youtube"><span class="sr-only">Youtube</span></a></li>
                            </ul>
                        </div>
                        <p class="copyright">©2016 Unismoke.com</p>
                        <!-- End / Mobile -->
                    </ul>
                </div>
                <!-- End / Main Menu (Categories) HELPER -->
            </nav>
        </div>
        <!-- END / Main Menu (Categories) -->
    </div><!-- /.navbar-collapse -->
    <button class="btn btn-default close-menu icon-close"></button>
</header>

<?php if (CI::session()->flashdata('message')):?>
    <div class="alert blue">
        <?php echo CI::session()->flashdata('message');?>
    </div>
<?php endif;?>

<?php echo CI::breadcrumbs()->generate(); ?>
