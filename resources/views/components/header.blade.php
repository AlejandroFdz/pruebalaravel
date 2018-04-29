
<?php $content = json_decode($component->content, true); ?>

<div id="{{$component->name}}" class="component" style="
        margin:{{$component->margin}}px;
        padding:{{$component->padding}}px;
        background-color:{{$content['component']['bg_color']}};
        background-image:url({{url('storage')}}/{{$content['component']['bg_img']}});
        text-align:{{$content['component']['text_align']}};
        ">

    <div data-component="{{$component->name}}" class="btn-settings">
        <i id="header_settings" class="fa fa-cog comp-settings btn btn-default" aria-hidden="true"></i>
    </div>

    @if( isset($content['logo']) )
        <img src="{{url('storage')}}/{{$content['logo']['properties']['picture']}}" style="
            margin-top:{{$content['logo']['styles']['margin_top']}}px;
            margin-bottom:{{$content['logo']['styles']['margin_bottom']}}px;
            width:25%;
        " id="logo_image">
    @endif

    @if( isset($content['title']) )
        <h1 id="header_title" style="
            font-size:{{$content['title']['styles']['font_size']}}px;
            margin-top:{{$content['title']['styles']['margin_top']}}px;
            margin-bottom:{{$content['title']['styles']['margin_bottom']}}px;
            color:{{$content['title']['styles']['color']}};
        ">
            {{$content['title']['properties']['text']}}
        </h1>
    @endif


</div>