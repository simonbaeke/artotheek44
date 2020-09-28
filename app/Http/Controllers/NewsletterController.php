<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Newsletter;
use Spatie\Valuestore\Valuestore;
use DrewM\MailChimp\MailChimp;
use DrewM\MailChimp\Batch;

class NewsletterController extends Controller
{
    public function subscribe(Request $request, User $user)
    {

        $result = (Newsletter::subscribe($user->email, ['FNAME' => $user->firstname, 'LNAME' => $user->lastname]));

        return response()
            ->json(['result' => $result]);

    }

    public function addTag(Request $request, User $user)
    {
        $request->validate([
            'tag' => 'required'
        ]);

        return Newsletter::addTags([$request->input('tag')], $user->email);
    }

    public function isSubscribed(User $user)
    {
        return response()
            ->json(['result' => Newsletter::isSubscribed($user->email)]);
    }

    public function getError()
    {

        $v = Valuestore::make('config.json', ['key' => 'value']);
        $v->put('listkey', 'e0b7334c89');
        return response()
            ->json($v);
        return response()
            ->json(['result' => Newsletter::getApi()]);
    }

    public function storeAll()
    {
        $users = User::all();
        $v = Valuestore::make('config.json');

        $MailChimp = new MailChimp($v->get('api'));
        $Batch = $MailChimp->new_batch();

        //$options = $this->getSubscriptionOptions($email, $mergeFields, $options);

        foreach ($users as $user) {
            $Batch->put($user->email, "lists/" . $v->get('list') . "/members/{$this->getSubscriberHash($user->email)}",
                $this->getSubscriptionOptions($user->email, ['FNAME' => $user->firstname, 'LNAME' => $user->lastname], []));


            //tags
            $roles = $user->roles->pluck('name');

            $payload = collect($roles)->map(function ($tag) {
                return ['name' => $tag, 'status' => 'active'];
            })->toArray();

            $Batch->post($user->email . 'tag',"lists/{$v->get('list')}/members/{$this->getSubscriberHash($user->email)}/tags", [
                'tags' => $payload,
            ]);

        }

        return response()
            ->json(['result' =>   $Batch->execute()]);
    }

    public function getMembers(){
        return response()
            ->json(Newsletter::getMembers('subscribers',['count' => 1000]));
    }

    public function getBatchStatus(Request $request){
        $request->validate([
            'id' => 'required'
        ]);

        $v = Valuestore::make('config.json');

        $MailChimp = new MailChimp($v->get('api'));
        $Batch = $MailChimp->new_batch();

        return response()
            ->json(['result' => $Batch->check_status($request->input('id'))]);
    }

    protected function getSubscriptionOptions(string $email, array $mergeFields, array $options): array
    {
        $defaultOptions = [
            'email_address' => $email,
            'status' => 'subscribed',
            'email_type' => 'html',
        ];

        if (count($mergeFields)) {
            $defaultOptions['merge_fields'] = $mergeFields;
        }

        $options = array_merge($defaultOptions, $options);

        return $options;
    }


    protected function getSubscriberHash(string $email): string
    {
        return  md5(strtolower($email));
    }



}
