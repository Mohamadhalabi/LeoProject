<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentMethods;
use App\Traits\ButtonTrait;
use App\Traits\DatatableTrait;
use App\Traits\SerializeDateTrait;
use Cache;
use http\Env\Response;
use function Symfony\Component\HttpFoundation\getLanguages;
class PaymentMethodsController extends Controller
{
    use ButtonTrait;
    use DatatableTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!permission_can('setting payment_methods', 'admin')) {
            return abort(403);
        }
        $filters = [];
        $filters[] = 'status';
        $datatable_route = route('backend.setting.payment-methods.datatable');
        $delete_all_route = route('backend.setting.payment-methods.delete-selected');

        #region data table columns
        $datatable_columns = [];
        $datatable_columns['placeholder'] = '';
        $datatable_columns['id'] = 'id';
        $datatable_columns['title'] = 'title';
        $datatable_columns['image'] = 'image';
        $datatable_columns['created_at'] = 'created_at';
        $datatable_columns['updated_at'] = 'updated_at';
        $datatable_columns['status'] = 'status';
        $datatable_columns['actions'] = 'actions';
        #endregion
        $datatable_script = $this->create_script_datatable($datatable_route, $datatable_columns, $delete_all_route, $filters,);
        $switch_script = null;
        $switch_route = route('backend.setting.payment-methods.change.status');
        $switch_class = 'status';
        $switch_script = $this->status_switch_script($switch_route, $switch_class);

        $create_button = '';
        if (permission_can('setting payment_methods', 'admin')) {
            $create_button = $this->create_button(route('backend.setting.payment-methods.create'), 'Create new payment method');
        }
        return view('backend.payments.index', compact('datatable_script', 'switch_script', 'create_button'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.payments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $payment_method = new PaymentMethods();
        $title = [];
        $description = [];
        $languages = get_languages();
        foreach ($languages as $language) {
            $title [$language->code] = $request->has('title_' . $language->code) && !empty($request->get('title_' . $language->code)) ? $request->get('title_' . $language->code) : $request->get('title_' . $languages[0]->code);
            $description [$language->code] = $request->has('description_' . $language->code) && !empty($request->get('description_' . $language->code)) ? $request->get('description_' . $language->code) : $request->get('description_' . $languages[0]->code);
        }
        $payment_method->icon = $request->image;
        $payment_method->description = $description;
        $payment_method->name = $title;
        $payment_method->status = $request->status;
        $payment_method->save();

        return redirect()->route('backend.setting.payment-methods.index')->with('success', trans('backend.global.success_message.created_successfully'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = PaymentMethods::where('id',$id)->first();
        return view('backend.payments.edit',compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $payment_method = PaymentMethods::where('id',$id)->first();
        $title = [];
        $description = [];
        $languages = get_languages();
        foreach ($languages as $language) {
            $title [$language->code] = $request->has('title_' . $language->code) && !empty($request->get('title_' . $language->code)) ? $request->get('title_' . $language->code) : $request->get('title_' . $languages[0]->code);
            $description [$language->code] = $request->has('description_' . $language->code) && !empty($request->get('description_' . $language->code)) ? $request->get('description_' . $language->code) : $request->get('description_' . $languages[0]->code);
        }
        $payment_method->icon = $request->image;
        $payment_method->description = $description;
        $payment_method->name = $title;
        $payment_method->status = $request->status;
        $payment_method->save();

        return redirect()->route('backend.setting.payment-methods.index')->with('success', trans('backend.global.success_message.created_successfully'));
      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (PaymentMethods::destroy($id)) {
            return response()->data(['message' => trans('backend.global.success_message.deleted_successfully')]);
        }
        return response()->error(trans('backend.global.error_message.error_on_deleted'));
    }

    public function datatable(Request $request)
    {
        if (!permission_can('show product', 'admin')) {
            return abort(403);
        }
        $model = PaymentMethods::query();

        $permission = array(
            'edit' => permission_can('edit product', 'admin'),
            'create' => permission_can('create product', 'admin'),
            'delete' => permission_can('delete product', 'admin'),
            'change_status' => permission_can('change status product', 'admin'),
            'change_feature' => permission_can('change feature product', 'admin'),
            'change_visibility' => permission_can('change visibility product', 'admin'),
            'change_super_sales' => permission_can('change super sales product', 'admin'),
            'change_best_seller' => permission_can('change best seller product', 'admin'),
            'change_today_deal' => permission_can('change today deal product', 'admin'),
            'change_free_shipping' => permission_can('change free shipping product', 'admin'),
        );
        $default_images = media_file(get_setting('default_images'));
        return datatables()->make($model)
            ->addColumn('placeholder', function ($q) {
                return '';
            })
            ->editColumn('title', function ($q) {
                return $q->name;
            })
            ->editColumn('created_at', function ($q) {
                return '<span class="badge badge-info">' . $q->created_at . '</span>';
            })


            ->editColumn('updated_at', function ($q) {
                return '<span class="badge badge-light">' . $q->updated_at . '</span>';
            })

            ->editColumn('status', function ($q) use ($permission) {
                return $this->status_switch($q->id, $q->status, 'status', !$permission['change_status']);
            })


            ->addColumn('actions', function ($q) use ($permission) {
                $actions = '';
                if ($permission['edit']) {
                    $actions .= $this->edit_button(route('backend.setting.payment-methods.edit', ['payment_method' => $q->id]));
                }
                if ($permission['delete']) {
                    $actions .= $this->delete_button(route('backend.setting.payment-methods.destroy', ['payment_method' => $q->id]));
                }
                return $actions;
            })
            ->editColumn('image', function ($q) use ($default_images) {
                return '<img width="75px" onerror="this.src=' . "'" . $default_images . "'" . '" src="' . media_file($q->icon) . '">';
            })

            ->rawColumns(['description', 'status', 'title', 'image',
                'actions',
                'created_at',
                'updated_at',

           
                

            ])
            ->toJson();
    }

    public function change_status(Requqest $request)
    {

    }

    public function delete_selected_items(Request $request)
    {

    }
}
