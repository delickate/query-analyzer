<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QueryAnalyzerController extends Controller
{
    
	public function index()
	{
	    return view('query-analyzer');
	}

	public function tables()
	{
	    $database = DB::getDatabaseName();

	    $tables = DB::select("
	        SELECT TABLE_NAME 
	        FROM INFORMATION_SCHEMA.TABLES 
	        WHERE TABLE_SCHEMA = ?
	    ", [$database]);

	    return response()->json($tables);
	}

	public function columns($table)
	{

	    $database = DB::getDatabaseName();

	    $columns = DB::select("
	        SELECT COLUMN_NAME
	        FROM INFORMATION_SCHEMA.COLUMNS
	        WHERE TABLE_SCHEMA = ?
	        AND TABLE_NAME = ?
	    ", [$database,$table]);

	    return response()->json($columns);

	}

	public function execute(Request $request)
	{

		$query = trim($request->input('query'));

		if(!str_starts_with(strtolower($query),'select')){
		return response()->json(['error'=>'Only SELECT allowed']);
		}

		try{

		$data = DB::select($query);

		return response()->json($data);

		}catch(\Exception $e){

		return response()->json(['error'=>$e->getMessage()]);

		}

	}
}
