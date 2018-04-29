<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Mail;
use App\Mail\CHormigaEmails;
use App\Mail\CampaignSendedNotify;

use App\Lists;
use App\Groups;
use App\Subscribers;

class SendCustomerEmails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $campaign_data = [
        'template_id' => 0,
        'id_user' => 0,
        'email' => '',
        'company' => '',
        'default_template_id' => 0,
        'list_id' => 0,
        'subject' => '',
        'from_name' => '',
        'from_email' => '',
        '_token' => ''
    ];

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($campaign_data)
    {
        $this->campaign_data = $campaign_data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {   
        /** Obtenemos todos los grupos asociados a la lista. */
        $groups_ids = [];

        $groups = Groups::where('list_id', '=', $this->campaign_data['list_id'])->get();

        foreach( $groups as $group ) {
            array_push($groups_ids, $group->id);
        }

        $subscribers = Subscribers::whereIn('group_id', $groups_ids)->get();

        /** Enviamos la lista de correos del Job. */
        foreach( $subscribers as $subscriber ) {
            
            $this->campaign_data['subscriber_id'] = $subscriber->id;
            $this->campaign_data['emails_sended'] = count($subscribers);

            Mail::to($subscriber->email)->send(new CHormigaEmails($this->campaign_data));
        }

        /** Enviamos una notificación al cliente de que la campaña se envió con éxito. */
        Mail::to($this->campaign_data['email'])->send(new CampaignSendedNotify());
    }
}
