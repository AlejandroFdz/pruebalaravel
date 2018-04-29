<?php $content = json_decode($component->content, true); ?>

<div id="{{$component->name}}" class="component" style="
        margin:{{$component->margin}}px;
        padding:{{$component->padding}}px;
        background-color:{{$content['component']['bg_color']}};
        text-align:{{$content['component']['text_align']}};
        ">

    <div data-component="{{$component->name}}" class="btn-settings">
        <i id="full_button_settings" class="fa fa-cog comp-settings btn btn-default" aria-hidden="true"></i>
    </div>

    @if( isset($content['button']) )
        <a href="{{$content['button']['link']}}" id="full_button_text" style="
            background-color:{{$content['button']['bg_color']}};
                color:{{$content['button']['color']}};
                font-size:{{$content['button']['font_size']}}px;
                padding:{{$content['button']['padding']}}px;
                border-radius:{{$content['button']['border_radius']}}px;
        ">
            {{$content['button']['text']}}
        </a>
    @endif

</div>
