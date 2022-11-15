<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\CompanyRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class CompanyController extends Controller
{
    private CompanyRepositoryInterface $companyRepository;

    public function __construct(CompanyRepositoryInterface $companyRepository)
    {
        $this->companyRepository = $companyRepository;
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
            'title' => 'required|string',
            'phone' => 'required|string',
            'description' => 'required|string',
        ]);
        $validated['user_id'] = Auth::user()->id;
        $company = $this->companyRepository->create($validated);

        if($company){
            return response()->json(['success' => true, 'data' => $company], Response::HTTP_CREATED);
        }
        return response()->json(['success' => false, 'data' => null], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function get(){
        $companies = $this->companyRepository->getByUser(Auth::user()->id);
        return response()->json(['success' => true, 'data' => $companies]);
    }
}
