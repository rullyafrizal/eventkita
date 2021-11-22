<?php

namespace App\Actions;

use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class UploadFile
{
    use AsAction;

    public function handle(Request $request)
    {
        return $request->file('file')->store($request->store_path, 'public');
    }
}
