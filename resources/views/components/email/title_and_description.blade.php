
<?php $content = json_decode($component->content, true); ?>

<div id="{{$component->name}}" class="component" style="
        margin:{{$component->margin}}px;
        padding:{{$component->padding}}px;
        background-color:{{$content['component']['bg_color']}};
        text-align:{{$content['component']['text_align']}};
        ">

    @if( isset($content['title']) )
        <h3 id="header_title" style="
            font-size:{{$content['title']['styles']['font_size']}}px;
            margin-top:{{$content['title']['styles']['margin_top']}}px;
            margin-bottom:{{$content['title']['styles']['margin_bottom']}}px;
            color:{{$content['title']['styles']['color']}};
            ">
            {{$content['title']['properties']['text']}}
        </h3>


        <h1 id="header_description" style="
            font-size:{{$content['description']['styles']['font_size']}}px;
            margin-top:{{$content['description']['styles']['margin_top']}}px;
            margin-bottom:{{$content['description']['styles']['margin_bottom']}}px;
            color:{{$content['description']['styles']['color']}};
        ">
            {{$content['description']['properties']['text']}}
        </h1>
    @endif


</div>