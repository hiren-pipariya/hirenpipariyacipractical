<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//Package for datatable
use Illuminate\Support\Facades\Storage;
use Yajra\Datatables\Datatables;
use Illuminate\Validation\Rule;

use Validator;

//Models
use App\User;
use App\Skill;
use App\UserDetail;
use App\UserRelations;

class UserController extends Controller
{
    public function adminUserList()
    {
        return view('user.index');
    }

    public function edit_profile()
    {
        $auth_user = auth()->user();
        $user = User::with('skills','userdetail')
                    ->where('id',$auth_user->id)
                    ->first();
        $dataArr = array('id'       => $auth_user->id);
        $dataArr['first_name']      = $user->userdetail->first_name;
        $dataArr['last_name']       = $user->userdetail->last_name;
        $dataArr['mobile']          = $user->userdetail->mobile;
        $dataArr['gender']          = $user->userdetail->gender;
        $dataArr['photo']           = $user->userdetail->photo;
        $dataArr['email']           = $user->email;
        $dataArr['skills']          = $user->skills->pluck('id');

        $skill_option = Skill::get()->pluck('skill', 'id')->toArray();
        $form = $dataArr;
        return view('profile.edit', compact('form','skill_option'));
    }
    public function update_profile(Request $request)
    {
        $data = $request->all();
        $auth_user = auth()->user();

        //Validator for whole controller
        $validator =  Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'digits:12'],
            'gender' => ['required',  Rule::in(['male', 'female'])],
            'photo' => ['nullable',  'image' , 'max:2048'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($auth_user->id)],
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        //Find and get user instance to update 
        $user = User::find($auth_user->id);
        $user->update([
            'name' => $data['first_name']. " ".$data['last_name'],
            'email' => $data['email'],
        ]);

        //Find and get userdetail instance to update 
        $oldDetail = UserDetail::where('user_id',$auth_user->id)->first();

        // Create array with new data
        $userdata = array(
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'mobile'     => $data['mobile'],
            'gender'     => $data['gender'],
        );

        //check if new photo uploaded
        if(!empty($data['photo'])){
            Storage::delete($oldDetail->photo); // delete old photo

            $file_path = 'public/user/'.$auth_user->id.'/'.$oldDetail->user_name; //create name of file and path of file
            $file_name = Storage::disk('local')->put($file_path, $data['photo']); // Store image in particular folder get name
            $userdata['photo'] = $file_name;
        }
        $oldDetail->update($userdata);

        $skills = $data['skills'];
        $user->skills()->sync($skills);  
        return redirect('/home');

    }

    
    public function adminUserDatatable()
    {
        $getdata =  User::with('userdetail')->where('role','user')->get();
        return Datatables::of($getdata)->make(true);
    }

    public function friendList()
    {
        return view('friend.index');
    }
    public function friendListDatatable()
    {
        $auth_user = auth()->user();

        $user = User::where('id',$auth_user->id)->first();
            $sender = DB::table('user_relations')
            ->where('user_relations.status', 'Accept')
            ->join('users as r', 'user_relations.send_to', '=', 'r.id')
            ->where(function($query) use($auth_user)
            {
                $query->where('send_by', $auth_user->id);
            })
             ->get()->pluck('send_to');
    
            $receiver = DB::table('user_relations')
            ->where('user_relations.status', 'Accept')
            ->join('users as s', 'user_relations.send_to', '=', 's.id')
            ->where(function($query) use($auth_user)
            {
                $query->where('send_to', $auth_user->id);
            })
             ->get()->pluck('send_by');

        // get the list of users who has same skills like auth user
        $list = User::with('userdetail')
            ->whereIn('id', $receiver)
            ->orWhereIn('id', $sender)
            ->get();

        return Datatables::of($list)->make(true);
    }

    public function sameskill()
    {
        return view('sameskill.index');
    }

    public function sameskillDatatable()
    {
        // get the auth user
        $auth_user = auth()->user();

        // get user along with skills
        $user = User::with('skills')->where('id',$auth_user->id)->first();
        $skills_ids = $user->skills->pluck('id');;

        $sender = DB::table('user_relations')
        ->join('users as r', 'user_relations.send_to', '=', 'r.id')
        ->where(function($query) use($auth_user)
        {
            $query->where('send_by', $auth_user->id);
        })
         ->get()->pluck('send_to');

        $receiver = DB::table('user_relations')
        ->join('users as s', 'user_relations.send_to', '=', 's.id')
        ->where(function($query) use($auth_user)
        {
            $query->where('send_to', $auth_user->id);
        })
         ->get()->pluck('send_by');

        // get the list of users who has same skills like auth user
        $list = User::with('userdetail')
            ->whereHas('skills', function ($q) use($skills_ids) {
                $q->whereIn('skill_id', $skills_ids);
            })
            ->whereNotIn('id', $receiver)
            ->whereNotIn('id', $sender)
            ->where('id', '<>', $auth_user->id)
            ->get();

        return Datatables::of($list)->make(true);
    }

    public function pendingRequest()
    {
        return view('pending.index');
    }

    
    public function pendingRequestDatatable()
    {
        // get the auth user
        $auth_user = auth()->user();

        $user = User::where('id',$auth_user->id)->first();
        $sender = DB::table('user_relations')
        ->join('users as r', 'user_relations.send_by', '=', 'r.id')
        ->where('user_relations.status', null)
        ->where(function($query) use($auth_user)
        {
            $query->where('send_to', $auth_user->id);
        })
         ->get()->pluck('send_by');

        // get the list of users who has same skills like auth user
        $list = User::with('userdetail')
            ->whereIn('id', $sender)
            ->get();
        return Datatables::of($list)->make(true);
    }

    public function friendRequest($id)
    {
        // get the auth user
        $auth_user = auth()->user();

        $data = [
            'send_by' => $auth_user->id,
            'send_to' => $id
        ];
        UserRelations::create($data);
        return  response()->json(['message' => 'Request sent'],200);
    }

    public function friendRequestAccept($id)
    {
        // get the auth user
        $auth_user = auth()->user();

        $data = [
            'status' => 'Accept'
        ];
        // dump($id);
        // dd($auth_user->id);
        $data = UserRelations::where('send_to','=',$auth_user->id)->where('send_by' ,'=',$id)
        ->update($data);
        return  response()->json(['message' => 'Request accepted'],200);
    }

    public function friendRequestCancle($id)
    {
        // get the auth user
        $auth_user = auth()->user();
        $data = UserRelations::where('send_to','=',$auth_user->id)->where('send_by' ,'=',$id)
        ->delete();
        return  response()->json(['message' => 'Request cancled'],200);
    }

    public function unfriendUser($id)
    {
        // get the auth user
        $auth_user = auth()->user();
        $update = [
            'status' => 'Reject'
        ];
        $data = UserRelations::where([['send_by','=', $id],['send_to', '=' ,$auth_user->id]])
                            ->orWhere([['send_by','=', $auth_user->id],['send_to', '=' ,$id]])
                            ->update($update);
        return  response()->json(['message' => 'User unfriend'],200);
    }
}
