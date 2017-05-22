<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Services\Admin\BannerSettingService;
use App\Services\Admin\ArticleService;
use App\Models\MailTemplate;

class InviteFriendsController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->viewData['popularPost'] = ArticleService::getPopularPost($this->currentLocaleId);
        $this->viewData['banners'] = BannerSettingService::getBannerViaLocale($this->currentLocaleId);
        $this->viewData['url'] = str_replace('invite-friends', 'create', request()->url());
    }

    public function index()
    {
        $mail = MailTemplate::where('locale_id', $this->currentLocaleId)
            ->where('key', config('user.mail_template.invite_friends'))
            ->first();
        $this->viewData['subject'] = rawurlencode(str_replace('{username}', auth()->user()->name, $mail->subject));
        $content = str_replace('{username}', auth()->user()->name, $mail->content);
        $this->viewData['content'] = rawurlencode(str_replace('{referralId}', auth()->user()->invite_code, $content));

        return view('web.invite_friends.' . $this->currentLocale . '.content', $this->viewData);
    }
}
