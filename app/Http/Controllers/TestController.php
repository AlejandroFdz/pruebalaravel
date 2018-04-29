<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\UserTemplates;
use App\UserComponents;
use App\Campaigns;

class TestController extends Controller
{
    public function show()
    {
    	$template_id = 5;

        $campaign_id = 2;

        $campaign = Campaigns::find($campaign_id);
        $company = $campaign->company;

        $components = UserComponents::join('taxonomies', 'user_components.id', '=', 'taxonomies.id_component')
            ->where('taxonomies.id_template', '=', $template_id)
            ->orderBy('taxonomies.order', 'ASC')
            ->get();

        return view('test.show')->with('components', $components);
    }
}
