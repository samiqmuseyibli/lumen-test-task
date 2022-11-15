<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    private UserRepositoryInterface $userRepository;

    /**
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return JsonResponse
     * @throws ValidationException
     */
    public function authenticate(Request $request): JsonResponse
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);
        $user = User::where('email', $request->post('email'))->first();
        if ($user && Hash::check($request->post('password'), $user->password)) {
            $apikey = base64_encode(generateRandomString(40));
            User::where('email', $request->post('email'))->update(['api_token' => "$apikey"]);
            return response()->json(['status' => true, 'api_token' => $apikey], Response::HTTP_OK);
        } else {
            return response()->json(['status' => false, 'error' => "Wrong password or email!"], 401);
        }
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $this->validate($request, [
            'first_name' => 'required|string|max:20|min:2',
            'last_name' => 'required|string|max:20|min:2',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string',
            'password' => 'required|string|max:20|min:5'
        ]);
        $user = $this->userRepository->create($validated);
        if ($user) {
            return response()->json(['success' => true, 'data' => $user], Response::HTTP_CREATED);
        } else {
            return response()->json(['success' => false, 'data' => null], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function get(Request $request): JsonResponse
    {
        $user = $this->userRepository->find(Auth::user()->id);
        if ($user) {
            return response()->json(['success' => true, 'data' => $user], Response::HTTP_OK);
        }
        return response()->json(['success' => false, 'data' => null], Response::HTTP_NOT_FOUND);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @throws ValidationException
     */
    public function forgotPassword(Request $request): JsonResponse
    {
        $this->validate($request, [
            'email' => 'required|email|exists:users',
        ]);

        $user = $this->userRepository->findByEmail($request->post('email'));
        $token = generateRandomString(5);
        $user->update(['token' => $token]);

        //sent this token to user's mail

        //For sure, we shouldn't send this token in response
        return response()->json(['success' => true, 'data' => $token], Response::HTTP_OK);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @throws ValidationException
     */
    public function recoverPassword(Request $request): JsonResponse
    {
        $this->validate($request, [
            'email' => 'required|email|exists:users',
            'token' => 'required|string',
            'password' => 'required|min:2|max:20|string',
        ]);

        $user = $this->userRepository->findByEmail($request->post('email'));
        if ($user->token === $request->token) {
            $user->update([
                'password' => $request->password,
                'token' => null
            ]);
            return response()->json(['success' => true, 'data' => 'Password changed successfully'], Response::HTTP_OK);
        } else {
            return response()->json(['success' => false, 'data' => 'Invalid token!'], Response::HTTP_NOT_FOUND);
        }
    }
}
