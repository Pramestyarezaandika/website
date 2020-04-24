<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Kreait\Firebase\Database;

class DashboardController extends Controller
{
    //
    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function index() 
    {
        // $reference = $this->database->getReference('pegawai');
        try {
            $reference = 'pegawai';
            $ref = $this->database->getReference($reference);
            $snapshot = $ref->getSnapshot();
            $refPegawai = $snapshot->getValue();
            $valpegawai = array_values(array_filter($refPegawai));
            $sizePegawai = sizeof($valpegawai);
        } catch (\Throwable $th) {
            $sizePegawai = 0;
        }
        
        return view('admin.dashboard', compact('sizePegawai'));

        // $value_1 = $snapshot->getValue();
        // $value_2 = $reference->getValue(); // Shortcut for $reference->getSnapshot()->getValue();

        // $value = $snapshot->exists(); // returns true if the Snapshot contains any (non-null) data.
        // $value = $snapshot->getChild('1')->getValue(); // returns another Snapshot for the location at the specified relative path.
        // $value = $snapshot->getChild('1')->getKey(); // returns the key (last part of the path) of the location of the Snapshot.
        // $value = $snapshot->hasChild('20'); // returns true if the specified child path has (non-null) data.
        // $value = $snapshot->hasChildren(); //  returns true if the Snapshot has any child properties, i.e. if the value is an array.
        // $value = $snapshot->numChildren(); //  returns the number of child properties of this Snapshot, if there are any.
    }
}
