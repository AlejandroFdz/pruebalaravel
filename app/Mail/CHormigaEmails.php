<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\UserTemplates;
use App\UserComponents;
use App\Campaigns;
use App\EmailUrls;

use Log;

class CHormigaEmails extends Mailable
{
    use Queueable, SerializesModels;

    public $campaign_data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($campaign_data)
    {
      $this->campaign_data = $campaign_data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $template_id = $this->campaign_data['template_id'];

        $campaign_id = $this->campaign_data['campaign_id'];

        $campaign = Campaigns::find($campaign_id);
        $company = $campaign->company;

        $components = UserComponents::join('taxonomies', 'user_components.id', '=', 'taxonomies.id_component')
            ->where('taxonomies.id_template', '=', $template_id)
            ->orderBy('taxonomies.order', 'ASC')
            ->get();

        $user_template = UserTemplates::find($template_id);
        $default_template = $user_template->default_template_id;

        return $this->from(['address' => $this->campaign_data['from_email'], 'name' => $this->campaign_data['from_name']])
            ->subject($this->campaign_data['subject'])
            ->view('emails.templates.template' . $default_template, compact('company', $company))
            ->with(['campaign_data' => $this->campaign_data])
            ->with(['components' => $components]);
    }
}
