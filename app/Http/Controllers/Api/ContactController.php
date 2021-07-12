<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Contracts\Services\PhoneBook\PhoneBookService;
use App\Models\Contact;
use App\Http\Resources\ContactResource;
use App\Http\Requests\CreateContactRequest;
use App\Http\Requests\UpdateContactRequest;
use Illuminate\Http\JsonResponse;

class ContactController extends Controller
{
    /**
     * The PhoneBookService instance.
     *
     * @var PhoneBookService
     */
    private PhoneBookService $phoneBookService;

    /**
     * Create a new controller instance.
     *
     * @param  PhoneBookService  $phoneBookService
     *
     * @return void
     */
    public function __construct(PhoneBookService $phoneBookService)
    {
        $this->phoneBookService = $phoneBookService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return ContactResource::collection(
            $this->phoneBookService->contactsList()
        )
            ->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateContactRequest  $request
     *
     * @return JsonResponse
     */
    public function store(CreateContactRequest $request): JsonResponse
    {
        $contact = $this->phoneBookService->createContact($request->dataTransferObject());

        return ContactResource::make($contact)
            ->additional(['message' => 'Created.'])
            ->response();
    }

    /**
     * Display the specified resource.
     *
     * @param  Contact  $contact
     *
     * @return JsonResponse
     */
    public function show(Contact $contact): JsonResponse
    {
        return ContactResource::make($contact)->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateContactRequest  $request
     * @param  Contact  $contact
     *
     * @return JsonResponse
     */
    public function update(UpdateContactRequest $request, Contact $contact): JsonResponse
    {
        $contact = $this->phoneBookService->updateContact($contact, $request->dataTransferObject());

        return ContactResource::make($contact)
            ->additional(['message' => 'Updated.'])
            ->response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Contact  $contact
     *
     * @return JsonResponse
     */
    public function destroy(Contact $contact): JsonResponse
    {
        $this->phoneBookService->deleteContact($contact);

        return \response()->json(['message' => 'Deleted.']);
    }
}
