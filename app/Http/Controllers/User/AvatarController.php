<?php

namespace App\Http\Controllers\User;

use Auth;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserAvatarRequest;
use App\Services\Contracts\UserProfileService;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded;

class AvatarController extends Controller
{
    /**
     * @var \App\Services\Contracts\UserProfileService
     */
    private $userProfileService;

    /**
     * @param \App\Services\Contracts\UserProfileService $userProfileService
     */
    public function __construct(UserProfileService $userProfileService)
    {
        $this->userProfileService = $userProfileService;
    }

    /**
     * Get the user profile avatar.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(): JsonResponse
    {
        $avatar = $this->userProfileService->getAvatar(Auth::user());

        return response()->json(['avatar' => $avatar]);
    }

    /**
     * Update the current user avatar.
     *
     * @param \App\Http\Requests\UpdateUserAvatarRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateUserAvatarRequest $request): JsonResponse
    {
        try {
            $avatar = $this->userProfileService->updateAvatar(Auth::user(), $request);
        } catch (FileCannotBeAdded $e) {
            return response()->json([
                'error' => __('Http/Controllers/User/AvatarController.file_cannot_be_added'),
            ], 422);
        }

        return response()->json(['avatar' => $avatar]);
    }

    /**
     * Delete the current user avatar.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(): JsonResponse
    {
        $this->userProfileService->deleteAvatar(Auth::user());

        return response()->json();
    }
}
