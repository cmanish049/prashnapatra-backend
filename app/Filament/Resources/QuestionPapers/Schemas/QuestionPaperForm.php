<?php

namespace App\Filament\Resources\QuestionPapers\Schemas;

use App\Models\Subject;
use App\Models\University;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class QuestionPaperForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('university_id')
                    ->label('University')
                    ->options(University::query()->pluck('name', 'id'))
                    ->required()
                    ->live()
                    ->afterStateUpdated(function (Set $set): void {
                        $set('program_id', null);
                        $set('semester', null);
                        $set('subject_id', null);
                    }),

                Select::make('program_id')
                    ->label('Program')
                    ->options(function (Get $get) {
                        $universityId = $get('university_id');
                        if (! $universityId) {
                            return [];
                        }

                        return University::query()->find($universityId)
                            ?->programs()
                            ->pluck('programs.name', 'programs.id') ?? [];
                    })
                    ->required()
                    ->live()
                    ->disabled(fn (Get $get): bool => ! $get('university_id'))
                    ->afterStateUpdated(function (Set $set): void {
                        $set('semester', null);
                        $set('subject_id', null);
                    }),

                Select::make('semester')
                    ->options(function (Get $get) {
                        $universityId = $get('university_id');
                        $programId = $get('program_id');
                        if (! $universityId || ! $programId) {
                            return [];
                        }

                        return Subject::query()
                            ->where('university_id', $universityId)
                            ->where('program_id', $programId)
                            ->distinct()
                            ->pluck('semester', 'semester')
                            ->mapWithKeys(fn ($value): array => [$value => "Semester $value"])
                            ->toArray();
                    })
                    ->required()
                    ->live()
                    ->disabled(fn (Get $get): bool => ! $get('program_id'))
                    ->afterStateUpdated(fn (Set $set): mixed => $set('subject_id', null)),

                Select::make('subject_id')
                    ->label('Subject')
                    ->options(function (Get $get) {
                        $universityId = $get('university_id');
                        $programId = $get('program_id');
                        $semester = $get('semester');
                        if (! $universityId || ! $programId || ! $semester) {
                            return [];
                        }

                        return Subject::query()
                            ->where('university_id', $universityId)
                            ->where('program_id', $programId)
                            ->where('semester', $semester)
                            ->pluck('name', 'id');
                    })
                    ->required()
                    ->disabled(fn (Get $get): bool => ! $get('semester')),

                TextInput::make('year')
                    ->required(),
                TextInput::make('file_path'),
                TextInput::make('file_url')
                    ->url(),
            ]);
    }
}
