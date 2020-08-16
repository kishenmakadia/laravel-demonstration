<?php

namespace App\Services;

use App\Post;
use Illuminate\Support\Str;

trait Sluggable
{
    public function getSourceField()
    {
        return 'name';
    }

    /**
     * @param $title
     * @param int $id
     * @return string
     * @throws \Exception
     */
    public function createSlug()
    {
        $slug = Str::slug($this->{$this->getSourceField()});

        $allSlugs = $this->getRelatedSlugs($slug);

        if (!$allSlugs->contains('slug', $slug)) {
            return $slug;
        }

        for ($i = 1; $i <= 10; $i++) {
            $newSlug = $slug . '-' . $i;
            if (!$allSlugs->contains('slug', $newSlug)) {
                return $newSlug;
            }
        }

        throw new \Exception('Can not create a unique slug');
    }

    protected function getRelatedSlugs($slug, $id = 0)
    {
        return (static::class)::select('slug')->where('slug', 'like', $slug . '%')
            ->where('id', '<>', $this->id ?? 0)
            ->get();
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($record) {
            $record->slug = $record->createSlug();
        });

        static::updating(function ($record) {
            $record->slug = $record->createSlug();
        });
    }
}
