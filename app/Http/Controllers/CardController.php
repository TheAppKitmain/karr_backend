<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Stripe\Customer;
use Stripe\Subscription;
use Stripe\PaymentMethod;
use Stripe\Token;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;
use Stripe\Subscription as StripeSubscription;
use Stripe\SubscriptionItem;

class CardController extends Controller
{
    public function card(Request $request)
    {
        try {
            $count = Card::all()->count();
            if ($count < 3) {
                $data = $request->validate([
                    'name' => 'required|max:255',
                    'card' => 'required|integer',
                    'cvc' => 'required',
                    'mon' => 'required|max:2',
                    'year' => 'required|max:4',
                    'user_id' => 'required',
                ]);
                Card::create($data);
                return back()->with('success', 'Card is added successfully');
            } else {
                return back()->with('error', 'Already 3 cards are added');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Oops card is not added');
        }
    }
    public function cardDelete($id)
    {
        $card = Card::find($id);
        $card->destory();
        return back()->with('success', 'Card is delete successfully');
    }

    public function myAccount()
    {
        $user = Card::where('user_id', Auth::user()->id)->where('status' , 1)->first();
        if ($user) {
            return view('profile.my-account', compact('user'));
        } else {
            $user = User::where('id', Auth::user()->id)->first();
            return view('profile.my-account', compact('user'));
        }
    }

    public function createSubscription(Request $request)
    {
        try {

            Stripe::setApiKey(env('STRIPE_SECRET'));
            $user_id = Auth::user()->id;
            $check = Card::where('card', $request->card)->first(); 
            // if there is already existence of card
            if ($check) {

                // Create a Stripe Customer with the payment token
                $customer = Customer::create([
                    'email' => $request->user()->email,
                    'source' => $request->input('stripeToken'),
                    'name'  => $request->input('name'),
                ]);

                $subscription = Subscription::create([
                    'customer' => $customer->id,
                    'items' => [
                        [
                            'price' => 'price_1OI9AXFzC65vT5pxobNGdjqL',
                        ],
                    ],
                    'collection_method' => 'charge_automatically',
                ]);
                $card = new Card();
                $card->trial_end = now();
            } else {

                // Create a Stripe Customer with the payment token
                $customer = Customer::create([
                    'email' => $request->user()->email,
                    'source' => $request->input('stripeToken'),
                    'name'  => $request->input('name'),
                ]);

                $subscription = Subscription::create([
                    'customer' => $customer->id,
                    'items' => [
                        [
                            'price' => 'price_1OI9AXFzC65vT5pxobNGdjqL',
                        ],
                    ],
                    'trial_end' => strtotime('+60 days'),
                    'collection_method' => 'charge_automatically',
                ]);
                $card = new Card();
                $card->trial_end = now()->addDays(60);
            }

            $card->user_id = $user_id;
            $card->subscription_id = $subscription->id;
            $card->customer_id = $subscription->customer;
            $card->trial_start = now();
            $card->name = $request->name;
            $card->card = $request->card;
            $card->cvc = $request->cvc;
            $card->mon = $request->mon;
            $card->year = $request->year;
            $card->save();

            //Assign User role of admin

            $user = User::find($user_id);
            $adminRole = Role::where('name', 'admin')->first();
            $user->assignRole($adminRole);
            $user->removeRole('user');

            return redirect()->back()->with('success', 'Subscription created successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() . 'Subscription not created');
        }
    }
    public function cancelSubscription(Request $request, $id)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $user = User::find($id);

            if (!$user) {
                return redirect()->back()->with('error', 'User not found');
            }
            $subscriptionDetails = Card::where('user_id', $user->id)->where('card', $request->card)->first();
            // return $subscriptionDetails->customer_id;

            if (!$subscriptionDetails) {
                return redirect()->back()->with('error', 'Subscription details not found');
            }
            //   dd($subscriptionDetails->customer_id);
            $customer = Customer::retrieve($subscriptionDetails->customer_id);
            $subscription = Subscription::retrieve($subscriptionDetails->subscription_id);

            $subscription->cancel();

            // Update subscription details
            $subscriptionDetails->status = 0;
            $subscriptionDetails->save();

            // Assign the 'user' role to the user
            $user->syncRoles(['User']);
            $user->removeRole('Admin');
            // Logout the user
            Auth::logout();

            return redirect()->route('login');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() . ' Subscription is not canceled');
        }
    }
}
