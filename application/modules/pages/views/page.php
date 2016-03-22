<main>
    <div class="container-fluid">
        <div class="wrapper">
            <ol class="breadcrumb">
                <li><a href="#">Customer Service </a></li>
                <li class="active"><?php echo $page_title;?></li>
            </ol>
            <div class="row content-page">
                <aside  class="col-sm-3 col-xs-12 aside-menu">
                <?php
                    foreach ($page_list as $level1):
                        if ($level1->parent_id == 0){
                ?>
                        <div class="content-category <?php if ($parent_id==$level1->id) echo "open"?>">
                            <h3><?php echo $level1->title;?></h3>
                            <div class="acc-submenu" <?php if ($parent_id==$level1->id) echo "style='display: block;'"?>">
                            <?php
                                foreach ($page_list as $level2):
                                    if ($level2->parent_id==$level1->id){
                            ?>
                                <a href="<?php echo $level2->slug;?>" data-tab="1" class="<?php if ($level2->title==$page_title) echo 'active';?>"><?php echo $level2->title;?></a>
                            <?php
                                    }
                                endforeach;
                            ?>
                            </div>
                        </div>
                <?php
                        }
                    endforeach;
                ?>
                </aside>
                
                <div class=" col-sm-9 col-xs-12">
                    <div class="tab visible" data-index="13">
                        <?php echo $page->content;?>
                    </div>
                </div>
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

<script type="text/javascript" src="<?php echo base_url('themes/unismoke/assets/js/content_page.js');?>"></script>