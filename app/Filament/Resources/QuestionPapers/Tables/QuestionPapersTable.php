<?php

namespace App\Filament\Resources\QuestionPapers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class QuestionPapersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('university.name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('program.name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('semester')
                    ->sortable(),
                TextColumn::make('subject.name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('year')
                    ->sortable(),
                TextColumn::make('file_path')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('file_url')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
