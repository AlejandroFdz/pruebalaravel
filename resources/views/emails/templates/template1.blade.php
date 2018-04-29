<table width="100%" cellspacing="0" cellpadding="0" border="0">
  <tbody>
    <tr>

      @foreach( $components as $component )
      	@if( $component->name != "footer" )
        	@include('components/email/' . $component->name, ['component' => $component, 'campaign_data' => $campaign_data])
        @endif
      @endforeach

      <!-- Footer -->

		@foreach( $components as $component )

	      	@if($component->name == "footer")

	      		<?php $content = json_decode($component->content, true); ?>

		    	<div id="{{$component->name}}" class="component" style="
			        margin:{{$component->margin}}px;
			        background-color:{{$content['component']['bg_color']}};
			        text-align:{{$content['component']['text_align']}};
			        display:inline-block;
			        width:100%;
			        padding:20px;
			        ">

				    @if(isset($content['social_media']))

				        <div>

				            @foreach($content['social_media'] as $key => $social)
				            	<a href="{{{config('app.url')}}}/email/clicked/{{{$campaign_data['list_id']}}}/{{{$campaign_data['subscriber_id']}}}/{{{$social['url']}}}" target="_blank" style="
				                        margin-left:{{$social['margin_left']}}px;
				                        margin-right:{{$social['margin_right']}}px;
				                        text-decoration: none;" id="social_footer_{{$key}}">			                
				                    <img src="{{asset('imgs/templates/components/footer/social')}}/{{$social['icon']}}" width="22" height="22">
				                </a>
				            @endforeach

				            <hr>

				            <span style="line-height:27px;">
				                Copyright © <strong id="footer_company">{{$company}}</strong>,<br>
				                ¿Quieres darte de baja de éste boletín de noticias?<br>
				                Puedes hacerlo pulsando <a href="{{url('contacts/unsubscribe')}}/{{$campaign_data['subscriber_id']}}" target="_blank" style="text-decoration:none;color:#fff;">aquí</a>.
				            </span>

				        </div>

				    @endif

				</div>

			@endif

		@endforeach

	<!-- End Footer -->
      
    </tr>
  </tbody>
</table>

<img src='http://correo.hormiga/email/opened/{{{$campaign_data['list_id']}}}/{{{$campaign_data['subscriber_id']}}}/{{{$campaign_data['emails_sended']}}}' style='width:1px;height:1px;'>
