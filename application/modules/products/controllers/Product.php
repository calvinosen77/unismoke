<?php namespace GoCart\Controller;
/**
 * Product Class
 *
 * @package     GoCart
 * @subpackage  Controllers
 * @category    Product
 * @author      Clear Sky Designs
 * @link        http://gocartdv.com
 */

class Product extends Front {

    public function index($slug) {

        if(\CI::input()->post('product_id')) {

            $save['product_id'] = \CI::input()->post('product_id');
            $save['customer_id'] = \CI::session()->userdata('customer')->id;
            $save['author'] = (\CI::session()->userdata('customer')->screen_name) ? \CI::session()->userdata('customer')->screen_name : '';
            $save['headline'] = \CI::input()->post('review_headline');
            $save['body'] = \CI::input()->post('review_text');
            $save['rating'] = \CI::input()->post('review_score');

            \CI::Products()->saveNewReview($save);
        }

        $product = \CI::Products()->slug($slug);

        if(!$product)
        {
            throw_404();
        }
        else
        {

            //set product options
            $data['options'] = \CI::ProductOptions()->getProductOptions($product->id);

            $data['posted_options'] = \CI::session()->flashdata('option_values');

            //get related items
            $data['related'] = $product->related_products;

            //get swatches items
            $data['swatches'] = $product->related_swatches;
            $data['reviews_data'] = $product->reviews_data;

            //get accessory products
            $data['accessory'] = \CI::Products()->getAccessoryProducts($product->id);
            //create view variable
            $data['page_title'] = $product->name;
            $data['meta'] = $product->meta;
            $data['seo_title'] = (!empty($product->seo_title))?$product->seo_title:$product->name;
            $data['product'] = $product;

            //load the view
            $this->view('product', $data);
        }
    }

    //list review
    public function list_review()
    {
        $type = trim(\CI::input()->post('type'));
        $product_id = \CI::input()->post('product_id');
        $results = \CI::Products()->list_review($type, $product_id);
        echo json_encode($results);
    }


}

