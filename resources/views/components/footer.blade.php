<?php $content = json_decode($component->content, true); ?>

<div id="{{$component->name}}" class="component" style="
        margin:{{$component->margin}}px;
        padding:{{$component->padding}}px;
        background-color:{{$content['component']['bg_color']}};
        text-align:{{$content['component']['text_align']}};
        display:inline-block;
        width:100%;
        ">

    <div data-component="{{$component->name}}" class="btn-settings">
        <i id="footer_settings" class="fa fa-cog comp-settings btn btn-default" aria-hidden="true"></i>
    </div>

    @if(isset($content['social_media']))

        <div>

            @foreach($content['social_media'] as $key => $social)
                <a href="{{$social['url']}}" target="_blank" style="
                        margin-left:{{$social['margin_left']}}px;
                        margin-right:{{$social['margin_right']}}px;
                        " id="social_footer_{{$key}}">
                    <img src="{{asset('imgs/templates/components/footer/social')}}/{{$social['icon']}}" width="22" height="22">
                </a>
            @endforeach

            <hr>

            <span style="line-height:27px;">
                Copyright © <strong id="footer_company">[NOMBRE DE LA EMPRESA]</strong>, <span id="footer_copyright">{{$content['info']['copyright']}}</span>,<br>
                ¿Quieres darte de baja de éste boletín de noticias?<br>
                Puedes hacerlo pulsando <a href="#" target="_blank">aquí</a>.
            </span>

        </div>

    @endif

</div>
