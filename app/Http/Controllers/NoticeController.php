<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Http\Request;
use App\Http\Requests\StoreNoticeRequest;
use App\Http\Requests\UpdateNoticeRequest;

class NoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notices = Notice::latest()->get();
        // dd($notices);
        return view('notices',[
            'notices' => $notices
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('noticeAdd');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreNoticeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $added_by= auth()->user()->id;
        $attributes=request()->validate([
            'title'=> 'required | min:3 | max:255',
            'desc'=> 'nullable',
            'image' => 'max:500',
            'status' => 'nullable | boolean'
        ]);

        if (request()->has('image')) {
            // $fileName='FILE_'.md5(date('d-m-Y H:i:s')).$file->getClientOriginalName();
            $imageName='IMG_'.md5(date('d-m-Y H:i:s')).'.'.$request->image->extension();
            request()->image->move(public_path('assets/uploads/notices'), $imageName);
            $imageName = "assets/uploads/notices/".$imageName;
        }else{
            $imageName = "";
        }
        if($attributes['status'] == 1){
            $oldScheduleStatusUpdate = Notice::where('status', 1)
            ->update([
                'status'=> 0,
            ]);
        }
        $notice= Notice::create([
            'title'=> request()->input('title'),
            'desc'=> request()->input('desc'),
            'image' => $imageName,
            'status' => request()->input('status'),
            'added_by' => $added_by
        ]);
        return redirect('/notice/notices')->with('success', 'Notice has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function show(Notice $notice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function edit(Notice $notice)
    {
        // dd(bcrypt($user->password));
        return view('noticeEdit', [
            'notice' => $notice
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateNoticeRequest  $request
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function update(Notice $notice)
    {
        $attributes=request()->validate([
            'title'=> 'required | min:3 | max:255',
            'desc'=> 'nullable',
            'image' => 'max:150',
            'status'=> 'required | boolean',
        ]);
        if (request()->has('image')) {
            // File::delete($employee->image);
            if($notice->image){
                unlink(public_path($notice->image));
            }
            $imageName='IMG_'.md5(date('d-m-Y H:i:s')).'.'.request()->image->extension();
            request()->image->move(public_path('assets/uploads/notices'),$imageName);
            $imageName = "assets/uploads/notices/".$imageName;
        }else{
            $imageName = $notice->image;
        }
        if($attributes['status'] == 1){
            $oldScheduleStatus = Notice::where('status', 1)
            ->update([
                'status'=> 0,
            ]);
        }
        // dd(request()->all());
        Notice::where('id', $notice->id)->update([
            'title'=> request()->input('title'),
            'desc'=> request()->input('desc'),
            'image' => $imageName,
            'status' => request()->input('status')
        ]);
        return redirect('/notice/notices')->with('success', 'Notice has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function destroy($notice)
    {
        $data = Notice::findorFail($notice);
        // dd($data);
        if($data){
            if ($data->image) {
                unlink(public_path($data->image));
            }
            $data->delete();
            return back()->with('success', 'Notice has been deleted.');
        }else{
            return back()->with('error', 'Something went wrong!');
        }
    }
}
