<?php

use Illuminate\Support\Facades\Route;
use Kwijkniet\MdEditor\Http\Controllers\MarkdownController;

// Mirrors Statamic's entry URL pattern: /cp/collections/{collection}/entries/{entry}
// Adding /markdown gives us the markdown editor page.
Route::get('collections/{collection}/entries/{entry_id}/markdown', [MarkdownController::class, 'show'])
    ->name('md-editor.entries.markdown');

Route::patch('collections/{collection}/entries/{entry_id}/markdown', [MarkdownController::class, 'save'])
    ->name('md-editor.entries.markdown.save');
