<?php

namespace App\Http\Controllers\Dashboard\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Http\UploadedFile;

class SettingsController extends Controller
{
    
    public function index()
    {
        $breadcrumb = [
            'title' =>  __("Settings List"),
            'items' =>  [
                [
                    'title' =>  __("Settings List"),
                    'url'   =>  '#!',
                ]
            ],
        ];
        $lists = Setting::FORM_INPUTS;

        return view('admin.pages.settings.index',[
            'breadcrumb'=>$breadcrumb,
            'lists'=>$lists,
        ]);
    }

    public function edit($group_by = null)
    {
        $lists = Setting::FORM_INPUTS;
        if(is_null($group_by) || !key_exists($group_by,$lists)) {
            abort(404);
        }
        $breadcrumb = [
            'title' =>  __("Edit Settings"),
            'items' =>  [
                [
                    'title' =>  __("Settings List"),
                    'url'   =>  route('admin.settings.index'),
                ],
                [
                    'title' =>  __("Edit Settings"),
                    'url'   =>  '#!',
                ],
            ],
        ];
        $form = $lists[$group_by]['form'];
        return view('admin.pages.settings.edit',[
            'breadcrumb'=>$breadcrumb,
            'group_by'=>$group_by,
            'form'=>$form,
        ]);
    }

    public function update(Request $request, $group_by = null)
    {
        try {
            $lists = Setting::FORM_INPUTS;
            if(is_null($group_by) || !key_exists($group_by,$lists)) {
                abort(404);
            }
            $request = request()->all();
            unset($request['_token']);
            unset($request['_method']);
            $my = [];
            foreach(config('laravellocalization.supportedLocales') as $key=>$value) {
                $my[$key] = (array_key_exists($key,$request)) ? $request[$key]: [];
                unset($request[$key]);
            }
            foreach($request as $k=>$v) {
                foreach(config('laravellocalization.supportedLocales') as $key=>$value) {
                    $my[$key][$k] = $v;
                }
            }
            $end = [];
            foreach($my as $key=>$value) {
                foreach($value as $x=>$y) {
                    $end[$x][$key] = ['value'=>$this->filterValue($y,$x)];
                }
            }
            foreach($end as $key=>$value) {
                $check = Setting::where(['key' => $key,'group_by'=> $group_by])->first();
                if(!is_null($check)) {
                    $check->update($value);
                } else {
                    $value['key']       = $key;
                    $value['group_by']  = $group_by;
                    Setting::create($value);
                }
            }
            return redirect()->route('admin.settings.index')->with('success', __("This data has been updated."));
        
        } catch (\Throwable $th) {
            return redirect()->route('admin.settings.index')->with('error', __("Internal server error."));
        }
    }

    public function filterValue($value,$key)
    {
        if ($value instanceof UploadedFile) {
            $value = imageUpload($value, 'stander');
        }
        if (is_array($value) ) {
            foreach($value as $k => $v) {
                $value = $v;
            }
        }
        return $value;
    }
}
