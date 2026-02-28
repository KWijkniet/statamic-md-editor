<?php

namespace Kwijkniet\MdEditor\Actions;

use Statamic\Actions\Action;
use Statamic\Contracts\Entries\Entry;
use Statamic\Contracts\Entries\EntryRepository;
use Statamic\Stache\Repositories\EntryRepository as StacheEntryRepository;

class EditMarkdown extends Action
{
    protected $confirm = false;
    protected $icon = 'edit';

    public static function title()
    {
        return __('Edit Markdown');
    }

    public function visibleTo($item)
    {
        return $item instanceof Entry
            && app(EntryRepository::class) instanceof StacheEntryRepository;
    }

    public function authorize($user, $item)
    {
        return true;
    }

    public function triggersFullPageRefresh(): bool
    {
        return true;
    }

    public function redirect($items, $values)
    {
        return $items->first()->editUrl().'/markdown';
    }

    public function run($items, $values)
    {
        //
    }
}
