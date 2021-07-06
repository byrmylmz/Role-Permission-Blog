<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Article extends Model
{
    use HasFactory;
    protected $fillable=['title','full_text','category_id','user_id','published_at'];
    

    
    
    // For more information about belongs to 
    //https://stackoverflow.com/questions/57498767/whats-the-with-method-in-laravel
    //https://stackoverflow.com/questions/37582848/what-is-the-difference-between-belongsto-and-hasone-in-laravel
    public function user(){
        return $this->belongsTo(User::class);
    }
    


    /* THIS FUNCTION IS FOR TO FETCH DATA ACCORDING TO USER ID
        Only your articles you can see 
        This is global scope. instead of using where() in all funcitons. This function provide us global solution at one time.
    */
    protected static function booted()
    {    
        /**
         * we check the auth and is admin. 
         * Ogranization id aim is check for if organization id is exist or not.
         * If organization id exist use id or use user id.
         */
        if (auth()->check() && !auth()->user()->is_admin) {
            static::addGlobalScope('user', function (Builder $builder) {
                $organizationId = auth()->user()->organization_id ? auth()->user()->organization_id : auth()->id(); // 
                $builder->where('user_id', $organizationId);
            });
        }
    }
}
