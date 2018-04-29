<?php $content = json_decode($component->content, true); ?>

<div id="{{$component->name}}" class="component" style="
        margin:{{$component->margin}}px;
        padding:{{$component->padding}}px;
        background-color:{{$content['component']['bg_color']}};
        text-align:{{$content['component']['text_align']}};
        display:inline-block;
        ">

    <div data-component="{{$component->name}}" class="btn-settings">
        <i id="two_posts_settings" class="fa fa-cog comp-settings btn btn-default" aria-hidden="true"></i>
    </div>

    @if( isset($content['column_1']) && isset($content['column_2']) )
        <div>
            <div class="{{$content['column_1']['name']}}" style="
                width:49%;
                float: left;
            ">
                <img src="{{url('storage')}}/{{$content['column_1']['picture']}}" id="two_posts_left_picture" style="width:100%;">
                <h4 id="two_posts_left_title" style="
                    color:{{$content['column_1']['title']['color']}};
                    font-size:{{$content['column_1']['title']['font_size']}}px;
                     margin-top:{{$content['column_1']['title']['margin_top']}}px;
                     margin-bottom:{{$content['column_1']['title']['margin_bottom']}}px;
                ">
                    {{$content['column_1']['title']['text']}}
                </h4>
                <p id="two_posts_left_description" style="
                    font-size:{{$content['column_1']['description']['font_size']}}px;
                    color:{{$content['column_1']['description']['color']}};
                    min-height:50px;
                ">
                    {{$content['column_1']['description']['text']}}
                </p>
                <a href="{{$content['column_1']['link']['url']}}" id="two_posts_left_link" target="_blank" style="
                    color:{{$content['column_1']['link']['color']}};
                ">
                    {{$content['column_1']['link']['text']}}
                </a>
            </div>
            <div class="{{$content['column_2']['name']}}" style="
                width:49%;
                float: right;
            ">
                <img src="{{url('storage')}}/{{$content['column_2']['picture']}}" id="two_posts_right_picture" style="width:100%;">
                <h4 id="two_posts_right_title" style="
                    color:{{$content['column_1']['title']['color']}};
                    font-size:{{$content['column_1']['title']['font_size']}}px;
                    margin-top:{{$content['column_1']['title']['margin_top']}}px;
                    margin-bottom:{{$content['column_1']['title']['margin_bottom']}}px;
                ">
                    {{$content['column_2']['title']['text']}}
                </h4>
                <p id="two_posts_right_description" style="
                        font-size:{{$content['column_1']['description']['font_size']}}px;
                        color:{{$content['column_1']['description']['color']}};
                        min-height:50px;
                        ">
                    {{$content['column_2']['description']['text']}}
                </p>
                <a href="{{$content['column_2']['link']['url']}}" id="two_posts_right_link" target="_blank" style="
                        color:{{$content['column_1']['link']['color']}};
                    ">
                    {{$content['column_2']['link']['text']}}
                </a>
            </div>
        </div>
    @endif

</div>
