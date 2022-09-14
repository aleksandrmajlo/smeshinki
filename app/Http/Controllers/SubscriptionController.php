<?php

namespace App\Http\Controllers;

use App\Mail\SubscriptionMail;
use App\Mail\SubscriptionSend;
use App\Models\Subscription;
use App\Models\Word;
use App\Models\Anecdote;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;


class SubscriptionController extends Controller
{

    //получение почты
    public function subscription(Request $request)
    {

        $uniqid = uniqid('', true);
        $email = trim($request->email);
        $subscription = Subscription::where('email', $email)->first();
        // если есть почта
        if ($subscription) {
            $subscription->remember_token = $uniqid;
            $subscription->save();
        } else {
            Subscription::create([
                'email' => $email,
                'remember_token' => $uniqid,
                'updated_at' => null
            ]);
        }
        try {
            \Mail::to($email)->send(new SubscriptionMail($uniqid));
        } catch (Exception $e) {

        }
        return response()->json(['suc' => 1]);
    }

    // активация
    public function activation(Request $request)
    {
        $activation = $request->activation;
        $subscription = Subscription::where('remember_token', $activation)->first();
        if ($subscription) {
            meta()
                ->set('title', __('Дякую за підписку'))
                ->set('description', __('Дякую за підписку'));
//            $subscription->email_verified_at = Carbon::now();
//            $subscription->updated_at = null;
//            $subscription->save();
            \DB::table('subscriptions')
                ->where('remember_token', $activation)
                ->update([
                    'email_verified_at' => Carbon::now(),
                ]);

            return view('subscription', [
            ]);
        } else {
            abort('404');
        }
    }

    // сама розсылка
    public function send()
    {

        // начинаем с  10 часов
        $date=Carbon::now("Europe/Kiev");
        if($date->hour<10){
            return false;
        }

        $limit = 10;
        $limit_anecdote = 3;
        $offset = \DB::table('subscription_offset')->find(1);

        $subscriptions = Subscription::whereNotNull('email_verified_at')
            ->whereDate('updated_at', '!=', Carbon::now()->format('Y-m-d'))
            ->orWhereNull('updated_at')
            ->offset($offset->offset)
            ->limit($limit)
            ->get();


        $subscription_count = Subscription::whereNotNull('email_verified_at')
            ->whereDate('updated_at', '!=', Carbon::now()->format('Y-m-d'))
            ->orWhereNull('updated_at')
            ->count();

//        dd($subscriptions);

        // cама расылка
        if ($subscriptions->isNotEmpty()) {
            // записи за  прошлый день
            $yesterday = Carbon::yesterday();
            $words = Word::whereNotNull('photo')
                ->whereDate('created_at', '=', $yesterday)
                ->get();

            foreach ($subscriptions as $subscription) {
                // получить данные  по анектотам
                $subscription_datas = \DB::table('subscription_datas')
                    ->where('subscription_id', $subscription->id)
                    ->where('type', 'anecdotes')
                    ->first();

                if ($subscription_datas) {
                    $subscription_ids = json_decode($subscription_datas->ids);
                    $anecdotes = Anecdote::limit($limit_anecdote)->inRandomOrder()
                        ->whereNotIn('id', $subscription_ids)
                        ->get();

                    $ids = $anecdotes->pluck('id')->toArray();
                    $result = array_merge($ids, $subscription_ids);
                    \DB::table('subscription_datas')
                        ->where('subscription_id', $subscription->id)
                        ->where('type', 'anecdotes')
                        ->update([
                            'ids' => json_encode($result)
                        ]);

                } else {
                    // первая отправка анектодов
                    $anecdotes = Anecdote::limit($limit_anecdote)->inRandomOrder()
                        ->get();
                    $ids = $anecdotes->pluck('id')->toArray();
                    // сохраняем что была  отправка данных ид
                    \DB::table('subscription_datas')->insert([
                        'subscription_id' => $subscription->id,
                        'type' => 'anecdotes',
                        'ids' => json_encode($ids)
                    ]);
                }

                // обновить - что рассылка пошла
                $subscription->updated_at = Carbon::now();
                // раскоментировать
                $subscription->save();

                // тут отсылка
                if ($words->isNotEmpty() || $anecdotes->isNotEmpty()) {
                    try {
                        \Mail::to($subscription->email)->send(new SubscriptionSend($words, $anecdotes));
                    } catch (Exception $e) {

                    }
                }
            }
        }

        // обновить отступ
        $offset_new = $limit + $offset->offset;
        if ($offset_new >= $subscription_count) {
            $offset_new = 0;
        }
        \DB::table('subscription_offset')->where('id', 1)
            ->update(['offset' => $offset_new]);

    }

    // подписка отписка пользователя
    public function user_subs(Request $request){

        $sub=$request->sub;
        $user=Auth::user();
        $sub_user=Subscription::where('user_id',$user->id)->first();

        if($sub==1){
            // подписатся
            if($sub_user){
                $sub_user->email_verified_at=Carbon::now();
                $sub_user->save();
            }else{
                Subscription::create([
                    'email' => $user->email,
                    'email_verified_at'=>Carbon::now(),
                    'user_id'=>$user->id,
                    'updated_at' => null
                ]);
            }
        }else{
            // отписаться
            if($sub_user){
                $sub_user->email_verified_at=null;
                $sub_user->save();
            }
        }
        return redirect()->back();
    }

}
