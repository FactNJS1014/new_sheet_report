<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportSheetController extends Controller
{

    /**
     * 06-03-2025
     * Get Data from MPDZONE_TBL to Dropdown list in ReportForm.vue
     */
    public function getDataZone()
    {
        try {
            $zone = DB::table('MPDZONE_TBL')
                ->select('MPDZONE_ID', 'MPDZONE_DESC')
                ->get();

            return response()->json($zone, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong!'], 500);
        }
    }

    /**
     * 06-03-2025
     * Take value zone and get value from MLINE_TBL where at zone 
     */
    public function sendDataZone(Request $request)
    {
        try {
            $zone = $request->input('zone');
            $data = DB::table('MLINE_TBL')
                ->select('MLINE_ID', 'MLINE_DESC', 'MLINE_ZONE', 'MLINE_NAME')
                ->where('MLINE_ZONE', $zone)
                ->get();
            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong!'], 500);
        }
    }

    /**
     * 07-03-2025
     * Show Data on tables
     */

    public function showTableData(Request $request)
    {
        $forms = $request->forms;

        $query = DB::select('EXEC PRODDOC_GETDAILYREPORTBYLINE ?,?,?', [$forms['line'], $forms['pshift'], $forms['date']]);
        // $db = 'EXEC PRODDOC_GETDAILYREPORTBYLINE ?,?,?' 'SMT-01' ,'A' ,'';
        return response()->json($query, 200);
    }

    /**
     * 07-03-2025
     * Show Data Report
     */

    public function showReportData(Request $request)
    {
        $docid = $request->doc_id;
        $name = $request->name;
        // return response()->json($docid, 200);

        $query = DB::table('APPRLOG_TBL')
            ->join('USERS_TBL', 'APPRLOG_TBL.APPRLOG_EMPID', '=', 'USERS_TBL.USERS_EMPID')
            ->select('APPRLOG_TBL.*', 'USERS_TBL.USERS_EMPNAME')
            ->where('APPRLOG_TBL.APPRLOG_RID', $docid)
            ->orderBy('APPRLOG_TBL.APPRLOG_APPRLEVEL', 'asc')
            ->get();

        $data = DB::select('EXEC PRODDOC_GETRID ?', [$docid]);
        
        return response()->json([
            'results' => $query,
            'details' => $data,            
            'name' => $name
        ], 200);
    }
}
