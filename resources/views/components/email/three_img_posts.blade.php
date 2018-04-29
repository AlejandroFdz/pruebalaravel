<?php $content = json_decode($component->content, true); ?>

<div id="{{$component->name}}" class="component" style="
        margin:{{$component->margin}}px;
        padding:{{$component->padding}}px;
        background-color:{{$content['component']['bg_color']}};
        text-align:{{$content['component']['text_align']}};
        display:inline-block;
        ">

    @if( isset($content['featured_picture']) )
        <div>
            <div class="featured_picture" style="width:100%;">
                <img src="{{url('storage')}}/{{$content['featured_picture']['picture']}}" id="featured_picture" style="width:100%;">
            </div>
        </div>
    @endif

    <div style="width:100%;margin-top:8px;">
        <div style="width:49.5%;display:inline-block;float:left;">
            <img src="{{url('storage')}}/{{$content['left_picture']['picture']}}" id="left_picture" style="width:100%;">
        </div>
        <div style="width:49.5%;display:inline-block;float:right;">
            <img src="{{url('storage')}}/{{$content['right_picture']['picture']}}" id="right_picture" style="width:100%;">
        </div>
    </div>

    @if( isset($content['description']) )
        <div class="description" style="font-size:18px;margin-top:15px;display:inline-block;color:{{$content['text_color']}};">
            <p>
                {{$content['description']['p1']}}
            </p>
            <p>
                {{$content['description']['p2']}}
            </p>
        </div>
    @endif

    @if( isset($content['title']) )
        <h3 style="font-weight:800;">{{$content['title']}}</h3>
    @endif

    @if( isset($content['sub_description']) )
        <div class="sub-description" style="font-size:18px;color:{{$content['text_color']}};">
            <p>{!! $content['sub_description'] !!}</p>
        </div>
    @endif

    @if( isset($content['button']) )
        <div class="button-link" style="text-align: center; margin-top:50px;">
            @if( $content['button']['url'] == '#' || $content['button']['url'] = '' || $content['button']['url'] == ' ' )
                <a href="#" style="
                color: {{$content['button']['color']}};
                background-color: {{$content['button']['bg_color']}};
                border-radius: 5px;
                padding: 20px;
                font-weight: 600;
                font-size: 18px;
                display: inline-block;">
            @else
                <a href="{{{config('app.url')}}}/email/clicked/{{{$campaign_data['list_id']}}}/{{{$campaign_data['subscriber_id']}}}/{{{$campaign_data['emails_sended']}}}/{{$content['button']['url']}}" style="
                color: {{$content['button']['color']}};
                background-color: {{$content['button']['bg_color']}};
                border-radius: 5px;
                padding: 20px;
                font-weight: 600;
                font-size: 18px;
                display: inline-block;">
            @endif
            {{$content['button']['text']}}</a>
        </div>
    @endif

</div>
