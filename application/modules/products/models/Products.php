<?php
/**
 * Products Class
 *
 * @package     GoCart
 * @subpackage  Models
 * @category    Products
 * @author      Clear Sky Designs
 * @link        http://gocartdv.com
 */

Class Products extends CI_Model
{
    public function __construct()
    {
        $this->customer = \CI::Login()->customer();
    }

    public function getProduct($id)
    {
        //do this again right here since it can be used for combining the cart. We want to make sure it's fresh.
        $this->customer = \GC::getCustomer();

        //find the product
        $product = CI::db()->select('*, saleprice_'.$this->customer->group_id.' as saleprice, price_'.$this->customer->group_id.' as price')->where('id', $id)->where('enabled_'.$this->customer->group_id, '1')->get('products')->row();
        $product = $this->processImageDecoding($product);
        return $product;
    }

    public function product_autocomplete($name, $limit)
    {
        return  CI::db()->like('name', $name)->get('products', $limit)->result();
    }

    public function touchInventory($id, $quantity)
    {
        $product = $this->getProduct($id);
        if(!$product)
        {
            return false;
        }

        CI::db()->where('id', $id)->update('products', ['quantity' => ($product->quantity - $quantity)]);
    }

    public function products($data=[], $return_count=false)
    {
        if(empty($data))
        {
            //if nothing is provided return the whole shabang
            CI::db()->order_by('name', 'ASC');
            $result = CI::db()->get('products');

            return $result->result();
        }
        else
        {
            //grab the limit
            if(!empty($data['rows']))
            {
                CI::db()->limit($data['rows']);
            }

            //grab the page
            if(!empty($data['page']))
            {
                CI::db()->offset($data['page']);
            }

            //do we order by something other than category_id?
            if(!empty($data['order_by']))
            {
                //if we have an order_by then we must have a direction otherwise KABOOM
                CI::db()->order_by($data['order_by'], $data['sort_order']);
            }

            //do we have a search submitted?
            if(!empty($data['term']))
            {
                $search = json_decode($data['term']);
                //if we are searching dig through some basic fields
                if(!empty($search->term))
                {
                    CI::db()->like('name', $search->term);
                    CI::db()->or_like('description', $search->term);
                    CI::db()->or_like('excerpt', $search->term);
                    CI::db()->or_like('sku', $search->term);
                }

                if(!empty($search->category_id))
                {
                    //lets do some joins to get the proper category products
                    CI::db()->join('category_products', 'category_products.product_id=products.id', 'right');
                    CI::db()->where('category_products.category_id', $search->category_id);
                    CI::db()->order_by('sequence', 'ASC');
                }
            }

            if($return_count)
            {
                return CI::db()->count_all_results('products');
            }
            else
            {
                return CI::db()->get('products')->result();
            }

        }
    }

    public function getProducts($category_id = false, $limit = false, $offset = false, $by=false, $sort=false)
    {
        //if we are provided a category_id, then get products according to category
        if ($category_id)
        {
            CI::db()->select('category_products.*, products.*, saleprice_'.$this->customer->group_id.' as saleprice, price_'.$this->customer->group_id.' as price, LEAST(IFNULL(NULLIF(saleprice_'.$this->customer->group_id.', 0), price_'.$this->customer->group_id.'), price_'.$this->customer->group_id.') as sort_price', false)->from('category_products')->join('products', 'category_products.product_id=products.id')->where(array('category_id'=>$category_id, 'enabled_'.$this->customer->group_id=>1));

            CI::db()->order_by($by, $sort);

            $result = CI::db()->limit($limit)->offset($offset)->get()->result();

            $products = [];

            foreach($result as $product)
            {
                $products[] = $this->processImageDecoding($product);
            }
            return $products;
        }
        else
        {
            //sort by alphabetically by default
            return CI::db()->order_by('name', 'ASC')->get('products')->result();
        }
    }

    public function count_all_products()
    {
        return CI::db()->count_all_results('products');
    }

    public function count_products($id)
    {
        return CI::db()->select('product_id')->from('category_products')->join('products', 'category_products.product_id=products.id')->where(array('category_id'=>$id, 'enabled_'.$this->customer->group_id=>1))->count_all_results();
    }

    public function slug($slug, $related=true)
    {
        $result = CI::db()->select('*, saleprice_'.$this->customer->group_id.' as saleprice, price_'.$this->customer->group_id.' as price')->get_where('products', array('slug'=>$slug, 'enabled_'.$this->customer->group_id=>1))->row();
        //get images
        $result->images = json_decode($result->images, true);
        if($result->images)
        {
            $result->images = array_values($result->images);
        }
        else
        {
            $result->images = [];
        }
        //get primary_image ID & origin names & extentions
        $primary_image_id = 0;
        for($i=0;$i<count($result->images);$i++) {
            if(isset($result->images[$i]['color']) && isset($result->images[$i]['color']['primary_image'])){
                $primary_image_id = $i;
            }
            $arrayImagename = explode('100x', $result->images[$i]['filename']);
            $arrayExtentions = explode('100x100', $result->images[$i]['filename']);
            $arrayOriginname = explode('uploads/images/100_100/', $arrayImagename[0]);
            $origin_names[$i] = $arrayOriginname[1];
            $origin_extentions[$i] = $arrayExtentions[1];
        }
        if(count($result->images) == 0){
            $origin_names[0] = 'no-image_';
            $origin_extentions[0] = '.gif';
        }
        $result->primary_image_id = $primary_image_id;
        $result->origin_names = $origin_names;
        $result->origin_extentions = $origin_extentions;
        //get primary category name
        $categoryItem = CI::db()->get_where('categories', array('id'=>$result->primary_category))->result();
        $result->primary_category_name = $categoryItem[0]->name;

        //get manufacturer name
        $manufacturerItem = CI::db()->get_where('manufacturer', array('id'=>$result->manufacturer))->result();
        $result->manufacturer_name = $manufacturerItem[0]->manufacturer;
        //get reviews data
        $sql = 'SELECT * FROM uni_product_review_customer prc LEFT JOIN uni_customers c ON prc.customer_id=c.id LEFT JOIN uni_customers_address_bank cab ON prc.customer_id=cab.customer_id WHERE prc.status=1 AND prc.product_id=' . $result->id;
        $result->reviews_data   = CI::db()->query($sql)->result();
        $rows = count($result->reviews_data);
        $total_score = 0;
        if($rows > 0){
            for($i=0;$i<$rows;$i++){
                $total_score += $result->reviews_data[$i]->rating;
            }
            $result->avg_review_score = number_format($total_score / $rows, 1);
        }else{
            $result->avg_review_score = 0;
        }
        $result->review_count = $rows;
        $review_status   = CI::db()->get_where('product_review_customer', array('product_id'=>$result->id, 'customer_id'=>CI::session()->userdata('customer')->id))->result();
        $result->review_item   = (count($review_status)>0)? $review_status[0]: [];
        $result->review_status   = (count($review_status)>0)? 0 : 1;
        // -- end

        if(!$result)
        {
            return false;
        }

        $swatches = json_decode($result->related_swatches);
        //get swatches data
        $where = [];
        $where[] = 'p.id = ' . $result->id;
        if(!empty($swatches)) {
            foreach ($swatches as $s) {
                $where[] = 'p.id = ' . $s;
            }
        }
        $sql = 'SELECT p.*, p.id AS pid, p.saleprice_1 AS saleprice, p.price_1 AS price, m.manufacturer as manufacture FROM uni_products p LEFT JOIN  uni_manufacturer m ON p.manufacturer=m.id WHERE (' . implode(' OR ', $where) . ') AND p.enabled_1=1';
        $result->related_swatches = CI::db()->query($sql)->result();
        $arraySwatches = $result->related_swatches;
        //get swatches primary_image ID & swatches origin names & swatches extentions & color
        $swatches_images = array();
        for ($i = 0; $i < count($arraySwatches); $i++) {
            $array_swatches_images = json_decode($arraySwatches[$i]->images, true);
            if ($array_swatches_images) {
                $array_swatches_images = array_values($array_swatches_images);
            } else {
                $array_swatches_images = [];
            }
            $swatches_images_item = array();

            $primary_image_id = 0;
            $swatches_color = '';
            for ($k = 0; $k < count($array_swatches_images); $k++) {
                if (isset($array_swatches_images[$k]['color']) && isset($array_swatches_images[$k]['color']['primary_image'])) {
                    $primary_image_id = $k;
                    $swatches_color = $array_swatches_images[$k]['color']['color_name'];
                }
                if($array_swatches_images) {
                    $arrayImagename = explode('100x', $array_swatches_images[$k]['filename']);
                    $arrayExtentions = explode('100x100', $array_swatches_images[$k]['filename']);
                    $arrayOriginname = explode('uploads/images/100_100/', $arrayImagename[0]);
                    $origin_names[$k] = $arrayOriginname[1];
                    $origin_extentions[$k] = $arrayExtentions[1];
                }else{
                    $origin_names[$k] = '';
                    $origin_extentions[$k] = '';
                }
            }
            $swatches_images_item['color'] = $swatches_color;
            $swatches_images_item['rows'] = count($array_swatches_images);
            $swatches_images_item['primary_image_id'] = $primary_image_id;
            $swatches_images_item['origin_names'] = $origin_names;
            $swatches_images_item['origin_extentions'] = $origin_extentions;

            $swatches_images[$i] = $swatches_images_item;
        }
        $result->swatches_images = $swatches_images;

        $related = json_decode($result->related_products);
        //get related product data
        if(!empty($related))
        {
            //build the where
            $where = [];
            foreach($related as $r)
            {
                $where[] = 'p.id = '.$r;
            }
/*
            CI::db()->select('*, saleprice_'.$this->customer->group_id.' as saleprice, price_'.$this->customer->group_id.' as price');
            CI::db()->where('('.implode(' OR ', $where).')', null);
            CI::db()->where('enabled_'.$this->customer->group_id, 1);
*/
            $sql = 'SELECT p.*, p.id AS pid, p.saleprice_1 AS saleprice, p.price_1 AS price, m.manufacturer as manufacture FROM uni_products p LEFT JOIN  uni_manufacturer m ON p.manufacturer=m.id WHERE (' . implode(' OR ', $where).') AND p.enabled_1=1';
            $result->related_products   = CI::db()->query($sql)->result();

            //get related product reviews data
            $related_product_rows = count($result->related_products);
            for($k=0;$k<$related_product_rows;$k++) {
                $sql = 'SELECT * FROM uni_product_review_customer prc LEFT JOIN uni_customers c ON prc.customer_id=c.id LEFT JOIN uni_customers_address_bank cab ON prc.customer_id=cab.customer_id WHERE prc.status=1 AND prc.product_id=' . $result->related_products[$k]->pid;
                $related_product_reviews_data = CI::db()->query($sql)->result();
                $related_review_rows[$k] = count($related_product_reviews_data);
                $total_score = 0;
                if ($related_review_rows[$k] > 0) {
                    for ($i = 0; $i < $related_review_rows[$k]; $i++) {
                        $total_score += $related_product_reviews_data[$i]->rating;
                    }
                    $related_avg_review_score[$k] = number_format($total_score / $related_review_rows[$k], 1);
                }else{
                    $related_avg_review_score[$k] = 0;
                }
            }
            $result->related_review_rows = $related_review_rows;
            $result->related_avg_review_score = $related_avg_review_score;

            //get related product image name and extention
            $related_images = array();
            for ($i = 0; $i < count($result->related_products); $i++) {
                $array_related_images = json_decode($result->related_products[$i]->images, true);
                if ($array_related_images) {
                    $array_related_images = array_values($array_related_images);
                } else {
                    $array_related_images = [];
                }
                $related_images_item = array();

                $primary_image_id = 0;
                for ($k = 0; $k < count($array_related_images); $k++) {
                    if (isset($array_related_images[$k]['color']) && isset($array_related_images[$k]['color']['primary_image'])) {
                        $primary_image_id = $k;
                    }
                }
                if($array_related_images) {
                    $arrayImagename = explode('100x', $array_related_images[$primary_image_id]['filename']);
                    $arrayExtentions = explode('100x100', $array_related_images[$primary_image_id]['filename']);
                    $arrayOriginname = explode('uploads/images/100_100/', $arrayImagename[0]);
                    $origin_names = $arrayOriginname[1];
                    $origin_extention = $arrayExtentions[1];
                }else{
                    $origin_names = '';
                    $origin_extention = '';
                }
                $related_images_item['origin_name'] = $origin_names;
                $related_images_item['origin_extention'] = $origin_extention;
                $related_images[$i] = $related_images_item;
            }
            $result->related_images = $related_images;
        }
        else
        {
            $result->related_products   = [];
            $result->related_review_rows   = [];
            $result->related_avg_review_score   = [];
        }
        $result->categories = $this->getProductCategories($result->id);

        return $result;
    }

    public function find($id, $related=true)
    {
        $result = CI::db()->get_where('products', array('id'=>$id))->row();
        if(!$result)
        {
            return false;
        }

        if($related)
        {
            $relatedItems = json_decode($result->related_products);
            if(!empty($relatedItems))
            {
                //build the where
                $where = [];
                foreach($relatedItems as $r)
                {
                    $where[] = '`id` = '.$r;
                }

                CI::db()->where('('.implode(' OR ', $where).')', null);
                CI::db()->where('enabled_'.$this->customer->group_id, 1);

                $result->related_products   = CI::db()->get('products')->result();
            }
            else
            {
                $result->related_products   = [];
            }
            //get swatches data
            $swatchesItems = json_decode($result->related_swatches);
            if(!empty($swatchesItems))
            {
                //build the where
                $where = [];
                foreach($swatchesItems as $swatches)
                {
                    $where[] = '`id` = '.$swatches;
                }

                CI::db()->where('('.implode(' OR ', $where).')', null);
                CI::db()->where('enabled_'.$this->customer->group_id, 1);

                $result->related_swatches   = CI::db()->get('products')->result();
            }
            else
            {
                $result->related_swatches   = [];
            }
            //get manufacturer data
            $result->manufacturer_data   = CI::db()->get('manufacturer')->result();
            // -- end

            //get accessory product data
            $accessory_data = CI::db()->get_where('products_accessories', array('product_id'=>$id))->result();
            $accessoryItems = [];
            for($i=0;$i<count($accessory_data);$i++){
                $accessoryItems[$i] = $accessory_data[$i]->product_accessory_id;
            }
            if(!empty($accessoryItems))
            {
                //build the where
                $where = [];
                foreach($accessoryItems as $r)
                {
                    $where[] = '`id` = '.$r;
                }

                CI::db()->where('('.implode(' OR ', $where).')', null);
                CI::db()->where('enabled_'.$this->customer->group_id, 1);

                $result->accessory_products   = CI::db()->get('products')->result();
            }
            else
            {
                $result->accessory_products   = [];
            }
            //--end
        }

        $result->categories = $this->getProductCategories($result->id);

        return $result;
    }

    // get accessory products
    public function getAccessoryProducts($id)
    {
        //get accessory product data
        $accessory_data = CI::db()->get_where('products_accessories', array('product_id'=>$id))->result();
        $accessoryItems = [];
        for($i=0;$i<count($accessory_data);$i++){
            $accessoryItems[$i] = $accessory_data[$i]->product_accessory_id;
        }
        if(!empty($accessoryItems))
        {
            //build the where
            $where = [];
            foreach($accessoryItems as $r)
            {
                $where[] = '`id` = '.$r;
            }

            CI::db()->where('('.implode(' OR ', $where).')', null);
            CI::db()->where('enabled_'.$this->customer->group_id, 1);

            $accessory_products   = CI::db()->get('products')->result();
        }
        else
        {
            $accessory_products   = [];
        }
        //--end

        return $accessory_products;
    }

    public function getProductCategories($id)
    {
        return CI::db()->where('product_id', $id)->join('categories', 'category_id = categories.id')->get('category_products')->result();
    }

    public function save($product, $options=false, $categories=false, $product_accessory=false)
    {
        if ($product['id'])
        {
            CI::db()->where('id', $product['id']);
            CI::db()->update('products', $product);

            //save product accessory data
            CI::db()->where('product_id', $product['id'])->delete('products_accessories');

            foreach($product_accessory['accessory_products'] as $accessory_id) {

                $product_data = CI::db()->where('id', $accessory_id)->get('products')->result();

                $accessory_data['product_id'] = $product['id'];
                $accessory_data['product_accessory_id'] = $product_data[0]->id;
                $accessory_data['product_accessory_category_id'] = $product_data[0]->primary_category;

                CI::db()->insert('products_accessories', $accessory_data);
            }
            //--end
            $id = $product['id'];
        }
        else
        {
            CI::db()->insert('products', $product);
            $id = CI::db()->insert_id();
            //save product accessory data
            foreach($product_accessory['accessory_products'] as $accessory_id) {

                $product_data = CI::db()->where('id', $accessory_id)->get('products')->result();

                $accessory_data['product_id'] = $id;
                $accessory_data['product_accessory_id'] = $product_data[0]->id;
                $accessory_data['product_accessory_category_id'] = $product_data[0]->primary_category;

                CI::db()->insert('products_accessories', $accessory_data);
            }
            //--end
        }

        //loop through the product options and add them to the db
        if($options !== false)
        {

            // wipe the slate
            CI::ProductOptions()->clearOptions($id);

            // save edited values
            $count = 1;
            foreach ($options as $option)
            {
                $values = $option['values'];
                unset($option['values']);
                $option['product_id'] = $id;
                $option['sequence'] = $count;

                CI::ProductOptions()->saveOption($option, $values);
                $count++;
            }
        }

        if($categories !== false)
        {
            if($product['id'])
            {
                //get all the categories that the product is in
                $cats   = $this->getProductCategories($id);

                //generate cat_id array
                $ids    = [];
                foreach($cats as $c)
                {
                    $ids[]  = $c->id;
                }

                //eliminate categories that products are no longer in
                foreach($ids as $c)
                {
                    if(!in_array($c, $categories))
                    {
                        CI::db()->delete('category_products', array('product_id'=>$id,'category_id'=>$c));
                    }
                }

                //add products to new categories
                foreach($categories as $c)
                {
                    if(!in_array($c, $ids))
                    {
                        CI::db()->insert('category_products', array('product_id'=>$id,'category_id'=>$c));
                    }
                }
            }
            else
            {
                //new product add them all
                foreach($categories as $c)
                {
                    CI::db()->insert('category_products', array('product_id'=>$id,'category_id'=>$c));
                }
            }
        }

        //return the product id
        return $id;
    }

    public function delete_product($id)
    {
        // delete product
        CI::db()->where('id', $id);
        CI::db()->delete('products');

        // delete product accessories
        CI::db()->where('product_id', $id)->delete('products_accessories');
        CI::db()->where('product_accessory_id', $id)->delete('products_accessories');

        //delete references in the product to category table
        CI::db()->where('product_id', $id);
        CI::db()->delete('category_products');

        // delete coupon reference
        CI::db()->where('product_id', $id);
        CI::db()->delete('coupons_products');
    }

    public function search_products($term, $limit=false, $offset=false, $by=false, $sort=false)
    {
        $results = [];

        CI::db()->select('*, LEAST(IFNULL(NULLIF(saleprice_'.$this->customer->group_id.', 0), price_'.$this->customer->group_id.'), price_'.$this->customer->group_id.') as sort_price', false);
        //this one counts the total number for our pagination
        CI::db()->where('enabled_'.$this->customer->group_id, 1);
        CI::db()->where('(name LIKE "%'.CI::db()->escape_like_str($term).'%" OR description LIKE "%'.CI::db()->escape_like_str($term).'%" OR excerpt LIKE "%'.CI::db()->escape_like_str($term).'%" OR sku LIKE "%'.CI::db()->escape_like_str($term).'%")');
        $results['count'] = CI::db()->count_all_results('products');


        CI::db()->select('*, saleprice_'.$this->customer->group_id.' as saleprice, price_'.$this->customer->group_id.' as price, LEAST(IFNULL(NULLIF(saleprice_'.$this->customer->group_id.', 0), price_'.$this->customer->group_id.'), price_'.$this->customer->group_id.') as sort_price', false);
        //this one gets just the ones we need.
        CI::db()->where('enabled_'.$this->customer->group_id, 1);
        CI::db()->where('(name LIKE "%'.CI::db()->escape_like_str($term).'%" OR description LIKE "%'.CI::db()->escape_like_str($term).'%" OR excerpt LIKE "%'.CI::db()->escape_like_str($term).'%" OR sku LIKE "%'.CI::db()->escape_like_str($term).'%")');

        if($by && $sort)
        {
            CI::db()->order_by($by, $sort);
        }
        $products = CI::db()->get('products', $limit, $offset)->result();
        $results['products'] = [];
        foreach($products as $product)
        {
            $results['products'][] = $this->processImageDecoding($product);
        }

        return $results;
    }

    public function processImageDecoding($product)
    {
        if($product)
        {
            $product->images = json_decode($product->images, true);
            if($product->images)
            {
                $product->images = array_values($product->images);
            }
            else
            {
                $product->images = [];
            }
            return $product;
        }
        else
        {
            return $product;
        }
        
    }

    public function validate_slug($slug, $id=false, $counter=false)
    {
        CI::db()->select('slug');
        CI::db()->from('products');
        CI::db()->where('slug', $slug.$counter);
        if ($id)
        {
            CI::db()->where('id !=', $id);
        }
        $count = CI::db()->count_all_results();

        if ($count > 0)
        {
            if(!$counter)
            {
                $counter = 1;
            }
            else
            {
                $counter++;
            }
            return $this->validate_slug($slug, $id, $counter);
        }
        else
        {
             return $slug.$counter;
        }
    }

    function saveNewReview($save){
        $checkItem = CI::db()->get_where('product_review_customer', array('product_id'=>$save['product_id'], 'customer_id'=>$save['customer_id']))->result();
        if(count($checkItem) == 0) CI::db()->insert('product_review_customer', $save);
    }

    function getProductReviews($id){
        $sql = 'SELECT prc.*, c.firstname, c.lastname, c.email, c.screen_name FROM uni_product_review_customer prc LEFT JOIN uni_customers c ON prc.customer_id=c.id WHERE prc.product_id=' . $id;
        $reviews_data   = CI::db()->query($sql)->result();

        return $reviews_data;
    }

    public function approve_review($id, $status)
    {
        CI::db()->where('id', $id)->update('product_review_customer', ['status' => $status]);
        return $status;
    }

    public function delete_review($id)
    {
        return CI::db()->where('id', $id)->delete('product_review_customer');
    }

    public function list_review($type, $product_id)
    {
        switch ($type)
        {
            case 'newest':
                $add_query = ' ORDER BY prc.created DESC';
                break;
            case 'helpful':
                $add_query = ' ';
                break;
            case 'highest':
                $add_query = ' ORDER BY prc.rating DESC';
                break;
            case 'lowest':
                $add_query = ' ORDER BY prc.rating ASC';
                break;
        }
        $sql = 'SELECT * FROM uni_product_review_customer prc LEFT JOIN uni_customers c ON prc.customer_id=c.id LEFT JOIN uni_customers_address_bank cab ON prc.customer_id=cab.customer_id WHERE prc.status=1 AND prc.product_id=' . $product_id . $add_query;

        $result = CI::db()->query($sql)->result();

        return $result;
    }

}
