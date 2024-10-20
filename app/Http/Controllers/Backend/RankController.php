<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;

use App\Traits\ButtonTrait;
use App\Traits\DatatableTrait;
use Illuminate\Http\Request;
use App\Models\Ranks;
use Illuminate\Support\Facades\Validator;

class RankController extends Controller
{
    use DatatableTrait;
    use ButtonTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!permission_can('show product', 'admin')) {
            return abort(403);
        }
        $filters[] = 'status';
        // $filters[] = 'type';
        // $filters[] = 'category';
        // $filters[] = 'brand';
        // $filters[] = 'manufacturer';
        // $filters[] = 'is_featured';
        // $filters[] = 'is_visibility';
        // $filters[] = 'is_super_sales';
        // $filters[] = 'is_best_seller';
        // $filters[] = 'is_today_deal';
        // $filters[] = 'is_on_sale';
        // $filters[] = 'is_saudi_branch';
        // $filters[] = 'price_is_hidden';
        // $filters[] = 'max_price';
        // $filters[] = 'min_price';
        // $filters[] = 'is_bundle';
        // $filters[] = 'is_free_shipping';
        // $filters[] = 'discount_offer';
        // $filters[] = 'has_serial_numbers';
        // $filters[] = 'type';
        // $filters[] = 'quantity';
        // $filters[] = 'manufacturer_type';
        // $filters[] = 'brand';
        // $filters[] = 'model';
        // $filters[] = 'year';
        // $filters[] = 'start_date';
        // $filters[] = 'end_date';

        $datatable_route = route('backend.ranks.datatable');
        $delete_all_route = permission_can('delete product', 'admin') ? route('backend.ranks.delete-selected') : null;
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
        $datatable_script = $this->create_script_datatable($datatable_route, $datatable_columns, $delete_all_route, $filters);
        $switch_script = null;
        $switch_route = route('backend.ranks.change.status');
        $switch_class = 'status';
        $switch_script = $this->status_switch_script($switch_route, $switch_class);
        $switch_column = route('backend.products.change.column');


        $create_button = '';
        if (permission_can('create product', 'admin')) {
            $create_button = $this->create_button(route('backend.ranks.create'), 'Create new rank');
        }
        return view('backend.rank.index', compact('datatable_script', 'switch_script',
            'create_button',));
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.rank.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $languages = get_languages();
        $firstLanguageCode = $languages[0]->code;
    
        // Define validation rules
        $rules = [
            'image' => 'required',
            'title_' . $firstLanguageCode => 'required|string|max:255',
            'description_' . $firstLanguageCode => 'required|string',
        ];
    
        // Add optional rules for other languages
        foreach ($languages as $language) {
            if ($language->code !== $firstLanguageCode) {
                $rules['title_' . $language->code] = 'nullable|string|max:255';
                $rules['description_' . $language->code] = 'nullable|string';
            }
        }
    
        // Validate the request
        $validator = Validator::make($request->all(), $rules);
    
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
    
        // Proceed with saving the data if validation passes
        $product = new Ranks();
        $title = [];
        $description = [];
        foreach ($languages as $language) {
            $title[$language->code] = $request->get('title_' . $language->code);
            $description[$language->code] = $request->get('description_' . $language->code);
        }
    
        $product->title = $title;
        $product->description = $description;
        $product->icon = $request->image;

    
        if ($request->special_price == 1) {
            $product->is_special_price = 1;
            $product->discount_value = $request->discount;
        } else {
            $product->is_special_price = 0;
            $product->discount_value = 0;
        }
    
        if ($request->get_coupon == 1) {
            $product->is_coupon = 1;
            $product->coupon_value = $request->coupon_code;
        }
        else{
            $product->is_coupon = 0;
            $product->coupon_value = 0;
        }
    
        $product->status = $request->status;
        $product->save();
    
        return redirect()->route('backend.ranks.index')->with('success', trans('backend.global.success_message.created_successfully'));
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
        $rank = Ranks::where('id',$id)->first();
        return view('backend.rank.edit',compact('rank'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function datatable(Request $request)
    {
        if (!permission_can('show product', 'admin')) {
            return abort(403);
        }
        $model = Ranks::query();

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
            'show_product_series_number' => permission_can('show product serial number', 'admin'),
        );
        $default_images = media_file(get_setting('default_images'));
        return datatables()->make($model)
            ->addColumn('placeholder', function ($q) {
                return '';
            })
            ->editColumn('title', function ($q) {
                return $q->title;
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
                    $actions .= $this->edit_button(route('backend.ranks.edit', ['rank' => $q->id]));
                }
                if ($permission['delete']) {
                    $actions .= $this->delete_button(route('backend.ranks.destroy', ['rank' => $q->id]));
                }
                return $actions;
            })
            ->editColumn('image', function ($q) use ($default_images) {
                return '<img width="75px" onerror="this.src=' . "'" . $default_images . "'" . '" src="' . media_file($q->icon) . '">';
            })


            ->rawColumns(['actions', 'status', 'image',
                'title',
                'created_at',
                'updated_at',

            ])
            ->toJson();
    }

    public function change_status()
    {

    }
    public function delete_selected_items()
    {

    }
}
