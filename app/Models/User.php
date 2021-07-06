<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'role_id',
        'organization_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
     public function getRoleIdAttribute(){
        if (session('organization_role_id')){
            return session('organization_role_id');
        }

        return $this->attributes['role_id'];
     }

    //bay For more information check the link https://laravel.com/docs/8.x/eloquent-mutators#accessors-and-mutators
    // GetIsAdminAttribute=is_admin
    // GetIsPublisherAttribute=is_publisher
    public function getIsAdminAttribute(){
        return $this->role_id==2; // is_admin= role_id=2
    }


    public function getIsPublisherAttribute(){
        return $this->role_id==3; // is_publisher=role_id=3
    }
    
    // organization function use at app\Http\Controllers\JoinController.php
    public function organizations(){
        // https://laravel.com/docs/8.x/eloquent-relationships#many-to-many
        // belongsToMany(table1,table2,table1_id,table2_id)
        /**
         * For mor information about pivot table in laravel
         * https://gist.github.com/Braunson/8b18b7fc7efd0890136ce5e46452ec72#:~:text=A%20pivot%20table%20is%20used,can%20use%20a%20pivot%20table.
         * https://laravel.com/docs/8.x/eloquent-relationships#syncing-associations
         */
        return $this->belongsToMany(user::class, 'organization_user','user_id','organization_id')->withPivot(['role_id']);
        // withpivot allow us to attach an organization and specify role id
    }

    //getOrganizaionIdAttribute = organization_id 
    public function getOrganizationIdAttribute(){
        // organization id added to session so when we change the organization on UI it will be save on string ann shown on the UI
        // app\Http\Controllers\JoinController.php * organization function will change the organization and seave it to session.
        // Then here we are gonna check the organization if exitst or not then accordingly arrange it.
        if(session('organization_id')){
            return session('organization_id');
        }

        $organization = $this->organizations()->firts();
        if($organization){
            session(['organization_id'=>$organization->id,'organization_name'=>$organization->name]);
            return $organization->id;
        }

        return NULL;

    }
}
