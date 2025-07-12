<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Periods as Period;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class UpdatePeriodCycle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'periods:update-cycle';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update user period cycle, ovulation, fertile window, and next period date';

    /**
     * Execute the console command.
     */

    public function handle()
    {
        try {
            $periods = Period::all();

            foreach ($periods as $period) {
                $last_date     = Carbon::parse($period->periods_last_date);
                $cycle_length  = $period->cycle_length ?? 28;
                $period_length = $period->period_length ?? 5;

                $next_period_date = $last_date->copy()->addDays($cycle_length);
                $ovulation        = $next_period_date->copy()->subDays(14);
                $fertile_start    = $ovulation->copy()->subDays(5);
                $fertile_end      = $ovulation->copy()->addDay();

                // Update the record
                Period::where('id',$period->id)->update([
                    'next_period_date'     => $next_period_date,
                    'ovulation'            => $ovulation,
                    'fertile_window_start' => $fertile_start,
                    'fertile_window_end'   => $fertile_end,
                ]);

                Log::info("Period updated for user_id: {$period->user_id}");
            }

            $this->info('All periods updated successfully.');
            Log::info('All periods updated successfully.');

        } catch (\Exception $e) {
            Log::error('Failed to update periods: ' . $e->getMessage());
            $this->error('Error: ' . $e->getMessage());
        }
    }
}
