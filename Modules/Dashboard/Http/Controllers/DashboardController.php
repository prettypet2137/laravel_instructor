<?php

namespace Modules\Dashboard\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Events\Entities\Event;
use Modules\Events\Entities\Guest;
use Modules\Tracklink\Entities\Tracklink;
use Illuminate\Database\Eloquent\Builder;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */

    public function index(Request $request)
    {
        $user = $request->user();
        $total_events = Event::where('user_id', '=', $user->id)->count();
        $total_views = Tracklink::where('target_class', '=', Event::class)->whereHas('target', function (Builder $query) use ($user) {
            $query->where('user_id', '=', $user->id);
        })->count();
        $total_registered = Guest::where('user_id', '=', $user->id)->where('status', '=', 'registered')->count();
        $total_joined = Guest::where('user_id', '=', $user->id)->where('status', '=', 'joined')->count();

        $date2 = new \Carbon\Carbon();
        $date1 = $date2->clone()->subDays(7);

        $start_date = $date1->toDateString();
        $end_date = $date2->toDateString();

        // line-chart data
        $pageviews_visible = false;
        $pageviews_chart = [];
        $date = $date1->clone();
        do {
            $pageviews_chart[$date->toDateString()] = [
                'visitors' => 0,
                'paids' => 0,
                'joined' => 0,
            ];
            $date = $date->addDays(1);
        } while ($date2->toDateString() !== $date->toDateString());

        $visitors_results = \DB::select("
            SELECT 
                COUNT(id) AS total,
                DATE_FORMAT(created_at, '%Y-%m-%d') AS date
            FROM
                event_guests
            WHERE
                user_id = '" . $user->id . "'
                AND created_at >= '" . $start_date . " 00:00:00'
                AND created_at <= '" . $end_date . " 23:59:59'
            GROUP BY date
            ORDER BY date ASC
        ");
        foreach ($visitors_results as $visitors_result) {
            $pageviews_visible = true;
            $pageviews_chart[$visitors_result->date]['visitors'] =  $visitors_result->total;
        }

        $paid_results = \DB::select("
            SELECT 
                COUNT(id) AS total,
                DATE_FORMAT(created_at, '%Y-%m-%d') AS date
            FROM
                event_guests
            WHERE
                user_id = '" . $user->id . "'
                AND is_paid = 1
                AND created_at >= '" . $start_date . " 00:00:00'
                AND created_at <= '" . $end_date . " 23:59:59'
            GROUP BY date
            ORDER BY date ASC
        ");
        foreach ($paid_results as $paid_result) {
            $pageviews_visible = true;
            $pageviews_chart[$paid_result->date]['paids'] =  $paid_result->total;
        }

        $joined_results = \DB::select("
            SELECT 
                COUNT(id) AS total,
                DATE_FORMAT(created_at, '%Y-%m-%d') AS date
            FROM
                event_guests
            WHERE
                user_id = '" . $user->id . "'
                AND status = 'joined'
                AND created_at >= '" . $start_date . " 00:00:00'
                AND created_at <= '" . $end_date . " 23:59:59'
            GROUP BY date
            ORDER BY date ASC
        ");
        foreach ($joined_results as $joined_result) {
            $pageviews_visible = true;
            $pageviews_chart[$joined_result->date]['joined'] =  $joined_result->total;
        }

        $pageviews_chart = get_chart_data($pageviews_chart);


        // registered & joined  column-chart data
        $column_chart_visible = false;
        $data_labels = [];
        $data_registered = [];
        $data_joined = [];
        $column_chart_results = \DB::select("
            SELECT 
                TBLRegisterd.event_id AS event_id,
                TBLRegisterd.event_name AS event_name,
                TBLRegisterd.total AS total_registered,
                TBLJoined.total AS total_joined,
                (TBLRegisterd.total + TBLJoined.total) AS total_rows
            FROM
                (SELECT 
                    TBLEvents.id AS event_id,
                        TBLEvents.name AS event_name,
                        SUM(CASE
                            WHEN TBLGuests.status = 'registered' THEN 1
                            ELSE 0
                        END) AS total
                FROM
                    events TBLEvents
                LEFT JOIN event_guests TBLGuests ON TBLGuests.event_id = TBLEvents.id
                WHERE
                    TBLEvents.user_id = '" . $user->id . "'
                GROUP BY TBLEvents.id , TBLEvents.name) TBLRegisterd
                    INNER JOIN
                (SELECT 
                    TBLEvents.id AS event_id,
                        TBLEvents.name AS event_name,
                        SUM(CASE
                            WHEN TBLGuests.status = 'joined' THEN 1
                            ELSE 0
                        END) AS total
                FROM
                    events TBLEvents
                LEFT JOIN event_guests TBLGuests ON TBLGuests.event_id = TBLEvents.id
                WHERE
                    TBLEvents.user_id = '" . $user->id . "'
                GROUP BY TBLEvents.id , TBLEvents.name) TBLJoined ON TBLRegisterd.event_id = TBLJoined.event_id
            ORDER BY total_rows DESC
            LIMIT 0 , 10
        ");
        foreach ($column_chart_results as $column_chart_result) {
            $column_chart_visible = true;
            array_push($data_labels, $column_chart_result->event_name);
            array_push($data_registered, intval($column_chart_result->total_registered));
            array_push($data_joined, intval($column_chart_result->total_joined));
        }

        $column_chart = [
            'labels'   => $data_labels,
            'datasets' => [
                [
                    'label' => __('Registered'),
                    'backgroundColor' => '#168AE6',
                    'borderColor' => '#168AE6',
                    'borderWidth' => 1,
                    'tension' => false,
                    'data' => $data_registered,
                ], [
                    'label' => __('Joined'),
                    'backgroundColor' => '#1CC88A',
                    'borderColor' => '#1CC88A',
                    'borderWidth' => 1,
                    'tension' => false,
                    'data' => $data_joined,
                ],
            ],
        ];

        // guest by event chart
        $guest_by_event_visible = false;
        $guest_by_event_chart = [
            'labels' => [],
            'datasets' => [],
        ];

        $guest_by_event_data = [];
        $guest_by_event_data['data'] = [];
        $guest_by_event_data['backgroundColor'] = [];
        $guest_by_event_data['hoverBackgroundColor'] = [];
        $guest_by_event_data['statusLink'] = [];

        $colors = [
            '#28B8DA',
            '#03a9f4',
            '#c53da9',
            '#757575',
            '#8e24aa',
            '#d81b60',
            '#0288d1',
            '#7cb342',
            '#fb8c00',
            '#84C529',
            '#fb3b3b',
            '#168AE6',
            '#1CC88A',
        ];

        $guest_by_event_results = \DB::select("
            SELECT 
                TBLEvents.id AS event_id,
                TBLEvents.name AS event_name,
                COUNT(*) AS total
            FROM
                events TBLEvents
                    LEFT JOIN
                event_guests TBLGuests ON TBLEvents.id = TBLGuests.event_id
            WHERE TBLEvents.user_id = '" . $user->id . "'
            GROUP BY TBLEvents.id , TBLEvents.name
            ORDER BY total DESC
            LIMIT 0 , 10
        ");

        foreach ($guest_by_event_results as $guest_by_event_index => $guest_by_event_result) {
            $guest_by_event_visible = true;
            array_push($guest_by_event_data['statusLink'], 'javascript:void(0);');
            array_push($guest_by_event_chart['labels'], $guest_by_event_result->event_name);
            array_push($guest_by_event_data['backgroundColor'], $colors[$guest_by_event_index % count($colors)]);
            array_push($guest_by_event_data['data'], intval($guest_by_event_result->total));
          }
        
          $guest_by_event_chart['datasets'][] = $guest_by_event_data;

        return view(
            'dashboard::index',
            [
                'total_events' => $total_events,
                'total_views' => $total_views,
                'total_registered' => $total_registered,
                'total_joined' => $total_joined,
                'pageviews_chart' => $pageviews_chart,
                'pageviews_visible' => $pageviews_visible,
                'column_chart' => $column_chart,
                'column_chart_visible' => $column_chart_visible,
                'guest_by_event_chart' => $guest_by_event_chart,
                'guest_by_event_visible' => $guest_by_event_visible,
            ]
        );
    }
}
