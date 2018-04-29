<?php $content = json_decode($component->content, true); ?>

<div id="{{$component->name}}" class="component" style="
        margin:{{$component->margin}}px;
        padding:{{$component->padding}}px;
        background-color:{{$content['component']['bg_color']}};
        text-align:{{$content['component']['text_align']}};
        ">

    <div data-component="{{$component->name}}" class="btn-settings">
        <i class="fa fa-cog comp-settings btn btn-default" aria-hidden="true"></i>
    </div>

    @if( isset($content['featured_picture']) )
        <img src="{{url('storage')}}/{{$content['featured_picture']['picture']}}" id="single_post_featured_image" style="
                margin-bottom:{{$content['featured_picture']['margin_bottom']}}px;
                width:{{$content['featured_picture']['width']}};
                ">
    @endif

    @if( isset($content['title']) )
        <h3 id="single_post_title" style="
                font-size:{{$content['title']['font_size']}}px;
                margin-top:{{$content['title']['margin_top']}}px;
                color:{{$content['title']['color']}}
                ">
            {{$content['title']['text']}}
        </h3>
    @endif

    @if( isset($content['description']) )
        <div style="
            font-size:{{$content['description']['styles']['font_size']}}px;
            line-height:{{$content['description']['styles']['line_height']}}px;
            color:{{$content['description']['styles']['color']}};
            margin-top:{{$content['description']['styles']['margin_top']}}px;
            margin-bottom:{{$content['description']['styles']['margin_bottom']}}px;
        ">
            <p id="single_post_column_1">{{$content['description']['content']['p1']}}</p>
            <p id="single_post_column_2">{{$content['description']['content']['p2']}}</p>
        </div>
    @endif


</div>
