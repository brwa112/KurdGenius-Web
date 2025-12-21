<?php

namespace App\Providers;

use App\Models\Pages\MailInformation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // $mail_information = MailInformation::first();
        // dd($mail_information);
        // if ($mail_information) {
        //     config([
        //         // 'mail.mailers.smtp.host' => $mail_information->host,
        //         'mail.mailers.smtp.port' => $mail_information->port,
        //         'mail.mailers.smtp.encryption' => $mail_information->encryption,
        //         'mail.mailers.smtp.username' => $mail_information->username,
        //         'mail.mailers.smtp.password' => decrypt($mail_information->password),
        //         'mail.from.address' => $mail_information->from_address,
        //         'mail.from.name' => $mail_information->from_name,
        //     ]);
        // }
        // try {
        // } catch (\Exception $e) {
        //     // Fallback to .env values if database not available
        // }
    }
}
