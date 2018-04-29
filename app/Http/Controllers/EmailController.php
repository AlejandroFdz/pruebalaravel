<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Lists;
use App\Stats;

class EmailController extends Controller
{
    public function opened($list_id, $subscriber_id, $emails_sended, Request $request)
    {
    	/** Obtenemos los datos de las estadísticas. */
    	$opened = 0;
    	$email_opened = 0.0;

        $all_stats = Stats::where('list_id', '=', $list_id)
            ->where('clicks', '!=', 1.0)
            ->get();

    	$stats = Stats::where('list_id', '=', $list_id)
            ->where('subscriber_id', '=', $subscriber_id)
            ->where('clicks', '!=', 1.0)
            ->get();

        /** Si el subscriptor que abrió el correo no tiene ya registro de apertura. */
        if( $stats->count() == 0 ) {

            $opened = $all_stats->count();
            $opened++;

            $list = Lists::find($list_id);
            $list->opens = $opened;
            $list->sended = $emails_sended;
            $list->save();

            $input = [
                'list_id' => $list_id,
                'subscriber_id' => $subscriber_id,
            ];

            Stats::create($input);
        }
    	
    }

    public function clicked($list_id, $subscriber_id, $emails_sended, $url, Request $request)
    {
        /** Obtenemos los datos de las estadísticas. */
        $clicked = 0;
        $email_opened = 0.0;

        $all_stats = Stats::where('list_id', '=', $list_id)
            ->where('clicks', '=', 1.0)
            ->get();

        $stats = Stats::where('list_id', '=', $list_id)
            ->where('subscriber_id', '=', $subscriber_id)
            ->where('clicks', '=', 1)
            ->get();

        /** Si el subscriptor que abrió el correo no tiene ya registro de apertura. */
        if( $stats->count() == 0 ) {

            $clicked = $all_stats->count();
            $clicked++;

            $list = Lists::find($list_id);
            $list->clicks = $clicked;
            $list->save();

            $input = [
                'list_id' => $list_id,
                'subscriber_id' => $subscriber_id,
                'clicks' => 1.0
            ];

            Stats::create($input);
        }

        /** Redireccionamos a la url. */
        return redirect()->away($url);
        
    }
}
