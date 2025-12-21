<?php

namespace Database\Seeders;

use App\Traits\GenerateSlugKey;
use Illuminate\Database\Seeder;
use App\Models\Pages\SocialLink;
use App\Models\System\Users\User;
use App\Models\Pages\PhoneNumbers;
use App\Models\Pages\MailInformation;
use App\Models\System\Users\UserSettings;
use Database\Seeders\RolePermissionSeeder;
use App\Models\System\Settings\Settings\Language;


class DatabaseSeeder extends Seeder
{
    use GenerateSlugKey;

    private const TEST_USER_DATA = [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
    ];

    public function run(): void
    {
        // DB::transaction(function () {
        $user = $this->createTestUser();
        // user types removed: createUserTypes() skipped
        // $this->createPermissions($user);
        $this->callAdditionalSeeders();
        $this->createUserSettings($user);
        $this->createDeveloperUser();
        $this->createTheme($user);
        $this->createSocialLinks();
        $this->createMailInformation();
    }

    private function createTheme($user): void
    {
        $themes = [
            ['name' => 'light', 'slug' => 'light'],
            ['name' => 'dark', 'slug' => 'dark'],
        ];

        foreach ($themes as $theme) {
            $user->theme()->firstOrCreate($theme);
        }
    }
    private function createSocialLinks()
    {
        $links = [
            'facebook' => 'https://www.facebook.com/safedatacompany',
            'telegram' => 'https://www.instagram.com/safedatacompany?igsh=MThvbmM4Zm80MDJ4eg==',
            'email' => 'info@safedatait.com',
            'instagram' => 'https://t.me/safedatacompany',
        ];
        SocialLink::create([
            'facebook' => $links['facebook'],
            'telegram' => $links['telegram'],
            'email' => $links['email'],
            'instagram' => $links['instagram'],
        ]);

        // PhoneNumbers::create([
        //     'phone_number' => '+9647762191',
        // ]);
    }

    // user types were removed from the system; seeding not required

    private function createTestUser(): User
    {
        $user = [
            [
                'name' => 'Super Admin',
                'email' => 'super@safedatait.com',
                'password' => 'password',
            ],
            [
                'name' => 'developer',
                'email' => 'developer@safedatait.com',
                'password' => 'password',
            ],
        ];

        foreach ($user as $key => $value) {
            User::firstOrCreate($value);
        }

        return User::first();
    }

    private function createDeveloperUser()
    {
        $user = User::where('email', 'developer@safedatait.com')->first();
        $this->createUserSettings($user);
    }



    private function createUserSettings(User $user): void
    {
        UserSettings::firstOrCreate(
            ['user_id' => $user->id],
            [
                'font_scale' => 'medium',
                'theme' => 'dark',
                'language_id' => Language::where('slug', 'en')->first()->id ?? null,
            ]
        );
    }

    public function createMailInformation()
    {

        MailInformation::create([
            'mailer' => 'smtp',
            'host' => 'smtp.gmail.com',
            'port' => 587,
            'username' => 'info@safedatait.com',
            'password' => 'xczlbdmjjroohqmu',
            'encryption' => 'tls',
            'from_address' => 'info@safedatait.com',
            'from_name' => 'SafeData IT Company',
        ]);
    }

    private function callAdditionalSeeders(): void
    {
        $this->call([
            TranslationsSeeder::class,
            RolePermissionSeeder::class,
        ]);
    }
}
