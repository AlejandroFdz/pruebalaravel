<?php

namespace App\Http\Controllers;

use App\User;
use App\Subscribers;
use App\Lists;
use App\Groups;
use App\Tickets;
use App\Blog;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
      $users = User::where('admin', '!=', 1)->get();
      $subscribers = Subscribers::get();
      $lists = Lists::get();
      $groups = Groups::get();
      $tickets = Tickets::get();
      $posts = Blog::get();

      $total_users = $users->count();
      $total_subscribers = $subscribers->count();
      $total_lists = $lists->count();
      $total_groups = $groups->count();
      $total_tickets = $tickets->count();
      $total_posts = $posts->count();

      return view('admin.dashboard', compact('total_users', 'total_subscribers', 'total_lists', 'total_groups', 'total_tickets', 'total_posts'));
    }
}
