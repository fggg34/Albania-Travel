<?php

namespace App\Filament\Resources\BlogPosts\Pages;

use App\Filament\Resources\BlogPosts\BlogPostResource;
use App\Models\BlogTag;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBlogPost extends EditRecord
{
    protected static string $resource = BlogPostResource::class;

    protected array $tagNamesToSync = [];

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['tags'] = $this->record->tags->pluck('name')->toArray();
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->tagNamesToSync = $data['tags'] ?? [];
        unset($data['tags']);
        return $data;
    }

    protected function afterSave(): void
    {
        $tagIds = collect($this->tagNamesToSync)
            ->map(fn ($name) => trim((string) $name))
            ->filter()
            ->map(fn ($name) => BlogTag::firstOrCreate(['name' => $name])->id)
            ->values()
            ->all();
        $this->record->tags()->sync($tagIds);
    }
}
