<?php if(!empty($breadcrumbs)):?>

<div class="wrapper">
    <ol class="breadcrumb">
        <a href="<?php echo site_url();?>"><i class="icon-home"></i></a>
        <?php for($i = 0; $i<count($breadcrumbs); $i++):?>
            <?php if($i != count($breadcrumbs)-1):?>
                <li><a href="<?php echo $breadcrumbs[$i]['link'];?>"><?php echo $breadcrumbs[$i]['name'];?></a></li>
            <?php else:?>
                <li><span style="color: #F27220;"><?php echo $breadcrumbs[$i]['name'];?></span></li>
            <?php endif;?>
        <?php endfor;?>
    </ol>
</div>

<?php endif;