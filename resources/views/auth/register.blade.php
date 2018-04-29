@extends('layouts.app')

@section('content')
<div class="container register-form">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">@lang('auth.register_title')</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">@lang('auth.name')</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('lastname') ? ' has-error' : '' }}">
                            <label for="lastname" class="col-md-4 control-label">@lang('auth.lastname')</label>

                            <div class="col-md-6">
                                <input id="lastname" type="text" class="form-control" name="lastname" value="{{ old('lastname') }}" required autofocus>

                                @if ($errors->has('lastname'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('lastname') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('company') ? ' has-error' : '' }}">
                            <label for="company" class="col-md-4 control-label">@lang('auth.company')</label>

                            <div class="col-md-6">
                                <input id="company" type="text" class="form-control" name="company" value="{{ old('company') }}" required autofocus>

                                @if ($errors->has('company'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('company') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label for="phone" class="col-md-4 control-label">@lang('auth.phone')</label>

                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control" name="phone" value="{{ old('phone') }}" required autofocus>

                                @if ($errors->has('phone'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
                            <label for="country" class="col-md-4 control-label">@lang('auth.country')</label>

                            <div class="col-md-6">
                                <select id="country" name="country" class="form-control" required>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country }}">{{ $country }}</option>                              
                                    @endforeach
                                </select>

                                @if ($errors->has('country'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('country') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('postal_code') ? ' has-error' : '' }}">
                            <label for="postal_code" class="col-md-4 control-label">@lang('auth.postal_code')</label>

                            <div class="col-md-6">
                                <input id="postal_code" type="number" class="form-control" name="postal_code" value="{{ old('postal_code') }}" required autofocus>

                                @if ($errors->has('phone'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">@lang('auth.email_address')</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">@lang('auth.password')</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">@lang('auth.confirm_password')</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="jumbotron">
                            <h2>¡Envía correos <strong>ilimitados</strong>!</h2>
                            <p>Por sólo <span class="price">$197MXN</span> al mes podrás enviar todos los correos que necesites para mantener informados a tus clientes o para conseguir <strong>más ventas</strong>.</p>
                            <div class="row">
                                <div class="col-md-8">
                                    <p style="margin-top:12px;">
                                        <!-- <input type="checkbox" id="optcontract" name="optcontract" checked="checked" /> -->
                                        <label for="optcontract" class="contract-label">
                                            Accede a <a href="{{url('/planes')}}">PLANES</a> y contrata el <br><strong>Plan PREMIUM</strong><br>
                                            <small><span style="color:red;">*</span> Si quieres probar <strong>Correo Hormiga</strong> dispones de 1 mes gratis de prueba.</small>
                                        </label>
                                    </p>
                                </div>                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="col-md-6 col-md-offset-4 text-left">
                                            <input type="submit" class="btn btn-lg btn-primary" value="@lang('auth.register_button')">
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1"></div>
                            </div>
                      </div>

                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@section('checkbox_styles')    
    <link href="{{ asset('css/checkbox.css') }}" rel="stylesheet">
@endsection
