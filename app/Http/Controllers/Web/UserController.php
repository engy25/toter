<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\{
    User,
    RoleTranslation,
    Currency,
    Device,
    Notification,
    Addon,Country
};
use App\Helpers\Helpers;
use App\Http\Requests\Web\UpdateBalanceWalletRequest;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public $helper;
    public function __construct()
    {
        $this->helper = new Helpers();

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_role = RoleTranslation::where("name", "user")->first();
        $default_currency = Currency::where("default", 1)->first();

        $users = User::where("role_id", $user_role->role_id)->orderByDesc("id")->paginate(PAGINATION_COUNT);
        return view("users.index", compact("users", "default_currency"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user = User::with("orders", "walletTransactions")->find($user->id);
        $orders_user = $user->orders()->get();

        $wallet = $user->walletTransactions;

        $currency_default = Currency::where("default", 1)->first();
        return view("users.show", compact("user", "orders_user", "wallet", "currency_default"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view("users.edit", compact("user"));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(UpdateBalanceWalletRequest $request, User $user)
    {
        $default_currency = Currency::where("default", 1)->first();
        $wallet_transactions = $user->walletTransactions;

        /**
         * if admin want add balnce we add to the balance exists
         */

        $wallet_user_transaction = $user->walletTransactions();
        /**update the balance */
        $wallet_user_transaction->update([
            "balance" => $wallet_transactions->balance + $request->add_balance
        ]);

        /**send notification to the user */
        $message = [
            'title_ar' => "تم اضافه رصيدالي المحفظة ",
            'title_en' => "Balence Added Successfully To Your Wallet",
            'body_en' => "Balence Added Successfully To Your Wallet " . $request->add_balance . $default_currency->isocode,
            'body_ar' => " تم اضافه رصيدالي المحفظة  " . $request->add_balance . $default_currency->isocode,

        ];
        $this->sendNotification($message, $user->id);

        return redirect()->route('users.index')->with('success', 'User has been updated successfully.');
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }

    public function WalletDetails($id)
    {
        $user = User::with('walletTransactions')->whereId($id)->first();
        $wallet_user = $user->walletTransactions;

        return view("users.index_wallet_image", compact("wallet_user"));


    }



    private function sendNotification($message, $user_id)
    {
        $device_id = Device::where('user_id', $user_id)->pluck('device_token')->toArray();
        if (isset($device_id)) {
            $this->helper->androidPushNotification($device_id, $message);
            Notification::create([
                'user_id' => $user_id,
                'title' => ['en' => $message['title_en'], 'ar' => $message['title_ar']],
                'data' => ['en' => $message['body_en'], 'ar' => $message['body_ar']],
            ]);

        }
    }





public function ll()
{
  return Country::with('currency')->orderBy('id','desc')->get();
}






}
