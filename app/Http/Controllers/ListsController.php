<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests\ListsRequest;
use App\Lists;
use App\Subscribers;
use App\Groups;
use App\Stats;

use Barryvdh\Debugbar\Facade as Debugbar;

class ListsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /** Array que contiene el número de subscritos a la lista. */
        $subscriber_count = [];

        $list_opens = [];
        $list_clicked = [];

        $lists = Lists::latest()
            ->where('client_id', '=', Auth::user()->id)
            ->take(25)
            ->get();

        /** Obtenemos el total de subscritos a la lista. */
        foreach( $lists as $list ) {

            $subscribers_count = Subscribers::join('groups', 'subscribers.group_id', '=', 'groups.id')
                    ->join('lists', 'lists.id', '=', 'groups.list_id')
                    ->where('lists.id', '=', $list->id)
                    ->count();

            array_push($subscriber_count, $subscribers_count);

            if( $list->opens != 0 && $list->sended != 0 ) {
                $resultado = $list->opens * 100;
                $email_opened = $resultado / $list->sended;
                array_push($list_opens, $email_opened);
            } else {
                array_push($list_opens, 0);
            }

            if( $list->clicks != 0 && $list->sended != 0 ) {
                $resultado = $list->clicks * 100;
                $email_clicked = $resultado / $list->sended;
                array_push($list_clicked, $email_clicked);
            } else {
                array_push($list_clicked, 0);
            }
        }

        return view('lists.index')->with('lists', $lists)
            ->with('subscriber_count', $subscriber_count)
            ->with('list_opens', $list_opens)
            ->with('list_clicked', $list_clicked);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {        
        return view('lists.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ListsRequest $request)
    {
        $input = [
            'name' => $request->name,
            'description' => $request->description,
            'client_id' => Auth::user()->id,
        ];

        Lists::create($input);
        return redirect('lists');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $list = Lists::find($id);
        $u_token = Auth::user()->token;

        $groups = Groups::where('list_id', '=', $list->id)->get();

        if( isset($groups[0]->id) ) {
            $first_group_id = $groups[0]->id;
        } else {
            $first_group_id = -1;
        }

        return view('lists.edit', compact('u_token', $u_token), compact('first_group_id', $first_group_id))->with('list', $list)->with('groups', $groups);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ListsRequest $request, $id)
    {
        $list = Lists::find($id);

        $list->name = $request->name;
        $list->description = $request->description;

        $list->save();
        return redirect('lists');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if( $request->ajax() ) {

            $groups = Groups::join('lists', 'groups.list_id', '=', 'lists.id')
                ->where('lists.client_id', '=', Auth::user()->id)
                ->where('lists.id', '=', $request->id)
                ->get(['groups.id']);

            if( $groups->count() > 0 ) {
                foreach( $groups as $group ) {
                    Groups::destroy($group->id);
                }
            }

            $lists = Lists::where('id', '=', $request->id)
                ->where('client_id', '=', Auth::user()->id)
                ->get();

            if( $lists->count() > 0 ) {
                $list = Lists::find($request->id);
                Lists::destroy($list->id);
            }

        }
    }
}
