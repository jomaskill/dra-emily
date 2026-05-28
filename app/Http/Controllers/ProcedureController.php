<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class ProcedureController extends Controller
{
    /**
     * Display a single procedure landing page.
     */
    public function show(string $slug): View
    {
        $procedure = config("procedures.{$slug}");

        abort_if($procedure === null, 404);

        return view($procedure['view'] ?? 'procedure', [
            'slug' => $slug,
            'procedure' => $procedure,
        ]);
    }
}
