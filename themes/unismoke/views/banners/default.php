<?php $banners = CI::Banners()->get_homepage_banners(); ?>
<div class="container-fluid slider-box">
	<div class="main-slider wrapper">
		<?php foreach($banners as $banner):?>
			<?php $banner_image = base_url('uploads/'.$banner->image); ?>
			<div class="slide">
				<div class="row">
					<div class="col-xs-5">
						<div class="caption">
							<?php if ($banner->banner_id == 1): // TODO Add HTML to admin banners section. and place the html from here in DB via the admin panel. ?>
								<p>ENJOY SUPERIOR TASTE AND FLAVORS</p>
								<h2>SUBSCRIBE NOW<br/> & GET 10% OFF</h2>
								<button class="btn btn-default">BUY OR SUBSCRIBE</button>
							<?php else: ?>
								<p>Our best selling product</p>
								<h2>INNOKIN MVP 3.0 PRO</h2>
								<p>Up to 60W with beautiful digital display.</p>
								<button class="btn btn-default">BUY OR SUBSCRIBE</button>
							<?php endif; ?>
						</div>
					</div>
					<div class="col-xs-7 col-xs-offset-5">
						<?php if ($banner->link) { ?>
							<a href="<?php $banner->link; ?>"><img src="<?php echo $banner_image ?>" alt="<?php echo $banner->name; ?>" class="img-responsive" /></a>
						<?php } else { ?>
							<img src="<?php echo base_url('uploads/'.$banner->image); ?>" alt="<?php echo $banner->name; ?>" class="img-responsive" />
						<?php } ?>
					</div>
				</div>
			</div>
		<?php endforeach;?>
	</div>

	<div class="slider-controls">
		<div id="main-slider-next" class="icon-right-open-big pull-right"></div>
		<div id="main-slider-prev" class="icon-left-open-big pull-left"></div>
	</div>
	<button class="btn next-btn icon-down-open-big">SHOP BY CATEGORY</button>
</div>