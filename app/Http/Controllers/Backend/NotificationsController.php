<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Cms\Slider\CreateRequest;
use App\Http\Requests\Backend\Shared\ChangeStatusRequest;
use App\Models\Attribute;
use App\Models\Slider;
use App\Models\UserNotications;
use App\Traits\ButtonTrait;
use App\Traits\DatatableTrait;
use Illuminate\Http\Request;
use phpseclib3\File\ASN1\Maps\UniqueIdentifier;
class NotificationsController extends Controller
{
    use DatatableTrait;
    use ButtonTrait;

    #region index
    public function index()
    {
        if (!permission_can('show sliders', 'admin')) {
            return abort(403);
        }
        $datatable_route = route('backend.cms.notifications.datatable');
        $delete_all_route = route('backend.cms.notifications.delete-selected');
        #region data table columns
        $datatable_columns = [];
        $datatable_columns['placeholder'] = '';
        $datatable_columns['id'] = 'id';
        $datatable_columns['title'] = 'title';
        $datatable_columns['created_at'] = 'created_at';
        $datatable_columns['updated_at'] = 'updated_at';
        $datatable_columns['status'] = 'status';
        $datatable_columns['actions'] = 'actions';
        #endregion
        $datatable_script = $this->create_script_datatable($datatable_route, $datatable_columns, $delete_all_route);
        $switch_script = null;
        $switch_route = route('backend.cms.notifications.change.status');
        $switch_class = 'status';
        $switch_script = $this->status_switch_script($switch_route, $switch_class);
        $create_button = '';
        if (permission_can('create slider', 'admin')) {
            $create_button = $this->create_button(route('backend.cms.notifications.create'), 'Create new notification');
        }
        return view('backend.notifications.index', compact('datatable_script', 'create_button', 'switch_script'));
    }

    public function datatable()
    {
        if (!permission_can('show notifications', 'admin')) {
            return abort(403);
        }

        $model = UserNotications::query();

        return datatables()->make($model)
            ->addColumn('placeholder', function ($q){
                return '';
            })
            ->editColumn('status', function ($q) {
                $bool = !permission_can('change status notification', 'admin');
                return $this->status_switch($q->id, $q->status, 'status', $bool);
            })
            ->editColumn('title', function ($q) {
                return trans($q->title);
            })

            ->addColumn('actions', function ($q) {
                $actions = '';
                if (permission_can('edit notification', 'admin')) {
                    $actions .= $this->edit_button(route('backend.cms.notifications.edit', ['notification' => $q->id]));
                }
                if (permission_can('delete notification', 'admin')) {
                    $actions .= $this->delete_button(route('backend.cms.notifications.destroy', ['notification' => $q->id]), $q->name);
                }
                return $actions;
            })
            ->rawColumns(['actions', 'title','status'])->toJson();
    }
    #endregion

    #region create
    public function create()
    {
        $types = [
            'main' => trans('backend.slider.main'),
            'banner' => trans('backend.slider.banner'),
            ];
        return view('backend.notifications.create', compact('types'));
    }

    public function store(Request $request)
    {
        foreach (get_languages() as $language) {
            $title[$language->code] = $request->has('title_' . $language->code) && !empty($request->get('title_' . $language->code)) ? $request->get('title_' . $language->code) : $request->get('title_' . get_languages()[0]->code);
        }
        UserNotications::create([
            'title' => $title,
            'status'=> $request->status?1:0]);

        return redirect()->route('backend.cms.notifications.index')->with('success', trans('backend.global.success_message.created_successfully'));
    }
    #endregion

    #region edit
    public function edit($id)
    {
        $notification = UserNotications::findOrFail($id);

        return view('backend.notifications.edit', compact('notification'));
    }

    public function update(Request $request, $id)
    {
        $slider = UserNotications::findOrFail($id);

        foreach (get_languages() as $language) {
            $title [$language->code] = $request->get('title_' . $language->code) ;
        }
        $slider->update([
            'title' => $title,
            'status'=> $request->status?1:0]);

        return redirect()->route('backend.cms.notifications.index')->with('success', trans('backend.global.success_message.updated_successfully'));
    }

    #endregion

    #region destroy
    public function destroy($id){
        if (!permission_can('delete slider', 'admin')) {
            return abort(403);
        }

        if (Slider::destroy($id)) {
            return response()->data(['message' => trans('backend.global.success_message.deleted_successfully')]);
        }
        return response()->error(trans('backend.global.error_message.error_on_deleted'));
    }
    #endregion

    #region change status
    function change_status(ChangeStatusRequest $request)
    {
        if (!permission_can('change status notification', 'admin')) {
            return abort(403);
        }
        $id = $request->id;
        $slider = UserNotications::find($id);
        if ($slider->status == 1) {
            $slider->status = 0;
        } else {
            $slider->status = 1;
        }
        if ($slider->save()) {
            return response()->data(['message' => trans('backend.global.success_message.changed_status_successfully')]);
        }
        return response()->error(trans('backend.global.error_message.cant_updated'));
    }
    #endregion
}
