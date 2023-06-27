<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use stdClass;
use Str;

class AuthController extends Controller
{
  public function __construct()
  {
    // $this->middleware('register', ['only' => ['register']]);
    $this->middleware('auth:sanctum', ['except' => ['login', 'register']]);
  }

  /**
   * @param LoginRequest $request
   * @return JsonResponse
   * @throws Exception
   */
  public function login(LoginRequest $request): JsonResponse
  {
    $request->validated();

    $credentials = $request->only('email', 'password');
    if (Auth::attempt($credentials)) {
      /** @var User $user */
      $user = Auth::user();
      // if ((int) $user->status !== 1) {
      //   return response()->json(['message' => 'The user is deactivated, contact the administrator'], 406);
      // }
      $token = $user->createToken(Str::slug(config('app.name').'_auth_token', '_'))->plainTextToken;
      return response()->json(['token' => $token, 'user' => new UserResource($user)]);
    }
    return response()->json(['message' => 'These credentials do not match our records, or the user is disabled'], 406);
  }

  /**
   * @param RegisterRequest $request
   * @return JsonResponse
   * @throws Exception
   */
  public function logout(): JsonResponse
  {
    /** @var User $user */
    $user = Auth::user();
    $user->currentAccessToken()->delete();
    return response()->json(['message' => 'Session closed successfuly']);
  }

  /**
   * @param RegisterRequest $request
   * @return JsonResponse
   * @throws Exception
   */
  public function register(RegisterRequest $request): JsonResponse
  {
    $request->validated();

    $user = new User();
    $user->name = $request->get('name');
    $user->email = $request->get('email');
    $user->role_id = 0;
    $user->password = bcrypt($request->get('password'));
    $user->save();

    $token = $user->createToken(Str::slug(config('app.name').'_auth_token', '_'))->plainTextToken;
    return response()->json(['token' => $token, 'user' => new UserResource($user)]);
  }

  /**
   * @return JsonResponse
   */
  public function user():Jsonresponse
  {
    return response()->json(new UserResource(auth()->user()));
  }

  /**
   * @param Request $request
   * @return JsonResponse
   * @throws Exception
   */
  public function check(Request $request):JsonResponse
  {
    // $dashboardAccess = false;
    // $access = Auth::check();
    // if ($access) {
    //   /** @var User $user */
    //   $user = Auth::user();
    //   $dashboardAccess = $user->userRole->checkDashboardAccess();
    //   if ($request->get('controller')) {
    //     $access = $user->userRole->checkPermission($request->get('controller'));
    //   }
    // }
    // return response()->json(['access' => $access, 'dashboard_access' => $dashboardAccess]);
  }
}