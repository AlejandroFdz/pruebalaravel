<?php $content = json_decode($component->content, true); ?>

<div id="{{$component->name}}" class="component" style="
        margin:{{$component->margin}}px;
        padding:{{$component->padding}}px;
        background-color:{{$content['component']['bg_color']}};
        text-align:{{$content['component']['text_align']}};
        ">

    @if( isset($content['button']) )
        @if( $content['button']['link'] == '#' || $content['button']['link'] == '' || $content['button']['link'] == ' ' )
            <a href="#" id="full_button_text" style="
            background-color:{{$content['button']['bg_color']}};
                color:{{$content['button']['color']}};
                font-size:{{$content['button']['font_size']}}px;
                padding:{{$content['button']['padding']}}px;
                border-radius:{{$content['button']['border_radius']}}px;">
        @else
            <a href="{{{config('app.url')}}}/email/clicked/{{{$campaign_data['list_id']}}}/{{{$campaign_data['subscriber_id']}}}/{{{$campaign_data['emails_sended']}}}/{{{$content['button']['link']}}}" id="full_button_text" style="
                background-color:{{$content['button']['bg_color']}};
                    color:{{$content['button']['color']}};
                    font-size:{{$content['button']['font_size']}}px;
                    padding:{{$content['button']['padding']}}px;
                    border-radius:{{$content['button']['border_radius']}}px;
            ">        
        @endif            
            {{$content['button']['text']}}
        </a>
    @endif

</div>
