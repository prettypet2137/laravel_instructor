<?php

namespace Modules\Tracklink\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Events\Entities\Event;
use Modules\Tracklink\Entities\Tracklink;

class TracklinkController extends Controller
{
    public function show(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'target_id' => 'required',
            'target_class' => 'required',
            'start_date' => 'date_format:Y-m-d|nullable',
            'end_date' => 'date_format:Y-m-d|nullable',
        ]);
        if ($validator->fails()) {
            abort(404);
        }
        $validated = $validator->valid();
        
        $target_id = $validated['target_id'];
        $target_class = $validated['target_class'];
        $start_date = isset($validated['start_date']) ? $validated['start_date'] : null;
        $end_date = isset($validated['end_date']) ? $validated['end_date'] : null;

        $target = null;
        $page_title = __('Statistics') . ': ';
        switch(strtoupper($target_class))
        {
            case 'EVENT':
                $target = Event::findOrFail($target_id);
                $page_title .= $target->name;
                $link = route('events.public.show', ['name' => getSlugName(auth()->user()->name),'slug' => $target->short_slug]);
                break;
            default:
                abort(404);
        }

        if(!isset($start_date) || !isset($end_date)) {
            $date2 = new \Carbon\Carbon();
            $date1 = $date2->clone()->subDays(30);

            $start_date = $date1->toDateString();
            $end_date = $date2->toDateString();
        }

        // get data chart
        $pageviews = [];
        $pageviews_chart = [];

        $pageviews_result = \DB::select("
            SELECT
                COUNT(id) AS pageviews,
                SUM(is_unique) AS visitors,
                DATE_FORMAT(datetime, '%Y-%m-%d') AS formatted_date
            FROM
                tracklinks
            WHERE
                target_class = '".addslashes(get_class($target))."'
                AND target_id = ".$target->id."
                AND datetime >= '".($start_date . ' 00:00:00')."'
                AND datetime <= '".($end_date . ' 23:59:59')."'
            GROUP BY
                formatted_date
            ORDER BY
                formatted_date ASC
        ");

        /* Generate the raw chart data and save pageviews for later usage */
        foreach($pageviews_result as $pageviews_result){
            $pageviews[] = $pageviews_result;

            $pageviews_chart[$pageviews_result->formatted_date] = [
                'pageviews' => $pageviews_result->pageviews,
                'visitors' => $pageviews_result->visitors
            ];
        }

        $pageviews_chart = get_chart_data($pageviews_chart);

        // get overview section
        $tracklinks = Tracklink::where([
            ['target_class', '=', get_class($target)],
            ['target_id', '=', $target->id],
            ['datetime', '>=', $start_date . ' 00:00:00'],
            ['datetime', '<=', $end_date . ' 23:59:59']
        ])->get();

        $statistics_keys = [
            'country_code',
            'referrer_host',
            'device_type',
            'os_name',
            'browser_name',
            'browser_language'
        ];

        $statistics = [];
        foreach($statistics_keys as $key) {
            $statistics[$key] = [];
            $statistics[$key . '_total_sum'] = 0;
        }
        
        foreach($tracklinks as $tracklink) {
            foreach($statistics_keys as $key) {

                $statistics[$key][$tracklink->{$key}] = isset($statistics[$key][$tracklink->{$key}]) ? $statistics[$key][$tracklink->{$key}] + 1 : 1;

                $statistics[$key . '_total_sum']++;

            }
        }

        foreach($statistics_keys as $key) {
            arsort($statistics[$key]);
        }

        return view('tracklink::statistics', compact('tracklinks', 'statistics', 'page_title', 'link', 'target_id', 'target_class', 'start_date', 'end_date', 'pageviews', 'pageviews_chart'));
    }
}
