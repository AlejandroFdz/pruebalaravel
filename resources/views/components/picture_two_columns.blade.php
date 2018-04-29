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
        <img src="{{url('storage')}}/{{$content['featured_picture']['picture']}}" id="picture_two_columns_featured_picture" style="width:100%;">
    @endif

    @if( isset($content['title']) )
        <h3 id="picture_two_columns_title" style="
                font-size:{{$content['title']['styles']['font_size']}}px;
                margin-top:{{$content['title']['styles']['margin_top']}}px;
                color:{{$content['title']['styles']['color']}}
                font-style: {{$content['title']['styles']['font-style']}};
                ">
            {{$content['title']['properties']['text']}}
        </h3>
    @endif

    @if( isset($content['columns']) )
        <div style="display:inline-block;color:#808080;font-size:16px;">
            <div id="column_text_1" style="width:49%;float:left;">
                {{$content['columns']['column_1']['text']}}
            </div>
            <div id="column_text_2" style="width:49%;float:right;">
                {{$content['columns']['column_2']['text']}}
            </div>
        </div>
    @endif


</div>
