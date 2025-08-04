<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use \App\Models\Periods as Period;
use App\Models\PeriodsReaction;

class PeriodController extends Controller
{
    public function store(Request $request)
    {
        $tip       = "Add Periods Detail";
        $message   = "Periods detail added successfully";
        $validator = Validator::make($request->all(), [
            'cramps_days'       => 'required|integer|min:0|max:31',
            'periods_end_date'  => 'required|date',
            'periods_last_date' => 'required|date',
            'period_type'       => 'required|integer|in:1,2,3',
        ]);

        if ($validator->fails()) {
            $responseArray = apiResponse("Failed", $validator, false, "", 422, $tip);
            return response()->json($responseArray, 422);
        } else {
            try {
                \DB::beginTransaction();

                $period                    = new Period();
                $validatedData             = $validator->validated();
                $period->cramps_days       = $validatedData['cramps_days'];
                $period->periods_end_date  = $validatedData['periods_end_date'];
                $period->periods_last_date = $validatedData['periods_last_date'];
                $period->period_type       = $validatedData['period_type'];
                $period->user_id           = auth()->id();

                // Calculate start date as 28 days before the last date
                $periods_last_date = Carbon::parse($period->periods_last_date);
                $periods_end_date  = Carbon::parse($period->periods_end_date);
                $cycle_length      = 28;

                $next_period_date = $periods_end_date->addDays($cycle_length);

                $ovulation_date = $next_period_date->copy()->subDays(14);

                $fertile_start                = $ovulation_date->copy()->subDays(5);
                $fertile_end                  = $ovulation_date->copy()->addDay();
                $period->periods_last_date    = $periods_last_date->subDays($cycle_length);
                $period->periods_end_date     = Carbon::parse($period->periods_end_date);
                $period->next_period_date     = $next_period_date;
                $period->ovulation            = $ovulation_date;
                $period->fertile_window_start = $fertile_start;
                $period->fertile_window_end   = $fertile_end;
                $period->cycle_length         = $cycle_length;
                $period->period_length        = $periods_end_date->diffInDays($periods_last_date) + 1;
                $period->flow                 = 0;
                $period->save();
                DB::commit();
                $responseArray = apiResponse("Success", '', false, "", 200, $tip, $message);
                return response()->json($responseArray, 200);
            } catch (\Exception $ex) {
                $responseArray = apiResponse("Failed", $ex, false, '', 500, $tip);
                return response()->json($responseArray, 500);
            }
        }
    }

    public function updatePeriodsRection(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mood'     => 'required|string|max:255',
            'symptoms' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            $responseArray = apiResponse("Failed", $validator, false, "", 422, 'Update Periods Reaction');
            return response()->json($responseArray, 422);
        } else {
            try {
                DB::beginTransaction();
                $period = Period::where('user_id', auth()->id())->latest()->first();
                if (! $period) {
                    $responseArray = apiResponse("Failed", "Period not found", false, '', 404);
                    return response()->json($responseArray, 404);
                }
                $periods_reaction = new PeriodsReaction();
                $periods_reaction->period_id = $period->id;
                $periods_reaction->mood     = $request->input('mood');
                $periods_reaction->symptoms = $request->input('symptoms');
                $periods_reaction->flow     = $request->input('flow', 0);
                $periods_reaction->save();
                DB::commit();
                $responseArray = apiResponse("Success", '', false, '', 200, "Update Periods Reaction", "Periods reaction updated successfully");
                return response()->json($responseArray, 200);
            } catch (\Exception $ex) {
                $responseArray = apiResponse("Failed", $ex, false, '', 500);
                return response()->json($responseArray, 500);
            }
        }

    }

    public function previousPeriods(Request $request)
    {
        $user    = auth()->user();
        $today   = Carbon::today();
        $periods = Period::where('user_id', $user->id)
            ->where('periods_last_date', '<', $today)
            ->orderBy('periods_last_date', 'desc')
            ->paginate(10);
        $responseArray = apiResponse("Success", '', true, $periods, 200, "Previous Periods", "Previous periods retrieved successfully");
        return response()->json($responseArray, 200);
    }

}
