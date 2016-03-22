<?php

include('crunch.php');
include('Parsedown.php');
include('content_filter.php');

function category_loop($parent = 0, $ulattribs=false, $ul=true)
{
    $cats = CI::Categories()->get_categories_tiered();

    $items = false;
    if(isset($cats[$parent]))
    {
        $items = $cats[$parent];
    }

    if($items)
    {
        foreach($items as $item)
        {

            $selected = (CI::uri()->segment(2) == $item->slug)?'class="has-sub-menu"':'class="has-sub-menu"';

            if(CI::Categories()->tier($item->id))  // Category with children
            {
                $parent = CI::Categories()->tier($item->id);
                $name = anchor('category/' . $item->slug, $item->name, $selected);  // Parent link
                $name .= '<div class="sub-menu-box">';
                $name .= '    <div class="wrapper">';
                $name .= '        <ul class="sub-menu">';
                foreach($parent as $key => $child) {
                    $name .= '            <li>';
                    $name .= '              <a href="/category/' . $child->slug . '" >';
                    $name .= '                <img src="/uploads/images/submenu/' . $child->image . '" />';
                    $name .= '                <p>' . $child->name . '</p>';
                    $name .= '              </a>';
                    $name .= '            </li>';
                }
                $name .= '        </ul>';
                $name .= '    </div>';
                $name .= '<a href="/category/' . $item->slug . '" class="btn btn-view">view all</a>';
                $name .= '</div>';
                $anchor = $name;
                $html = '<li class="dropdown">'.$anchor.'</li>';
                echo $html;

            }elseif($item->parent_id ==0) {
                $selected = '';
                $name = $item->name;
                $anchor = anchor('category/' . $item->slug, $name, $selected);
                echo '<li class="dropdown">'.$anchor;
                category_loop($item->id);
                echo '</li>';
            }
        }
    }
}

function page_loop($parent = 0, $ulattribs=false, $ul=true)
{
    $pages = CI::Pages()->get_pages_tiered();

    $items = false;
    if(isset($pages[$parent]))
    {
        $items = $pages[$parent];
    }

    if($items)
    {
        echo ($ul)?'<ul '.$ulattribs.'>':'';
        foreach($items as $item)
        {
            echo '<li>';
            $chevron = ' <i class="icon-chevron-down dropdown"></i>';
            
            if($item->slug == '')
            {
                //add the chevron if this has a drop menu
                $name = $item->title;
                if(isset($pages[$item->id]))
                {
                    $name .= $chevron;
                }

                $target = ($item->new_window)?' target="_blank"':'';
                $anchor = '<a href="'.$item->url.'"'.$target.'>'.$name.'</a>';
            }
            else
            {
                //add the chevron if this has a drop menu
                $name = $item->menu_title;
                if(isset($pages[$item->id]))
                {
                    $name .= $chevron;
                }
                $selected = (CI::uri()->segment(2) == $item->slug)?'class="selected"':'';
                $anchor = anchor('page/'.$item->slug, $name, $selected);
            }

            echo $anchor;
            page_loop($item->id);
            echo '</li>';
        }
        echo ($ul)?'</ul>':'';
    }
}