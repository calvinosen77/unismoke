<?php

$routes[] = ['GET|POST', '/admin/products/product_autocomplete', 'GoCart\Controller\AdminProducts#product_autocomplete'];
$routes[] = ['GET|POST', '/admin/products/approve_review', 'GoCart\Controller\AdminProducts#approve_review'];
$routes[] = ['GET|POST', '/admin/products/delete_review', 'GoCart\Controller\AdminProducts#delete_review'];
$routes[] = ['GET|POST', '/admin/products/bulk_save', 'GoCart\Controller\AdminProducts#bulk_save'];
$routes[] = ['GET|POST', '/admin/products/product_image_form', 'GoCart\Controller\AdminProducts#product_image_form'];
$routes[] = ['GET|POST', '/admin/products/product_image_upload', 'GoCart\Controller\AdminProducts#product_image_upload'];
$routes[] = ['GET|POST', '/admin/products/form/[i:id]?/[i:copy]?', 'GoCart\Controller\AdminProducts#form'];
$routes[] = ['GET|POST', '/admin/products/gift-card-form/[i:id]?/[i:copy]?', 'GoCart\Controller\AdminProducts#giftCardForm'];
$routes[] = ['GET|POST', '/admin/products/delete/[i:id]', 'GoCart\Controller\AdminProducts#delete'];
$routes[] = ['GET|POST', '/admin/products/[i:rows]?/[:order_by]?/[:sort_order]?/[:code]?/[i:page]?', 'GoCart\Controller\AdminProducts#index'];
$routes[] = ['GET|POST', '/product/[:slug]', 'GoCart\Controller\Product#index'];

$routes[] = ['GET|POST', '/product/list_review/[i:id]', 'GoCart\Controller\Product#list_review'];

// Image Manager
$routes[] = ['GET|POST', '/admin/media_manager/adminMedia/index', 'GoCart\Controller\AdminMedia#index'];
