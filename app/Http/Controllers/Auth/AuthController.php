<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Mews\Captcha\Facades\Captcha;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }
    
    public function register()
    {
        return view('register');
    }
    
    public function unauthorized()
    {
        return view('unauthorized');
    }
    
    public function registerSuccess()
    {
        return view('register_success');
    }
    
    public function complete()
    {
        return view('complete');
    }
    
    public function sync()
    {
        return view('sync');
    }
    
    public function syncAck()
    {
        $data = TrMessages::where('phone', auth()->user()->no_telepon)
            ->where('members_id', null)
            ->get();

        foreach($data as $item) {
            $update = TrMessages::find($item->id);
            $update->members_id = auth()->user()->id;
            $update->save();
        }
        return response()->json(['status' => 'success', 'error' => ''], 200);
    }

    public function completeAction(Request $request)
    {
        $data = Members::find(auth()->user()->id);
        $data->no_telepon = formatPhoneNumber($request->no_telepon);
        $data->save();
        return response()->json(['status' => 'success', 'error' => ''], 200);
    }
    
    public function verify($token)
    {
        if (isset(explode('#',crypto($token, 'decrypt'))[1])) {
            $id = explode('#',crypto($token, 'decrypt'))[0];
            if (explode('#',crypto($token, 'decrypt'))[1] < Carbon::now()) {
                $data = Members::find($id);
                $data->delete();
                $message = 'Expired Token, Silahkan Mendaftar kembali';
                $class = 'danger';
            } else {
                $data = Members::find($id);
                if ($data->status!='ACTIVE') {
                    $data->status = 'ACTIVE';
                    $data->email_verified_at = Carbon::now();
                    $data->save();
                    $message = 'Selamat, akun anda berhasil terverifikasi, silahkan login dan post aduan anda.';
                    $class = 'primary';
                } else {
                    $message = 'Anda sudah memverifikasi akun anda, silahkan login';
                    $class = 'primary';
                }
            }
        } else {
            $message = 'Invalid Token!';
            $class = 'danger';
        }
        return view('verify', ['message' => $message, 'class' => $class]);
    }

    public function registerAction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:members',
            'no_telepon' => 'required',
            'password' => 'required|min:7|confirmed',
            'password_confirmation' => 'required|min:7',
        ]);
        $formattedPhoneNumber = formatPhoneNumber($request->no_telepon);

        if (Members::where('no_telepon', $formattedPhoneNumber)->exists()) {
            return response()->json(['response' => 'validate', 'error' => 'Nomor telepon sudah terdaftar']);
        }

        if ($validator->fails()) {
            $validate = [];
            foreach($validator->errors()->all() as $val) {
                $validate[] = $val;
            }
            return response()->json(['response' => 'validate', 'error' => str_replace('.','',implode(', ', $validate))]);
        } else {
            try {
                $client = new Client(['verify' => false]);
                $response = $client->post('https://www.google.com/recaptcha/api/siteverify', [
                    'form_params' => [
                        'secret' => '6LcixhUkAAAAACKILlHKqrsmcP9FUJRsZkcQFt0o',
                        'response' => $request->recaptcha
                    ]
                ]);
                DB::select("SET timezone TO 'Asia/Jakarta'");
                $body = json_decode((string)$response->getBody());
                if ($body->success != true) {
                    return response()->json(['status' => 'recaptcha', 'error' => 'Pastikan anda bukan robot']);
                } else {
                    $data = new Members;
                    $data->email = $request->email;
                    $data->no_telepon = $formattedPhoneNumber;
                    $data->nama_lengkap = $request->nama_lengkap;
                    $data->password = bcrypt($request->password);
                    $data->status = 'PENDING';
                    $data->save();

                    $action_url = config('app.url').'/verify/'.removeSpecialChars(crypto($data->id.'#'.Carbon::now()->addDays(3), 'encrypt'));
                    $message = 'Selamat datang di LaporBup, '.$data->nama_lengkap.' Portal Laporan Pengaduan Online Pemerintah Kabupaten Cilacap Silahkan klik tombol di bawah ini untuk verifikasi \r\n'.$action_url;
                    sendReply($data->no_telepon, $message);
                    SendMailAccountConfirmation($data->email, $action_url);

                    return response()->json(['status' => 'success', 'error' => 'Berhasil Register', 'error' => false], 200);
                } 
            } catch (\Exception $e) {
                return response()->json(['status' => 'error', 'error' => $e->getMessage()]);
            }
        }
    }

    public function loginAction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
            
        ]);
        

        if ($validator->fails()) {
            $validate = [];
            foreach($validator->errors()->all() as $val) {
                $validate[] = $val;
            }
            return response()->json(['response' => 'validate', 'error'=>str_replace('.','',implode(', ', $validate))]);
        } else {
            
            $user = DB::table('users')->where(["username" => $request->username])->first();
            if (isset($user->role)) {
                if ($user->role=='nakes') {
                    
                    if(Auth::attempt(['username' => $user->username, 'password' => $request->password])) {
                        Auth::login($user, $remember_me);
                        return response()->json(['response' => 'success', 'error' => '']);
                    } else {
                        return response()->json(['response' => 'failed', 'error' => 'Gagal Login, Email / Password Mungkin salah atau mungkin anda menggunakan Google Sign in sebagai login']);
                    }
                } else {
                    return response()->json(['response' => 'failed', 'error' => 'Gagal Login, Akun anda belum terverifikasi, silahkan check Email / No Ponsel anda untuk verifikasi']);
                }
            } else {
                return response()->json(['response' => 'failed', 'error' => 'Gagal Login, Tidak ada user dengan email/no handphone ini']);
            }
        }
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->stateless()->user();
            $finduser = Members::where('google_id', $user->id)->first();
            if($finduser){
                Auth::loginUsingId($finduser->id);
            } else {

                $newUser = new Members;
                $newUser->nama_lengkap = $user->name;
                $newUser->email = $user->email;
                $newUser->avatar = $user->avatar;
                $newUser->status = 'ACTIVE';
                $newUser->google_id = $user->id;
                $newUser->email_verified_at = Carbon::now();
                $newUser->save();

                Auth::loginUsingId($newUser->id);
            }

            return redirect(route('app.sync'));

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
        
    public function logout()
    {
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        Auth::logout();
        session()->flush();
        return redirect('/');
    }

    public function userlogin(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);


        if ($validator->fails()) {
            $validate = [];
            foreach($validator->errors()->all() as $val) {
                $validate[] = $val;
            }
            return response()->json(['response' => 'validate', 'error'=>str_replace('.','',implode(', ', $validate))]);
        } else {
          
            $user = DB::table('users')->where(["username" => $request->username])->first();
            $remember_me  = TRUE;
            if (isset($user->role)) {
                if ($user->isActive=='1' && $user->role =='nakes') {
                    if(Auth::attempt(['username' => $user->username, 'password' => $request->password])) {
                        Auth::login($user, $remember_me);
                        $token = $user->createToken('myapptoken')->plainTextToken;
                            $response = [
                                'user' => $user->username,
                                'token' => $token
                            ];

                        return response($response, 201);
                    } else {
                        return response()->json(['response' => 'failed', 'error' => 'Gagal Login, Email / Password Mungkin salah atau mungkin anda menggunakan Google Sign in sebagai login']);
                    }
                } else {
                    return response()->json(['response' => 'failed', 'error' => 'Gagal Login, Akun anda belum terverifikasi, silahkan check Email / No Ponsel anda untuk verifikasi']);
                }
            } else {
                return response()->json(['response' => 'failed', 'error' => 'Gagal Login, Tidak ada user dengan email/no handphone ini']);
            }
        }

    }

    public function userlogout(Request $request) {

    	auth()->user()->tokens()->delete();

    	return [
    		'message' => 'successfully logged out'
    	];
    }
}
