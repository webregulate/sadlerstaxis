<?php

namespace App\Http\Controllers;

use App\Models\AboutPage;
use App\Models\AccountsPage;
use App\Models\CareersPage;
use App\Models\ContactPage;
use App\Models\HomePage;
use App\Models\PrivacyPolicyPage;
use App\Models\ServicesPage;
use App\Models\SiteSetting;
use Illuminate\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        return view('pages.home', [
            'page' => HomePage::current(),
            'settings' => SiteSetting::current(),
        ]);
    }

    public function about(): View
    {
        return view('pages.about', [
            'page' => AboutPage::current(),
        ]);
    }

    public function services(): View
    {
        return view('pages.services', [
            'page' => ServicesPage::current(),
        ]);
    }

    public function careers(): View
    {
        return view('pages.careers', [
            'page' => CareersPage::current()->load('applicationForm'),
        ]);
    }

    public function accounts(): View
    {
        return view('pages.accounts', [
            'page' => AccountsPage::current()->load('newAccountForm'),
        ]);
    }

    public function contact(): View
    {
        return view('pages.contact', [
            'page' => ContactPage::current()->load('contactForm'),
            'settings' => SiteSetting::current(),
        ]);
    }

    public function privacyPolicy(): View
    {
        return view('pages.privacy-policy', [
            'page' => PrivacyPolicyPage::current(),
        ]);
    }
}
