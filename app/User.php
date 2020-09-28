<?php

namespace App;

use App\Http\Filter\Filterable;
use App\Http\Filter\UserFilter;
use App\Notifications\MailResetPasswordNotification;
use DrewM\MailChimp\MailChimp;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Newsletter;
use Spatie\Valuestore\Valuestore;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable, HasRoles, Filterable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'email', 'password', 'email_verified_at', 'phone', 'memberid'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getFullNameAttribute()
    {
        return "{$this->firstname} {$this->lastname}";
    }

    public function subscriptions()
    {
        return $this->hasMany('App\Subscription');
    }

    public function preferences()
    {
        return $this->hasOne('App\Preference');
    }

    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    public function invoices()
    {
        return $this->hasMany('App\Invoice');
    }

    public function artworks()
    {
        return $this->belongsToMany('App\Artwork','artwork_user');
    }

    public function scopeOntlener($query)
    {
        return $query->role('ontlener');
    }

    public function scopeAdmin($query)
    {
        return $query->role('admin');
    }

    public function scopeFilter(Builder $builder, UserFilter $filter)
    {
        $filter->apply($builder);
    }

    public function activated()
    {
        return $this->email_verified_at != null;
    }

    public function address()
    {
        return $this->hasOne(Address::class);
    }

    public function givenVouchers()
    {
        return $this->hasMany('App\Voucher', 'from_id');
    }

    public function receivedVouchers()
    {
        return $this->hasMany('App\Voucher', 'to_id');
    }

    public function phoneNumbers()
    {
        return $this->hasMany('App\PhoneNumber');
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MailResetPasswordNotification($token));
    }


    public function mailchimpSubscribe(){

        Newsletter::subscribe($this->email, ['FNAME' => $this->firstname, 'LNAME' => $this->lastname]);

        return true;
    }

    public function mailchimpUnsubscribe(){

    }

    public function mailchimpAddTag($tag){
        Newsletter::addTags([$tag], $this->email);

        return true;

    }

    public function mailchimpRemoveTag($tag){

        Newsletter::removeTags([$tag], $this->email);

        return true;
    }

    public function sendMailchimp($array){
        $v = Valuestore::make('config.json');

        $mailchimp = new MailChimp($v->get('api'));



        $hash = MailChimp::subscriberHash($this->email);

        $mailchimp->post("lists/".$v->get('list')."/members/".$hash."/events", $array);

    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new Notifications\VerifyEmail);
    }
}
