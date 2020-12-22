<?php

namespace App\Http\Controllers;

use App\Models\Show;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ShowsController extends Controller
{
    public function __construct()
    {
//        $this->authorizeResource(Team::class, 'team');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     * @throws AuthorizationException
     */
    public function index(Request $request)
    {
        $show = $this->getShowFromRequest($request);

        $this->authorize('viewAny', Show::class);
        $shows = Show::get();
        return response()->view('shows.index', ['shows' => $shows]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Show::class);
        return response()->view('shows.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     * @throws AuthorizationException
     */
    public function store(Request $request)
    {
        $this->authorize('create', Show::class);
        $request->validate(
            [
                'name'                    => 'string|required',
                'start_date'              => 'required|date|',
                'ends_date'               => 'required|date|',
                'late_entry_deadline'     => 'required|date|',
                'entries_closed_deadline' => 'required|date|',
            ]
        );

        $show = new Show();

        $show->name                    = $request->name;
        $show->start_date              = $request->start_date;
        $show->ends_date               = $request->ends_date;
        $show->late_entry_deadline     = $request->late_entry_deadline;
        $show->entries_closed_deadline = $request->entries_closed_deadline;
        $show->save();
        return response()->redirectTo(route('shows.show', ['show' => $show->id]));
    }

    /**
     * Display the specified resource.
     *
     * @param Show $show
     * @return Response
     * @throws AuthorizationException
     */
    public function show(Show $show)
    {
        $this->authorize('view', $show);
        return response()->view(
            'shows.show',
            [
                'show'       => $show,
//                'categories' => $show->categories()->orderBy('sortorder')->get()
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Show $show
     * @return Response
     * @throws AuthorizationException
     */
    public function edit(Show $show)
    {
        $this->authorize('update', Show::class);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Show $show
     * @return Response
     * @throws AuthorizationException
     */
    public function update(Request $request, Show $show)
    {
        $this->authorize('update', Show::class);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Show $show
     * @return Response
     * @throws AuthorizationException
     */
    public function destroy(Show $show)
    {
        $this->authorize('delete', Show::class);
    }

    public function duplicate(Show $show)
    {
        $this->authorize('create', Show::class);
        return response()->view('shows.duplicate', ['show' => $show]);
    }
}
