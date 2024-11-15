<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateMasterEventRequest;
use App\Models\ContentEvent;
use App\Models\MasterEvent;
use App\Models\EventPosition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterEventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumbsItems = [
            [
                'name' => 'Master Event',
                'url' => route('events.index'),
                'active' => false
            ],
            [
                'name' => 'List',
                'url' => '#',
                'active' => true
            ],
        ];

        // $data = DB::table('master_events as me')
        //     ->join('event_positions as ep', 'me.position_id', '=', 'ep.id')
        //     ->select('me.*', 'ep.*') // Select the columns you want
        //     ->get();
        $data = MasterEvent::with('positions')->get();
            // dd($data);

        return view('master-event.index', [
            'data' => $data,
            'breadcrumbItems' => $breadcrumbsItems,
            'pageTitle' => 'Master Event'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $breadcrumbsItems = [
            [
                'name' => 'Master Event',
                'url' => route('events.index'),
                'active' => false
            ],
            [
                'name' => 'Create',
                'url' => '#',
                'active' => true
            ],
        ];

        $positions = EventPosition::all();

        return view('master-event.create', [
            'positions' => $positions,
            'breadcrumbItems' => $breadcrumbsItems,
            'pageTitle' => 'Create Event'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'position_id' => 'required|exists:event_positions,id', // Validate position_id exists in event_positions
            'name' => 'required|string|max:255', // Adjust max length as needed
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d|after_or_equal:start_date', // Ensure end_date is after or equal to start_date
            'isActive' => 'required|boolean', // Ensure isActive is a boolean
            'order' => 'required|integer|min:1', // Ensure order is a positive integer
            // 'file' => 'required|file|mimes:mp4,avi,mov|max:204800'
        ]);

        if ($request->hasFile('file'))
        {
            $file = $request->file('file');
            $filePath = $file->storeAs('public/uploads/videos', $file->getClientOriginalName());
            $fileName = $file->getClientOriginalName();

            // dd($filePath);
            // Create a new master event
            $masterEvent =  MasterEvent::create([
                'positions_id' => $request->position_id,
                'name' => $request->name,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'isActive' => $request->isActive,
                'content_order' => $request->order
            ]);

            $contentEvent = ContentEvent::create([
                'master_event_id' => $masterEvent->id,
                'type' => $request->type,
                'url' => $filePath,
                'filename' => $fileName
            ]);
        }

        return redirect()->route('events.index')->with('message', 'Event created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MasterEvent  $masterEvent
     * @return \Illuminate\Http\Response
     */
    public function show(MasterEvent $masterEvent)
    {
        $breadcrumbsItems = [
            [
                'name' => 'Master Event',
                'url' => route('events.index'),
                'active' => false
            ],
            [
                'name' => $masterEvent->name,
                'url' => '#',
                'active' => true
            ],
        ];

        return view('master-event.show', [
            'event' => $masterEvent,
            'breadcrumbItems' => $breadcrumbsItems,
            'pageTitle' => 'Event Details'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MasterEvent  $masterEvent
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // dd($id);
        $breadcrumbsItems = [
            [
                'name' => 'Master Event',
                'url' => route('events.index'),
                'active' => false
            ],
            [
                'name' => 'Edit',
                'url' => '#',
                'active' => true
            ],
        ];

        $masterEvent = MasterEvent::findOrFail($id);
        $positions = EventPosition::where('id', $masterEvent->positions_id)->get();
        $allPositions = EventPosition::all();

        // dd($positions);

        return view('master-event.edit', [
            'event' => $masterEvent,
            'positions' => $positions,
            'allPositions' => $allPositions,
            'breadcrumbItems' => $breadcrumbsItems,
            'pageTitle' => 'Edit Event'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MasterEvent  $masterEvent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request);
        $request->validate([
            'position_id' => 'required|exists:event_positions,id', // Validate position_id exists in event_positions
            'name' => 'required|string|max:255', // Adjust max length as needed
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d|after_or_equal:start_date', // Ensure end_date is after or equal to start_date
            'isActive' => 'required|boolean', // Ensure isActive is a boolean
            'content_order' => 'required|integer|min:1', // Ensure order is a positive integer
        ]);

        $masterEvent = MasterEvent::findOrFail($id);
        $masterEvent->positions_id = $request->position_id;
        $masterEvent->name = $request->name;
        $masterEvent->start_date = $request->start_date;
        $masterEvent->end_date = $request->end_date;
        $masterEvent->isActive = $request->isActive;
        $masterEvent->content_order = $request->content_order;
        $masterEvent->save();

        return redirect()->route('events.index')->with('message', 'Event updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MasterEvent  $masterEvent
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = MasterEvent::findOrFail($id);

        $data->delete();

        return redirect()->route('events.index')->with('message', 'Event deleted successfully.');
    }
}
