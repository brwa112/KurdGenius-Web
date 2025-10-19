<?php

namespace App\Imports;


use Illuminate\Support\Collection;

use App\Models\System\Settings\Settings\Key;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\System\Settings\Settings\Translations;

class TranslationsImport implements ToCollection
{
       protected $language_id;

    public function __construct($language_id)
    {
        $this->language_id = $language_id;
    }

    public function collection(Collection $rows)
    {
        // Flatten all values (in case Excel gives multiple columns, only take the first column per row)
        $values = $rows->map(function($row) {
            return $row[1] ?? null;
        })->filter()->values();

        // Get all keys ordered by ID (change order if needed!)
        $keys = Key::orderBy('id')->get();

        // Make sure counts match
        $count = min($keys->count(), $values->count());

        for ($i = 0; $i < $count; $i++) {
            $key = $keys[$i];
            $value = $values[$i];

            Translations::updateOrCreate(
                [
                    'key_id' => $key->id,
                    'language_id' => $this->language_id,
                ],
                [
                    'value' => $value,
                ]
            );
        }
    }

}
