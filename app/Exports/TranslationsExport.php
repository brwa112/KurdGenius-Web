<?php

namespace App\Exports;


use App\Enums\Language;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\System\Settings\Settings\Translations;

class TranslationsExport implements FromCollection, WithHeadings
{
    protected $language;

    public function __construct($language)
    {
        $this->language = $language;
    }

    public function collection()
    {
        $en_language_id = Language::ENGLISH->value;
        return Translations::withoutGlobalScopes() // prevent deleted_at scope error
            ->from('translations as t_en')
            ->leftJoin('translations as t_tr', function ($join) {
                $join->on('t_tr.key_id', '=', 't_en.key_id')
                    ->where('t_tr.language_id', '=', $this->language);
            })
            ->where('t_en.language_id', $en_language_id) // English language_id
            ->select([
                't_en.value as english',
                't_tr.value as translated'
            ])
            ->get();
    }


    public function headings(): array
    {
        return ['English', 'Translated'];
    }
}
