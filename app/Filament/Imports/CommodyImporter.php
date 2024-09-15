<?php

namespace App\Filament\Imports;

use App\Models\Commody;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Facades\DB;

class CommodyImporter extends Importer
{
    protected static ?string $model = Commody::class;
    public static function getColumns(): array
    {
        DB::table('commodies')->delete();
        return [
            ImportColumn::make('name')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('category')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('unit')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('spot')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('wow')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('mom')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('ytd')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
        ];
    }
    public function resolveRecord(): ?Commody
    {

        // return Commody::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new Commody();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your commody import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
