<main>
    <div class="container-fluid">
        <div class="wrapper">
            <div class="row register-form">
                <aside class=" col-sm-4">
                    <div class="login-form">
                        <h3>Log In to Unismoke</h3>
                        <?php echo form_open('login/'.$redirect, 'id="loginForm" data-parsley-validate'); ?>
                            <div class="field-row form-group">
                                <label class="fl_label" for="aside-login-form-email">Email</label>
                                <input type="email" name="email" class="form-control with-ph" id="aside-login-form-email" required>
                            </div>
                            <div class="field-row form-group">
                                <label class="fl_label" for="aside-login-form-password">Password</label>
                                <input type="password" name="password" class="form-control with-ph" id="aside-login-form-password" required>
                            </div>
                            <div class="col-sm-12 field-row pull-left form-group">
                                <input type="checkbox" name="remember" value="true" id="aside-keep-logged"/>
                                <label for="aside-keep-logged">Keep me logged in</label>
                                
                                <a href="<?php echo site_url('forgot-password'); ?>" class="pull-right pass-help"><?php echo lang('forgot_password')?></a>
                            </div>
                      <?php if(isset($loginErrors) && array_key_exists("password", $loginErrors)):?>
                            <div id="login_form_error" class="col-sm-12 field-row pull-left form-group">
                                <p class="generic_error">There was a problem with your request</p>
                                <p class="generic_error">There was an error with your E-Mail/ Password combination. Please try again.</p>
                            </div>
                      <?php endif;?>
                            <button type="submit" class="btn btn-default">LOGIN</button>
                            <div class="separator">
                                <p>or</p>
                            </div>                        
                            <button type="submit" class="btn btn-amazon icon-amazon">Login with Amazon</button>
                        </form>
                    </div>
                </aside>
                <div class="col-sm-8">
                    <h3>Register With Unismoke</h3>
                    <p>Create one account to manage everything you do on Unismoke.com. You'll enjoy personal services and great benefits including:</p>
                    <ul>
                        <li>Acess to exclusive releases and limited products.</li>
                        <li>Free returns on all your Unismoke.com orders.</li>
                        <li>Unismoke.com benefits and promotions.</li>
                    </ul>
                    <?php echo form_open('register', 'id="registration_form" data-parsley-validate'); ?>
                        <input type="hidden" name="submitted" value="submitted" />
                        <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
                        <div class="half-form">
                            <div class="field-row form-group">
                                <label class="fl_label" for="r-first-name">First Name<span>*</span></label>
                                <input type="text" class="with-ph" id="r-first-name" name="firstname" required>
                            </div>
                            <div class="field-row form-group">
                                <label class="fl_label" for="r-last-name">Last Name<span>*</span></label>
                                <input type="text" class="with-ph" id="r-last-name" name="lastname" required>
                            </div>
                            <div class="field-row form-group">
                                <label class="fl_label" for="reg-email">Email Address<span>*</span></label>
                                <input type="email" class="with-ph" id="reg-email" name="email" required>
                            </div>
                            <div class="field-row form-group">
                                <label class="fl_label" for="r-pass">Password<span>*</span></label>
                                <input type="password" class="with-ph" id="r-pass" name="password" required>
                            </div>
                            <div class="field-row form-group">
                                <label class="fl_label" for="r-confirm-pass">Confirm Password<span>*</span></label>
                                <input type="password" class="with-ph" id="r-confirm-pass" name="confirm" required data-parsley-equalto="#r-pass">
                            </div>
                        </div>
                        <div class="half-form">
                            <div class="field-row form-group">
                                <label class="fl_label" for="r-screen-name">Screen Name<span>*</span></label>
                                <input type="text" class="with-ph" id="r-screen-name" name="screen_name" required>
                            </div>
                            <div class="three-field">
                                <p>Date of Birth <span>*</span></p>
                                <div class="field-row form-group clearfix" id="b-month">
                                    <label class="sr-only" for="month">month</label>
                                    <select name="month" id="month" data-placeholder="MM" required data-parsley-class-handler="#b-month">
                                        <option value="" disabled selected>MM</option>
                                        <option value="01">January</option>
                                        <option value="02">February</option>
                                        <option value="03">March</option>
                                        <option value="04">April</option>
                                        <option value="05">May</option>
                                        <option value="06">June</option>
                                        <option value="07">July</option>
                                        <option value="08">August</option>
                                        <option value="09">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select>
                                </div>
                                <div class="field-row form-group clearfix" id="b-day">
                                    <label class="sr-only" for="day">day</label>
                                    <select name="day" id="day" data-placeholder="DD" required data-parsley-class-handler="#b-day">
                                        <option value="" disabled selected>DD</option>
                                    <?php for($i=1; $i<=31; $i++){?>
                                        <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                    <?php }?>
                                    </select>
                                </div>
                                <div class="field-row form-group clearfix" id='b-year'>
                                    <label class="sr-only" for="year">month</label>
                                    <select name="year" id="year" data-placeholder="YYYY" required data-parsley-class-handler="#b-year">
                                        <option value="" disabled selected>YYYY</option>
                                    <?php for($i=1997; $i>=1925; $i--){?>
                                        <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                    <?php }?>
                                    </select>
                                </div>
                            </div>
                            <div class="field-row form-group">
                                <div class="check-wrap">
                                    <input type="checkbox" id="old" name="old" value="1" required/>
                                    <label for="old">You must be 18 years or older to enter our site. By checking
                                        this box, you certify that you are over the age of 18.*</label>
                                </div>
                            </div>
                            <div class="radio-wrap" id="gender">
                                <p>Gender <span>*</span></p>
                                <div class="field-row form-group">
                                    <input type="radio" id="male" name="gender" value="1" required data-parsley-class-handler="#gender"/>
                                    <label for="male">Male</label>
                                </div>
                                <div class="field-row form-group">
                                    <input type="radio" id="female" name="gender" value="2" required data-parsley-class-handler="#gender"/>
                                    <label for="female">Female</label>
                                </div>
                            </div>
                            <div class="field-row form-group">
                                <label class="fl_label" for="zip">Zipcode<span>*</span></label>
                                <input type="text" class="with-ph" id="zip" name="zip" required data-parsley-type="number" data-parsley-maxlength="5">
                            </div>
                        </div>
                        
                        <div class="field-row form-group">
                            <input type="checkbox" id="email_subscribe" name="email_subscribe" value="1"/>
                            <label for="email_subscribe">Sign up for emails to learn about the latest styles, special offers and services from Unismoke.</label>
                        </div>
                    <?php if(isset($registrationErrors) && array_key_exists('email', $registrationErrors)):?>       
                        <div id="register_form_error" class="col-sm-12 field-row form-group">
                            <p class="generic_error">Email address already in use</p>
                            <p class="generic_error">You indicated you are a new customer, but an account already exists with the e-Mail : <?php echo $email;?></p>
                            <p class="generic_error">If you are a returning customer, please use the login form.</p>
                        </div>
                    <?php endif;?>
                        <p class="req"><span>*</span> Required Fields</p>
                        <p>By clicking SIGN UP, you are agreeing to the Unismoke.com <a href="">Policy</a> and <a
                                href="">Terms & Conditions</a>.</p>
                        <button type="submit" class="btn btn-default">register</button>
                    </form>
                </div>
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
<script type="text/javascript" src="<?php echo base_url('themes/unismoke/assets/js/login.js');?>"></script>
