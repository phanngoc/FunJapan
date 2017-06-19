<?php

namespace App\Console\Commands;

use App\Models\Locale;
use App\Models\VisitedLog;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class LogLastWeek extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'last_week:process {locale}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Log hot key of last 7 day';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $localeIso = $this->argument('locale');
        $locale = Locale::where('iso_code', $localeIso)->first(['id']);
        
        $toDay = Carbon::now(trans('datetime.time_zone', [], $localeIso));

        if ($locale) {
            $toDay = $toDay->toDateString();

            $last7Day = Carbon::now(trans('datetime.time_zone', [], $localeIso))
                ->subWeek()
                ->toDateString();

            try {
                foreach (config('visit_log.relate_type') as $key => $type) {
                    $newLogs = $this->process($locale->id, $type, $last7Day, $toDay, config('visit_log.hot_key.limit.' . $key));

                    Cache::forever(config('visit_log.hot_key.cache_key.' . $key) . '.' . $localeIso, $newLogs);
                }

                $this->alert('Success !');
            } catch (\Exception $e) {
                $this->error($e->getMessage());
            }
        }
    }

    protected function process($localeId, $type, $last7Day, $toDay, $limit = 3)
    {
        return VisitedLog::select(['relate_table_id', 'relate_table_type', DB::raw('SUM(count) AS count')])
            ->where('locale_id', $localeId)
            ->where('relate_table_type', $type)
            ->whereBetween('start_date', [$last7Day, $toDay])
            ->groupBy('relate_table_id', 'relate_table_type')
            ->orderBy('count', 'DESC')
            ->limit($limit)
            ->get()
            ->toArray();
    }
}
