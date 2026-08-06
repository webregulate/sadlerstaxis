<?php

namespace Database\Seeders;

use App\Models\AboutPage;
use App\Models\AccountsPage;
use App\Models\CareersPage;
use App\Models\ContactPage;
use App\Models\Form;
use App\Models\HomePage;
use App\Models\PrivacyPolicyPage;
use App\Models\ServicesPage;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SadlersTaxisSeeder extends Seeder
{
    private const BUSINESS_EMAIL = 'info@sadlerstaxis.co.uk';

    public function run(): void
    {
        $this->seedAdminUser();
        $this->seedSiteSettings();
        $this->seedHomePage();
        $this->seedAboutPage();
        $this->seedServicesPage();

        $contactForm = $this->seedContactForm();
        $newAccountForm = $this->seedNewAccountForm();
        $driverForm = $this->seedDriverApplicationForm();

        $this->seedCareersPage($driverForm);
        $this->seedAccountsPage($newAccountForm);
        $this->seedContactPage($contactForm);
        $this->seedPrivacyPolicyPage();
    }

    private function seedAdminUser(): void
    {
        if (User::query()->exists()) {
            $this->command?->info('Admin user already exists, skipping.');

            return;
        }

        $password = Str::random(12);

        User::create([
            'name' => 'Sadlers Taxis Admin',
            'email' => self::BUSINESS_EMAIL,
            'password' => bcrypt($password),
        ]);

        $this->command?->warn("Created admin login — email: ".self::BUSINESS_EMAIL." / password: {$password}");
    }

    private function seedSiteSettings(): void
    {
        SiteSetting::query()->delete();

        SiteSetting::create([
            'site_name' => 'Sadlers Taxis',
            'tagline' => 'A family business since 1869',
            'show_warning_banner' => true,
            'warning_banner' => 'Not all taxis operating out of Loughton Station are Sadlers taxis, some are independent and are dearer than Sadlers taxis. To book a taxi please go into our office or see our taxi marshal and they will guide you to the appropriate vehicle.',
            'primary_phone' => '020 8508 6600',
            'email' => self::BUSINESS_EMAIL,
            'phone_areas' => [
                ['areaName' => 'Buckhurst Hill', 'phoneNumbers' => '020 8504 9999'],
                ['areaName' => 'Chigwell', 'phoneNumbers' => '020 8500 7777 / 020 8501 2222'],
                ['areaName' => 'Chingford', 'phoneNumbers' => '020 8524 7777'],
                ['areaName' => 'Debden', 'phoneNumbers' => '020 8502 5555'],
                ['areaName' => 'Epping', 'phoneNumbers' => '01992 571111 / 01992 572222'],
                ['areaName' => 'Loughton', 'phoneNumbers' => '020 8508 6600'],
                ['areaName' => 'Woodford', 'phoneNumbers' => '020 8505 1111'],
            ],
            'book_online_url' => 'http://www.sadlerstaxis-online.com/consumer/#/booking',
            'account_booking_url' => 'http://www.sadlerstaxis-online.com/corporate',
            'ios_app_url' => 'https://itunes.apple.com/us/app/sadlers-taxis-minicabs/id581878298?mt=8',
            'android_app_url' => 'https://play.google.com/store/apps/details?id=com.cordic.loughton.sadlers',
            'footer_copyright_name' => 'SadlersTaxis(UK) Ltd',
        ]);
    }

    private function seedHomePage(): void
    {
        HomePage::query()->delete();

        HomePage::create([
            'hero_heading' => 'Welcome to Sadlers Taxis',
            'hero_subheading' => 'Serving Abridge, Buckhurst Hill, Chigwell, Chingford, Debden, Epping, Loughton, Nazing, North Weald, Roydon, Sheering, Theydon Bois, Upshire, Waltham Abbey, Woodford and Sawbridgeworth since 1869.',
            'intro_text' => '<p>Sadler&rsquo;s Taxi call centre is located centrally within the Epping Forest District and controls our entire fleet of taxis ranked at various locations. When you call us our controllers will enter your booking through our state-of-the-art computerised despatch system, which will automatically send the nearest vehicle to you.</p><p>Our driver will receive your request directly via the in-car computer, and their satellite navigation will automatically give directions for the quickest route to pick you up and take you to your destination. Once you have called us and registered, our &ldquo;Caller ID&rdquo; will recognise your number the next time you call, making it even quicker to book future taxis.</p>',
            'highlights' => [
                ['title' => 'State-of-the-Art Dispatch', 'description' => 'Bookings are sent straight to the nearest driver through our computerised despatch system.'],
                ['title' => 'Satellite Navigation', 'description' => "Every driver's in-car computer gives them the quickest route to you automatically."],
                ['title' => 'Caller ID Recognition', 'description' => 'We recognise your number next time you call, making repeat bookings even faster.'],
                ['title' => 'A Vehicle For Every Trip', 'description' => 'Saloons, estates and 8-seater MPVs available across the whole fleet.'],
                ['title' => 'Licensed & Vetted Drivers', 'description' => 'All drivers are licensed by Epping Forest District Council and DBS-checked.'],
                ['title' => '12 Areas Covered', 'description' => 'From Abridge and Loughton to Waltham Abbey and Woodford.'],
            ],
            'meta_title' => 'Sadlers Taxis — Taxis in Loughton, Chigwell & the Epping Forest District',
            'meta_description' => 'Family-run taxi and private hire company covering the Epping Forest District since 1869. Book online or call your local office.',
        ]);
    }

    private function seedAboutPage(): void
    {
        AboutPage::query()->delete();

        AboutPage::create([
            'heading' => 'About Us & History',
            'intro_text' => '<p>Sadler&rsquo;s Taxi call centre is located centrally within the Epping Forest District and controls our entire fleet of taxis ranked at various locations around Abridge, Buckhurst Hill, Chigwell, Chingford, Debden, Epping, Loughton, Nazing, North Weald, Sheering, Roydon, Theydon Bois, Upshire, Waltham Abbey, Woodford and Sawbridgeworth.</p><p>When you call us our controllers will enter your booking through our state-of-the-art computerised despatch system, which will automatically send the nearest vehicle to you. Our driver will receive your request directly via the in-car computer, and their satellite navigation will automatically give the directions for the quickest route to pick you up and take you to your destination. Once you have called us and registered, our &ldquo;Caller ID&rdquo; will recognise your number the next time you call and make it even quicker for you to book future taxis.</p>',
            'history_heading' => 'History',
            'history_text' => '<p>Sadler&rsquo;s Taxis is one of the oldest family run businesses in the Epping Forest District, established around 1869/1870 by Mr William Sadler. William used the stables and yards either side of the old Crown public house in Loughton, now the site of Marks &amp; Spencer and Tom, Dick and Harry&rsquo;s.</p><p>Our taxis have provided the area with a first-class, safe, affordable service from the early horse-drawn hackneys to the area&rsquo;s first petrol engine taxi, driven in the 1920s by Mr F.P. Sadler, grandfather to Phil &amp; Peter Sadler, two of the current directors.</p><p>Upon leaving the army after the Second World War, Mr F.P. Sadler junior, known as Phil, took over control of the firm and, with his brother John, expanded the business with London black taxis licensed by the carriage office. Together they began to build a modern, reliable taxi service from their taxi rank at Loughton Station.</p><p>Telephone calls were taken at Phil&rsquo;s house and jobs were dispatched by an early Pye two-way radio system. By the 1970s, Sadler&rsquo;s Taxis had moved into the old bus canteen at Loughton Station. The introduction of private hire cars proved very popular with the public.</p><p>In 1983, Phil &amp; Peter Sadler took over upon the retirement of their father Phil. They carried on with the same values and continued to expand the business using the latest technology available. Sadler&rsquo;s Taxis moved to their present office in Loughton Station in 2001.</p><p>In September 2006, Phil &amp; Peter Sadler were pleased to welcome Mr Paul Nelson and Mr Tim Western to the board of directors. A state-of-the-art computer system has since been introduced, incorporating sat nav and passenger call-back to our modern fleet of taxis. We will continue to embrace modern technology to provide a first-class service to our customers, old and new.</p>',
            'history_gallery' => [
                ['path' => 'media/about-history/sadlers-taxis-history-1.gif', 'caption' => 'Sadlers Taxis — Loughton, 1870'],
                ['path' => 'media/about-history/sadlers-taxis-history-2.gif', 'caption' => 'Sadlers Taxis — Loughton, 1870'],
            ],
            'meta_title' => 'About Us & History — Sadlers Taxis',
            'meta_description' => 'Sadlers Taxis has served the Epping Forest District since 1869 — read about our family history.',
        ]);
    }

    private function seedServicesPage(): void
    {
        ServicesPage::query()->delete();

        ServicesPage::create([
            'heading' => 'Services',
            'intro_text' => '<p>We have a large fleet of owner-driver and company vehicles, ranging from saloons and estate cars up to 8-seater MPVs.</p>',
            'services' => [
                ['title' => 'Saloon Cars', 'description' => 'Comfortable, everyday rides for individuals and small groups.'],
                ['title' => 'Estate Cars', 'description' => 'Extra luggage space for the airport run or a big shop.'],
                ['title' => '8-Seater MPVs', 'description' => 'Perfect for larger groups, families or nights out.'],
                ['title' => 'Licensed & Vetted', 'description' => 'All vehicles and drivers are licensed by Epping Forest District Council, with drivers screened by the criminal records agency and the taxi licensing department.'],
                ['title' => 'Regularly Tested Vehicles', 'description' => 'Every vehicle is stringently tested every four months by Epping Forest District Council.'],
            ],
            'meta_title' => 'Services — Sadlers Taxis',
            'meta_description' => 'Saloons, estates and 8-seater MPVs — licensed, vetted and regularly tested.',
        ]);
    }

    private function seedContactForm(): Form
    {
        return Form::create([
            'name' => 'Contact Form',
            'fields' => [
                ['type' => 'text', 'name' => 'name', 'label' => 'Name', 'required' => true],
                ['type' => 'email', 'name' => 'email', 'label' => 'Email', 'required' => true],
                ['type' => 'text', 'name' => 'subject', 'label' => 'Subject', 'required' => true],
                ['type' => 'textarea', 'name' => 'message', 'label' => 'Message', 'required' => true],
            ],
            'submit_button_label' => 'Send Message',
            'confirmation_message' => "Thanks for contacting Sadlers Taxis — we'll get back to you as soon as possible.",
            'notify_email' => self::BUSINESS_EMAIL,
            'subject_template' => 'New contact form submission: {{subject}}',
            'message_template' => "New message from {{name}} ({{email}}):\n{{message}}",
        ]);
    }

    private function seedNewAccountForm(): Form
    {
        return Form::create([
            'name' => 'New Business Account Application',
            'fields' => [
                ['type' => 'heading', 'label' => 'Company Details'],
                ['type' => 'text', 'name' => 'company_name', 'label' => 'Company Name', 'required' => true],
                ['type' => 'textarea', 'name' => 'address', 'label' => 'Address', 'required' => true],
                ['type' => 'text', 'name' => 'post_code', 'label' => 'Post Code', 'required' => true],
                ['type' => 'email', 'name' => 'email', 'label' => 'Email', 'required' => true],
                ['type' => 'text', 'name' => 'tel_number', 'label' => 'Telephone Number', 'required' => true],
                ['type' => 'text', 'name' => 'fax_number', 'label' => 'Fax Number', 'required' => false],
                ['type' => 'heading', 'label' => 'Accounts Department (if different from above)'],
                ['type' => 'text', 'name' => 'acct_contact_name', 'label' => 'Contact Name', 'required' => false],
                ['type' => 'textarea', 'name' => 'acct_address', 'label' => 'Address', 'required' => false],
                ['type' => 'text', 'name' => 'acct_post_code', 'label' => 'Post Code', 'required' => false],
                ['type' => 'email', 'name' => 'acct_email', 'label' => 'Email', 'required' => false],
                ['type' => 'text', 'name' => 'acct_tel_number', 'label' => 'Telephone Number', 'required' => false],
                ['type' => 'text', 'name' => 'acct_fax_number', 'label' => 'Fax Number', 'required' => false],
                ['type' => 'heading', 'label' => 'Trade Reference 1'],
                ['type' => 'text', 'name' => 'ref1_company_name', 'label' => 'Company Name', 'required' => true],
                ['type' => 'textarea', 'name' => 'ref1_address', 'label' => 'Address', 'required' => true],
                ['type' => 'text', 'name' => 'ref1_tel_number', 'label' => 'Telephone Number', 'required' => true],
                ['type' => 'heading', 'label' => 'Trade Reference 2'],
                ['type' => 'text', 'name' => 'ref2_company_name', 'label' => 'Company Name', 'required' => true],
                ['type' => 'textarea', 'name' => 'ref2_address', 'label' => 'Address', 'required' => true],
                ['type' => 'text', 'name' => 'ref2_tel_number', 'label' => 'Telephone Number', 'required' => true],
            ],
            'submit_button_label' => 'Submit Application',
            'confirmation_message' => "Thank you — your account application has been received. We'll be in touch shortly to confirm your new account.",
            'notify_email' => self::BUSINESS_EMAIL,
            'subject_template' => 'New business account application: {{company_name}}',
            'message_template' => "A new account application was submitted by {{company_name}}.\nContact email: {{email}}\nTelephone: {{tel_number}}",
        ]);
    }

    private function seedDriverApplicationForm(): Form
    {
        return Form::create([
            'name' => 'Driver Application',
            'fields' => [
                ['type' => 'text', 'name' => 'full_name', 'label' => 'Full Name', 'required' => true],
                ['type' => 'text', 'name' => 'phone', 'label' => 'Phone Number', 'required' => true],
                ['type' => 'email', 'name' => 'email', 'label' => 'Email', 'required' => true],
                [
                    'type' => 'select',
                    'name' => 'area',
                    'label' => 'Preferred Area',
                    'required' => true,
                    'options' => [
                        ['label' => 'Loughton', 'value' => 'loughton'],
                        ['label' => 'Debden', 'value' => 'debden'],
                        ['label' => 'Epping', 'value' => 'epping'],
                        ['label' => 'Theydon Bois', 'value' => 'theydon-bois'],
                        ['label' => 'Buckhurst Hill', 'value' => 'buckhurst-hill'],
                        ['label' => 'Chigwell', 'value' => 'chigwell'],
                        ['label' => 'Chingford', 'value' => 'chingford'],
                        ['label' => 'Other', 'value' => 'other'],
                    ],
                ],
                [
                    'type' => 'select',
                    'name' => 'driver_type',
                    'label' => 'Owner or Company Driver',
                    'required' => true,
                    'options' => [
                        ['label' => 'Owner Driver', 'value' => 'owner-driver'],
                        ['label' => 'Company Driver', 'value' => 'company-driver'],
                    ],
                ],
                [
                    'type' => 'select',
                    'name' => 'hours',
                    'label' => 'Full-time or Part-time',
                    'required' => true,
                    'options' => [
                        ['label' => 'Full-time', 'value' => 'full-time'],
                        ['label' => 'Part-time', 'value' => 'part-time'],
                    ],
                ],
                ['type' => 'textarea', 'name' => 'message', 'label' => 'Tell us a bit about yourself', 'required' => false],
            ],
            'submit_button_label' => 'Send Application',
            'confirmation_message' => 'Thanks for your interest in driving with Sadlers Taxis — Peter will be in touch soon.',
            'notify_email' => self::BUSINESS_EMAIL,
            'subject_template' => 'New driver application: {{full_name}}',
            'message_template' => "New driver application from {{full_name}}.\nPhone: {{phone}} — Email: {{email}}\nArea: {{area}} — Type: {{driver_type}} — Hours: {{hours}}\n{{message}}",
        ]);
    }

    private function seedCareersPage(Form $applicationForm): void
    {
        CareersPage::query()->delete();

        CareersPage::create([
            'heading' => 'Careers',
            'intro_text' => '<p>We currently have vacancies for owner or company drivers, full or part-time, in Loughton, Debden, Epping, Theydon Bois, Buckhurst Hill, Chigwell and Chingford. If you are interested in joining our friendly and busy taxi company, get in touch below or apply using the form.</p>',
            'contact_name' => 'Peter Sadler',
            'contact_phone' => '020 8508 6600',
            'contact_email' => self::BUSINESS_EMAIL,
            'application_form_id' => $applicationForm->id,
            'meta_title' => 'Careers — Sadlers Taxis',
            'meta_description' => 'We have driver vacancies across the Epping Forest District — apply today.',
        ]);
    }

    private function seedAccountsPage(Form $newAccountForm): void
    {
        AccountsPage::query()->delete();

        AccountsPage::create([
            'heading' => 'Business & Personal Accounts',
            'intro_text' => "<p>Opening an account with Sadlers Taxis couldn't be simpler. We offer both business and personal accounts — register using the form below and one of the team will be in touch.</p>",
            'benefits' => [
                ['title' => 'Monthly Invoicing', 'description' => 'One consolidated invoice sent at the end of each month, payable within 14 days.'],
                ['title' => 'Priority Booking', 'description' => 'Account holders go straight through to our despatch system.'],
                ['title' => 'Detailed Journey Records', 'description' => 'Keep track of business travel for expenses and reporting.'],
                ['title' => 'Personal or Business', 'description' => 'Accounts are available for individuals as well as companies.'],
            ],
            'terms_text' => '<p>Invoices will be sent at the end of each month, payable within 14 days. If invoices are not paid within 14 days we reserve the right to charge a 5% administration fee on future invoices.</p>',
            'new_account_form_id' => $newAccountForm->id,
            'meta_title' => 'Business & Personal Accounts — Sadlers Taxis',
            'meta_description' => 'Open a business or personal account with Sadlers Taxis for monthly invoicing and priority booking.',
        ]);
    }

    private function seedContactPage(Form $contactForm): void
    {
        ContactPage::query()->delete();

        ContactPage::create([
            'heading' => 'Contact Us',
            'intro_text' => "<p>Please use the form below to get in touch with us, or if you'd prefer to speak to someone, call one of the numbers below.</p>",
            'contact_form_id' => $contactForm->id,
            'office_address' => 'Sadlers Taxis, Loughton Station, Loughton, Essex',
            'meta_title' => 'Contact Us — Sadlers Taxis',
            'meta_description' => 'Get in touch with Sadlers Taxis by form, phone or email.',
        ]);
    }

    private function seedPrivacyPolicyPage(): void
    {
        PrivacyPolicyPage::query()->delete();

        $sections = [
            ['h2' => '1. Information We Collect', 'p' => 'We collect information to provide and improve our taxi booking and related services.'],
            ['h3' => 'a. Personal Information', 'p' => 'Contact Information: name, email address, phone number, and billing address, when you book a taxi or create an account. Payment Information: credit/debit card details or other payment information processed through our secure payment processor when you pay for a ride. Location Data: if you enable location services on our app, we collect precise geolocation data to facilitate taxi bookings, track your ride, and provide accurate pickup/drop-off services. Account Information: username, password, and preferences if you create an account.'],
            ['h3' => 'b. Non-Personal Information', 'p' => 'Usage Data: information about how you interact with our Service. Device Information: IP address, device type, operating system, browser type, and unique device identifiers. Cookies and Tracking Technologies: we use cookies and similar technologies to enhance your experience, analyse usage, and deliver personalised content.'],
            ['h3' => 'c. Third-Party Data', 'p' => 'We may receive data from third-party services, such as Google Analytics for usage statistics and Google Maps for location services, which may include anonymised or aggregated data about your interactions with our Service.'],
            ['h2' => '2. How We Use Your Information', 'p' => 'We use your information to provide and manage taxi booking services, communicate with you about your bookings, account, or customer support enquiries, improve our Service, personalise your experience, and comply with legal obligations such as tax or regulatory requirements.'],
            ['h2' => '3. How We Share Your Information', 'p' => 'We do not sell your personal information. We may share it with drivers (to facilitate your booking), service providers (payment processors, cloud hosting, analytics, mapping services), legal authorities where required by law, and an acquiring entity in the event of a merger, acquisition or sale of assets.'],
            ['h2' => '4. Legal Basis for Processing (UK GDPR)', 'p' => 'We process your personal data on the basis of contract, consent, legitimate interests, and legal obligation.'],
            ['h2' => '5. Data Retention', 'p' => 'We retain your personal information only for as long as necessary to fulfil the purposes outlined in this Privacy Policy, unless a longer retention period is required by law.'],
            ['h2' => '6. Your Rights', 'p' => 'Under the UK GDPR you have the right to access, rectify, erase, restrict processing of, port, and object to processing of your personal data, and to withdraw consent at any time. To exercise your rights, contact us at info@sadlerstaxis.co.uk. You may also lodge a complaint with the UK Information Commissioner’s Office (ICO) at www.ico.org.uk.'],
            ['h2' => '7. Cookies and Tracking Technologies', 'p' => 'Our website and app use essential, analytics and functional cookies to enhance functionality and analyse performance. You can manage cookie preferences through your browser settings.'],
            ['h2' => '8. Data Security', 'p' => 'We implement reasonable technical and organisational measures to protect your data, including encryption of sensitive data in transit and at rest, secure cloud storage, and access controls.'],
            ['h2' => '9. International Data Transfers', 'p' => 'Your data may be transferred to and stored in countries outside the UK. We ensure such transfers comply with UK GDPR through adequacy decisions, Standard Contractual Clauses, or other safeguards as required by law.'],
            ['h2' => '10. Third-Party Links', 'p' => 'Our Service may contain links to third-party websites or services. We are not responsible for their privacy practices.'],
            ['h2' => '11. Children’s Privacy', 'p' => 'Our Service is not intended for children under 13. We do not knowingly collect personal information from children under 13 without verifiable parental consent.'],
            ['h2' => '12. Changes to This Privacy Policy', 'p' => 'We may update this Privacy Policy to reflect changes in our practices or legal requirements. We will notify you of material changes by posting the updated policy on our website and app.'],
            ['h2' => '13. Contact Us', 'p' => 'If you have questions, concerns, or requests regarding this Privacy Policy or our data practices, please contact us at Sadlers Taxis, info@sadlerstaxis.co.uk.'],
        ];

        $intro = '<p>Sadlers Taxis ("we," "us," or "our") operates the website sadlerstaxis.co.uk and the Sadlers Taxis mobile application (collectively, the "Service"). We are committed to protecting your privacy and ensuring the security of your personal information. This Privacy Policy explains how we collect, use, disclose, and protect your personal data when you use our Service, in compliance with the UK General Data Protection Regulation (UK GDPR), the Data Protection Act 2018, and other applicable laws.</p><p>By using our Service, you agree to the collection and use of information in accordance with this Privacy Policy. If you do not agree, please do not use our Service.</p>';

        $html = $intro;
        foreach ($sections as $section) {
            $tag = isset($section['h2']) ? 'h2' : 'h3';
            $heading = $section[$tag];
            $html .= "<{$tag}>{$heading}</{$tag}><p>{$section['p']}</p>";
        }

        PrivacyPolicyPage::create([
            'heading' => 'Privacy Policy',
            'last_updated' => '2025-05-08',
            'content' => $html,
        ]);
    }
}
