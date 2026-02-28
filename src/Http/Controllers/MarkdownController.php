<?php

namespace Kwijkniet\MdEditor\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Statamic\Facades\Entry;
use Statamic\Facades\Site;
use Statamic\Facades\User;
use Statamic\Fields\Blueprint;
use Statamic\Http\Controllers\CP\CpController;

class MarkdownController extends CpController
{
    public function show($collection, $entry_id)
    {
        $entry = Entry::find($entry_id);
        abort_if(! $entry, 404);

        // Read the entire raw .md file from disk
        $rawFile = file_get_contents($entry->path());
        
        return Inertia::render('MdEditor', [
            'title' => $entry->value('title'),
            'reference' => $entry->reference(),
            'actions' => [
                'save' => cp_route('md-editor.entries.markdown.save', [$collection, $entry_id]),
                'editUrl' => $entry->editUrl(),
                'publish' => $entry->publishUrl(),
                'unpublish' => $entry->unpublishUrl(),
                'revisions' => $entry->revisionsUrl(),
                'restore' => $entry->restoreRevisionUrl(),
                'createRevision' => $entry->createRevisionUrl(),
                'editBlueprint' => null,
            ],
            'values' => ['raw' => $rawFile],
            'collection' => $collection,
            'initialListingUrl' => cp_route('collections.show', $collection),
            'itemActionUrl' => null,
        ]);
    }

    public function save(Request $request, $collection, $entry_id)
    {
        $entry = Entry::find($entry_id);
        abort_if(! $entry, 404);

        $rawContent = $request->input('raw');

        $result = file_put_contents($entry->path(), $rawContent);

        abort_if($result === false, 500, 'Failed to write file.');

        return response()->json([
            'data' => [
                'title' => $entry->value('title'),
                'permalink' => $entry->absoluteUrl(),
                'published' => $entry->published(),
                'status' => $entry->status(),
            ],
        ]);
    }
}
