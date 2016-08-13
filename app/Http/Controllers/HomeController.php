<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
    
    public function getDashboard()
    {
        $self = Auth::user();
        $users = User::where('id', '<>', $self->id)->get();
        
        return view('panel', ['self' => $self, 'users' => $users]);
    }
    
    public function getTransfer()
    {
        return redirect('/dashboard');
    }
    
    public function postTransfer(Request $request, User $user)
    {
        $validator = Validator::make([
            'from' => $request->from,
            'amount' => $request->amount,
            'to' => $request->to
        ], [
            'from' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:1',
            'to' => 'required|exists:users,id',
        ]);
        
        if ($validator->fails()) {
            $messages = $validator->messages();
            
            return redirect('/dashboard')
                ->withErrors($validator)
                ->withInput(Input::except('amount', 'from'));
        }
        
        $from = User::find($request->from);
        $to = User::find($request->to);
        
        if ($request->amount > $from->balance) {
            Session::flash('error_transfer', 'Not enough balance to transfer (Balance:' . $from->balance . ', Transfer: ' . $request->amount . ')');
            return redirect('/dashboard');
        }
        
        $from->balance -= $request->amount;
        $to->balance += $request->amount;
        
        $from->save();
        $to->save();
        
        Session::flash('success_transfer', 'You transfer ' . $request->amount . ' to ' . $to->name . '(email:' . $to->email . ')');
        
        return redirect('/dashboard');
    }
}
