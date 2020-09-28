<?php

namespace App\Http\Controllers;

use DrewM\MailChimp\MailChimp;
use Illuminate\Http\Request;
use Spatie\Valuestore\Valuestore;
use App\User;


class MailchimpController extends Controller
{
    public function get(Request $request)
    {
        $v = Valuestore::make('config.json');

        return response()
            ->json($v->all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'api' => 'required',
            'list' => 'required'
        ]);

        $v = Valuestore::make('config.json');


        return response()
            ->json($v->put(['api' => $request->input('api'), 'list' => $request->input('list')]));

    }

    public function event(Request $request,User $user)
    {
        $v = Valuestore::make('config.json');

        $mailchimp = new MailChimp($v->get('api'));


        $hash = MailChimp::subscriberHash($user->email);

        $options=[
            'name' => 'Nieuweontlening',


            'properties' => ['artwork'=>'mona lisa']

        ];

        return response()
            ->json($mailchimp->post("lists/".$v->get('list')."/members/".$hash."/events", $options));

        $mailchimp->post("lists/".$v->get('list')."/members/".$hash."/events", $options);

        return response()
            ->json(['response' =>$mailchimp->getLastRequest() ] );


    }

}
