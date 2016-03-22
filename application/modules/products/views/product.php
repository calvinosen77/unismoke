<main>
    <div class="container-fluid">
        <div class="wrapper">
            <div class="product-descr row clearfix">
                <div class="col-sm-6 col-sm-offset-1">
                    <div class="row slider-wrap">
                        <div class="col-sm-12">
                            <div class="mob-heading">
                                <h1><?php echo $product->name;?> <small>by <?php echo $product->manufacturer_name; ?></small></h1>
                                <div class="rating">
                                <?php if($product->review_count > 0){ ?>
                                    <input value="<?php echo $product->avg_review_score; ?>" type="number" class="rating" data-glyphicon="false" min=0 max=5 step=0.1 data-size="xs" data-star-captions="{}" data-default-caption="" data-readonly="true" data-rating-class="rating-fa">
                                    <p><?php echo $product->review_count; ?> customer reviews</p>
                                <?php }else{ ?>
                                    <?php if($product->review_status){ ?>
                                        <?php if(CI::session()->userdata('customer')->email){ ?>
                                            <a href="javascript:;" class="empty_review_title_bottom open-review-form">BE THE FIRST TO REVIEW THIS ITEM</a>
                                        <?php }else{ ?>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>
                                </div>
                            </div>
                            <?php for($i=0;$i<count($product->swatches_images);$i++){ ?>
                                <?php $primary_id = $product->swatches_images[$i]['primary_image_id']; ?>
                                <div class="img-zoom-container main_common main_img<?php echo $product->related_swatches[$i]->id;?>" style="display: <?php echo ($i==0)? 'block' : 'none';?>">
                                    <input type="hidden" value="<?php echo base_url('uploads/images/full_full/' . $product->swatches_images[$i]['origin_names'][$primary_id] . 'fullxfull' . $product->swatches_images[$i]['origin_extentions'][$primary_id]);?>" id="init_img<?php echo $product->related_swatches[$i]->id;?>">
                                    <img id="main_img_url<?php echo $product->related_swatches[$i]->id;?>" src="<?php echo base_url('uploads/images/full_full/' . $product->swatches_images[$i]['origin_names'][$primary_id] . 'fullxfull' . $product->swatches_images[$i]['origin_extentions'][$primary_id]);?>" alt="" class="img-container" data-large="<?php echo base_url('uploads/images/full_full/' . $product->swatches_images[$i]['origin_names'][$primary_id] . 'fullxfull' . $product->swatches_images[$i]['origin_extentions'][$primary_id]);?>"/>
                                </div>
                            <?php } ?>
                        </div>

                        <?php for($i=0;$i<count($product->swatches_images);$i++){ ?>
                        <div id="product-pager" class="side_common side_img<?php echo $product->related_swatches[$i]->id;?>" style="display: <?php echo ($i==0)? 'block' : 'none';?>">
                            <?php for($k=0;$k<$product->swatches_images[$i]['rows'];$k++){ ?>
                                <a data-slide-index="<?php echo $k;?>" class="<?php echo ($k==0)? 'active' : ''; ?>" href="" data-default="<?php echo base_url('uploads/images/full_full/' . $product->swatches_images[$i]['origin_names'][$k] . 'fullxfull' . $product->swatches_images[$i]['origin_extentions'][$k]);?>" data-large="<?php echo base_url('uploads/images/full_full/' . $product->swatches_images[$i]['origin_names'][$k] . 'fullxfull' . $product->swatches_images[$i]['origin_extentions'][$k]);?>"><span><?php echo $i;?></span><img src="<?php echo base_url('uploads/images/70_70/' . $product->swatches_images[$i]['origin_names'][$k] . '70x70' . $product->swatches_images[$i]['origin_extentions'][$k]);?>" /></a>
                            <?php } ?>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="row">
                        <div class="social-box col-sm-offset-1 col-sm-11">
                            <ul>
                                <li><a href="" class="icon-twitter"><span class="sr-only">Twitter</span></a></li>
                                <li><a href="" class="icon-facebook"><span class="sr-only">Facebook</span></a></li>
                                <li><a href="" class="icon-instagram"><span class="sr-only">Instagram</span></a></li>
                                <li><a href="" class="icon-pinterest"><span class="sr-only">Pinterest</span></a></li>
                            </ul>
                            <button class="btn transparent add-to-wish icon-heart-empty">Add to Wish List</button>
                        </div>
                    </div>
                </div>
                <div class="col-sm-5 product-info">
                    <div class="product-info-box">
                        <h1><?php echo $product->name;?> <small>by <?php echo $product->manufacturer_name; ?></small></h1>
                        <div class="rating">
                        <?php if($product->review_count > 0){ ?>
                            <input value="<?php echo $product->avg_review_score; ?>" type="number" class="rating" data-glyphicon="false" min=0 max=5 step=0.1 data-size="xs" data-star-captions="{}" data-default-caption="" data-readonly="true" data-rating-class="rating-fa">
                            <p><?php echo $product->review_count; ?> customer reviews</p>
                        <?php }else{ ?>
                            <?php if($product->review_status){ ?>
                                <?php if(CI::session()->userdata('customer')->email){ ?>
                                    <a href="javascript:;" class="empty_review_title_bottom open-review-form">BE THE FIRST TO REVIEW THIS ITEM</a>
                                <?php }else{ ?>
                                    <a href="javascript:;" class="empty_review_title_bottom">BE THE FIRST TO REVIEW THIS ITEM</a>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                        </div>
                        <div class="cost-descr">
                            <p class="good-cost">Price: <span class="old-price">$<?php echo $product->price_1; ?></span></p>
                            <p class="sale">Sale Price: <mark>$<?php echo $product->saleprice_1; ?></mark></p>
                            <p class="save">You Save: <mark>$<?php echo number_format($product->price_1 - $product->saleprice_1, 2); ?> (<?php echo number_format(($product->price_1 - $product->saleprice_1) * 100 / $product->price_1, 2); ?>%)</mark></p>
                        </div>
                        <?php if($product->quantity > 2){ ?>
                            <p class="stock available">In Stock</p>
                        <?php }else{ ?>
                            <p class="stock">Only <?php echo $product->quantity;?> left in stock - order soon</p>
                        <?php } ?>

                        <form action="" class="form-inline clearfix" data-parsley-validate>

                        <!-- VAPOR Category -->
                        <?php if($product->primary_category == 6/*VAPOR Category ID*/){ ?>
                            <?php
                                $tank_accessory = [];
                                $battery_accessory = [];
                                $charger_accessory = [];

                                foreach($accessory as $item){
                                    $item->images = json_decode($item->images, true);
                                    if($item->primary_category == 13/*tank category id*/) $tank_accessory[count($tank_accessory)] = $item;
                                    if($item->primary_category == 14/*battery category id*/) $battery_accessory[count($battery_accessory)] = $item;
                                    if($item->primary_category == 15/*charger category id*/) $charger_accessory[count($charger_accessory)] = $item;
                                }
                            ?>
                            <!-- Color -->
                            <div class="field-row form-group color">
                                <p>Color: <span class="ch-color"><?php echo $product->swatches_images[0]['color']; ?></span></p>
                                <?php for($i=0;$i<count($product->swatches_images);$i++){ ?>
                                    <?php $primary_id = $product->swatches_images[$i]['primary_image_id']; ?>
                                    <div class="color-wrap">
                                        <input type="radio" name="color" id="<?php echo $product->swatches_images[$i]['color']; ?>" value="<?php echo $product->related_swatches[$i]->id;?>" <?php echo($i==0)? 'checked' : ''; ?>/>
                                        <label for="<?php echo $product->swatches_images[$i]['color']; ?>"><img class="swatches_img" id="<?php echo $product->swatches_images[$i]['color']; ?>" value="<?php echo $product->related_swatches[$i]->id;?>" src="<?php echo base_url('uploads/images/78_78/' . $product->swatches_images[$i]['origin_names'][$primary_id] . '78x78' .  $product->swatches_images[$i]['origin_extentions'][$primary_id]);?>" alt=""/></label>
                                    </div>
                                <?php } ?>
                            </div>

                            <div class="upgrade">
                                <p class="open"><span class="tooltipster" title="Lorem ipsum">?</span>Upgrade Your Vapor</p>
                                <!-- Tank -->
                                <div class="hidden-block" style="display: block">
                                    <div class="field-row form-group big-sel clearfix">
                                    <?php if(count($tank_accessory) > 0){ ?>
                                        <label class="sr-only" for="">Choose Your Tank</label>
                                        <div class="sel-box-choosen">
                                            <p>Choose Your Tank</p>
                                            <b></b>
                                        </div>
                                    <?php }else{ ?>
                                        <label class="sr-only" for="">There is no Tank</label>
                                        <div class="sel-box-choosen">
                                            <p>There is no Tank</p>
                                            <b></b>
                                        </div>
                                    <?php } ?>
                                        <?php if(count($tank_accessory) > 0){ ?>
                                        <div class="sel-box-result">
                                            <ul class="goods-list">
                                                <li class="default-value active">
                                                    <p>Choose Your Tank</p>
                                                </li>
                                                <?php foreach($tank_accessory as $tankItem){ ?>
                                                <li class="clearfix">
                                                    <div class="preview-wrap pull-left">
                                                        <?php if($tankItem->images){ ?>
                                                            <img src="<?php echo base_url(array_shift($tankItem->images)['filename']);?>" alt=""/>
                                                        <?php }else{ ?>
                                                            <img src="<?php echo base_url('uploads/images/100_100/no-image_100x100.gif');?>" alt=""/>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="review-goods">
                                                        <p class="good-name"><?php echo $tankItem->name; ?></p>
                                                        <div class="rating">
                                                            <input value="4" type="number" class="rating" data-glyphicon="false" min=0 max=5 step=1 data-size="xs" data-star-captions="{}" data-default-caption="" data-readonly="true" data-rating-class="rating-fa">
                                                            <p>12 Reviews</p>
                                                        </div>
                                                        <p class="good-cost">Price <b>$<?php echo number_format(($tankItem->saleprice_1)? $tankItem->saleprice_1 : $tankItem->price_1, 2);?></b></p>
                                                    </div>
                                                </li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <!-- Battery -->
                                    <div class="field-box">
                                        <div class="field-row form-group pull-left">
                                        <?php if(count($battery_accessory) > 0){ ?>
                                            <label class="sr-only" for="">Batteries</label>
                                            <div class="sel-box-choosen">
                                                <p>Batteries</p>
                                                <b></b>
                                            </div>
                                            <?php }else{ ?>
                                            <label class="sr-only" for="">There is no Batteries</label>
                                            <div class="sel-box-choosen">
                                                <p>There is no Batteries</p>
                                                <b></b>
                                            </div>
                                        <?php } ?>
                                            <?php if(count($battery_accessory) > 0){ ?>
                                            <div class="sel-box-result">
                                                <ul class="goods-list">
                                                    <li class="default-value active">
                                                        <p>Batteries</p>
                                                    </li>
                                                    <?php foreach($battery_accessory as $batteryItem){ ?>
                                                        <li class="clearfix">
                                                            <div class="preview-wrap pull-left">
                                                                <?php if($batteryItem->images){ ?>
                                                                    <img src="<?php echo base_url(array_shift($batteryItem->images)['filename']);?>" alt=""/>
                                                                <?php }else{ ?>
                                                                    <img src="<?php echo base_url('uploads/images/100_100/no-image_100x100.gif');?>" alt=""/>
                                                                <?php } ?>
                                                            </div>
                                                            <div class="review-goods">
                                                                <p class="good-name"><?php echo $batteryItem->name; ?></p>
                                                                <div class="rating">
                                                                    <input value="4" type="number" class="rating" data-glyphicon="false" min=0 max=5 step=1 data-size="xs" data-star-captions="{}" data-default-caption="" data-readonly="true" data-rating-class="rating-fa">
                                                                    <p>12 Reviews</p>
                                                                </div>
                                                                <p class="good-cost">Price <b>$<?php echo number_format(($batteryItem->saleprice_1)? $batteryItem->saleprice_1 : $batteryItem->price_1, 2);?></b></p>
                                                            </div>
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                            <?php } ?>
                                        </div>
                                <!-- Charger -->
                                        <div class="field-row form-group pull-right">
                                        <?php if(count($charger_accessory) > 0){ ?>
                                            <label class="sr-only" for="">Charger</label>
                                            <div class="sel-box-choosen">
                                                <p>Charger</p>
                                                <b></b>
                                            </div>
                                        <?php }else{ ?>
                                            <label class="sr-only" for="">There is no Charger</label>
                                            <div class="sel-box-choosen">
                                                <p>There is no Charger</p>
                                                <b></b>
                                            </div>
                                        <?php } ?>
                                            <?php if(count($charger_accessory) > 0){ ?>
                                            <div class="sel-box-result">
                                                <ul class="goods-list">
                                                    <li class="default-value active">
                                                        <p>Charger</p>
                                                    </li>
                                                    <?php foreach($charger_accessory as $chargerItem){ ?>
                                                        <li class="clearfix">
                                                            <div class="preview-wrap pull-left">
                                                                <?php if($chargerItem->images){ ?>
                                                                    <img src="<?php echo base_url(array_shift($chargerItem->images)['filename']);?>" alt=""/>
                                                                <?php }else{ ?>
                                                                    <img src="<?php echo base_url('uploads/images/100_100/no-image_100x100.gif');?>" alt=""/>
                                                                <?php } ?>
                                                            </div>
                                                            <div class="review-goods">
                                                                <p class="good-name"><?php echo $chargerItem->name; ?></p>
                                                                <div class="rating">
                                                                    <input value="4" type="number" class="rating" data-glyphicon="false" min=0 max=5 step=1 data-size="xs" data-star-captions="{}" data-default-caption="" data-readonly="true" data-rating-class="rating-fa">
                                                                    <p>12 Reviews</p>
                                                                </div>
                                                                <p class="good-cost">Price <b>$<?php echo number_format(($chargerItem->saleprice_1)? $chargerItem->saleprice_1 : $chargerItem->price_1, 2);?></b></p>
                                                            </div>
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <!-- // End VAPOR Category -->

                        <!-- E-LIQUID Category -->
                        <?php if($product->primary_category == 2/*E-LIQUID Category ID*/){ ?>
                            <div class="field-row form-group pull-left" id="nicotine">
                            <?php if(isset($options[0]->name)){ ?>
                                <label class="sr-only" for=""><?php echo $options[0]->name; ?></label>
                                <select name="" id="" data-placeholder="<?php echo $options[0]->name; ?>" required data-parsley-class-handler="#nicotine">
                                    <option value="" ><?php echo $options[0]->name; ?></option>
                                    <?php foreach($options[0]->values as $valueItem){ ?>
                                        <option value="<?php echo $valueItem->sequence; ?>" ><?php echo $valueItem->name; ?></option>
                                    <?php } ?>
                                </select>
                            <?php } ?>
                            </div>

                            <div class="field-row form-group pull-right" id="taste">
                            <?php if(isset($options[1]->name)){ ?>
                                <label class="sr-only" for=""><?php echo $options[1]->name; ?></label>
                                <select name="" id="" data-placeholder="<?php echo $options[1]->name; ?>" required data-parsley-class-handler="#taste">
                                    <option value=""  selected><?php echo $options[1]->name; ?></option>
                                    <?php foreach($options[1]->values as $valueItem){ ?>
                                      <option value="<?php echo $valueItem->sequence; ?>" ><?php echo $valueItem->name; ?></option>
                                    <?php } ?>
                                </select>
                            <?php } ?>
                            </div>
                        <?php } ?>
                        <!-- // End E-LIQUID Category -->

                            <div class="field-row form-group pull-left small-sel">
                                <label for="">Quantity</label>
                                <select name="" id="" class="pull-right">
                                    <?php for($i=1;$i<=$product->quantity;$i++){ ?>
                                        <option value="<?php echo $i; ?>" ><?php echo $i; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <button class="btn btn-default pull-right">ADD TO CART</button>
                        </form>
                    </div>
                    <div class="prod-add-info">
                        <p class="icon-shipping">Free Shipping On $49+ Orders</p>
                        <p class="icon-money-back"><mark>%100 Money Back Guarantee</mark></p>
                    </div>
                </div>
            </div>
            <div class="prod-detail">
                <h3>PRODUCT DETAILS</h3>
                <p><?php echo $product->description; ?></p>
                <p>Made in the Philippines</p>
                <p>Mechanical MOD</p>
                <ul>
                    <li class="icon-checked">Stainless Steel Construction</li>
                    <li class="icon-checked">510 Threaded</li>
                    <li class="icon-checked">Removable Tubes accommodate: 18650, 18500, 18350 and 2 x 18350 batteries</li>
                    <li class="icon-checked">Adjustable Floating Center Pin</li>
                    <li class="icon-checked">Adjustable Battery Contact</li>
                    <li class="icon-checked">Spring Loaded Button</li>
                    <li class="icon-checked">Soft Reverse Locking Mechanism</li>
                    <li class="icon-checked">Vent Holes</li>
                    <li class="icon-checked">Unique Serial Number engraved on base</li>
                    <li class="icon-checked">Gear and hazard Well</li>
                </ul>
            </div>
            <div class="dimensions">
                <h3>DIMENSIONS</h3>
                <p>18650: 4-1/8"L x 1"D</p>
                <p>18500: 3-1/2:L x 1"D</p>
                <p>18350: 2-15/16L" x 1"D</p>
                <div class="warning-info">
                    <p>Warning: Use special caution when working with Li-ion cells, they are very sensitive to charging characteristics and may explode or burn if mishandled. Make sure the user has enough knowledge of Li-Ion rechargeable batteries in charging, discharging and assembly before use. Always charge in/on a fire-proof surface. Never leave charging batteries unattended. We are not responsible for damage if there is any modification of the batteries/chargers in any form or shape (including pack making). We are not responsible for any damage caused by misuse or mishandling of Li-Ion batteries and chargers. We only recommend using Lithium Ion rechargeable batteries with a control circuit (protection PCB) to assure safe charge, discharge, etc, use of lithium ion batteries without a protection circuit is potentially hazardous</p>
                    <p>Unismoke will not be held responsible or liable for any injury, damage, or defect, permanent or temporary that may be caused by the improper use of a LI-ION battery. Please have a basic understanding of the batteries you are using and how to care for them properly.</p>
                </div>
            </div>
            <div class="like-goods">
                <h3>YOU MAY ALSO LIKE</h3>
                <div class="like-slider-wrap">
                    <div class="like-slider">
                        <?php $related_counter = 0; ?>
                        <?php foreach($related as $relatedItem){ ?>
                            <?php $relatedItem->images = json_decode($relatedItem->images, true); ?>
                            <div class="slide item-box">
                                <a href="<?php echo site_url('/product/' . $relatedItem->slug); ?>">
                                <div class="img-wrap">
                                    <?php if($product->related_images[$related_counter]['origin_name']){ ?>
                                    <img src="<?php echo base_url('uploads/images/175_175/' . $product->related_images[$related_counter]['origin_name'] . '175x175' . $product->related_images[$related_counter]['origin_extention']);?>" alt=""/>
                                <?php }else{ ?>
                                    <img src="<?php echo base_url('uploads/images/175_175/no-image_175x175.gif');?>" alt=""/>
                                <?php } ?>
                                </div>
                                <div class="good-descr">
                                    <p class="good-name"><?php echo $relatedItem->name; ?></p>
                                    <p class=""><mark>by <?php echo $relatedItem->manufacture; ?></mark></p>
                                    <p class="good-cost">Price <span>$<?php echo number_format($relatedItem->price_1, 2); ?></span></p>
                                    <div class="rating">
                                        <input value="<?php echo $product->related_avg_review_score[$related_counter]; ?>" type="number" class="rating" data-glyphicon="false" min=0 max=5 step=1 data-size="xs" data-star-captions="{}" data-default-caption="" data-readonly="true" data-rating-class="rating-fa">
                                        <?php if($product->related_review_rows[$related_counter] > 0){ ?>
                                            <p><?php echo $product->related_review_rows[$related_counter]; ?> Reviews</p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </a>
                        </div>
                            <?php $related_counter++; ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="review-box" style="text-align: center;">
                <div class="review-title">
                    <?php if($product->review_count > 0){ ?>
                        <div class="rating product-rating">
                            <input value="<?php echo $product->avg_review_score; ?>" type="number" class="rating" data-glyphicon="false" min=0 max=5 step=0.1 data-size="xs" data-star-captions="{}" data-default-caption="{rating}" data-readonly="true" data-rating-class="rating-fa">
                        </div>
                        <h2><mark><?php echo $product->review_count; ?></mark> REVIEWS</h2>
                        <p>100% OF REVIEWERS RECOMMEND THIS PRODUCT</p>
                        <?php if($product->review_status){ ?>
                            <?php if(CI::session()->userdata('customer')->email){ ?>
                                <button class="btn btn-default open-review-form">add your review</button>
                            <?php }else{ ?>
                                <button class="btn btn-default">add your review</button>
                            <?php } ?>
                        <?php }else{ ?>
                            <?php if($product->review_item->status){ ?>
                                <p class="title_review_approve">Thanks for reviewing this product.</p>
                            <?php }else{ ?>
                                <p class="title_review_pending1">Thanks for your review.</p>
                                <p class="title_review_pending2">We're currently processing your review and we will email you at <?php echo CI::session()->userdata('customer')->email;?> as soon as this is complete.</p>
                            <?php } ?>
                        <?php } ?>
                    <?php }else{ ?>
                        <?php if($product->review_status){ ?>
                            <?php if(CI::session()->userdata('customer')->email){ ?>
                                <button class="btn btn-default empty_review_title_bottom open-review-form" style="width: 300px;">BE THE FIRST TO REVIEW THIS ITEM</button>
                            <?php }else{ ?>
                                <button class="btn btn-default" style="width: 300px;">BE THE FIRST TO REVIEW THIS ITEM</button>
                            <?php } ?>
                        <?php }else{ ?>
                            <?php if($product->review_item->status){ ?>
                                <p class="title_review_approve">Thanks for reviewing this product.</p>
                            <?php }else{ ?>
                                <p class="title_review_pending1">Thanks for your review.</p>
                                <p class="title_review_pending2">We're currently processing your review and we will email you at <?php echo CI::session()->userdata('customer')->email;?> as soon as this is complete.</p>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                </div>
                <?php if($product->review_count > 0){ ?>
                    <div class="review-filter clearfix">
                        <p class="pull-left">REVIEWS</p>
                        <ul class="pull-right">
                            <li><a href="javascript:;" onclick="listReview('newest', '<?php echo $product->id; ?>');">Newest</a></li>
                            <li><a href="javascript:;" onclick="listReview('helpful', '<?php echo $product->id; ?>');">Most helpful</a></li>
                            <li><a href="javascript:;" onclick="listReview('highest', '<?php echo $product->id; ?>');">Highest rated</a></li>
                            <li><a href="javascript:;" onclick="listReview('lowest', '<?php echo $product->id; ?>');">Lowest rated</a></li>
                        </ul>
                    </div>
                <?php } ?>
                <script>
                    function listReview(type, product_id)
                    {
                        $.post("<?php echo site_url('/product/list_review/' . $product->id);?>", { product_id: product_id, type: type },
                            function(data) {
                                $('#review_content').empty();

                                var review_html = '';
                                var review_counter = 0;
                                data.forEach(function(reviewItem)
                                {
                                    var date = new Date(reviewItem['birthday']);
                                    var current_date = new Date();
                                    var created_date = new Date(reviewItem['created']);
                                    var age = current_date.getFullYear() - date.getFullYear();

                                    if(reviewItem['gender'] == 1) var gender = 'Male';
                                    else var gender = 'Female';
                                    review_counter++;
                                    if (review_counter > 3) {
                                        review_html += '<div class="hidden-review">';
                                    }
                                    review_html += '<div class="review clearfix">' +
                                    '     <div class="author pull-left">' +
                                    '         <div class="rating">' +
                                    '             <input value="' + reviewItem['rating'] + '" type="number" class="rating" data-glyphicon="false" min=0 max=5 step=0.1 data-size="xs" data-star-captions="{}" data-default-caption="{rating}" data-readonly="true" data-rating-class="rating-fa">' +
                                    '         </div>' +
                                    '         <p><span>Name</span>:  ' + reviewItem['screen_name'] + '</p>' +
                                    '         <p><span>Location</span>:  ' + reviewItem['city'] + ', ' + reviewItem['zone'] + '</p>' +
                                    '         <p><span>Age</span>:  '+ age + '</p>' +
                                    '         <p><span>Gender</span>:  ' + gender + '</p>' +
                                    '     </div>' +
                                    '     <div class="review-body pull-left">' +
                                    '         <div class="review-heading clearfix">' +
                                    '             <h3 class="pull-left">' + reviewItem['headline'] + ' - <time datetime="">' + ("0" + (created_date.getMonth() + 1)).slice(-2) + '/' + ("0" + created_date.getDate()).slice(-2) + '/' + created_date.getFullYear() + '</time></h3>' +
                                    '             <p class="pull-right">Do you recommend this product ? Yes</p>' +
                                    '         </div>' +
                                    '         <p>' + reviewItem['body'] + '</p>' +
                                    '         <div class="helpful">' +
                                    '             <p>Was this review helpful? <mark>( <a href="">Yes</a> | <a href="">No</a> )</mark></p>' +
                                    '         </div>' +
                                    '     </div>' +
                                    '</div>';
                                    if (review_counter > 3) {
                                        review_html += '</div>';
                                    }
                                });
                                $('#review_content').append(review_html);

                            }, 'json');
                    }


                </script>
                <div id="review_content">
                <?php if($product->review_count > 0){ ?>
                    <?php $review_counter = 0; ?>
                    <?php foreach($reviews_data as $reviewItem){ ?>
                        <?php $review_counter++; ?>
                        <?php if($review_counter > 3){ ?>
                            <div class="hidden-review">
                        <?php } ?>
                        <div class="review clearfix">
                            <div class="author pull-left">
                                <div class="rating">
                                    <input value="<?php echo number_format($reviewItem->rating, 1); ?>" type="number" class="rating" data-glyphicon="false" min=0 max=5 step=0.1 data-size="xs" data-star-captions="{}" data-default-caption="{rating}" data-readonly="true" data-rating-class="rating-fa">
                                </div>
                                <p><span>Name</span>:  <?php echo $reviewItem->screen_name; ?></p>
                                <p><span>Location</span>:  <?php echo $reviewItem->city; ?>, <?php echo $reviewItem->zone; ?></p>
                                <?php $age = date('Y') - date('Y', strtotime($reviewItem->birthday)); ?>
                                <p><span>Age</span>:  <?php echo $age; ?></p>
                                <p><span>Gender</span>:  <?php echo ($reviewItem->gender==1)? 'Male' : 'Female'; ?></p>
                            </div>
                            <div class="review-body pull-left">
                                <div class="review-heading clearfix">
                                    <h3 class="pull-left"><?php echo $reviewItem->headline; ?> - <time datetime=""><?php echo date("m/d/Y", strtotime($reviewItem->created)); ?></time></h3>
                                    <p class="pull-right">Do you recommend this product ? Yes</p>
                                </div>
                                <p><?php echo $reviewItem->body; ?></p>
                                <div class="helpful">
                                    <p>Was this review helpful? <mark>( <a href="">Yes</a> | <a href="">No</a> )</mark></p>
                                </div>
                            </div>
                        </div>
                        <?php if($review_counter > 3){ ?>
                            </div>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
                </div>
                <?php if($product->review_count > 3){ ?>
                    <div class="all-review-box">
                        <a href="">SEE ALL REVIEWS</a>
                    </div>
                <?php } ?>
            </div>
            <div class="subscribe-box clearfix">
                <p class="pull-left">subscribe <mark><strong>& get 15% off</strong></mark></p>
                <form class="form-inline pull-left" data-parsley-validate>
                    <div class="form-group">
                        <label class="fl_label" for="subscribe-name">First name</label>
                        <input type="text" class="form-control with-ph" id="subscribe-name" required>
                    </div>
                    <div class="form-group">
                        <label class="fl_label" for="subscribe-lastname">Last name</label>
                        <input type="text" class="form-control with-ph" id="subscribe-lastname" required>
                    </div>
                    <div class="form-group">
                        <label class="fl_label" for="subscribe-email">Email Address</label>
                        <input type="email" class="form-control with-ph" id="subscribe-email" required>
                    </div>
                    <button type="submit" class="btn btn-default">subscribe</button>
                </form>
            </div>
            <div class="info no-border">
                <h4>YOU MUST BE OF LEGAL SMOKING AGE TO BUY AND/OR USE ANY OF OUR PRODUCTS</h4>
                <p>WARNING:  Products are not for use by persons under legal smoking age. Keep out of reach of children and pets. If swallowed, this product can present a choking hazard. Nicotine is addictive and can be toxic if inhaled or ingested and may cause irritation if it comes into contact with your eyes or skin. Wash immediately with soap and water upon contact. Like other products with nicotine, you should not use this product if you are pregnant or breastfeeding, have or are at risk of heart disease, high blood pressure, diabetes, if you are taking medicines for depression or asthma or if you are allergic to nicotine, propylene glycol, or any combination of inhalants. Discontinue use and consult a physician if you experience symptoms of nicotine misuse such as nausea, vomiting, dizziness, diarrhea, weakness or rapid heartbeat. This product does not treat, diagnose or cure any disease, physical ailment or condition. This product is not marketed for use as a smoking cessation product and is not intended for use by non-smokers. This product and the statements made herein have not been evaluated by the FDA, or any other health or regulatory authority.</p>
                <p>WARNING: This product contains nicotine derived from tobacco. Nicotine is an addictive chemical.</p>
            </div>
            <div class="info">
                <h4>NOT FOR SALE TO MINORS | CALIFORNIA PROPOSITION 65</h4>
                <p>WARNING: This product contains nicotine, a chemical known to the state of California to cause birth defects or other reproductive harm.</p>
            </div>
        </div>
    </div>
</main>

<div class="overlay"></div>
<div class="modal fade" id="reviewModal" tabindex="-1" role="dialog" aria-labelledby="reviewModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <div class="modal-body clearfix">
                <p class="title">Write a review</p>
                <div class="product-img pull-left">
                    <img src="<?php echo base_url('uploads/images/full_full/' . $product->origin_names[$product->primary_image_id] . 'fullxfull' . $product->origin_extentions[$product->primary_image_id]);?>" alt=""/>
                </div>
                <div class="add-review-form pull-left">
                    <form action="<?php echo site_url('/product/' . $product->slug); ?>" method="post" class="clearfix" data-parsley-validate>
                        <input type="hidden" name="product_id" value="<?php echo $product->id;?>">
                        <p class="good-name"><?php echo $product->name;?></p>
                        <p class="">by <?php echo $product->manufacturer_name; ?></p>
                        <div class="rating product-rating">
                            <input name="review_score" value="1" type="number" class="rating" data-glyphicon="false" min=0 max=5 step=1 data-size="xs" data-star-captions="{}" data-default-caption="{rating}" data-rating-class="rating-fa">
                        </div>
                        <div class="field-row form-group">
                            <label for="review-headline" class="fl_label">Headline for your review</label>
                            <input name="review_headline" type="text" id="review-headline" class="with-ph" required/>
                        </div>
                        <div class="field-row form-group">
                            <label for="review-text" class="fl_label">Write your review here</label>
                            <textarea name="review_text" id="review-text" class="with-ph" required></textarea>
                        </div>
                        <button class="btn btn-default pull-right" type="submit">submit</button>
                        <button class="btn transparent pull-left cancel-review" type="button">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
