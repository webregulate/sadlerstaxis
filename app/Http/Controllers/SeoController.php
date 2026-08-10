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
use Illuminate\Http\Response;

class SeoController extends Controller
{
    public function sitemap(): Response
    {
        $pages = [
            ['url' => route('home'), 'lastmod' => HomePage::current()->updated_at, 'priority' => '1.0'],
            ['url' => route('about'), 'lastmod' => AboutPage::current()->updated_at, 'priority' => '0.8'],
            ['url' => route('services'), 'lastmod' => ServicesPage::current()->updated_at, 'priority' => '0.8'],
            ['url' => route('accounts'), 'lastmod' => AccountsPage::current()->updated_at, 'priority' => '0.7'],
            ['url' => route('careers'), 'lastmod' => CareersPage::current()->updated_at, 'priority' => '0.6'],
            ['url' => route('contact'), 'lastmod' => ContactPage::current()->updated_at, 'priority' => '0.7'],
            ['url' => route('privacy-policy'), 'lastmod' => PrivacyPolicyPage::current()->updated_at, 'priority' => '0.3'],
        ];

        return response()
            ->view('seo.sitemap', ['pages' => $pages])
            ->header('Content-Type', 'application/xml');
    }

    public function llmsTxt(): Response
    {
        $settings = SiteSetting::current();
        $home = HomePage::current();
        $about = AboutPage::current();
        $services = ServicesPage::current();

        $lines = [];
        $lines[] = '# '.$settings->site_name;
        $lines[] = '';
        $lines[] = '> '.($settings->tagline ?: 'A family-run taxi and private hire company.');
        $lines[] = '';

        if ($home->intro_text) {
            $lines[] = $this->plainText($home->intro_text);
            $lines[] = '';
        }

        $lines[] = '## Coverage area';
        $lines[] = '';
        $areas = collect($settings->phone_areas ?? [])->pluck('areaName')->filter()->implode(', ');
        if ($areas) {
            $lines[] = 'Serves: '.$areas.' (Epping Forest District, Essex, UK).';
            $lines[] = '';
        }

        $lines[] = '## Contact';
        $lines[] = '';
        if ($settings->primary_phone) {
            $lines[] = '- Phone: '.$settings->primary_phone;
        }
        if ($settings->email) {
            $lines[] = '- Email: '.$settings->email;
        }
        foreach (($settings->phone_areas ?? []) as $area) {
            if (! empty($area['areaName']) && ! empty($area['phoneNumbers'])) {
                $lines[] = '- '.$area['areaName'].' office: '.$area['phoneNumbers'];
            }
        }
        $lines[] = '';

        if (! empty($services->services)) {
            $lines[] = '## Services';
            $lines[] = '';
            foreach ($services->services as $service) {
                if (! empty($service['title'])) {
                    $lines[] = '- **'.$service['title'].'**: '.($service['description'] ?? '');
                }
            }
            $lines[] = '';
        }

        if ($about->history_text) {
            $lines[] = '## History';
            $lines[] = '';
            $lines[] = $this->plainText($about->history_text);
            $lines[] = '';
        }

        $lines[] = '## Pages';
        $lines[] = '';
        $lines[] = '- ['.$home->hero_heading.']('.route('home').'): Homepage, booking links and an overview of the business.';
        $lines[] = '- [About Us & History]('.route('about').'): Company background, founded '.'1869.';
        $lines[] = '- [Services]('.route('services').'): Vehicle types and licensing information.';
        $lines[] = '- [Business & Personal Accounts]('.route('accounts').'): Account signup for regular/corporate customers.';
        $lines[] = '- [Careers]('.route('careers').'): Driver vacancies and how to apply.';
        $lines[] = '- [Contact]('.route('contact').'): Contact form and office phone numbers.';
        $lines[] = '- [Privacy Policy]('.route('privacy-policy').'): Data protection and privacy information.';

        return response(implode("\n", $lines), 200)
            ->header('Content-Type', 'text/plain; charset=utf-8');
    }

    private function plainText(string $html): string
    {
        return html_entity_decode(strip_tags(str_replace('</p>', "\n", $html)), ENT_QUOTES);
    }
}
