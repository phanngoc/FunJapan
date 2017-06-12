<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use App\Models\SocialAccount;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'description',
        'rank',
        'point',
        'login_count',
        'access_admin',
        'avatar',
        'gender',
        'birthday',
        'religion_id',
        'location_id',
        'locale_id',
        'invite_code',
        'subscription_new_letter',
        'subscription_reply_noti',
        'locale_id',
        'registered_by',
        'invite_user_id',
        'role_id',
        'access_api',
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

    protected $appends = [
        'avatar_url',
        'birthday_parse',
        'social',
    ];

    protected $dates = ['deleted_at'];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function interests()
    {
        return $this->belongsToMany(Category::class, 'interest_users', 'user_id', 'category_id')
            ->whereNull('interest_users.deleted_at')
            ->withTimestamps();
    }

    public function postPhotos()
    {
        return $this->hasMany(PostPhoto::class);
    }

    public function favoriteComments()
    {
        return $this->hasMany(FavoriteComment::class);
    }

    public function favoriteArticles()
    {
        return $this->hasMany(FavoriteArticle::class);
    }

    public function favoritePhotos()
    {
        return $this->hasMany(FavoritePhoto::class);
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function confirmPass($value)
    {
        return $this->attributes['password'] == Hash::make($value);
    }

    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            return null; //Do it latter
        }

        return null;
    }

    public function getSocialAttribute()
    {
        switch ($this->registered_by) {
            case config('user.social_provider.facebook'):
                return 'Facebook';
                break;
            default:
                return null;
        }
    }

    public static function getByCondition($conditions, $getOne = false)
    {
        $query = self::select('*');

        foreach ($conditions as $field => $value) {
            $query->where($field, $value);
        }

        if ($getOne) {
            return $query->first();
        }

        return $query->get();
    }

    public function getBirthdayParseAttribute()
    {
        $date = Carbon::parse($this->birthday);
        return $date;
    }

    public function registeredBySocial()
    {
        return $this->registered_by != 0;
    }

    public function deleteItAndRelation()
    {
        try {
            DB::beginTransaction();

            $this->comments()->each(function ($comment) {
                $comment->delete();
            });

            $this->postPhotos()->each(function ($postPhoto) {
                $postPhoto->delete();
            });

            $this->favoriteArticles()->each(function ($favoriteArticle) {
                $favoriteArticle->delete();
                $favoriteArticle->articleLocale->decrement('like_count');
            });

            $this->favoritePhotos()->each(function ($favoritePhoto) {
                $favoritePhoto->delete();
            });

            $favoriteComments = $this->favoriteComments();
            $favoriteComments->each(function ($favoriteComment) {
                if ($favoriteComment->comment) {
                    $favoriteComment->comment->decrement('favorite_count');
                }
            });

            InterestUser::where('user_id', $this->id)->delete();
            CouponUser::where('user_id', $this->id)->delete();
            Notification::where('sender_id', $this->id)
                ->orWhere('user_id', $this->id)
                ->delete();

            $favoriteComments->delete();
            $this->delete();

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function isNewUser()
    {
        return $this->created_at->isToday();
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function hasDefinePrivilege($permission)
    {
        if (!$permission || !$this->role) {
            return false;
        }

        return $this->role->hasDefinePrivilege($permission);
    }

    public function isAccessAdmin()
    {
        if (!$this->role) {
            return false;
        }

        return $this->role->isAccessAdmin();
    }
}
