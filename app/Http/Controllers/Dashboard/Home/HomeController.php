<?php

namespace App\Http\Controllers\Dashboard\Home;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
// Request
use Illuminate\Http\Request;
// Models
use App\Models\User;
use App\Models\Area;
use App\Models\Car;
use App\Models\CarCountryFactory;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Intro;
use App\Models\Order;
use App\Models\Refusal;
use App\Models\Slider;

class HomeController extends Controller
{

    public function index()
    {
        $statistic = [
            [
                'title'     => __('Admins'),
                'icon'      => 'bx-world',
                'count'     => User::where('user_type',User::TYPE_ADMIN)->count(),
            ],
            [
                'title'     => __('Customers'),
                'icon'      => 'bx-world',
                'count'     => User::where('user_type',User::TYPE_CUSTOMER)->count(),
            ],
            [
                'title'     => __('Providers'),
                'icon'      => 'bx-world',
                'count'     => User::where('user_type',User::TYPE_PROVIDER)->count(),
            ],
            [
                'title'     => __('Areas'),
                'icon'      => 'bx-world',
                'count'     => Area::where('parent',0)->count(),
            ],
            [
                'title'     => __('Cars'),
                'icon'      => 'bx-world',
                'count'     => Car::count(),
            ],
            [
                'title'     => __('Car Country Factories'),
                'icon'      => 'bx-world',
                'count'     => CarCountryFactory::count(),
            ],
            [
                'title'     => __('Contacts'),
                'icon'      => 'bx-world',
                'count'     => Contact::where('message_type','contact-us')->count(),
            ],
            [
                'title'     => __('Feedback'),
                'icon'      => 'bx-world',
                'count'     => Contact::where('message_type','feedback')->count(),
            ],
            [
                'title'     => __('Categories'),
                'icon'      => 'bx-world',
                'count'     => Category::count(),
            ],
            [
                'title'     => __('Intros'),
                'icon'      => 'bx-world',
                'count'     => Intro::count(),
            ],
            [
                'title'     => __('Sliders'),
                'icon'      => 'bx-world',
                'count'     => Slider::count(),
            ],
            [
                'title'     => __('Refusals'),
                'icon'      => 'bx-world',
                'count'     => Refusal::count(),
            ],
        ];
        $orders = [
            [
                'title'     => __('New Orders'),
                'icon'      => 'bx-world',
                'count'     => Order::where("order_status","new")->count(),
            ],
            [
                'title'     => __('Process Orders'),
                'icon'      => 'bx-world',
                'count'     => Order::where("order_status","process")->count(),
            ],
            [
                'title'     => __('Wait Pay Orders'),
                'icon'      => 'bx-world',
                'count'     => Order::where("order_status","wait_for_pay")->count(),
            ],
            [
                'title'     => __('Done Orders'),
                'icon'      => 'bx-world',
                'count'     => Order::where("order_status","done")->count(),
            ],
            [
                'title'     => __('Closed Orders'),
                'icon'      => 'bx-world',
                'count'     => Order::where("order_status","cancel")->count(),
            ],
        ];
        return view('admin.pages.home.index',get_defined_vars());
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }

    public function most_viewed(Request $request)
    {
        $typePath =  "\\App\\Helpers\\Charts\\".$request->type;
        $typeInstance = new $typePath();

        return $typeInstance->most_viewed();
        return $request->all();
    }
}
