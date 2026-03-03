<?php

namespace App\Filament\Resources\BlogPosts\Pages;

use App\Filament\Resources\BlogPosts\BlogPostResource;
use App\Models\BlogTag;
use Filament\Resources\Pages\CreateRecord;

class CreateBlogPost extends CreateRecord
{
    protected static string $resource = BlogPostResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        unset($data['tags']);
        return $data;
    }

    protected function afterCreate(): void
    {
        $tagNames = $this->form->getState()['tags'] ?? [];
        if (! empty($tagNames)) {
            $tagIds = collect($tagNames)
                ->map(fn ($name) => trim((string) $name))
                ->filter()
                ->map(fn ($name) => BlogTag::firstOrCreate(['name' => $name])->id)
                ->values()
                ->all();
            $this->record->tags()->sync($tagIds);
        }
    }
}
