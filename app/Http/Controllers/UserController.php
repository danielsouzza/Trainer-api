<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserableResource;
use App\Models\PersonalTrainer;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;


class UserController extends Controller
{
    public function index(): AnonymousResourceCollection{
        $user = User::all();
        return UserableResource::collection($user);
    }

    public function store(StoreUserRequest $request): Response{
        $data = $request->validated();
        if($request->userable_type == 'student'){
            $userable = new StudentController();
            $data['userable_type'] = Student::class;
        }else{
            $userable = new PersonalTrainerController();
            $data['userable_type'] = PersonalTrainer::class;
        }

        $userable = $userable->store($data);
        $data['userable_id'] = $userable->id;
        $user = User::create($data);
        return response([$user, $userable], ResponseAlias::HTTP_ACCEPTED);
    }

    public function show(string $id){
        $user = User::findOrFail($id);
        return new UserableResource($user);
    }

    public function me(Request $request){
        $user = $this->requestUser($request);
        $user['userable'] = $user->userable;
        return response($user,Response::HTTP_OK);
    }

    public function update(UpdateUserRequest $request,){
        $user = $this->requestUser($request);
        $data = $request->validated();
        $user->update($data);
        $user->userable->update($data);
        return response($user, Response::HTTP_OK);
    }

    public function destroy(Request $request): JsonResponse{
        $user = $this->requestUser($request);
        if(!$request->password || !Hash::check($request->password, $user->password)){
            return response()->json([
                'message' => 'Credentials Invalids'
            ], ResponseAlias::HTTP_NOT_FOUND);
        }

        $user->userable->delete();
        $user->tokens()->delete();
        $user->delete();
        return response()->json([],ResponseAlias::HTTP_NO_CONTENT);
    }

    public function auth(AuthUserRequest $request){
        $user = User::where('email',$request->email)->first();
        $abilities = [];

        if(!$user || !Hash::check($request->password, $user->password)){
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        if ($user->userable_type == PersonalTrainer::class){
            $abilities = [
                'modify-program',
            ];
        }
        return $user->createToken($request->device_name,$abilities);
    }
}
