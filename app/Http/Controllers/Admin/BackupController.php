<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BackupController extends Controller
{
    public function index()
    {
        if (!file_exists(storage_path('app/bk'))) {
            $backups = [];
        } else {
            $backups = \File::allFiles(storage_path('app/bk'));

            // Sort files by modified time DESC
            usort($backups, function ($a, $b) {
                return -1 * strcmp($a->getMTime(), $b->getMTime());
            });
        }

        return view('admin.backups.index', compact('backups'));
    }

    public function download($fileName)
    {
        return response()->download(storage_path('app/bk/') . $fileName);
    }

    public function destroy($fileName)
    {
        if (file_exists(storage_path('app/bk/') . $fileName)) {
            unlink(storage_path('app/bk/') . $fileName);
        }

        return back()->with('success', 'Xóa thành công');
    }
}
