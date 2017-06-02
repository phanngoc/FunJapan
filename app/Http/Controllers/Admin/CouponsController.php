<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Auth;
use Session;
use App\Services\Admin\CouponService;
use App\Http\Requests\Admin\CreateCouponRequest;
use App\Http\Requests\Admin\UpdateCouponRequest;

class CouponsController extends Controller
{
    public function index()
    {
        return view('admin.coupons.index');
    }

    public function create()
    {
        return view('admin.coupons.create');
    }

    public function show($id)
    {
        $coupon = CouponService::find($id);
        if ($coupon) {
            $this->viewData['coupon'] = $coupon;
            return view('admin.coupons.show', $this->viewData);
        }

        return redirect()->action('Admin\CouponsController@index')
                ->withErrors(['errors' => trans('admin/coupon.coupon_not_exists')]);
    }

    public function edit($id)
    {
        $coupon = CouponService::find($id);
        if ($coupon) {
            $this->viewData['coupon'] = $coupon;
            return view('admin.coupons.edit', $this->viewData);
        }

        return redirect()->action('Admin\CouponsController@index')
                ->withErrors(['errors' => trans('admin/coupon.coupon_not_exists')]);
    }

    public function update(UpdateCouponRequest $request, $id)
    {
        if (CouponService::update($request->all(), $id)) {
            return redirect()->action('Admin\CouponsController@index')
                ->with(['message' => trans('admin/coupon.update_successfully')]);
        } else {
            return redirect()->back()->withErrors(['errors' => trans('admin/coupon.update_error')]);
        }
    }

    public function store(CreateCouponRequest $request)
    {
        $coupon = CouponService::create($request->all());
        if ($coupon) {
            return redirect()->action('Admin\CouponsController@index')
                ->with(['message' => trans('admin/coupon.create_successfully')]);
        }

        return redirect()->back()->withErrors(['errors' => trans('admin/coupon.create_error')]);
    }

    public function destroy($id)
    {
        $isDestroy = CouponService::delete($id);
        if ($isDestroy) {
            Session::flash('message', trans('admin/coupon.delete_successfully'));
            return response()->json(['status' => 200, 'success' => true]);
        } else {
            Session::flash('error', trans('admin/coupon.delete_error'));
            return response()->json(['status' => 200, 'success' => false]);
        }
    }

    public function getListCoupons(Request $request)
    {
        $params = $request->all();
        $draw = $params['draw'];
        $couponsData = CouponService::list($params);
        $couponsData['draw'] = (int)$draw;

        return $couponsData;
    }
}
