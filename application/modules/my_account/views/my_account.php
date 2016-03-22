<main>
    <div class="container-fluid">
        <div class="wrapper">
            <ol class="breadcrumb">
                <li><a href="index.html">Home </a></li>
                <li class="active">My Account</li>
            </ol>
            <div class="wrapper account-page">
                <div class="account-menu">
                    <a href="" class="btn transparent">your orders</a>
                    <a href="" class="btn transparent">your wish list</a>
                    <a href="login/logout" class="btn transparent">sign out</a>
                    <a href="" class="btn transparent">contact us</a>
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
<!-- 
<div class="page-header">
    <h2><?php echo str_replace('{name}', $customer['firstname'].' '.$customer['lastname'], lang('my_account_page_title'));?></h2>
</div>

<div class="col-nest">
    <div class="col" data-cols="1/3">
        <?php echo form_open('my-account'); ?>

            <h3><?php echo lang('account_information');?></h3>

            <label for="company"><?php echo lang('account_company');?></label>
            <?php echo form_input(['name'=>'company', 'value'=> assign_value('company', $customer['company'])]);?>
                
            <div class="col-nest">
            
                <div class="col" data-cols="1/2">
                    <label for="account_firstname"><?php echo lang('account_firstname');?></label>
                    <?php echo form_input(['name'=>'firstname', 'value'=> assign_value('firstname', $customer['firstname'])]);?>
                </div>

                <div class="col" data-cols="1/2">
                    <label for="account_lastname"><?php echo lang('account_lastname');?></label>
                    <?php echo form_input(['name'=>'lastname', 'value'=> assign_value('lastname', $customer['lastname'])]);?>
                </div>
            
                <div class="col" data-cols="1/2">
                    <label for="account_email"><?php echo lang('account_email');?></label>
                    <?php echo form_input(['name'=>'email', 'value'=> assign_value('email', $customer['email'])]);?>
                </div>
            
                <div class="col" data-cols="1/2">
                    <label for="account_phone"><?php echo lang('account_phone');?></label>
                    <?php echo form_input(['name'=>'phone', 'value'=> assign_value('phone', $customer['phone'])]);?>
                </div>
            </div>

            <label class="checklist">
                <input type="checkbox" name="email_subscribe" value="1" <?php if((bool)$customer['email_subscribe']) { ?> checked="checked" <?php } ?>/> <?php echo lang('account_newsletter_subscribe');?>
            </label>
        
            <div style="margin:30px 0px 10px; text-align:center;">
                <strong><?php echo lang('account_password_instructions');?></strong>
            </div>
        
            <div class="col-nest">
                <div class="col" data-cols="1/2">
                    <label for="account_password"><?php echo lang('account_password');?></label>
                    <?php echo form_password(['name'=>'password']);?>
                </div>

                <div class="col" data-cols="1/2">
                    <label for="account_confirm"><?php echo lang('account_confirm');?></label>
                    <?php echo form_password(['name'=>'confirm']);?>
                </div>
            </div>
        
            <input type="submit" value="<?php echo lang('form_submit');?>" class="blue" />
        </form>
    </div>

    <div id="addresses" class="col" data-cols="2/3"></div>
</div>
<div class="col-nest">
    <div class="col" data-cols="1">
        <div class="page-header" style="margin-top:30px;">
            <h2><?php echo lang('order_history');?></h2>
        </div>
        <?php if($orders):
            echo $orders_pagination;
        ?>
        <table class="table bordered zebra">
            <thead>
                <tr>
                    <th><?php echo lang('order_date');?></th>
                    <th><?php echo lang('order_number');?></th>
                    <th><?php echo lang('order_status');?></th>
                </tr>
            </thead>

            <tbody>
            <?php
            foreach($orders as $order): ?>
                <tr>
                    <td>
                        <?php $d = format_date($order->ordered_on); 
                
                        $d = explode(' ', $d);
                        echo $d[0].' '.$d[1].', '.$d[3];
                
                        ?>
                    </td>
                    <td><a href="<?php echo site_url('order-complete/'.$order->order_number); ?>"><?php echo $order->order_number; ?></a></td>
                    <td><?php echo $order->status;?></td>
                </tr>
        
            <?php endforeach;?>
            </tbody>
        </table>
        <?php else: ?>
            <div class="alert yellow"><i class="close"></i><?php echo lang('no_order_history');?></div>
        <?php endif;?>
    </div>
</div>

<script>
$(document).ready(function(){
    loadAddresses();
});

function closeAddressForm()
{
    $.gumboTray.close();
    loadAddresses();
}

function loadAddresses()
{
    $('#addresses').spin();
    $('#addresses').load('<?php echo base_url('addresses');?>');
}
</script>
-->