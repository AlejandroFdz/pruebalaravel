<?php $content = json_decode($component->content, true); ?>

<div id="{{$component->name}}" class="component" style="
        margin:{{$component->margin}}px;
        padding:{{$component->padding}}px;
        background-color:{{$content['component']['bg_color']}};
        text-align:{{$content['component']['text_align']}};
        ">

    @if( isset($content['row_1']) )
        <div style="display: inline-block;">
            <div style="display:inline-block;text-align:right;">
                <img src="{{url('storage')}}/{{$content['row_1']['picture']}}" id="row_1_picture" style="width:100%;margin-right:20px;">
            </div>
            <div style="display: inline-block;">
                <h4 id="row1_title" style="color:#000;font-weight:600;font-size:22px;">{{$content['row_1']['title']}}</h4>
                <p id="row_1_text" style="font-size:18px;">
                    {{$content['row_1']['text']}}<br><br>                    
                </p>
            </div>
        </div>
    @endif

    @if( isset($content['row_2']) )
        <div style="display: inline-block;margin-top:15px;margin-bottom:15px;">
            <div style="display: inline-block; text-align:right;">
                <img src="{{url('storage')}}/{{$content['row_2']['picture']}}" id="row_2_picture" style="width:100%;margin-right:20px;">
            </div>
            <div style="display: inline-block;">
                <h4 id="row2_title" style="color:#000;font-weight:600;font-size:22px;">{{$content['row_2']['title']}}</h4>
                <p id="row_2_text" style="font-size:18px;">
                    {{$content['row_2']['text']}}<br><br>                    
                </p>
            </div>
        </div>
    @endif

    @if( isset($content['row_3']) )
        <div style="display: inline-block;">
            <div style="display: inline-block;text-align:right;">
                <img src="{{url('storage')}}/{{$content['row_3']['picture']}}" id="row_3_picture" style="width:100%;margin-right:20px;">
            </div>
            <div style="display: inline-block;">
                <h4 id="row3_title" style="color:#000;font-weight:600;font-size:22px;">{{$content['row_3']['title']}}</h4>
                <p id="row_3_text" style="font-size:18px;">
                    {{$content['row_3']['text']}}<br><br>                    
                </p>
            </div>
        </div>
    @endif


</div>
